<div style="margin-bottom: 10px;">
    <button class="btn btn-secondary" onclick="showHidden()">Show list of Questions</button>
</div>
<div class="questions" style="display: none;">
    <h3>Questions</h3>
    <table class="table table-stripped mb-3">
        <thead>
            <tr>
                <th>Id</th>
                <th>Question</th>
                <th>Image path</th>
                <th>Category</th>
                <th>Is Blocked</th>
                <th>Delete</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?
            include_once("/OSPanel/domains/CourseProject/functions/functions.php");
            $pdo = connect();
            $ps1 = $pdo->prepare("SELECT q.Id, q.Question, q.ImagePath, c.Category, q.IsBlocked FROM questions q LEFT JOIN categories c ON c.Id = q.CategoryId ORDER BY Id ASC");
            $ps1->execute();
            $ps1->setFetchMode(PDO::FETCH_NUM);
            while($row = $ps1->fetch()){
                echo "<tr>";
                echo "<td>$row[0]</td>";
                if(strlen($row[1]) <= 50){
                    echo "<td>$row[1]</td>";
                }
                else{
                    echo "<td>".substr($row[1], 0, 50)."...</td>";
                }
                echo "<td><img src='$row[2]' style='width: 60px' alt='$row[2]' onmouseover='enlargeImage(this)' onmouseout='resetImage(this)'></td>";
                echo "<td>$row[3]</td>";
                echo "<td>$row[4]</td>";
                if($row[4] == 0){
                    echo "<td><input type='checkbox' class='form-check-input' name='delquestions[]' value='" . $row[0] . "' form='questionForm'/></td>";
                }
                else{
                    echo "<td></td>";
                }
                echo "<td><button class='btn btn-sm btn-warning' onclick='editQuestion($row[0])'>Edit</button></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<form method="post" id="questionForm" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="floatingTextarea">Ouestion</label>
        <textarea class="form-control" placeholder="Add new question..." id="floatingTextarea" name="question"></textarea>
    </div>

    <div class="mb-3">
        <label for="formFile" class="form-label">Load Photo</label>
        <input class="form-control" type="file" id="formFile" name="photo">
    </div>

    <div class="mb-3 w-50">
        <select class="form-select" aria-label="Default select example" name='categoryId'>
            <option value=0 selected>Choose category</option>
            <?
            $ps = getAllCategories();
            while ($row = $ps -> fetch()) {
                echo "<option value='" . $row['Id'] . "'>" . $row['Category'] . "</option>";
            }
            ?>
        </select>
    </div>

    <div class="btn-group">
        <button type="submit" class="btn btn-sm btn-success" name='addquestion'>Add</button>
        <button type="submit" class="btn btn-sm btn-danger" name='deletequestions'>Delete</button>
    </div>
</form>

<script>
    function editQuestion(questionId){
        window.location.href = 'index.php?page=9&questionId=' + questionId;
    }

    function showHidden(){
        const questionDiv = document.querySelector('.questions');
        const showButton = document.querySelector('.btn-secondary');

        if(questionDiv.style.display === 'none'){
            questionDiv.style.display = 'block';
            showButton.textContent = 'Hide list of Questions'
        }
        else{
            questionDiv.style.display = 'none';
            showButton.textContent = 'Show list of Questions'
        }
    }

    function enlargeImage(imageElement){
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
if(isset($_POST['addquestion'])){
    $question = '';
    $question = $_POST['question'];
    $categoryId = $_POST['categoryId'];
    $filepath = '';

    if($_FILES && $_FILES['photo']['error'] == UPLOAD_ERR_OK){
        $filename = $_FILES['photo']['name'];
        $filepath = 'assets/questionImages/'.$filename;
    }

    if($question == ''){
        echo "<script>alert(`Put a question!`)</script>";
        echo "<script>setTimeout(()=>{
                location = 'index.php?page=3';
            }, 10)</script>";
    }
    else{
        try{
            $ps2 = $pdo->prepare("INSERT INTO questions(`Question`, `ImagePath`, `CategoryId`)VALUES(?, ?, ?)");
            $ps2->bindParam(1, $question);
            $ps2->bindParam(2, $filepath);
            $ps2->bindParam(3, $categoryId);
            $ps2->execute();
            echo "<script>location = document.URL</script>";
        }catch(PDOException $ex){
            if($ex->getCode() == 23000){
                echo "<div class='alert alert-danger'>Choose category!!!</div>"; 
            }
            else{
                echo "<div class='alert alert-warning'>" . $ex->getMessage() . "</div>";
            }
        }
    }
}

if(isset($_POST['delquestions'])){
    $delquestions = $_POST['delquestions'];
    $count = count($delquestions);
    foreach($delquestions as $questionId){
        deleteQuestion($questionId);
    }

    echo "<script>location = document.URL</script>";
}
?>