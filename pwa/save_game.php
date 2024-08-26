<?php
session_start();
require_once 'config.php';  
$createSql = "CREATE TABLE IF NOT EXISTS players (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    score INT NOT NULL,
    game_date DATETIME NOT NULL
)";

if (!$DB->query($createSql)) {
    die("Error creating table: " . $DB->error);
}

if (!isset($_SESSION['username'])) {
    echo "Uživatel není přihlášen.";
    exit;
}

// data z AJAXu
$username = $_SESSION['username'];
$score = isset($_POST['score']) ? intval($_POST['score']) : 0;
$game_date = date("Y-m-d H:i:s"); 

$sql = "INSERT INTO players (username, score, game_date) VALUES (?, ?, ?)";
$stmt = $DB->prepare($sql);

if ($stmt) {
    $stmt->bind_param("sis", $username, $score, $game_date);
    $stmt->execute();
    $stmt->close();
} else {
    echo "Nepodařilo se připravit SQL příkaz.";
}

$DB->close();
?>
