<?
session_start();
unset($_SESSION['login']);
unset($_SESSION['roleUser']);
unset($_SESSION['id']);
header("Location: index.php?page=5");