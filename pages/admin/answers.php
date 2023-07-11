<table class="table table-stripped mb-3">
    <thead>
        <tr>
            <th>Id</th>
            <th>Question</th>
            <th>Answer</th>
            <th>Is true answer</th>
            <th></th>

        </tr>
    </thead>
    <tbody>
        <?
        $ps1 = $pdo->prepare("SELECT a.Id, q.Question, a.AnswerText, a.AnswerPhoto, a.IsRealAnswer FROM answers a LEFT JOIN questions q ON a.QuestionId = q.Id ORDER BY Id ASC");
        $ps1->execute();
        $ps1->setFetchMode(PDO::FETCH_NUM);
        while ($row = $ps1->fetch()) {
            echo "<tr>";
            echo "<td>$row[0]</td>";
            if(strlen($row[1]) <= 20){
                echo "<td>$row[1]</td>";
            }else{
                echo "<td>".substr($row[1], 0,20)."...</td>";
            }
            if ($row[2] != '') {
                if(strlen($row[2]) <= 10){
                    echo "<td>$row[2]</td>";
                }else{
                    echo "<td>".substr($row[2], 0,10)."...</td>";
                }
            } else {
                echo "<td><img src='$row[3]' alt='$row[3]' style='width: 60px'></td>";
            }
            echo "<td>$row[4]</td>";
            echo "<td><button class='btn btn-sm btn-warning' onclick='editAnswer($row[0])'>Edit</button></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

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
                <input class="form-check-input" type="radio" name="answerType" value="text" id="textAnswer" required>
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
        <select class="form-select" aria-label="Default select example" name='isRealAnswer' required>
            <option value=-1 selected>Choose is true answer</option>
            <option value=0>false</option>
            <option value=1>true</option>
        </select>
    </div>

    <div class="btn-group">
        <button type="submit" class="btn btn-sm btn-success" name='addanswer'>Add</button>
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
</script>

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
?>