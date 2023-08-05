<?
session_start();

if(isset($_SESSION['category'])){
    unset($_SESSION['category']);
}

if(isset($_SESSION['randomQuestion'])){
    unset($_SESSION['randomQuestion']);
}

if(isset($_SESSION['answers'])){
    unset($_SESSION['answers']);
}

if(isset($_SESSION['currentQuestionIndex'])){
    unset($_SESSION['currentQuestionIndex']);
}

if(isset($_SESSION['correctAnswer'])){
    unset($_SESSION['correctAnswer']);
}