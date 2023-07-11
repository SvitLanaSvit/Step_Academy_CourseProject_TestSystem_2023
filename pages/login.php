<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<style>
    body {
        background-color: transparent;
    }

    h2{
        color: white;
    }
</style>

<body>
    <?
    include_once("/OSPanel/domains/CourseProject/functions/functions.php");
    if (!isset($_POST['submit'])) {
    ?>
        <div class="container">
            <h2>Log in</h2>
            <form method="POST">
                <div class="mb-3 w-25">
                    <label for="login">Login:</label>
                    <input type="login" class="form-control" id="login" name="login" required>
                </div>

                <div class="mb-3 w-25">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="btn-group">
                    <button type="submit" name="submit" class="btn btn-primary">Log in</button>
                </div>
            </form>
        </div>
    <? } else {
        include_once("/OSPanel/domains/CourseProject/functions/functions.php");
        $isLogIn = false;
        $iaPaswordVerify = false;

        if (isset($_POST['submit'])) {
            $login = $_POST['login'];
            $password = $_POST['password'];
            echo $password;

            $res = getUsersFromSQL();

            while ($row = $res->fetch()) {
                $isPaswordVerify = password_verify($password, $row[2]);
                if ($login == $row[1] && $isPaswordVerify) {
                    $isLogIn = true;
                    break;
                }
            }

            if ($isLogIn) {
                $roleUser = getRoleUser($login);
                $idUser = getIdUser($login);
                if ($roleUser != null) {
                    session_start();
                    $_SESSION['login'] = $login;
                    $_SESSION['roleUser'] = $roleUser;
                    $_SESSION['id'] = $idUser;
                    echo "<div class='alert alert-success' style='color: green; text-align: center;'>You have successfully passed the verification</div>";
                    echo "<script>
                                setTimeout(()=>{
                                    location = 'index.php?page=1';
                                }, 2000)
                            </script>";
                } else {
                    echo "<script>alert('The role of user is empty!')</script>";
                    echo "<script>
                                setTimeout(()=>{
                                    location = 'index.php?page=1';
                                }, 2000)
                            </script>";
                }
            } else {
                if (isset($_SESSION['login'])) {
                    unset($_SESSION['login']);
                    unset($_SESSION['roleUser']);
                }
                echo "<div class='alert alert-danger' style='color: red; text-align: center;'>Email or password are not correct!</div>";
                echo "<script>
                                setTimeout(()=>{
                                    location = 'index.php?page=5';
                                }, 2000)
                            </script>";
            }
        }
    }
    ?>
</body>

</html>