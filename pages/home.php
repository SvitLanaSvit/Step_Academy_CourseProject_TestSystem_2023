<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        .info{
            display: flex;

        }

        .userinfo{
            margin-left: 20px;
            border-radius: 5px;
            background-color: rgba(47, 79, 79, 0.8);
            padding: 10px;
        }

        .table>:not(caption)>*>*{
            background-color: transparent;
            color: white;
        }

        hr{
            color: white;
            opacity: 1;
        }
    </style>
</head>
<body>
    <?
    include_once('/OSPanel/domains/CourseProject/functions/functions.php');
    $id = $_SESSION['id'];
    $roleUser = $_SESSION['roleUser'];
    $row = getUserById($id);
    $login = $row['Login'];
    $email = $row['Email'];
    ?>
    <div class="container">
        <h3>HOME PAGE</h3>
        <div class="info mt-4 mb-4">
            <div>
                <?
                if($row['Photo'] != null){
                    $base64Image = base64_encode($row['Photo']);
                    $imageUrl = "data:image/jpeg;base64,".$base64Image;
                ?>
                    <img src="<?echo $imageUrl?>" alt="<?echo 'userId_'.$id?>" style="width: 120px;">
                <?}else{?>
                    <img src="/assets/userImages/add.png" style="width: 120px;" onclick="addPhoto()" alt="add">
                <?}?>
            </div>
            <div class="userinfo">
                <table class="table table-striped">
                    <tr>
                        <th>Login</th>
                        <td><?echo $login?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?echo $email?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="btn-group">
            <button class="btn btn-warning" onclick="editUser()">EDIT</button>
            <?if($roleUser != 'Admin'){?>
            <button class="btn btn-danger" onclick="removeUser()">REMOVE ACCOUNT</button>4
            <?}?>
        </div>
    </div>
    <hr>
    <div class="container p-3" style="background-color: rgba(47, 79, 79, 0.8); border-radius: 10px;">
        <h3>RESULTS OF TESTS</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Date of test</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
                <?
                $ps = getAllResultsByUserId($id);
                while($row = $ps->fetch()){
                    echo "<tr>";
                    echo "<td>$row[Category]</td>";
                    echo "<td>$row[DateTest]</td>";
                    echo "<td>$row[Result]</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function addPhoto(){
            location = 'index.php?page=12&userId=<?echo $id?>';
        }

        function editUser(){
            location = 'index.php?page=13&userId=<?echo $id?>';
        }

        function removeUser(){
            location = 'index.php?page=14&userId=<?echo $id?>';
        }
    </script>
</body>
</html>