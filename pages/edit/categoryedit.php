<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category edit</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: transparent;
        }

        h3 {
            color: bisque;
        }
    </style>
</head>

<body>
    <?
    include_once("/OSPanel/domains/CourseProject/functions/functions.php");
    if (isset($_GET['categoryId'])) {
        $id = $_GET['categoryId'];

        $row = getCategoryById($id);
        $category = $row['Category'];
        $isBlocked = $row['IsBlocked'];
        $filepath = $row['ImagePath'];
    }
    ?>
    <div class="container">
        <h3>EDIT CATEGORY</h3>
        <form method="post" id="categoryForm" enctype="multipart/form-data">
            <input type="hidden" name="categoryId" id="categoryId" value="<? echo $id ?>">
            <div class="mb-3 w-25">
                <label for="category" class="form-label">Category</label>
                <input type="text" class="form-control" id="category" value="<? echo $category ?>" placeholder="Add new category..." name="category">
            </div>

            <div class="mb-3 w-25">
                <input type="checkbox" class="form-check-input" id="isBlocked" name="isBlocked" <? if ($isBlocked) echo 'checked' ?>>
                <label class="form-check-label" for="isBlocked">Is Blocked</label>
            </div>

            <div class="mb-3 w-25">
                <label for="formFile" class="form-label">Load Photo</label>
                <input class="form-control" type="file" id="formFile" name="photo">
                <? if ($filepath != null) { ?>
                    <p class="mt-2">Current image: <img src="<? echo $filepath; ?>" alt="Current image" style="width: 200px;"></p>
                <? } else { ?>
                    <p class="mt-2">Category has not any image!</p>
                <? } ?>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-sm btn-success mb-5" name='editcategory'>Save</button>
            </div>
        </form>
    </div>
    <?
    if (isset($_POST['editcategory'])) {
        $id = $_POST['categoryId'];
        $category = $_POST['category'];
        $isBlocked = isset($_POST['isBlocked']) ? 1 : 0;

        updateCategory($category, $isBlocked, $id);
    }
    ?>
</body>

</html>