<table class="table table-stripped mb-3">
    <thead>
        <tr>
            <th>Id</th>
            <th>Category</th>
            <th>Is Blocked</th>
            <th>Image path</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?
        $ps1 = $pdo->prepare("SELECT Id, Category, IsBlocked, ImagePath FROM categories ORDER BY Id ASC");
        $ps1->execute();
        $ps1->setFetchMode(PDO::FETCH_NUM);
        while($row = $ps1->fetch()){
            echo "<tr>";
            echo "<td>$row[0]</td>";
            echo "<td>$row[1]</td>";
            echo "<td>$row[2]</td>";
            echo "<td><img style='width: 30px' src='$row[3]' alt='$row[3]'></td>";
            echo "<td><button class='btn btn-sm btn-warning' onclick='editCategory($row[0])'>Edit</button></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<form method="post" id="categoryForm" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="category" class="form-label">Category</label>
        <input type="text" class="form-control" id="category" placeholder="Add new category..." name="category" required>
    </div>

    <div class="mb-3">
        <label for="formFile" class="form-label">Load Photo</label>
        <input class="form-control" type="file" id="formFile" name="photo">
    </div>

    <div class="btn-group">
        <button type="submit" class="btn btn-sm btn-success" name='addcategory'>Add</button>
    </div>
</form>

<script>
    function editCategory(categoryId){
        window.location.href = 'index.php?page=7&categoryId='+categoryId;
    }
</script>

<?
if(isset($_POST['addcategory'])){
    $category = $_POST['category'];
    $filepath = '';

    if($_FILES && $_FILES['photo']['error'] == UPLOAD_ERR_OK){
        $filename = $_FILES['photo']['name'];
        $filepath = 'assets/categoryImages/'.$filename;
    }

    try{
        $ps2 = $pdo->prepare("INSERT INTO categories(`Category`, `ImagePath`)VALUES(?, ?)");
        $ps2->bindParam(1, $category);
        $ps2->bindParam(2, $filepath);
        $ps2->execute();
        echo "<script>location = document.URL</script>";
    }catch(PDOException $ex){
        echo "<div class='alert alert-warning'>" . $ex->getMessage() . "</div>";
    }
}
?>