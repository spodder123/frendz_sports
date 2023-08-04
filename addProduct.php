<?php

require('connect.php');
require __DIR__ . DIRECTORY_SEPARATOR . 'php-image-resize-master' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'ImageResize.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'php-image-resize-master' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'ImageResizeException.php';
use \Gumlet\ImageResize;

session_start();

$errorFlag = false;
$errorMessage = "";



$query = "SELECT * FROM categories";
$statement = $db->prepare($query);
$statement->execute();
$categories = $statement->fetchAll();

function file_upload_path($original_filename, $upload_subfolder_name = 'uploads') {
    $current_folder = dirname(__FILE__);
    $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
    return join(DIRECTORY_SEPARATOR, $path_segments);
 }

 function file_is_an_image($temporary_path, $new_path) {
    $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
    $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];

    $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
    $actual_mime_type        = getimagesize($temporary_path)['mime'];

    $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
    $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);

    return $file_extension_is_valid && $mime_type_is_valid;
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $category_id = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_NUMBER_INT);

    $availability = isset($_POST['available']) ? $_POST['available'] : (isset($_POST['not-available']) ? $_POST['not-available'] : '');

    $availability = $availability == "available" ? 1 : ($availability == "not-available" ? 0 : 'not-set');

    if ($category_id == "0"){
        $errorFlag = true;
        $errorMessage = "Choose a category.";
    } else if ( $availability == "not-set") {
        $errorFlag = true;
        $errorMessage = "Choose product availability.";
    } else {
            $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
            $upload_error_detected = isset($_FILES['image']) && ($_FILES['image']['error'] > 0);

            if ($image_upload_detected) {
                $image_filename        = $_FILES['image']['name'];
                $temporary_image_path  = $_FILES['image']['tmp_name'];
                $new_image_path        = file_upload_path($image_filename);

                if (file_is_an_image($temporary_image_path, $new_image_path)) {
                    $image = new ImageResize($temporary_image_path);
                    $image->resizeToBestFit(200, 200);
                    $image->save($new_image_path);


                    $query = "INSERT INTO images (image_filename) VALUES (:imagefilename)";
                    $statement = $db->prepare($query);
                    $statement->bindValue(':imagefilename', $image_filename);
                    $statement->execute();
                    $imageID = $db->lastInsertId();


                    $query1 = "INSERT INTO products (category_id, image_id, product_name, product_description, product_price, product_availability) VALUES (:category_id, :imageID, :pname, :pdescription, :pprice , :pavailability)";
                    $statement1 = $db->prepare($query1);
                    $statement1->bindValue(':pname', $name);
                    $statement1->bindValue(':pdescription', $description);
                    $statement1->bindValue(':pprice', $price);
                    $statement1->bindValue(':pavailability', $availability);
                    $statement1->bindValue(':category_id', $category_id, PDO::PARAM_INT);
                    $statement1->bindValue(':imageID', $imageID, PDO::PARAM_INT);
                    $statement1->execute();

                    header('Location: adminDashboard.php');
                    exit;
                } else{
                    $errorFlag = true;
                    $errorMessage = "Sorry, the file you uploaded is not an image. Please upload an image file (JPG, PNG, JPEG, GIF).";
                }

        } else{
            $imageID = 1;
            $query = "INSERT INTO products (category_id, image_id, product_name, product_description, product_price, product_availability) VALUES (:category_id, :imageID, :pname, :pdescription, :pprice , :pavailability)";
            $statement = $db->prepare($query);
            $statement->bindValue(':pname', $name);
            $statement->bindValue(':pdescription', $description);
            $statement->bindValue(':pprice', $price);
            $statement->bindValue(':pavailability', $availability);
            $statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);
            $statement->bindValue(':imageID', $imageID, PDO::PARAM_INT);
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
    <title>Add Product</title>
    <link rel="stylesheet" href="./styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>
<body>
    <?php include ('header.php'); ?>

      <div class="row mb-3 shadow-sm p-3 mb-5 bg-body rounded px-0 mx-0">
        <h2 class="col text-center">Add New Product</h2>
      </div>
      <form action="addProduct.php" method="post" enctype="multipart/form-data">

      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" placeholder="Name of the product" name="name" value="" required>
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <input type="text" class="form-control" id="description" placeholder="Description of the product" name="description" required>
      </div>
      <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" step="0.01" min="0" class="form-control" id="price" placeholder="Price of the product" name="price" required>
      </div>

      <select class="form-select" aria-label="Category select" name="category">
        <option value="0">Choose a category</option>
        <?php foreach ($categories as $category): ?>
        <option value="<?= $category['category_id'] ?>"><?= $category['category_name'] ?></option>
        <?php endforeach ?>
      </select>

      <br>

      <p>Availability</p>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="available" id="available" value="available">
        <label class="form-check-label" for="available">
          Available
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="radio" name="not-available" id="not-available" value="not-available">
        <label class="form-check-label" for="not-available">
          Not Available
        </label>
      </div>


        <div class="row d-flex align-items-center">

          <div class="col-8 my-3">
              <label for="image" class="form-label">Product Image <i class="fw-lighter">(Optional)</i></label>
              <input class="form-control" type="file" id="image" name="image">
          </div>

        </div>


      <div class="row mb-3">
        <div class="col d-grid gap-2 d-md-flex justify-content-md-end">
          <input type="submit" name="post-btn" class="btn btn-primary" value="Add Product">
        </div>
      </div>
      </form>

      <?php if($errorFlag): ?>
        <div class="alert alert-danger" role="alert">
          <p class="text-center text-danger"><?= $errorMessage ?></p>
        </div>
      <?php endif ?>

      <?php include ('footer.php'); ?>
</body>
</html>
