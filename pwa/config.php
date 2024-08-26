<?php
// Databázové přihlašovací údaje
$server = "localhost";
$user = "jan.mika";
$pass = "jan.mika";
$dbname = "jan.mika";

// Vytvoření připojení k databázi
$DB = new mysqli($server, $user, $pass, $dbname);

// Kontrola připojení
if ($DB->connect_error) {
    die("Connection failed: " . $DB->connect_error);
}
?>
