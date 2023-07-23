<?
include_once("/OSPanel/domains/CourseProject/functions/functions.php");
?>
<h3>TESTS</h3>
<div class="container">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
        <?
        $ps = getAllCategoriesIsNotBloked();
        $countLink = 19;
        while($row = $ps->fetch()) {
            $encodedCategory = urlencode(strtolower($row['Category']));
        ?>
        <div class="card mb-3" style="background-color: rgba(47, 79, 79, 0.8);">
            <a style="text-align: center; text-decoration: none; color: white;" href="?page=<?=$countLink?>&category=<?=$encodedCategory?>">
                <h4><?=strtoupper($row['Category'])?></h4>
                <img style="width: auto; height: 200px; " src="<?=$row['ImagePath']?>" alt="<?=$row['Category']?>">
            </a>
        </div>
        <?
        }
        ?>
    </div>
</div>