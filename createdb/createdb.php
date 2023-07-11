<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
<?
include_once("../functions/functions.php");

$pdo = connect();
$tableNameCategories = 'categories';
$tableNameRoles = 'roles';
$tableNameQuestions = 'questions';
$tableNameAnswers = 'answers';
$tableNameUsers = 'users';
$tableNameResults = 'results';

$ct1 = "CREATE TABLE IF NOT EXISTS $tableNameCategories(
    Id int primary key not null auto_increment,
    Category varchar(50) not null unique,
    IsBlocked bool not null default false,
    ImagePath varchar(255)) default charset='utf8'";

$ct2 = "CREATE TABLE IF NOT EXISTS $tableNameRoles(
    Id int primary key not null auto_increment,
    RoleName varchar(50) not null unique) default charset='utf8'";

$ct3 = "CREATE TABLE IF NOT EXISTS $tableNameQuestions(
    Id int primary key not null auto_increment,
    Question varchar(1024) not null unique,
    ImagePath varchar(255),
    CategoryId int not null,
    IsBlocked bool not null default false,
    FOREIGN KEY (CategoryId) REFERENCES $tableNameCategories(Id) ON DELETE CASCADE) default charset='utf8'";

$ct4 = "CREATE TABLE IF NOT EXISTS $tableNameAnswers(
    Id int primary key not null auto_increment,
    QuestionId int not null,
    AnswerText varchar(1024) unique,
    AnswerPhoto varchar(255) unique,
    IsRealAnswer bool not null,
    FOREIGN KEY (QuestionId) REFERENCES $tableNameQuestions(Id) ON DELETE CASCADE) default charset='utf8'";

$ct5 = "CREATE TABLE IF NOT EXISTS $tableNameUsers(
    Id int primary key not null auto_increment,
    Login varchar(50) not null unique,
    Password varchar(255) not null,
    Email varchar(255) not null,
    Photo mediumblob,
    RoleId int not null default 2,
    FOREIGN KEY (RoleId) REFERENCES $tableNameRoles(Id) ON DELETE CASCADE) default charset='utf8'";

$ct6 = "CREATE TABLE IF NOT EXISTS $tableNameResults(
    Id int primary key not null auto_increment,
    UserId int not null,
    CategoryId int not null,
    DateTest date not null,
    Result int not null,
    FOREIGN KEY (UserId) REFERENCES $tableNameUsers(Id) ON DELETE CASCADE,
    FOREIGN KEY (CategoryId) REFERENCES categories(Id) ON DELETE CASCADE) default charset='utf8'";

$ct6 = "CREATE TABLE IF NOT EXISTS $tableNameResults(
    Id int primary key not null auto_increment,
    UserId int not null,
    CategoryId int not null,
    DateTest date not null,
    Result int not null,
    FOREIGN KEY (UserId) REFERENCES $tableNameUsers(Id) ON DELETE CASCADE,
    FOREIGN KEY (CategoryId) REFERENCES categories(Id) ON DELETE CASCADE) default charset='utf8'";

try{
    $pdo->exec($ct1);
    $pdo->exec($ct2);
    $pdo->exec($ct3);
    $pdo->exec($ct4);
    $pdo->exec($ct5);
    $pdo->exec($ct6);
    echo "<div class='alert alert-success'>Table $tableNameCategories created successfully.</div>";
    echo "<div class='alert alert-success'>Table $tableNameRoles created successfully.</div>";
    echo "<div class='alert alert-success'>Table $tableNameQuestions created successfully.</div>";
    echo "<div class='alert alert-success'>Table $tableNameAnswers created successfully.</div>";
    echo "<div class='alert alert-success'>Table $tableNameUsers created successfully.</div>";
    echo "<div class='alert alert-success'>Table $tableNameResults created successfully.</div>";
}catch(PDOException $ex){
    echo "Error creating table: ".$ex->getMessage();
}
?>
</body>
</html>