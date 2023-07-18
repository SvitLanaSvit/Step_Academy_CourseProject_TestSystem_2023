<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question edit</title>

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
if(isset($_GET['questionId'])){
    $id = $_GET['questionId'];

    $row = getQuestionById($id);
    $question = $row['Question'];
    $filepath = $row['ImagePath'];
    $categoryId = $row['CategoryId'];
}
?>
<div class="container">
    <h3>EDIT QUESTION</h3>  
    <form method="post" id="questionForm" enctype="multipart/form-data">
        <input type="hidden" name="questionId" id="questionId" value="<?echo $id?>">
        <div class="mb-3 w-50">
            <textarea class="form-control" placeholder="Add new question..." id="floatingTextarea"  name="question" required style="height: 150px;"><?echo $question?></textarea>
            <label for="floatingTextarea">Ouestion</label>
        </div>

        <div class="mb-3 w-50">
            <label for="formFile" class="form-label">Load Photo</label>
            <input class="form-control" type="file" id="formFile" name="photo">
            <?if($filepath != null){?>
                <p class="mt-2">Current image: <img src="<?echo $filepath;?>" alt="Current image" style="width: 200px;"></p>
            <?} else{?>
                <p class="mt-2">The question has not any image!</p>
            <?}?>
        </div>

        <div class="mb-3 w-25">
            <select class="form-select" aria-label="Default select example" name='categoryId'>
                <option value=0>Choose category</option>
                <?
                $ps = getAllCategories();
                while ($row = $ps -> fetch()) {
                    $selected = ($row['Id'] == $categoryId) ? 'selected' : '';
                    echo "<option value='" . $row['Id'] . "' $selected>" . $row['Category'] . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-sm btn-success mb-5" name='editquestion'>Save</button>
        </div>
    </form>     
</div>
<?
    if(isset($_POST['editquestion'])){
        $id = $_POST['questionId'];
        $question = $_POST['question'];
        $categoryId = $_POST['categoryId'];
    
        updateQuestion($question, $categoryId, $id);
    }
?>
</body>
</html>