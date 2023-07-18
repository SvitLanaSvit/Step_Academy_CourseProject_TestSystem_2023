<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Answer edit</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: transparent;
        }

        h3 {
            color: bisque;
        }
    </style>
</head>

<body>
    <?
    include_once("/OSPanel/domains/CourseProject/functions/functions.php");
    if (isset($_GET['answerId'])) {
        $id = $_GET['answerId'];

        $row = getAnswerById($id);
        $questionId = $row['QuestionId'];
        $answerText = $row['AnswerText'];
        $answerPhoto = $row['AnswerPhoto'];
        $isRealAnswer = $row['IsRealAnswer'];
    }
    ?>
    <div class="container">
        <h3>EDIT ANSWER</h3>
        <form method="post" id="answerForm" enctype="multipart/form-data">
            <input type="hidden" name="answerId" id="answerId" value="<? echo $id ?>">
            <div class="mb-3 w-50">
                <label for="questionId">Question:</label>
                <select class="form-select" aria-label="Default select example" name='questionId' id="questionId">
                    <?
                    $ps = getAllQuestions();
                    while ($row = $ps->fetch()) {
                        $selected = ($row['Id'] == $questionId) ? 'selected' : '';
                        echo "<option value='" . $row['Id'] . "' $selected>" . $row['Question'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="answerType">Answer type:</label>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="answerType" value="text" id="textAnswer" required>
                    <label for="textAnswer" class="form-check-label">Answer text</label>
                </div>
                <div>
                    <input type="radio" class="form-check-input" name="answerType" value="photo" id="photoAnswer">
                    <label for="photoAnswer" class="form-check-label">Answer photo</label>
                </div>
            </div>

            <div class="mb-3 w-50" id="textAnswerField" style="display: none;">
                <label for="answerText" class="form-label">Answer text</label>
                <?
                if ($answerText != null) {
                ?>
                    <textarea class="form-control" placeholder="Add new answer..." id="floatingTextarea" name="answerText"><? echo $answerText ?></textarea>
                <?
                } else {
                ?>
                    <textarea class="form-control" placeholder="Add new answer..." id="floatingTextarea" name="answerText"></textarea>
                <?
                }
                ?>
            </div>

            <div class="mb-3 w-50" id="photoAnswerField" style="display: none;">
                <label for="formFile" class="form-label">Answer photo</label>
                <input class="form-control" type="file" id="formFile" name="photo">
                <?
                if ($answerPhoto != null) {
                ?>
                    <p class="mt-2">Current answer photo: <img src="<? echo $answerPhoto; ?>" alt="Current answer photo" style="width: 200px;"></p>
                <?
                } else {
                ?>
                    <p class="mt-2">There is no any photo answer!</p>
                <?
                }
                ?>
            </div>

            <div class="mb-3 w-25">
                <select class="form-select" aria-label="Default select example" name='isRealAnswer' required>
                    <?
                    $isRealAnswers = array('0' => 'false', '1' => 'true');
                    foreach($isRealAnswers as $isAnswerTrue=>$val){
                        $selected = ($isRealAnswer == $isAnswerTrue) ? 'selected' : '';
                        echo "<option value='$isAnswerTrue' $selected>$val</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-sm btn-success mb-5" name='editanswer'>Save</button>
            </div>
        </form>
    </div>
</body>

<script>
    const textAnswerField = document.getElementById('textAnswerField');
    const photoAnswerField = document.getElementById('photoAnswerField');
    const textAnswerRadio = document.getElementById('textAnswer');
    const photoAnswerRadio = document.getElementById('photoAnswer');

    textAnswerRadio.addEventListener('change', () => {
        textAnswerField.style.display = 'block';
        photoAnswerField.style.display = 'none';
    });

    photoAnswerRadio.addEventListener('change', () => {
        photoAnswerField.style.display = 'block';
        textAnswerField.style.display = 'none';
    });
</script>

<?
if (isset($_POST['editanswer'])) {
    $id = $_POST['answerId'];
    $questionId = $_POST['questionId'];
    $answerText = '';
    $answerPhoto = '';
    $isRealAnswer = $_POST['isRealAnswer'];

    $row = getAnswerById($id);

    if($_POST['answerType'] === 'text'){
        if(isset($_POST['answerText'])){
            if($_POST['answerText'] == ''){
                echo "<div class='alert alert-danger'>Write text for the answer!</div>";
            }
            else{
                $answerText = $_POST['answerText'];
                updateAnswer($questionId, $answerText, $answerPhoto, $isRealAnswer, $id);
            }
        }
    }
    else if($_POST['answerType'] === 'photo'){
        if ($_FILES && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
            $filename = $_FILES['photo']['name'];
            $answerPhoto = 'assets/answerImages/' . $filename;
            updateAnswer($questionId, $answerText, $answerPhoto, $isRealAnswer, $id);
        }
        else{
            if($row['AnswerPhoto'] != null){
                $answerPhoto = $row['AnswerPhoto'];
                updateAnswer($questionId, $answerText, $answerPhoto, $isRealAnswer, $id);
            }
            else{
                echo "<div class='alert alert-danger'>Choose photo for the answer!</div>";
            }
        }
    }
}
?>

</html>