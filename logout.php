<?php
session_start();

session_unset();
session_destroy();

if (isset($_COOKIE['PHPSESSID'])) {
    // Establecer la cookie con un tiempo pasado para eliminarla
    setcookie('PHPSESSID', '', time() - 3600, '/');
}

header("Location: index.php");
exit;
