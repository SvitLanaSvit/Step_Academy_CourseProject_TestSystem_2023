<div class="users">
    <h3>Users</h3>
    <table class="table table-stripped mb-3">
        <thead>
            <tr>
                <th>Id</th>
                <th>Login</th>
                <th>Email</th>
                <th>Photo</th>
                <th>Role</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?
            include_once("/OSPanel/domains/CourseProject/functions/functions.php");
            $pdo = connect();
            $ps1 = $pdo->prepare("SELECT u.Id, u.Login, u.Email, u.Photo, r.RoleName FROM users u LEFT JOIN roles r ON r.Id = u.RoleId ORDER BY Id ASC");
            $ps1->execute();
            $ps1->setFetchMode(PDO::FETCH_NUM);
            while($row = $ps1->fetch()){
                echo "<tr>";
                echo "<td>$row[0]</td>";
                echo "<td>$row[1]</td>";
                echo "<td>$row[2]</td>";
                if($row[3] != null){
                    $base64image = base64_encode($row[3]);
                    $dataUrl = 'data:image/jpeg;base64,'.$base64image;
                    echo "<td><img src=$dataUrl alt='userId_".$row[0]."' style='width: 60px; height: auto;'></td>";
                }
                else{
                    echo "<td></td>";
                }
                echo "<td>$row[4]</td>";
                echo "<td><button class='btn btn-sm btn-warning' onclick='editUser(".$row[0].")'>Edit</button></td>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    function editUser(userId){
        window.location.href = 'index.php?page=11&userId=' + userId;
    }
</script>