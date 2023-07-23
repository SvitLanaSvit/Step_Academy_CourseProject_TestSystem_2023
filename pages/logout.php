<?
session_start();
unset($_SESSION['login']);
unset($_SESSION['roleUser']);
unset($_SESSION['id']);
if(isset($_SESSION['randomQuestion'])){
    unset($_SESSION['randomQuestion']);
    if(isset($_SESSION['answers'])){
        unset($_SESSION['answers']);
    }
}
header("Location: index.php?page=5");