<?php

require('connect.php');

session_start();

$errorFlag = false;
$errorMessage = "";

if(!isset($_GET['id'])){
    $query = "SELECT * FROM categories";
    $statement = $db->prepare($query);
    $statement->execute();
    $rows = $statement->fetchAll();
} else {
    $category_id = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);

    $query = "SELECT * FROM categories WHERE category_id = {$category_id}";
    $statement = $db->prepare($query);
    $statement->execute();
    $row = $statement->fetch();
}




if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


    if (empty($name) || empty($description) ) {
        $errorFlag = true;
        $errorMessage = "All fields are required.";
    } else {
        if (isset($_POST['update-btn'])) {



            $query = "UPDATE categories SET category_name = :cname, category_description = :cdescription  WHERE category_id = :id";
            $statement = $db->prepare($query);
            $statement->bindValue(':cname', $name);
            $statement->bindValue(':cdescription', $description);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();


            header('Location: adminDashboard.php');
            exit;
        } else if(isset($_POST['delete-btn'])){

            $query = "DELETE FROM categories WHERE category_id = :category_id";
            $statement = $db->prepare($query);
            $statement->bindValue(':category_id', $id, PDO::PARAM_INT);
            $statement->execute();

            header('Location: adminDashboard.php');
            exit;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Categories</title>
<link rel="stylesheet" href="./styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>
<body>
    <div id="content">


<?php include ('header.php'); ?>

    <?php if(isset($_GET['id'])): ?>
        <div class="row mb-3 shadow-sm p-3 mb-5 bg-body rounded px-0 mx-0">
            <h2 class="col text-center">Editing Category</h2>
        </div>
        <form action="editCategory.php" method="post">
        <input type="hidden" name="id" value="<?= $row['category_id'] ?>">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" placeholder="Name of the category" name="name" value="<?= $row['category_name'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" class="form-control" id="description" placeholder="Description of the category" name="description" value="<?= $row['category_description'] ?>" required>
        </div>

        <div class="col d-grid gap-2 d-md-flex justify-content-md-end">
            <input type="submit" name="update-btn" class="btn btn-success" value="Update">
            <input type="submit" name="delete-btn" class="btn btn-danger" value="Delete" onclick="return confirm('Are you sure you wish to delete this category?')">
        </div>
        </form>
    <?php else: ?>
        <div class="row mb-3 shadow-sm p-3 mb-5 bg-body rounded px-0 mx-0">
            <h2 class="col text-center">Edit Categories</h2>
        </div>
        <p class="text-center text-light bg-dark mt-0 mb-1 border-warning border border-1">To edit a category, simply click on its name.</p>
        <?php foreach($rows as $key => $row): ?>
    <div class="row text-center bg-warning w-80 px-0 mx-0">
        <p><a href="editCategory.php?id=<?= $row['category_id'] ?>" class="text-decoration-none link-dark"><?= $row['category_name'] ?></a></p>
    </div>
        <?php if($key !== array_key_last($rows)): ?>
            <hr class="mb-0 mt-1">
        <?php endif ?>

        <?php endforeach ?>
    <?php endif?>


    <?php if($errorFlag): ?>
        <div class="alert alert-danger" role="alert">
            <p class="text-center text-danger"><?= $errorMessage ?></p>
        </div>
    <?php endif ?>

    <?php include ('footer.php'); ?>
    </div>
</body>
</html>
