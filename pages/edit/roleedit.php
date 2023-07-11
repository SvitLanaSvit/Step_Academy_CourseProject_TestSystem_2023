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
    </style>
</head>
<body>
<?
include_once("/OSPanel/domains/CourseProject/functions/functions.php");
if(isset($_GET['roleId'])){
    $id = $_GET['roleId'];

    $row = getRoleById($id);
    $role = $row['RoleName'];
}
?>
<div class="container">
    <h3>EDIT ROLE</h3>
    <form method="post" id="roleForm">
        <input type="hidden" name="roleId" id="roleId" value="<?echo $id?>">
        <div class="mb-3 w-25">
            <label for="role" class="form-label">Role</label>
            <input type="text" class="form-control" id="role" value="<?echo $role?>" placeholder="Add new role..." name="role">
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-sm btn-success mb-5" name='editrole'>Save</button>
        </div>
    </form>     
</div>
<?
    if(isset($_POST['editrole'])){
        $id = $_POST['roleId'];
        $role = $_POST['role'];

        updateRole($role, $id);
    }
?>
</body>
</html>