<h3>REMOVE ACOUNT</h3>
<?
include_once('/OSPanel/domains/CourseProject/functions/functions.php');
if(isset($_GET['userId'])){
    $userId = $_GET['userId'];
    deleteUserFromSQL($userId);

    session_start();
    unset($_SESSION['login']);
    unset($_SESSION['roleUser']);
    unset($_SESSION['id']);
    if(isset($_SESSION['randomQuestion'])){
        unset($_SESSION['randomQuestion']);

        if(isset($_SESSION['category'])){
            unset($_SESSION['category']);
        }
        
        if(isset($_SESSION['answers'])){
            unset($_SESSION['answers']);
        }
    }

    header("Location: index.php?page=1");
}