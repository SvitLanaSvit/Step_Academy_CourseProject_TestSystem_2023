<div style="margin-bottom: 10px;">
    <button class="btn btn-secondary" onclick="showHidden()">Show list of Anwers</button>
</div>
<div class="answers" style="display: none;">
    <h3>Answers</h3>
    <table class="table table-stripped mb-3">
        <thead>
            <tr>
                <th>Id</th>
                <th>Question</th>
                <th>Answer</th>
                <th>Is true answer</th>
                <th>Delete</th>
                <th></th>
    
            </tr>
        </thead>
        <tbody>
            <?
            include_once("/OSPanel/domains/CourseProject/functions/functions.php");
            $pdo = connect();
    
            $ps1 = $pdo->prepare("SELECT a.Id, q.Question, a.AnswerText, a.AnswerPhoto, a.IsRealAnswer FROM answers a LEFT JOIN questions q ON a.QuestionId = q.Id ORDER BY Id ASC");
            $ps1->execute();
            $ps1->setFetchMode(PDO::FETCH_NUM);
            while ($row = $ps1->fetch()) {
                echo "<tr>";
                echo "<td>$row[0]</td>";
                if(strlen($row[1]) <= 50){
                    echo "<td>$row[1]</td>";
                }else{
                    echo "<td>".substr($row[1], 0,50)."...</td>";
                }
                if ($row[2] != '') {
                    if(strlen($row[2]) <= 20){
                        echo "<td>$row[2]</td>";
                    }else{
                        echo "<td>".substr($row[2], 0,20)."...</td>";
                    }
                } else {
                    echo "<td><img src='$row[3]' alt='$row[3]' style='width: 60px' onmouseover='anlangerImage(this)' onmouseout='resetImage(this)'></td>";
                }
                echo "<td>$row[4]</td>";
                echo "<td><input type='checkbox' class='form-check-input' name='delanswers[]' value='" . $row[0] . "' form='answerForm'/></td>";
                echo "<td><button class='btn btn-sm btn-warning' onclick='editAnswer($row[0])'>Edit</button></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<form method="post" id="answerForm" enctype="multipart/form-data">
    <div class="mb-3">
        <select class="form-select" aria-label="Default select example" name='questionId' required>
            <option value=0 selected>Choose question</option>
            <?
            $ps = getAllQuestions();
            while ($row = $ps->fetch()) {
                echo "<option value='" . $row['Id'] . "'>" . $row['Question'] . "</option>";
            }
            ?>
        </select>
    </div>

    <div class="mb-3">
            <label for="answerType">Answer type</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="answerType" value="text" id="textAnswer">
                <label class="form-check-label" for="textAnswer">Answer text</label>
            </div>
            <div>
                <input class="form-check-input" type="radio" name="answerType" value="photo" id="photoAnswer">
                <label class="form-check-label" for="photoAnswer">Answer photo</label>
            </div>
    </div>

    <div class="mb-3" id="textAnswerField" style="display: none;">
        <label for="floatingTextarea">Answer text</label>
        <textarea class="form-control" placeholder="Add new answer..." id="floatingTextarea" name="answerText"></textarea>
    </div>

    <div class="mb-3" id="photoAnswerField" style="display: none;">
        <label for="formFile" class="form-label">Answer photo</label>
        <input class="form-control" type="file" id="formFile" name="photo">
    </div>

    <div class="mb-3 w-50">
        <select class="form-select" aria-label="Default select example" name='isRealAnswer'>
            <option value=-1 selected>Choose is true answer</option>
            <option value=0>false</option>
            <option value=1>true</option>
        </select>
    </div>

    <div class="btn-group">
        <button type="submit" class="btn btn-sm btn-success" name='addanswer'>Add</button>
        <button type="submit" class="btn btn-sm btn-danger" name='delanswer'>Delete</button>
    </div>
</form>

<script>
    function editAnswer(answerId) {
        window.location.href = 'index.php?page=10&answerId=' + answerId;
    }

    const textAnswerField = document.getElementById('textAnswerField');
    const photoAnswerField = document.getElementById('photoAnswerField');
    const textAnswerRadio = document.getElementById('textAnswer');
    const photoAnswerRadio = document.getElementById('photoAnswer');

    textAnswerRadio.addEventListener('change', ()=>{
        textAnswerField.style.display = 'block';
        photoAnswerField.style.display = 'none';
    });

    photoAnswerRadio.addEventListener('change', ()=>{
        textAnswerField.style.display = 'none';
        photoAnswerField.style.display = 'block';
    });

    function showHidden(){
        const answerDiv = document.querySelector('.answers');
        const showButton = document.querySelector('.btn-secondary');

        if(answerDiv.style.display === 'none'){
            answerDiv.style.display = 'block';
            showButton.textContent = 'Hide List of Answers';
        }
        else{
            answerDiv.style.display = 'none';
            showButton.textContent = 'Show list of Anwers';
        }
    }

    function anlangerImage(imageElement){
        imageElement.style.width = '250px';
        imageElement.style.height = 'auto';
        imageElement.style.cursor = 'pointer';
    }

    function resetImage(imageElement){
        imageElement.style.width = '60px';
        imageElement.style.height = 'auto';
        imageElement.style.cursor = 'default';
    }
</script>

<style>
    img{
        transition: width 0.3s ease;
    }
</style>

<?
if (isset($_POST['addanswer'])) {
    $answerText = '';
    $questionId = $_POST['questionId'];
    $answerText = $_POST['answerText'];
    $isRealAnswer = $_POST['isRealAnswer'];
    $filepath = '';

    if ($_FILES && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $filename = $_FILES['photo']['name'];
        $filepath = 'assets/answerImages/' . $filename;
    }

    if ($questionId == 0) {
        echo "<script>alert(`Choose question!`)</script>";
        echo "<script>setTimeout(()=>{
                location = 'index.php?page=3';
            }, 10)</script>";
    } 

    if(!isset($_POST['answerType'])){
        echo "<script>alert(`Choose type of Answer!`)</script>";
        echo "<script>setTimeout(()=>{
                location = 'index.php?page=3';
            }, 10)</script>";
    }

    if ($isRealAnswer == '-1') {
        echo "<script>alert(`Choose true or false by answer!`)</script>";
        echo "<script>setTimeout(()=>{
                location = 'index.php?page=3';
            }, 10)</script>";
    }
    
    if ($answerText != '') {
        try {
            $ps2 = $pdo->prepare("INSERT INTO answers(`QuestionId`, `AnswerText`, `IsRealAnswer`) VALUES (?, ?, ?)");
            $ps2->bindParam(1, $questionId);
            $ps2->bindParam(2, $answerText);
            $ps2->bindParam(3, $isRealAnswer);
            $ps2->execute();
            echo "<script>location = document.URL</script>";
        } catch (PDOException $ex) {
            if($ex->getCode() == 23000){
                echo "<div class='alert alert-warning'>The answer is duplicated!</div>";
            }
            else{
                echo "<div class='alert alert-warning'>" . $ex->getMessage() . "</div>";
            } 
        } 
    } else if ($filepath != '') {
        try {
            $ps2 = $pdo->prepare("INSERT INTO answers(`QuestionId`, `AnswerPhoto`, `IsRealAnswer`) VALUES (?, ?, ?)");
            $ps2->bindParam(1, $questionId);
            $ps2->bindParam(2, $filepath);
            $ps2->bindParam(3, $isRealAnswer);
            $ps2->execute();
            echo "<script>location = document.URL</script>";
        } catch (PDOException $ex) {
            if($ex->getCode() == 23000){
                echo "<div class='alert alert-warning'>The answer is duplicated!</div>";
            }
            else{
                echo "<div class='alert alert-warning'>" . $ex->getMessage() . "</div>";
            } 
        }
    } 
}

if(isset($_POST['delanswers'])){
    $delanswers = $_POST['delanswers'];
    foreach($delanswers as $answerId){
        deleteAnswer($answerId);
    }

    echo "<script>location = document.URL</script>";
}
?>