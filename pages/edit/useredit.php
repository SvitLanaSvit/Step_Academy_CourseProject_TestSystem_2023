<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit role</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body{
            background-color: transparent;
        }

        h3{
            color: bisque;
        }

        .table>:not(caption)>*>*{
            background-color: transparent;
            color: white;
        }

        th, td{
            color: white;
        }

        .usersInfo{
            border-radius: 10px;
            background-color: rgba(47, 79, 79, 0.8);
            padding: 10px;
        }
    </style>
</head>
<body>
<?
include_once("/OSPanel/domains/CourseProject/functions/functions.php");
if(isset($_GET['userId'])){
    $id = $_GET['userId'];

    $row = getUserById($id);
    $login = $row['Login'];
    $email = $row['Email'];
    $dataUrl = '';
    $roleId = $row['RoleId'];

    if($row['Photo'] != null){
        $base64Image = base64_encode($row['Photo']);
        $dataUrl = "data:image/jpeg;base64,".$base64Image;
    }
}
    
?>
<div class="usersInfo w-50">
    <table class="table table-striped">
        <tr>
            <th>Login</th>
            <td><?echo $login?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?echo $email?></td>
        </tr>
        <tr>
            <th>Photo</th>
            <?if($dataUrl != ''){?>
                <td><img src="<?echo $dataUrl?>" alt="userId_<?echo $id?>"></td>
            <?}
            else{?>
                <td></td>
            <?}?>
        </tr>
    </table>
</div>
<div class="container">
    <h3>EDIT USER</h3>
    <form method="post" id="roleForm">
        <input type="hidden" name="userId" id="userId" value="<?echo $id?>">
        <div class="mb-3 w-25">
            <label for="roleId">Role:</label>
            <select class="form-select" aria-label="Default select example" name='roleId'>
                <?
                $ps = getAllRoles();
                while ($row = $ps -> fetch()) {
                    $selected = ($row['Id'] == $roleId) ? 'selected' : '';
                    echo "<option value='" . $row['Id'] . "' $selected>" . $row['RoleName'] . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-sm btn-success mb-5" name='edituser'>Save</button>
        </div>
    </form>     
</div>
<?
    if(isset($_POST['edituser'])){
        $userId = $_POST['userId'];
        $roleId = $_POST['roleId'];

        updateUser($roleId, $userId);
    }
?>
</body>
</html>