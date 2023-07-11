<table class="table table-stripped mb-3">
    <thead>
        <tr>
            <th>Id</th>
            <th>Role name</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?
        $ps1 = $pdo->prepare("SELECT Id, RoleName FROM roles ORDER BY Id ASC");
        $ps1->execute();
        $ps1->setFetchMode(PDO::FETCH_NUM);
        while($row = $ps1->fetch()){
            echo "<tr>";
            echo "<td>$row[0]</td>";
            echo "<td>$row[1]</td>";
            echo "<td><button class='btn btn-sm btn-warning' onclick='editRole($row[0])'>Edit</button></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<form method="post" id="roleForm">
    <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <input type="text" class="form-control" id="role" placeholder="Add new role..." name="role" required>
    </div>

    <div class="btn-group">
        <button type="submit" class="btn btn-sm btn-success" name='addrole'>Add</button>
    </div>
</form>

<script>
    function editRole(roleId){
        window.location.href = 'index.php?page=8&roleId=' + roleId;
    }
</script>

<?
if(isset($_POST['addrole'])){
    $role = $_POST['role'];

    try{
        $ps2 = $pdo->prepare("INSERT INTO roles(`RoleName`)VALUES(?)");
        $ps2->bindParam(1, $role);
        $ps2->execute();
        echo "<script>location = document.URL</script>";
    }catch(PDOException $ex){
        echo "<div class='alert alert-warning'>" . $ex->getMessage() . "</div>";
    }
}
?>