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
            <h3>Questions</h3>
            <?
            include_once("admin/questions.php");
            ?>
        </div>
        <div class="col" style="padding: 5px;">
            <h3>Answers</h3>
            <?
            include_once("admin/answers.php");
            ?>
        </div>
    </div>
</div>
