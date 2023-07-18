<div class="results">
    <h3>Results</h3>
    <table class="table table-stripped mb-3">
        <thead>
            <tr>
                <th>Id</th>
                <th>Login</th>
                <th>Photo</th>
                <th>Category</th>
                <th>Date of test</th>
                <th>Result</th>
            </tr>
        </thead>
        <tbody>
            <?
            include_once("/OSPanel/domains/CourseProject/functions/functions.php");
            $pdo = connect();
    
            $ps1 = $pdo->prepare("SELECT res.Id, u.Login, u.Photo, cat.Category, res.DateTest, res.Result FROM results res
            LEFT JOIN users u ON res.UserId = u.Id
            LEFT JOIN categories cat ON cat.Id = res.CategoryId ORDER BY Id ASC");
            $ps1->execute();
            $ps1->setFetchMode(PDO::FETCH_NUM);
            while($row = $ps1->fetch()){
                echo "<tr>";
                echo "<td>$row[0]</td>";
                echo "<td>$row[1]</td>";
                if($row[2] != null){
                    $base64image = base64_encode($row[3]);
                    $dataUrl = 'data:image/jpeg;base64,'.$base64image;
                    echo "<td><img src=$dataUrl alt='userId_".$row[0]."'></td>";
                }
                else{
                    echo "<td></td>";
                }
                echo "<td>$row[3]</td>";
                echo "<td>$row[4]</td>";
                echo "<td>$row[5]</td>";
            }
            ?>
        </tbody>
    </table>
</div>