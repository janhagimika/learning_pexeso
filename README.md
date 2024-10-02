# learning_pexeso
English version of readme:
Learning Pexeso
Pexeso Game - Memory Matching Game (Against AI)
This project is a web implementation of the Pexeso game (also known as a memory matching game), where the player tries to find pairs of cards. The game allows playing against the computer, which "remembers" the cards during the game and strategically makes decisions.
Features
•	Play against the computer (AI): The game allows playing against the computer, which has its own strategy and memory.
•	Artificial Intelligence: The computer remembers the cards it has already flipped and tries to improve its strategy based on this information.
•	Card flip animation: Each card animates as it flips, providing a smooth visual experience.
•	Score tracking: The score of both the player and the computer is continuously displayed.
•	Simple and responsive design: The game is accessible on various devices thanks to the optimized design.
•	Game saving: The ability to save the current game and continue later.
How the AI Works
The computer in this version of Pexeso is not just a random player but tries to simulate human behavior when matching cards.
•	AI Memory: When the computer flips a card, it stores the information about the card in its memory. Later, if it flips another card, it compares it with the cards in its memory and tries to form a pair if it finds a match.
•	AI Strategy:
o	The computer starts by randomly selecting cards. As it remembers what’s on the cards, it gradually stops selecting randomly and starts targeting specific pairs.
o	If the computer flips a card it remembers, it will try to flip its matching pair as soon as possible if it already knows where it is.
•	Improved Decision-Making: After each turn, the computer compares the flipped cards with its memory and learns how to make more efficient decisions in selecting pairs.
How to Run the Project
1. Running in a Browser Only (Without PHP)
You can run the game simply by opening the index.php or pexeso.php file directly in your browser. All game logic (card flipping, AI opponent) is written in JavaScript, so the game will work without a server environment.
2. Running with PHP for Educational Purposes
For full functionality, including user registration, game saving, and the leaderboard, PHP and MySQL need to be set up.
Requirements:
•	A web server with PHP support.
•	MySQL database for storing user accounts, scores, and saved games.
Installation:
1.	Clone the repository from GitHub:
git clone https://github.com/your-repo-url/pexeso-game.git
2.	Set up the database:
o	Create a MySQL database.
o	Import the SQL file (e.g., db.sql), which will create the necessary tables for users and scores.
3.	Configure the config.php file:
o	Open the config.php file and fill in your database connection details:
$servername = "your-server";
$username = "your-database-username";
$password = "your-password";
$dbname = "your-database-name";
4.	Upload to the server:
o	Upload all the files to your web server with PHP support.
5.	Access the game with PHP:
o	Open the following URL in your browser:
http://your-server/index.php
How to Play
1.	If you are running the game without PHP, simply open index.php in your browser and start playing.
2.	If using the PHP version, you can register, log in, and your score will be saved in the database.

Czech version of readme:
Pexeso Game - Memory Matching Game (Against AI)
Tento projekt je webová implementace hry Pexeso (známé také jako hra na párování), kde se hráč snaží najít dvojice kartiček. Hra umožňuje hraní proti počítači, který si během hry „pamatuje“ kartičky a snaží se strategicky rozhodovat.

Funkce
•	Hra proti počítači (AI): Hra nabízí možnost hrát proti počítači, který má svou strategii a paměť.
•	Umělá inteligence: Počítač si pamatuje již otočené kartičky a snaží se zlepšit svou strategii na základě těchto informací.
•	Animace otáčení kartiček: Každá kartička se při otáčení animuje, aby byl vizuální zážitek co nejpříjemnější.
•	Sledování skóre: Skóre hráče i počítače je neustále zobrazováno.
•	Jednoduchý a responzivní design: Hra je přístupná na různých zařízeních díky optimalizovanému designu.
•	Ukládání her: Možnost uložit rozehranou hru a pokračovat později.

Jak počítač (AI) funguje
Počítač v této verzi Pexesa není pouze náhodný hráč, ale snaží se simulovat lidské chování při párování kartiček.
•	Paměť AI: Když počítač otočí kartičku, ukládá si do paměti, co je na ní zobrazeno. Když později otočí jinou kartičku, porovná ji s kartičkami ve své paměti a pokud najde shodu, pokusí se pár vytvořit.

•	Strategie AI:
o	Počítač začne hru tak, že náhodně vybírá kartičky. Postupně, jak si pamatuje, co je na kartičkách, přestává vybírat náhodně a začne cíleně hledat odpovídající dvojice.
o	Pokud otočí kartičku, kterou si již pamatuje, pokusí se co nejdříve otočit i její odpovídající dvojici, pokud ji již zná.
•	Vylepšování rozhodování: Po každém tahu počítač porovnává otočené kartičky s tím, co si již pamatuje, a učí se, jak efektivněji vybírat správné dvojice.

Jak spustit projekt
1. Spuštění pouze v prohlížeči (bez PHP)
Hru můžete spustit jednoduše tak, že otevřete soubor index.php nebo pexeso.php přímo v prohlížeči. Veškerá logika hry (otáčení kartiček, AI protivník) je napsána v JavaScriptu, takže hra bude fungovat i bez serverového prostředí.

2. Spuštění s PHP pro školní účely
Pro plnou funkcionalitu projektu, včetně registrace uživatelů, ukládání her a leaderboardu, je potřeba nastavit PHP a MySQL.
Požadavky:
•	Webový server s podporou PHP.
•	MySQL databáze pro ukládání uživatelských účtů, skóre a uložených her.

Instalace:
1.	Klonujte repozitář z GitHubu:
git clone https://github.com/your-repo-url/pexeso-game.git
2.	Nastavte databázi:
o	Vytvořte MySQL databázi.
o	Importujte SQL soubor (např. db.sql), který vytvoří potřebné tabulky pro uživatele a skóre.
3.	Konfigurujte soubor config.php:
o	Otevřete soubor config.php a doplňte údaje o připojení k databázi:
$servername = "váš-server";
$username = "váš-databázový-uživatel";
$password = "váše-heslo";
$dbname = "jméno-databáze";
4.	Nahrání na server:
o	Nahrajte všechny soubory na svůj webový server s podporou PHP.
5.	Přístup ke hře s PHP:
o	Otevřete ve svém prohlížeči URL:
http://váš-server/index.php
Jak hrát
1.	Pokud hru spouštíte bez PHP, stačí otevřít index.php v prohlížeči a začít hrát.
2.	Pokud používáte PHP verzi, můžete se zaregistrovat, přihlásit a vaše skóre bude uloženo v databázi.



