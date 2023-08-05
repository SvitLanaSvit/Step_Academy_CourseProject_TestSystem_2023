<?include_once("/OSPanel/domains/CourseProject/functions/functions.php");
if(isset($_GET['userId'])){
    $id = $_GET['userId'];

    $row = getUserById($id);
    $email = $row['Email'];
    $dataUrl = '';

    if($row['Photo'] != null){
        $base64Image = base64_encode($row['Photo']);
        $dataUrl = "data:image/jpeg;base64,".$base64Image;
    }
}?>
<div class="container">
    <h3>EDIT USER</h3>
    <form method="post" id="userForm" enctype="multipart/form-data">
        <input type="hidden" name="userId" id="userId" value="<?echo $id?>">
        <div class="mb-3 w-50">
            <label for="email" class="form-lable">Email:</label>
            <input type="email" value="<?echo $email?>" class="form-control" id="email" placeholder="Add new role..." name="email">
        </div>

        <div class="mb-3 w-50">
            <label for="formFile" class="form-lable">User`s photo:</label>
            <input type="file" class="form-control" id="formFile" name="photo">
            <?
            if($dataUrl != ''){
            ?>
                <p class="mt-2">Current user`s photo: <img src="<? echo $dataUrl; ?>" alt="<?echo 'user_'.$id?>" style="width: 200px; height: auto;"></p>
            <?
            }
            else{
            ?>
                <p class="mt-2">There is no any user`s photo!</p>
            <?
            }
            ?>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-sm btn-success mb-5" name='edituser'>Save</button>
        </div>
    </form>     
</div>
<?
if(isset($_POST['edituser'])){
    $userId = $_POST['userId'];
    $email = $_POST['email'];
    $photoData = '';

    if($_FILES && $_FILES['photo']['error'] == UPLOAD_ERR_OK){
        $uploadPhoto = $_FILES['photo'];
        $fileTmpPath = $uploadPhoto['tmp_name'];
        $filesize = $uploadPhoto['size'];

        $maxSize = 500 * 1024; //500kB
        if($filesize > $maxSize ){
            echo "<div class='alert alert-danger'>The size of the photo is very big!</div>";
        }
        else{
            $photoData = file_get_contents($fileTmpPath);
            updateUserWithPhoto($userId, $email, $photoData);
        }
    }
    else{
        updateUserWithPhoto($userId, $email, $photoData);
    }

    
}
?>
