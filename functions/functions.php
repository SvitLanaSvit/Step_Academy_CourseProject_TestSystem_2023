<?
function connect($host = "localhost:3307", $user = "root", $password = "", $dbname = "testssystemdb" ){
    $cs = "mysql:host=$host;dbname=$dbname;charset=utf8;";
    $options = array(
        PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES UTF8"
    );

    try{
        $pdo = new PDO($cs, $user, $password, $options);
        return $pdo;
    }
    catch(PDOException $excep){
        echo $excep->getMessage();
        return false;
    }
}

function hashPasswor($password){
    return password_hash($password, PASSWORD_BCRYPT);
}

function validatePassword($password){
    $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d])\S{6,}$/';
    return preg_match($passwordRegex, $password);
}

function register($user){
    $pdo = connect();

    $ps = $pdo->prepare("INSERT INTO users(`Login`,`Password`,`Email`)VALUES(?,?,?)");
    $ps->bindParam(1, $user->login);
    $ps->bindParam(2, $user->password);
    $ps->bindParam(3, $user->email);

    $ps->execute();
}

function getUsersFromSQL(){
    $pdo = connect();

    $ps = $pdo -> prepare("SELECT * FROM users");
    $ps->execute();
    $ps->setFetchMode(PDO::FETCH_NUM);
    return $ps;
}

function getRoleUser($login){
    $pdo = connect();

    $ps = $pdo -> prepare("SELECT r.RoleName FROM users u LEFT JOIN roles r ON r.Id = u.RoleId WHERE u.Login = '$login'");
    $ps -> execute();
    $row = $ps->fetch();
    $role = $row['RoleName'];
    return $role;
}

function getIdUser($login){
    $pdo = connect();

    try{
        $ps = $pdo -> prepare("SELECT Id FROM users WHERE Login = '$login'");
        $ps -> execute();
        $row = $ps->fetch();
        $Id = $row['Id'];
        return $Id;
    }catch(PDOException $ex){
        echo "<div class='alert alert-danger'>There is a problem with get id by user`s login!</div>";
    }
    return null;
}

function getCategoryById($id){
    $pdo = connect();

    try{
        $ps = $pdo -> prepare("SELECT * FROM categories WHERE Id = $id");
        $ps->execute();
        $row = $ps->fetch();
        return $row;
    }catch(PDOException $ex){
        echo "<div class='alert alert-danger'>There is a problem with get category by id!</div>";
    }
    return null;
}

function getRoleById($id){
    $pdo = connect();

    try{
        $ps = $pdo -> prepare("SELECT * FROM roles WHERE Id = $id");
        $ps->execute();
        $row = $ps->fetch();
        return $row;
    }catch(PDOException $ex){
        echo "<div class='alert alert-danger'>There is a problem with get role by id!</div>";
    }
    return null;
}

function getQuestionById($id){
    $pdo =connect();

    try{
        $ps = $pdo -> prepare("SELECT * FROM questions WHERE Id = $id");
        $ps -> execute();
        $row = $ps -> fetch();
        return $row;
    }catch(PDOException $ex){
        echo "<div class='alert alert-danger'>There is a problem with get question by id!</div>";
    }
    return null;
}

function getAllCategories(){
    $pdo = connect();

    try{
        $ps = $pdo -> prepare("SELECT * FROM categories");
        $ps -> execute();
        return $ps;
    }catch(PDOException $ex){
        echo "<div class='alert alert-danger'>There is a problem with get all categories!</div>";
    }
    return null;
}

function getAllQuestions(){
    $pdo = connect();

    try{
        $ps = $pdo -> prepare("SELECT * FROM questions");
        $ps -> execute();
        return $ps;
    }catch(PDOException $ex){
        echo "<div class='alert alert-danger'>There is a problem with get all questions!</div>";
    }
    return null;
}

function updateCategory($category, $isBlocked, $categoryId){
    $pdo = connect();

    try{
        if($_FILES && $_FILES['photo']['error'] == UPLOAD_ERR_OK){
            $filename = $_FILES['photo']['name'];
            $filePath = "assets/categoryImages/".$filename;

            $ps = $pdo -> prepare("UPDATE categories SET Category = ?, IsBlocked = ?, ImagePath = ? WHERE Id = ?");
            $ps -> bindParam(1, $category);
            $ps -> bindParam(2, $isBlocked, PDO::PARAM_INT);
            $ps -> bindParam(3, $filePath);
            $ps -> bindParam(4, $categoryId, PDO::PARAM_INT);
            $ps -> execute();
        }
        else{
            $ps = $pdo -> prepare("UPDATE categories SET Category = ?, IsBlocked = ? WHERE Id = ?");
            $ps -> bindParam(1, $category);
            $ps -> bindParam(2, $isBlocked, PDO::PARAM_INT);
            $ps -> bindParam(3, $categoryId, PDO::PARAM_INT);
            $ps -> execute();
        }
             
        echo "<div class='alert alert-success'>The update was successful!</div>";
    }catch(PDOException $ex){
        echo "<div class='alert alert-danger'>There is a problem with update category by edit!</div>";
    }
}

function updateRole($role, $roleId){
    $pdo = connect();

    try{
        $ps = $pdo -> prepare("UPDATE roles SET RoleName = ? WHERE Id = ?");
        $ps -> bindParam(1, $role);
        $ps -> bindParam(2, $roleId, PDO::PARAM_INT);

        $ps -> execute();
        echo "<div class='alert alert-success'>The update was successful!</div>";
    }catch(PDOException $ex){
        echo "<div class='alert alert-danger'>There is a problem with update role by edit!</div>";
    }
}

function updateQuestion($question, $categoryId, $questionId){
    $pdo = connect();

    try{
        if($_FILES && $_FILES['photo']['error'] == UPLOAD_ERR_OK){
            $filename = $_FILES['photo']['name'];
            $filePath = "assets/quetionImages/".$filename;

            $ps = $pdo -> prepare("UPDATE questions SET Question = ?, ImagePath = ?, CategoryId = ? WHERE Id = ?");
            $ps -> bindParam(1, $question);
            $ps -> bindParam(2, $filePath);
            $ps -> bindParam(3, $categoryId, PDO::PARAM_INT);
            $ps -> bindParam(4, $questionId, PDO::PARAM_INT);
            $ps -> execute();
        }
        else{
            $ps = $pdo -> prepare("UPDATE questions SET Question = ?, CategoryId = ? WHERE Id = ?");
            $ps -> bindParam(1, $question);
            $ps -> bindParam(2, $categoryId, PDO::PARAM_INT);
            $ps -> bindParam(3, $questionId, PDO::PARAM_INT);
            $ps -> execute();
        }
             
        echo "<div class='alert alert-success'>The update was successful!</div>";
    }catch(PDOException $ex){
        echo "<div class='alert alert-danger'>There is a problem with update question by edit ".$ex->getMessage()."!</div>";
    }
}

function deleteQuestion($questionId){
    $pdo = connect();
    $blocked = 1;

    $ps = $pdo -> prepare("UPDATE questions SET IsBlocked = ? WHERE Id = ?");
    $ps -> bindParam(1, $blocked, PDO::PARAM_INT);
    $ps -> bindParam(2, $questionId);

    $ps -> execute();
}