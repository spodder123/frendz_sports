<?php

require('connect.php');
require __DIR__ . DIRECTORY_SEPARATOR . 'php-image-resize-master' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'ImageResize.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'php-image-resize-master' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'ImageResizeException.php';
use \Gumlet\ImageResize;
session_start();


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


if(!isset($_GET['id'])){
    $query = "SELECT * FROM products";
    $statement = $db->prepare($query);
    $statement->execute();
    $rows = $statement->fetchAll();
}

if(!empty($_GET['id'])){
    $id = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);

    $query = "SELECT * FROM products WHERE product_id = {$id}";
    $statement = $db->prepare($query);
    $statement->execute();
    $row = $statement->fetch();


    $query = "SELECT * FROM categories";
    $statement = $db->prepare($query);
    $statement->execute();
    $categories = $statement->fetchAll();
}

$errorFlag = false;
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $product_id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $category_id = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_NUMBER_INT);


    $availability = intval($_POST['availability']);
    echo $availability;

    if (empty($name) || empty($description) || empty($price) || ($availability !== 0 && $availability !== 1)) {
        $errorFlag = true;
        $errorMessage = "All fields are required.";
    } elseif (!is_numeric($price)) {
        $errorFlag = true;
        $errorMessage = "Price must be numeric.";
    } else {
        if (isset($_POST['update-btn'])) {



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


                    $imageID = filter_input(INPUT_POST, 'imageID', FILTER_SANITIZE_NUMBER_INT);
                    if($imageID > 1){
                        $queryImage = "SELECT * FROM images WHERE image_id = :imageID";
                        $statement3 = $db->prepare($queryImage);
                        $statement3->bindValue(':imageID', $imageID);
                        $statement3->execute();
                        $image = $statement3->fetch();

                        unlink(file_upload_path($image['image_filename']));

                        $query = "DELETE FROM images WHERE image_id = :imageID";
                        $statement2 = $db->prepare($query);
                        $statement2->bindValue(':imageID', $imageID);
                        $statement2->execute();
                    }



                    $query1 = "INSERT INTO images (image_filename) VALUES (:imagefilename)";
                    $statement1 = $db->prepare($query1);
                    $statement1->bindValue(':imagefilename', $image_filename);
                    $statement1->execute();
                    $imageID = $db->lastInsertId();



                    $query = "UPDATE products SET category_id = :category_id, image_id = :imageID, product_name = :pname, product_description = :pdescription, product_price = :pprice, product_availability = :pavailability WHERE product_id = :product_id";
                    $statement = $db->prepare($query);
                    $statement->bindValue(':imageID', $imageID);
                    $statement->bindValue(':pname', $name);
                    $statement->bindValue(':pdescription', $description);
                    $statement->bindValue(':pprice', $price);
                    $statement->bindValue(':pavailability', $availability);
                    $statement->bindValue(':product_id', $product_id, PDO::PARAM_INT);
                    $statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);
                    $statement->execute();


                    header('Location: editProduct.php');
                } else{
                    $errorFlag = true;
                    $errorMessage = "Sorry, the file you uploaded is not an image. Please upload an image file (JPG, PNG, JPEG,GIF).";
                }
       } else {
        $query = "UPDATE products SET category_id = :category_id, product_name = :pname, product_description = :pdescription, product_price = :pprice, product_availability = :pavailability WHERE product_id = :product_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':pname', $name);
        $statement->bindValue(':pdescription', $description);
        $statement->bindValue(':pprice', $price);
        $statement->bindValue(':pavailability', $availability);
        $statement->bindValue(':product_id', $product_id, PDO::PARAM_INT);
        $statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $statement->execute();

        header('Location: editProduct.php');
   }
}else if(isset($_POST['delete-image'])){
            $imageID = filter_input(INPUT_POST, 'imageID', FILTER_SANITIZE_NUMBER_INT);
            $queryImage = "SELECT * FROM images WHERE image_id = :imageID";
            $statement3 = $db->prepare($queryImage);
            $statement3->bindValue(':imageID', $imageID);
            $statement3->execute();
            $image = $statement3->fetch();

            unlink(file_upload_path($image['image_filename']));

            $query = "DELETE FROM images WHERE image_id = :imageID";
            $statement2 = $db->prepare($query);
            $statement2->bindValue(':imageID', $imageID);
            $statement2->execute();

            $imageID = 1;
            $query1 = "UPDATE products SET category_id = :category_id, image_id = :imageID, product_name = :pname, product_description = :pdescription, product_price = :pprice, product_availability = :pavailability WHERE product_id = :product_id";
            $statement1 = $db->prepare($query1);
            $statement1->bindValue(':imageID', $imageID);
            $statement1->bindValue(':pname', $name);
            $statement1->bindValue(':pdescription', $description);
            $statement1->bindValue(':pprice', $price);
            $statement1->bindValue(':pavailability', $availability);
            $statement1->bindValue(':product_id', $product_id, PDO::PARAM_INT);
            $statement1->bindValue(':category_id', $category_id, PDO::PARAM_INT);
            $statement1->execute();
            header('Location: editProduct.php');

       } else if(isset($_POST['delete-btn'])){
            $query = "DELETE FROM products WHERE product_id = :product_id";
            $statement = $db->prepare($query);
            $statement->bindValue(':product_id', $product_id, PDO::PARAM_INT);
            $statement->execute();
            header('Location: editProduct.php');
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
    <title>Edit Product</title>
    <link rel="stylesheet" href="./styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>
<body>
    <div id="content">
        <?php include ('header.php'); ?>
        <?php if($errorFlag): ?>
        <div class="alert alert-danger" role="alert">
            <p class="text-center text-danger"><?= $errorMessage ?></p>
        </div>
        <?php endif ?>
        <?php if(isset($_GET['id'])): ?>
        <div class="row mb-3 shadow-sm p-3 mb-5 bg-body rounded px-0 mx-0">
            <h2 class="col text-center">Editing Product</h2>
        </div>
    <form action="editProduct.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $row['product_id'] ?>">

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" placeholder="Name of the product" name="name" value="<?= $row['product_name'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" class="form-control" id="description" placeholder="Description of the product" name="description" value="<?= $row['product_description'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" min="0" class="form-control" id="price" placeholder="Price of the product" name="price" value="<?= $row['product_price'] ?>" required>
        </div>

        <select class="form-select" aria-label="Category select" name="category">
            <option value="0">Choose a category</option>
            <?php foreach ($categories as $category): ?>
            <option value="<?= $category['category_id'] ?>" <?= $category['category_id'] === $row['category_id'] ? 'selected' : '' ?>><?= $category['category_name'] ?></option>
            <?php endforeach ?>
        </select>

        <br>

        <p>Availability</p>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="availability" id="availability" value="1" <?php echo $row['product_availability'] == 1 ? 'checked' : ''; ?>>
            <label class="form-check-label" for="availability">
                Available
            </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="availability" id="non-availability" value="0" <?php echo $row['product_availability'] == 0 ? 'checked' : ''; ?>>
            <label class="form-check-label" for="availability">
                Not Available
            </label>
        </div>

    <?php if($row['image_id'] == 1): ?>
    <div class="row d-flex align-items-center">

    <div class="col-8 my-3">
        <label for="image" class="form-label">Product Image <i class="fw-lighter">(Optional)</i></label>
        <input class="form-control" type="file" id="image" name="image">
    </div>

    </div>
    <?php else: ?>
        <input type="hidden" name="imageID" value="<?=$row['image_id']?>">
        <div class="row d-flex align-items-center">

    <div class="col-8 my-3">
        <label for="image" class="form-label">Product Image <i class="fw-lighter">(Optional)</i></label>
        <input class="form-control" type="file" id="image" name="image">
    </div>


        <div class="col-4 form-check mt-4">
            <input class="form-check-input me-3" type="checkbox" value="" id="delete-image" name="delete-image">
            <label class="form-check-label" for="delete-image">
                Check this box to delete the image.
            </label>
        </div>

    </div>
    <?php endif ?>

    <div class="row mb-3">
        <div class="col d-grid gap-2 d-md-flex justify-content-md-end">
            <input type="submit" name="update-btn" class="btn btn-success" value="Update">
            <input type="submit" name="delete-btn" class="btn btn-danger" value="Delete" onclick="return confirm('Are you sure you wish to delete this product?')">
        </div>
    </div>
</form>


    <?php else: ?>
        <div class="row mb-3 shadow-sm p-3 mb-5 bg-body rounded px-0 mx-0">
            <h2 class="col text-center">Edit Products</h2>
        </div>
        <p class="text-center text-light bg-dark mt-0 mb-1 border-warning border border-1">To edit a product, simply click on its name.</p>
        <?php foreach($rows as $key => $row): ?>
    <div class="row text-center bg-warning w-80 px-0 mx-0">
        <p><a href="editProduct.php?id=<?= $row['product_id'] ?>" class="text-decoration-none link-dark"><?= $row['product_name'] ?></a></p>
    </div>


    <?php if($key !== array_key_last($rows)): ?>
        <hr class="mb-0 mt-1">
    <?php endif ?>
    <?php endforeach ?>
    <?php endif?>



    <?php include ('footer.php'); ?>
</div>
</body>
</html>
