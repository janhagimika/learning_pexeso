<?php
session_start();

require_once 'config.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: index.php");
    exit;
}

$topPlayerSql = "SELECT username, AVG(score) AS average_score FROM players GROUP BY username ORDER BY average_score DESC LIMIT 1";
$result = $DB->query($topPlayerSql);

if ($row = $result->fetch_assoc()) {
  $_SESSION['top_player'] = $row['username'];
}

?>

<!DOCTYPE html>
<html lang="cs">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Pexeso 6x6</title>
<link rel="stylesheet" href="style.css">
</head>
<script>
function shuffleArray(array) {
    for(let y = 10; y > 0; y--){//míchání probíhá 10x
        for (let i = array.length - 1; i > 0; i--) {//počítám od konce a vždy prohodím s obrazkem na random pozici
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];//is called an array destructuring assignment. It allows for the swappingwithout the need for a temporary variable.
        }
    }
}

function generateRandomMemoryThreshold() {
    const foundPairs = playerPoints + computerPoints;
    let phase = Math.floor(foundPairs / 4); 
    let minThreshold, maxThreshold;
    switch (phase) {
        case 0: // Na začátku hry
            minThreshold = 6;
            maxThreshold = 8;
            break;
        case 1: // Střední fáze hry
            minThreshold = 5;
            maxThreshold = 7;
            break;
        case 2: // Pokročilá fáze hry
            minThreshold = 3;
            maxThreshold = 6;
            break;
        case 3: // Pokročilejší fáze hry
            minThreshold = 2;
            maxThreshold = 4;
            break;
        default: // Konečná fáze hry
            minThreshold = 1;
            maxThreshold = 3;
    }
    return Math.floor(Math.random() * (maxThreshold - minThreshold + 1)) + minThreshold;
}

let isPlayerTurn = true;
let boardCards = [];
let flippedCards = [];
let playerPoints = 0;
let computerPoints = 0;
let memoryMap = [];
let memoryFlips = 0;
let memoryThreshold = generateRandomMemoryThreshold();

function checkForWin() {
  if((playerPoints + computerPoints) === 3){
    if(playerPoints === computerPoints){
      document.getElementById('gameStatus').innerHTML = 'Hra skončila <b style="color: yellow;">REMÍZOU</b><a href="leaderboard.php">Zobrazit žebříček</a>';
    } else if(playerPoints > computerPoints){
      document.getElementById('gameStatus').innerHTML = 'Vítězem je <b style="color: green;">HRÁČ</b><a href="leaderboard.php">Zobrazit žebříček</a>';
    } else {
      document.getElementById('gameStatus').innerHTML = 'Vítězem je <b style="color: red;">POČÍTAČ</b><a href="leaderboard.php">Zobrazit žebříček</a>';
    }
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "save_game.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        console.log(xhr.responseText);
      }
    };
    xhr.send("score=" + playerPoints); // Posíláme skóre hráče
  }
}

function checkForMatch() {
  if (flippedCards[0].style.backgroundImage === flippedCards[1].style.backgroundImage) {
    if(isPlayerTurn){
      playerPoints++;
      flippedCards[0].style.border = '3px solid green';
      flippedCards[1].style.border = '3px solid green';
      document.getElementById('playerScore').innerHTML = 'HRÁČ: '+ playerPoints;
    } else {
      computerPoints++;
      flippedCards[0].style.border = '3px solid red';
      flippedCards[1].style.border = '3px solid red';
      document.getElementById('computerScore').innerHTML = 'POČÍTAČ: '+ computerPoints;
    }
    delete memoryMap[boardCards[0].id];
    delete memoryMap[boardCards[1].id];
    flippedCards = [];
    boardCards = [];
  } else {
    setTimeout(() => {
      boardCards[0].classList.toggle('is-flipped');
      boardCards[1].classList.toggle('is-flipped');
      flippedCards = [];
      boardCards = [];
    }, 1000);
  }
}

function updateMemoryMap(cardId, image) {
    memoryMap[cardId] = image;
    let cards = new Set(Object.values(memoryMap));
    let cardsCount = cards.size;
    console.clear();
    Object.entries(memoryMap).forEach(([cardId, image]) => {
    console.log(cardId, image); // Získá se klíč (cardId) a hodnotu (image) jako pole
});
}

function adjustMemoryThreshold() {
    memoryThreshold = generateRandomMemoryThreshold();
    document.getElementById('testInterval').innerHTML = "Zapamatována bude každá " + memoryThreshold + " kartička";
    memoryFlips = 0;
}

function chooseRandomCard() {
    const allCards = document.querySelectorAll('.card:not(.is-flipped)');
    const cardsNotInMemory = Array.from(allCards).filter(card => !memoryMap[card.id]);
    if (cardsNotInMemory.length > 0) {
        const randomIndex = Math.floor(Math.random() * cardsNotInMemory.length);
        return cardsNotInMemory[randomIndex];
    } else {
        const randomIndex = Math.floor(Math.random() * allCards.length);
        return allCards[randomIndex];
    }
}

function chooseTheCard(){
  if(flippedCards.length === 1){//kontroluje jestli se vybraná random kartička neshoduje s něčím v paměti 
    for(let cardId in memoryMap){
      if(flippedCards[0].style.backgroundImage === memoryMap[cardId] && boardCards[0].id != cardId){
        let card = document.querySelector('#'+cardId);
        return card;
      }
    } 
  } 
  if(flippedCards.length === 0){//kontroluje jestli 2 stejné kartičky v paměti
    document.getElementById('gameStatus').innerHTML = 'Teď hraje <b style="color: red;">počítač</b>';
    for(let cardId in memoryMap){
      for(let cardId2 in memoryMap){
        if(memoryMap[cardId] === memoryMap[cardId2] && cardId != cardId2){//pokud se nerovnají pozice ale jsou stejné obrázky...         
          let card = document.querySelector('#'+cardId);
          if(!card.classList.contains('is-flipped')){
            return card;
          }
        }
      }
    }
  }
  // pokud se neprovedla žádná z kontrol výše, vybere random kartičku v chooseRandomCard(), vybírá hlavně z těch které nejsou v paměti
  // aby ji potom mohl porovnávat s ostatními kartami v paměti
  card = chooseRandomCard();
  return card;
}

function playerTurn(card, cardback) {
  if (!isPlayerTurn) return;
  memoryFlips++;
  if (flippedCards.length < 2 && !card.classList.contains('is-flipped')) {
      card.classList.toggle('is-flipped');
      flippedCards.push(cardback);
      boardCards.push(card);
      if (memoryFlips === memoryThreshold) {
        updateMemoryMap(card.id, cardback.style.backgroundImage);
        card.style.border = '4px solid purple';//testovací...
        adjustMemoryThreshold();
      }
    if (flippedCards.length === 2) {
        checkForMatch();
        isPlayerTurn = !isPlayerTurn;
        setTimeout(() => {
          if((playerPoints + computerPoints) != 18){//když se zavolá computerTurn při 18 bodech, padá to na řádku  let cardback = card.querySelector('.back');
            computerTurn();
          }          
          checkForWin();
      }, 2000);
    }
  }
}

function computerTurn() {
  if (isPlayerTurn) return;
  memoryFlips++;
  let card = chooseTheCard();
  let cardback = card.querySelector('.back');
  if (flippedCards.length < 2) {
      card.classList.toggle('is-flipped');
      flippedCards.push(cardback);
      boardCards.push(card);
      if (memoryFlips === memoryThreshold) {
        updateMemoryMap(card.id, cardback.style.backgroundImage);
        card.style.border = '3px solid purple';//testovací...je vidět, které kartičky si pamatuje počítač
        adjustMemoryThreshold();
      }
      setTimeout(() => {
        computerTurn();
    }, 1500);
    if (flippedCards.length === 2) {
      checkForMatch();
        setTimeout(() => {
          document.getElementById('gameStatus').innerHTML = 'Teď hraje <b style="color: green;">' + '<?php 
          if (isset($_SESSION['top_player']) && $_SESSION['username'] == $_SESSION['top_player']){
            echo $_SESSION['top_player'] . ' ' .  '<img src="obrazky/badge.png" alt="Top Player Badge" class="badge-icon" />';
          }
          else {
            echo $_SESSION['username'];
          }
          ?>' + '</b>';
          isPlayerTurn = !isPlayerTurn;  
          checkForWin();     
      }, 1000);
    }
  }
}

document.addEventListener('DOMContentLoaded', function() {
    const gameBoard = document.querySelector('.game-board');        
    const images = [];
    document.getElementById('testInterval').innerHTML = "Zapamatována bude každá " + memoryThreshold + " kartička";
    for (let i = 3; i <= 20; i++) {
        images.push('obrazky/Screenshot_' + i + '.png');
        images.push('obrazky/Screenshot_' + i + '.png');
    }
    shuffleArray(images);
    let imageIndex = 0;
    for (let row = 0; row < 6; row++) {
        for (let col = 0; col < 6; col++) {
            const card = document.createElement('div');
            card.className = 'card';
            card.id = 'id' + row + '_' + col;

            const cardFront = document.createElement('div');
            cardFront.className = 'card-face front';
            const cardBack = document.createElement('div');
            cardBack.className = 'card-face back';
            cardBack.style.backgroundImage = `url("${images[imageIndex++]}")`;
            card.appendChild(cardFront);
            card.appendChild(cardBack);

            card.addEventListener('click', function() {               
                playerTurn(card, cardBack);
            });

            gameBoard.appendChild(card);
        }
    }
});

</script>
<body>
  <h1>Hra pexeso</h1>
  <div id="gameStatus">Teď hraje <b style="color: green;"><?php 
          if (isset($_SESSION['top_player']) && $_SESSION['username'] == $_SESSION['top_player']){
            echo $_SESSION['top_player'] . ' ' .  '<img src="obrazky/badge.png" alt="Top Player Badge" class="badge-icon" />';
          }
          else {
            echo $_SESSION['username'];
          }
          ?></b></div>
  <div class="game-board">  
  </div>
  <div id="scoreBoard">
    <div id="playerScore">HRÁČ: 0</div>
    <div id="computerScore">POČÍTAČ: 0</div>
  </div>
  <div id="testInterval"></div>
  <form action="logout.php" method="post">
    <button type="submit" name="logout" class="logout-button">Odhlásit se</button>
</form>
</body>
</html>
