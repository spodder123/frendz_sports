<?php
require('connect.php');
session_start();

if(isset($_GET['id'])){
    $id = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);

    $query = "SELECT * FROM products WHERE product_id = {$id}";
    $statement = $db->prepare($query);
    $statement->execute();
    $row = $statement->fetch();

    $query2 = "SELECT * FROM comments WHERE product_id = {$id} AND comment_view = 'public' ORDER BY comment_posted DESC";

    $statement2 = $db->prepare($query2);
    $statement2->execute();
    $comments = $statement2->fetchAll();

    $image_available = false;
    if($row['image_id'] > 1){
        $image_available = true;
        $queryImage = "SELECT * FROM images WHERE image_id = :imageID";
        $statement3 = $db->prepare($queryImage);
        $statement3->bindValue(':imageID', $row['image_id']);
        $statement3->execute();
        $image = $statement3->fetch();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Display</title>
    <link rel="stylesheet" href="./styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>
<body>



<?php include ('header.php'); ?>



        <?php if($image_available): ?>
            <div class="d-flex align-items-center justify-content-center">


            <img src="./uploads/<?=$image['image_filename']?>" class="rounded border m-5" alt="<?= $image['image_description'] ?>">

            <div>

            <p><span class="fw-bold">Name: </span><?= $row['product_name'] ?></p>

        <p><span class="fw-bold">Description: </span><?= $row['product_description'] ?></p>
        <p><span class="fw-bold">Price: </span> <?= $row['product_price'] ?></p>

        <?php if($row['product_availability']): ?>
            <p><span class="fw-bold">Availability:</span> Available</p>
        <?php else: ?>
            <p><span class="fw-bold">Availability:</span> Not Available</p>
        <?php endif ?>

                <div>

                <?php

                $timestamp = strtotime($row['product_posted']);
                if ($timestamp !== false) {
                    echo "<p> <span class='fw-bold'>Posted: </span>" . date('F d, Y  g:i A', $timestamp) . "</p>";
                } else {
                    echo "<p>Invalid date format</p>";
                }

                ?>


                </div>

        </div>

            </div>

        <?php else: ?>


            <div class="text-center">

            <p><span class="fw-bold">Name: </span><?= $row['product_name'] ?></p>

        <p><span class="fw-bold">Description: </span><?= $row['product_description'] ?></p>
        <p><span class="fw-bold">Price: </span> <?= $row['product_price'] ?></p>

        <?php if($row['product_availability']): ?>
            <p><span class="fw-bold">Availability:</span> Available</p>
        <?php else: ?>
            <p><span class="fw-bold">Availability:</span> Not Available</p>
        <?php endif ?>

        <p>

                <?php

                $timestamp = strtotime($row['product_posted']);
                if ($timestamp !== false) {
                    echo "<p> <span class='fw-bold'>Posted: </span>" . date('F d, Y  g:i A', $timestamp) . "</p>";
                } else {
                    echo "<p>Invalid date format</p>";
                }

                ?>
        </p>

        </div>
            </div>

<?php endif ?>

       <div class="row mb-3 shadow-sm p-3 mb-5 bg-body rounded px-0 mx-0">
            <h2 class="col text-center">Comments</h2>
        </div>

        <?php foreach($comments as $comment): ?>
        <p>
            <span class="fw-bold">Name:</span> <?= $comment['user_commentername'] ?>
        </p>


        <p>
            <span class="fw-bold">Comment:</span> <?= $comment['comment'] ?>
        </p>
        <hr>
        <?php endforeach ?>



        <div class="d-grid gap-2 col-6 mx-auto">
            <a class="btn btn-primary" href="comment.php?id=<?= $row['product_id'] ?>" role="button">Comment</a>
        </div>


    <?php include ('footer.php'); ?>

</body>
</html>