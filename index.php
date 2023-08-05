<?
ob_start();
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="icon" href="/assets//favicon/favicon.ico" type="image/x-icon">

    <style>
        html {
            background-image: url('/assets/matrix.jpg');
            background-size: cover;
            background-repeat: repeat;
            background-position: center center;
            height: 100%;
        }

        body {
            background-color: transparent;
        }

        section>.container>.row>.col>.container>.row>.col>.table>thead>tr>th,
        section>.container>.row>.col>.container>.row>.col>.table>tbody>tr>td {
            background-color: transparent;
            color: white;
            font-size: 16px;
        }

        section>.container>.row>.col>.container>.row>.col {
            border: 1px solid black;
            border-radius: 10px;
            background-color: rgba(47, 79, 79, 0.8)
        }

        h3 {
            color: bisque;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .bg-custom-color {
            background-color: rgba(47, 79, 79, 0.8);
        }

        section {
            margin-top: 70px;
        }

        .nav-link:hover {
            text-decoration: underline;
        }

        h2,h4, label, p{
            color: white;
        }

        nav>.container-fluid>#navbarNav>ul>li>a{
            color: white;
        }

        span.mb-3.mb-md-0.text-body-secondary{
            color: white !important;
        }

        .text-body-secondary{
            color: white !important;
        }

        .table>thead>tr>th, .table>tbody>tr>td{
            background-color: transparent;
            color: white;
        }

        .questions, .answers, .users, .results{
            border-radius: 10px;
            background-color: rgba(47, 79, 79, 0.8);
            padding: 10px;
        }

        .answers{
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <?
    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = 1;
    }
    include_once("pages/menu.php")
    ?>

    <section>
        <div class="container">
            <div class="row">
                <div class="col">
                    <?
                    switch ($page) {
                        case 1:
                            include_once("pages/main.php");
                            break;
                        case 2:
                            if (isset($_SESSION['roleUser'])){
                                include_once("pages/home.php");
                                break;
                            }
                            else{
                                echo "<script>alert('You should log in!');</script>";
                                echo "<script>
                                            setTimeout(()=>{
                                                location = 'index.php?page=1'
                                            }, 10);
                                        </script>";
                                break;
                            }
                        case 3:
                            if (isset($_SESSION['roleUser'])) {
                                if ($_SESSION['roleUser'] == 'Admin') {
                                    include_once("pages/admin.php");
                                    break;
                                } else {
                                    echo "<script>alert('Only admin can go in!');</script>";
                                    echo "<script>
                                                setTimeout(()=>{
                                                    location = 'index.php?page=1';
                                                }, 10)
                                            </script>";
                                    break;
                                }
                            } else {
                                echo "<script>alert('You should log in!');</script>";
                                echo "<script>
                                            setTimeout(()=>{
                                                location = 'index.php?page=1'
                                            }, 10);
                                        </script>";
                                break;
                            }
                        case 4:
                            if(!isset($_SESSION['login'])){
                                include_once("pages/registration.php");
                                break;
                            }
                            else{
                                echo "<script>alert('You are already regitered!');</script>";
                                echo "<script>
                                            setTimeout(()=>{
                                                location = 'index.php?page=1'
                                            }, 10);
                                        </script>";
                                break;
                            }
                            
                        case 5:
                            include_once("pages/login.php");
                            break;
                        case 6:
                            include_once("pages/logout.php");
                            break;
                        case 7:
                            include_once("pages/edit/categoryedit.php");
                            break;
                        case 8:
                            include_once("pages/edit/roleedit.php");
                            break;
                        case 9:
                            include_once("pages/edit/questionedit.php");
                            break;
                        case 10:
                            include_once("pages/edit/answeredit.php");
                            break;
                        case 11:
                            include_once("pages/edit/useredit.php");
                            break;
                        case 12:
                            include_once("pages/user/addphotouser.php");
                            break;
                        case 13:
                            include_once("pages/user/edituser.php");
                            break;
                        case 14:
                            include_once("pages/user/removeuser.php");
                            break;
                        case 15:
                            include_once("pages/admin/questions.php");
                            break;
                        case 16:
                            include_once("pages/admin/answers.php");
                            break;
                        case 17:
                            include_once("pages/admin/users.php");
                            break;
                        case 18:
                            include_once("pages/admin/results.php");
                            break;
                        case 19:
                            if(isset($_SESSION['id'])){
                                if(isset($_GET['category'])){
                                    $category = $_GET['category'];
                                    include_once("pages/tests/testbycategory.php");
                                    break;
                                }
                                break;
                            }else{
                                echo "<script>alert('Only a registered user can take the test!');</script>";
                                echo "<script>
                                            setTimeout(()=>{
                                                location = 'index.php?page=1'
                                            }, 10);
                                        </script>";
                                break;
                            } 
                            break;
                        default:
                            echo "<h2>Page was not found!</h2>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <div class="col-md-4 d-flex align-items-center">
                <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
                    <svg class="bi" width="30" height="24">
                        <use xlink:href="#bootstrap"></use>
                    </svg>
                </a>
                <span class="mb-3 mb-md-0 text-body-secondary">© 2023 Company, Inc</span>
            </div>

            <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                <li class="ms-3"><a class="text-body-secondary" href="#"><i class="bi bi-twitter"></i>
                        <use xlink:href="#twitter"></use></svg>
                    </a></li>
                <li class="ms-3"><a class="text-body-secondary" href="#"><i class="bi bi-instagram"></i>
                        <use xlink:href="#instagram"></use></svg>
                    </a></li>
                <li class="ms-3"><a class="text-body-secondary" href="#"><i class="bi bi-facebook"></i>
                        <use xlink:href="#facebook"></use></svg>
                    </a></li>
            </ul>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

</body>

</html>