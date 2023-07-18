<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <h3>ADD PHOTO</h3>
        <form method="post" id="userForm" enctype="multipart/form-data">
            <div class="mb-3 w-50">
                <label for="formFile" class="form-label">Load user photo</label>
                <input class="form-control" type="file" id="formFile" name="photo">
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-sm btn-success" name='addphoto'>Add</button>
            </div>
        </form>
    </div>
</body>

<?
include_once('/OSPanel/domains/CourseProject/functions/functions.php');
if(isset($_POST['addphoto'])){
    if(isset($_GET['userId'])){
        $userId = $_GET['userId'];

        if($_FILES && $_FILES['photo']['error'] == UPLOAD_ERR_OK){
            $uploadPhoto = $_FILES['photo'];
            $fileTmpPath = $uploadPhoto['tmp_name'];
            $fileSize = $uploadPhoto['size']; 
        }
    
        $maxSize = 500 * 1024; // 500kB
        if($fileSize > $maxSize){
            echo "<div class='alert alert-danger'>The size of the photo is very big!</div>";
        }
        else{
            $photoData = file_get_contents($fileTmpPath);
            //$photoData = addslashes($photoData); // Escaping special characters
    
            addPhotoUserToSQL($photoData, $userId);
        }
    }
    else{
        echo "<div class='alert alert-danger'>There is a problem with get id of user!</div>";
    }
    
}
?>

</html>