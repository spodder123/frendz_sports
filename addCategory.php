<?php

require('connect.php');

session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "INSERT INTO categories (category_name, category_description) VALUES (:cname, :cdescription)";
    $statement = $db->prepare($query);
    $statement->bindValue(':cname', $name);
    $statement->bindValue(':cdescription', $description);
    $statement->execute();

    header('Location: adminDashboard.php');
    exit;

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <link rel="stylesheet" href="./styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>
<body>
      <?php include ('header.php'); ?>
        <div class="row mb-3 shadow-sm p-3 mb-5 bg-body rounded px-0 mx-0">
            <h2 class="col text-center">Add New Category</h2>
        </div>
        <form action="addCategory.php" method="post">

          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" placeholder="Name of the category" name="name" required>
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" class="form-control" id="description" placeholder="Description of the category" name="description" required>
          </div>
          <div class="row mb-3">
            <div class="col d-grid gap-2 d-md-flex justify-content-md-end">
              <input type="submit" name="post-btn" class="btn btn-primary" value="Add Category">
            </div>
          </div>
        </form>


      <?php include ('footer.php'); ?>

</body>
</html>
