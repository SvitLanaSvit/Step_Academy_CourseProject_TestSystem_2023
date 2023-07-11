<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body{
            background-color: transparent;
        }

        h2{
            color: white;
        }
    </style>
</head>
<body>
        <h2>Registration Form</h2>
    <?
        include_once("/OSPanel/domains/CourseProject/functions/functions.php");
        if(!isset($_POST['submit'])){
    ?>
    <div class="container">
        <form method="POST">
            <div class="mb-3 w-25">
                <label for="Login">Login:</label>
                <input type="text" class="form-control" id="Login" name="Login" required>
            </div>

            <div class="mb-3 w-25">
                <label for="Password">Password:</label>
                <input type="password" class="form-control" id="Password" name="Password" required>
            </div>

            <div class="mb-3 w-25">
                <label for="ConfirmPassword">Confirm Password:</label>
                <input type="password" class="form-control" id="ConfirmPassword" name="ConfirmPassword" required>
            </div>

            <div class="mb-3 w-25">
                <label for="Email">Email:</label>
                <input type="email" class="form-control" id="Email" name="Email" required>
            </div>

            <div class="btn-group">
                <button type="submit" name="submit" class="btn btn-primary">Register</button>
            </div>
        </form>
    </div>
    <?}
        else{
            class User {
                public $login;
                public $password;
                public $email;
            
                function __construct($login, $password, $email) {
                    $this->login = $login;
                    $this->password = $password;
                    $this->email = $email;
                }
            }

            if(isset($_POST['submit'])){
                $login = $_POST['Login'];
                $password = $_POST['Password'];
                $confirmPassword = $_POST['ConfirmPassword'];
                $email = $_POST['Email'];

                if(!validatePassword($password)){
                    echo "<script>alert('Password should be at least 6 characters long and contain at least one lowercase character, one uppercase character, and one symbol.')</script>";
                    echo "<script>
                            setTimeout(()=>{
                                location = 'index.php?page=4'
                            }, 2500);
                        </script>";
                }else{
                    if($password != $confirmPassword){
                        echo "<script>alert('Password should confirm!')</script>";
                        echo "<script>
                                setTimeout(()=>{
                                    location = 'index.php?page=4'
                                }, 10);
                            </script>";
                    }else{
                        $hashPassword = hashPasswor($password);
                        $userToSQL = new User($login, $hashPassword, $email);

                        register($userToSQL);
                        echo "<script>alert('Registration was successful!')</script>";
                        echo "<script>
                                setTimeout(()=>{
                                    location = 'index.php?page=5'
                                }, 10);
                            </script>";
                    }
                }  
            }
        }
    ?>
    </div>
</body>
</html>