<?
include_once("/OSPanel/domains/CourseProject/functions/functions.php");
$pdo = connect();
?>
<div class="container">
    <h3>ADMIN PAGE</h3>
    <div class="row row-cols-2">
        <div class="col" style="padding: 5px;">
            <h3>Categories</h3>
            <?
            include_once("admin/categories.php");
            ?>
        </div>
        <div class="col" style="padding: 5px;">
            <h3>Roles</h3>
            <?
            include_once("admin/roles.php");
            ?>
        </div>
        <div class="col" style="padding: 5px;">
            <a href="index.php?page=15" style="text-decoration: none; display: flex;">
                <h3>Questions</h3>
                <img src="/assets/another/new_click.png" style="width: 30px; height: 30px;" alt="icon_click">
            </a>
        </div>
        <div class="col" style="padding: 5px;">
            <a href="index.php?page=16" style="text-decoration: none; display: flex;">
                <h3>Answers</h3>
                <img src="/assets/another/new_click.png" style="width: 30px; height: 30px;" alt="icon_click">
            </a>
        </div>
        <div class="col" style="padding: 5px;">
            <a href="index.php?page=17" style="text-decoration: none; display: flex;">
                <h3>Users</h3>
                <img src="/assets/another/new_click.png" style="width: 30px; height: 30px;" alt="icon_click">
            </a>
        </div>
        <div class="col" style="padding: 5px;">
            <a href="index.php?page=18" style="text-decoration: none; display: flex;">
                <h3>Results</h3>
                <img src="/assets/another/new_click.png" style="width: 30px; height: 30px;" alt="icon_click">
            </a>
            <!-- <h3>Results</h3>
            <?
            include_once("admin/results.php");
            ?> -->
        </div>
    </div>
</div>
