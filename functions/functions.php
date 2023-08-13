<?
function connect($host = "localhost:3307", $user = "root", $password = "", $dbname = "testssystemdb")
{
    $cs = "mysql:host=$host;dbname=$dbname;charset=utf8;";
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"
    );

    try {
        $pdo = new PDO($cs, $user, $password, $options);
        return $pdo;
    } catch (PDOException $excep) {
        echo $excep->getMessage();
        return false;
    }
}

function hashPasswor($password)
{
    return password_hash($password, PASSWORD_BCRYPT);
}

function validatePassword($password)
{
    $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d])\S{6,}$/';
    return preg_match($passwordRegex, $password);
}

function register($user)
{
    try{
        $pdo = connect();

        $ps = $pdo->prepare("INSERT INTO users(`Login`,`Password`,`Email`)VALUES(?,?,?)");
        $ps->bindParam(1, $user->login);
        $ps->bindParam(2, $user->password);
        $ps->bindParam(3, $user->email);

        $ps->execute();
        echo "<div class='alert alert-success'>Registration was successful! Go now to LOG IN!</div>";
    }catch(PDOException $ex){
        if($ex->getCode() == 23000){
            echo "<div class='alert alert-danger'>The login is already exists!</div>";
        }
        else{
            echo "<div class='alert alert-danger'>".$ex->getMessage()."</div>";
        }
    }
    
}

function getUsersFromSQL()
{
    $pdo = connect();

    $ps = $pdo->prepare("SELECT * FROM users");
    $ps->execute();
    $ps->setFetchMode(PDO::FETCH_NUM);
    return $ps;
}

function getRoleUser($login)
{
    $pdo = connect();

    $ps = $pdo->prepare("SELECT r.RoleName FROM users u LEFT JOIN roles r ON r.Id = u.RoleId WHERE u.Login = '$login'");
    $ps->execute();
    $row = $ps->fetch();
    $role = $row['RoleName'];
    return $role;
}

function getIdUser($login)
{
    $pdo = connect();

    try {
        $ps = $pdo->prepare("SELECT Id FROM users WHERE Login = '$login'");
        $ps->execute();
        $row = $ps->fetch();
        $Id = $row['Id'];
        return $Id;
    } catch (PDOException $ex) {
        echo "<div class='alert alert-danger'>There is a problem with get id by user`s login!</div>";
    }
    return null;
}

function getCategoryById($id)
{
    $pdo = connect();

    try {
        $ps = $pdo->prepare("SELECT * FROM categories WHERE Id = $id");
        $ps->execute();
        $row = $ps->fetch();
        return $row;
    } catch (PDOException $ex) {
        echo "<div class='alert alert-danger'>There is a problem with get category by id!</div>";
    }
    return null;
}

function getCategoryId($category)
{
    $pdo = connect();

    try {
        $ps = $pdo->prepare("SELECT Id FROM categories WHERE Category = '$category'");
        $ps->execute();
        $row = $ps->fetch();
        return  (int)$row['Id'];
    } catch (PDOException $ex) {
        echo "<div class='alert alert-danger'>There is a problem with get Id category by category name!" .$ex->getMessage()."</div>";
    }
    return null;
}

function getRoleById($id)
{
    $pdo = connect();

    try {
        $ps = $pdo->prepare("SELECT * FROM roles WHERE Id = $id");
        $ps->execute();
        $row = $ps->fetch();
        return $row;
    } catch (PDOException $ex) {
        echo "<div class='alert alert-danger'>There is a problem with get role by id!</div>";
    }
    return null;
}

function getQuestionById($id)
{
    $pdo = connect();

    try {
        $ps = $pdo->prepare("SELECT * FROM questions WHERE Id = $id");
        $ps->execute();
        $row = $ps->fetch();
        return $row;
    } catch (PDOException $ex) {
        echo "<div class='alert alert-danger'>There is a problem with get question by id!</div>";
    }
    return null;
}

function getAnswerById($id)
{
    $pdo = connect();
    try {
        $ps = $pdo->prepare("SELECT * FROM answers WHERE Id = $id");
        $ps->execute();
        $row = $ps->fetch();
        return $row;
    } catch (PDOException $ex) {
        echo "<div class='alert alert-danger'>There is a problem with get answer by id!". $ex->getMessage() ."</div>";
    }
    return null;
}

function getAnswerByQuestionId($id)
{
    $pdo = connect();
    try {
        $ps = $pdo->prepare("SELECT an.Id as AnswerId, an.AnswerText, an.AnswerPhoto, an.IsRealAnswer, q.Id as QuestionId FROM answers an LEFT JOIN questions q ON q.Id = an.QuestionId WHERE q.Id = $id");
        $ps->execute();
        return $ps;
    } catch (PDOException $ex) {
        echo "<div class='alert alert-danger'>There is a problem with get answers by question id!". $ex->getMessage() ."</div>";
    }
    return null;
}


function getRealAnswerByQuestionId($id)
{
    $pdo = connect();
    try {
        $ps = $pdo->prepare("SELECT an.Id as AnswerId, an.AnswerText, an.AnswerPhoto, an.IsRealAnswer, q.Id as QuestionId FROM answers an LEFT JOIN questions q ON q.Id = an.QuestionId WHERE q.Id = $id and an.IsRealAnswer = true");
        $ps->execute();
        $row = $ps->fetch();
        return $row;
    } catch (PDOException $ex) {
        echo "<div class='alert alert-danger'>There is a problem with get real answer by question id!". $ex->getMessage() ."</div>";
    }
    return null;
}
function getUserById($id){
    $pdo = connect();
    try {
        $ps = $pdo->prepare("SELECT * FROM users WHERE Id = ?");
        $ps->bindParam(1, $id);
        $ps->execute();
        $row = $ps->fetch();
        return $row;
    } catch (PDOException $ex) {
    }
    return null;
}

function getAllCategories($category = '')
{
    $pdo = connect();

    try {
        if($category == ''){
            $ps = $pdo->prepare("SELECT * FROM categories");
            $ps->execute();
            return $ps;
        }
        else{
            $ps = $pdo->prepare("SELECT * FROM categories WHERE Category = $category");
            $ps->execute();
            $row = $ps->fetch();
            return $ps;
        }
        
    } catch (PDOException $ex) {
        echo "<div class='alert alert-danger'>There is a problem with get all categories!</div>";
    }
    return null;
}

function getAllCategoriesIsNotBloked()
{
    $pdo = connect();

    try {
        $ps = $pdo->prepare("SELECT * FROM categories WHERE IsBlocked = 0");
            $ps->execute();
            return $ps;
        
    } catch (PDOException $ex) {
        echo "<div class='alert alert-danger'>There is a problem with get all categories!</div>";
    }
    return null;
}

function getAllQuestions()
{
    $pdo = connect();

    try {
        $ps = $pdo->prepare("SELECT * FROM questions");
        $ps->execute();
        return $ps;
    } catch (PDOException $ex) {
        echo "<div class='alert alert-danger'>There is a problem with get all questions!</div>";
    }
    return null;
}

function getAllQuestionsIsNotBlockedLanguageRandom($category)
{
    $pdo = connect();

    try {
        $ps = $pdo->prepare("SELECT q.Id as IdQuestion, q.Question, q.ImagePath as ImagePathQuestion, q.CategoryId, q.IsBlocked as IsBlockedQuestion, ct.Id as IdCategory, ct.Category, ct.IsBlocked as IsBlockedCategory, ct.ImagePath as ImagePathCategory FROM questions q LEFT JOIN categories ct ON ct.Id = q.CategoryId WHERE q.IsBlocked = 0 and Category = '$category'");
        $ps->execute();
        $questions = $ps->fetchAll();
        $countOfQuestions = 20;

        if(count($questions) >= $countOfQuestions){
            // Randomly shuffle the questions array
            shuffle($questions);

            // Select the first 10 questions from the shuffled array
            $randomQuestions = array_slice($questions, 0, $countOfQuestions);
            return $randomQuestions;
        }
        else return $questions;
    } catch (PDOException $ex) {
        echo "<div class='alert alert-danger'>There is a problem with get all questions!</div>";
    }
    return null;
}

function getAllRoles(){
    $pdo = connect();

    try {
        $ps = $pdo->prepare("SELECT * FROM roles");
        $ps->execute();
        return $ps;
    } catch (PDOException $ex) {
        echo "<div class='alert alert-danger'>There is a problem with get all roles ".$ex->getMessage()."!</div>";
    }
    return null;
}

function getAllResultsByUserId($userId){
    $pdo = connect();

    try{
        $ps = $pdo->prepare("SELECT cat.Category, res.DateTest, res.Result FROM results res LEFT JOIN categories cat ON res.CategoryId = cat.Id WHERE UserId = ?");
        $ps -> bindParam(1, $userId);
        $ps->execute();
        return $ps;
    }catch(PDOException $ex){
        echo "<div class='alert alert-danger'>There is a problem with get all results".$ex->getMessage()."!</div>";
    }
    return null;
}

function updateCategory($category, $isBlocked, $categoryId)
{
    $pdo = connect();

    try {
        if ($_FILES && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
            $filename = $_FILES['photo']['name'];
            $filePath = "assets/categoryImages/" . $filename;

            $ps = $pdo->prepare("UPDATE categories SET Category = ?, IsBlocked = ?, ImagePath = ? WHERE Id = ?");
            $ps->bindParam(1, $category);
            $ps->bindParam(2, $isBlocked, PDO::PARAM_INT);
            $ps->bindParam(3, $filePath);
            $ps->bindParam(4, $categoryId, PDO::PARAM_INT);
            $ps->execute();
        } else {
            $ps = $pdo->prepare("UPDATE categories SET Category = ?, IsBlocked = ? WHERE Id = ?");
            $ps->bindParam(1, $category);
            $ps->bindParam(2, $isBlocked, PDO::PARAM_INT);
            $ps->bindParam(3, $categoryId, PDO::PARAM_INT);
            $ps->execute();
        }

        echo "<div class='alert alert-success'>The update was successful!</div>";
    } catch (PDOException $ex) {
        echo "<div class='alert alert-danger'>There is a problem with update category by edit!</div>";
    }
}

function updateRole($role, $roleId)
{
    $pdo = connect();

    try {
        $ps = $pdo->prepare("UPDATE roles SET RoleName = ? WHERE Id = ?");
        $ps->bindParam(1, $role);
        $ps->bindParam(2, $roleId, PDO::PARAM_INT);

        $ps->execute();
        echo "<div class='alert alert-success'>The update was successful!</div>";
    } catch (PDOException $ex) {
        echo "<div class='alert alert-danger'>There is a problem with update role by edit!</div>";
    }
}

function updateQuestion($question, $categoryId, $questionId)
{
    $pdo = connect();

    try {
        if ($_FILES && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
            $filename = $_FILES['photo']['name'];
            $filePath = "assets/quetionImages/" . $filename;

            $ps = $pdo->prepare("UPDATE questions SET Question = ?, ImagePath = ?, CategoryId = ? WHERE Id = ?");
            $ps->bindParam(1, $question);
            $ps->bindParam(2, $filePath);
            $ps->bindParam(3, $categoryId, PDO::PARAM_INT);
            $ps->bindParam(4, $questionId, PDO::PARAM_INT);
            $ps->execute();
        } else {
            $ps = $pdo->prepare("UPDATE questions SET Question = ?, CategoryId = ? WHERE Id = ?");
            $ps->bindParam(1, $question);
            $ps->bindParam(2, $categoryId, PDO::PARAM_INT);
            $ps->bindParam(3, $questionId, PDO::PARAM_INT);
            $ps->execute();
        }

        echo "<div class='alert alert-success'>The update was successful!</div>";
    } catch (PDOException $ex) {
        echo "<div class='alert alert-danger'>There is a problem with update question by edit " . $ex->getMessage() . "!</div>";
    }
}

function updateAnswer($questionId, $answerText, $answerPhoto, $isRealAnswer, $answerId){
    $pdo = connect();

    try{
        $ps = $pdo->prepare("UPDATE answers SET QuestionId = ?, AnswerText = ?, AnswerPhoto = ?, IsRealAnswer = ? WHERE Id = ?");
        $ps->bindParam(1, $questionId);
        $ps->bindParam(2, $answerText);
        $ps->bindParam(3, $answerPhoto);
        $ps->bindParam(4, $isRealAnswer);
        $ps->bindParam(5, $answerId);
        $ps->execute();
        echo "<div class='alert alert-success'>The update was successful!</div>";
    }catch(PDOException $ex){
        echo "<div class='alert alert-danger'>There is a problem with update answer by edit " . $ex->getMessage() . "!</div>";
    }
}

function updateUser($roleId, $userId){
    $pdo = connect();

    try{
        $ps = $pdo->prepare("UPDATE users SET RoleId = ? WHERE Id = ?");
        $ps->bindParam(1, $roleId);
        $ps->bindParam(2, $userId);
        $ps->execute();
        echo "<div class='alert alert-success'>The update was successful!</div>";
    }catch(PDOException $ex){
        echo "<div class='alert alert-danger'>There is a problem with update user by edit " . $ex->getMessage() . "!</div>";
    }
}

function updateUserWithPhoto($userId, $email, $photoData){
    $pdo = connect();

    try{
        if($photoData == ''){
            $ps = $pdo->prepare("UPDATE users SET Email = ? WHERE Id = ?");
            $ps->bindParam(1, $email);
            $ps->bindParam(2, $userId);
            $ps->execute();
            echo "<div class='alert alert-success'>The update was successful!</div>";
        }
        else{
            $ps = $pdo->prepare("UPDATE users SET Email = ?, Photo = ? WHERE Id = ?");
            $ps->bindParam(1, $email);
            $ps->bindParam(2, $photoData);
            $ps->bindParam(3, $userId);
            $ps->execute();
            echo "<div class='alert alert-success'>The update was successful!</div>";
        }
        
    }catch(PDOException $ex){
        echo "<div class='alert alert-danger'>There is a problem with update user with photo by edit " . $ex->getMessage() . "!</div>";
    }
}

function deleteQuestion($questionId)
{
    $pdo = connect();
    $blocked = 1;

    $ps = $pdo->prepare("UPDATE questions SET IsBlocked = ? WHERE Id = ?");
    $ps->bindParam(1, $blocked, PDO::PARAM_INT);
    $ps->bindParam(2, $questionId);

    $ps->execute();
}

function deleteAnswer($answerId){
    $pdo = connect();

    $ps = $pdo->prepare("DELETE FROM answers WHERE Id = ?");
    $ps->bindParam(1, $answerId);
    $ps->execute();
}

function deleteUserFromSQL($userId){
    $pdo = connect();

    $ps = $pdo->prepare("DELETE FROM users WHERE Id = ?");
    $ps->bindParam(1, $userId);
    $ps->execute();
}

function addPhotoUserToSQL($photoData, $userId){
    $pdo = connect();

    try{
        $ps = $pdo->prepare("UPDATE users SET Photo = ? WHERE Id = ?");
        $ps->bindParam(1, $photoData);
        $ps->bindParam(2, $userId);
        $ps->execute();
        echo "<div class='alert alert-success'>The photo added!</div>";
    }catch(PDOException $ex){
        echo "<div class='alert alert-danger'>There is a problem with add the photo of user to sql " . $ex->getMessage() . "!</div>";
    }
}

function writeResultToSQLFromTest($userId, $categoryId, $dateTest, $result){
    $pdo = connect();

    try{
        $ps = $pdo->prepare("INSERT INTO results(`UserId`, `CategoryId`, `DateTest`, `Result`)VALUES(?,?,?,?)");
        $ps->bindParam(1, $userId, PDO::PARAM_INT);
        $ps->bindParam(2, $categoryId, PDO::PARAM_INT);
        $ps->bindParam(3, $dateTest);
        $ps->bindParam(4, $result, PDO::PARAM_INT);
        $ps->execute();
        echo "<div class='alert alert-success'>The result of test added!</div>";
    }catch(PDOException $ex){
        echo "<div class='alert alert-danger'>There is a problem with add to rusults " . $ex->getMessage() . "!</div>";
    }
}