<?php
session_start();

if (isset($_POST['logout'])) {
    // Vymaže sessions
    $_SESSION = array();

    session_destroy();

    header("Location: index.php");
    exit;
}
?>
