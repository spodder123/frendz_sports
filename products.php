<?php


require('connect.php');
session_start();

$queryforcat = "SELECT * FROM categories";
$statementforcat = $db->prepare($queryforcat);
$statementforcat->execute();
$catALL = $statementforcat->fetchAll();



if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $category = $_GET['category'];
    if($category == 1){
        $query = "SELECT * FROM products WHERE
            product_name LIKE CONCAT('%', :search_term, '%') OR
            product_description LIKE CONCAT('%', :search_term, '%') OR
            product_price LIKE CONCAT('%', :search_term, '%')";

        $statement = $db->prepare($query);
        $statement->bindValue(':search_term', $searchTerm);
        $statement->execute();

    } else{

        $query = "SELECT * FROM products WHERE
            (product_name LIKE CONCAT('%', :search_term, '%') OR
            product_description LIKE CONCAT('%', :search_term, '%') OR
            product_price LIKE CONCAT('%', :search_term, '%')) AND
            category_id = :category";

        $statement = $db->prepare($query);
        $statement->bindValue(':search_term', $searchTerm);
        $statement->bindValue(':category', $category);
        $statement->execute();
    }
} else if(isset($_GET['sort'])){
    if($_SESSION['user_role'] == 'admin' || $_SESSION['user_role'] == 'user'){
        $sorting_type = $_GET['sort'];

        $col_name = "product_" . $sorting_type;
        $query = "SELECT * FROM products ORDER BY $col_name ASC";
        $statement = $db->prepare($query);
        $statement->execute();
    } else{

        $query = "SELECT * FROM products ORDER BY product_price ASC";
        $statement = $db->prepare($query);
        $statement->execute();
    }
} else{
    $query = "SELECT * FROM products ORDER BY product_price ASC";
    $statement = $db->prepare($query);
    $statement->execute();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="./styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>
<body>


<?php include ('header.php'); ?>
<br>
    <!-- search results -->
    <?php if (isset($_GET['search'])): ?>
        <?php if ($statement->rowCount() > 0): ?>
            <p class="text-center text-light bg-dark m-0">To see more information about a product, simply click on its name.</p>
        <p class="text-center text-light bg-dark m-0">To sort the contents by that column, click the table heading.</p>

            <table class="table table-success table-hover align-middle table-sm table-responsive">
                <thead class="">
                    <tr>
                        <th class="border text-center"><a href="products.php?sort=name" class="link-primary text-decoration-none">Name</a></th>
                        <th class="border text-center"><a href="products.php?sort=price" class="link-primary text-decoration-none">Price</a></th>
                        <th class="border text-center"><a href="products.php?sort=posted" class="link-primary text-decoration-none">Released Date and Time</a></th>
                    </tr>
                </thead>
                <tbody>
                <?php while($row = $statement->fetch()): ?>
                    <?php

                    $timestamp = strtotime($row['product_posted']);
                    if ($timestamp !== false) {
                        $time = date('F d, Y  g:i A', $timestamp);
                    } else {
                        $time = "Invalid date format";
                    }

                    ?>
                    <tr>
                    <td>
                        <p class="text-center"><a href="productDisplay.php?id=<?= $row['product_id'] ?>" class="link-primary text-decoration-none"><?= $row['product_name'] ?></a></p>
                    </td>
                    <td>
                        <p class="text-center">$<?= $row['product_price'] ?></p>
                    </td>
                    <td>
                        <p class="text-center"><?= $time ?></p>
                    </td>
                    </tr>
                    <?php endwhile ?>
                </tbody>
            </table>

        <?php else: ?>
            <p class="text-center text-danger bg-dark">Sorry, we couldn't find any matches for your search. Please try again with different keywords.</p>
        <?php endif ?>

        <!-- sorted results -->
        <?php elseif(isset($_GET['sort']) ): ?>
            <p class="text-center text-light bg-dark m-0">To see more information about a product, simply click on its name.</p>
            <p class="text-center text-light bg-dark m-0">To sort the contents by that column, click the table heading.</p>
            <?php if($sorting_type == "name"): ?>
                <p class="text-center text-light bg-dark m-0 text-capitalize">Sorted By: Name</p>
            <?php elseif($sorting_type == "price"): ?>
                <p class="text-center text-light bg-dark m-0 text-capitalize">Sorted By: Price</p>
            <?php elseif($sorting_type == "posted"): ?>
                <p class="text-center text-light bg-dark m-0 text-capitalize">Sorted By: Released Date and Time</p>
            <?php else: ?>
                <p class="text-center text-light bg-dark m-0 text-capitalize">***Only registered users can sort the products list***</p>
            <?php endif?>
            <table class="table table-success table-hover align-middle table-sm table-responsive">
                <thead class="">
                    <tr>
                        <th class="border text-center"><a href="products.php?sort=name" class="link-dark text-decoration-none">Name</a></th>
                        <th class="border text-center"><a href="products.php?sort=price" class="link-dark text-decoration-none">Price</a></th>
                        <th class="border text-center"><a href="products.php?sort=posted" class="link-dark text-decoration-none">Released Date and Time</a></th>
                    </tr>
                </thead>
                <tbody>
                <?php while($row = $statement->fetch()): ?>
                    <?php

                    $timestamp = strtotime($row['product_posted']);
                    if ($timestamp !== false) {
                        $time = date('F d, Y  g:i A', $timestamp);
                    } else {
                        $time = "Invalid date format";
                    }

                    ?>
                    <tr>
                    <td>
                        <p class="text-center"><a href="productDisplay.php?id=<?= $row['product_id'] ?>" class="link-primary text-decoration-none"><?= $row['product_name'] ?></a></p>
                    </td>
                    <td>
                        <p class="text-center">$<?= $row['product_price'] ?></p>
                    </td>
                    <td>
                        <p class="text-center"><?= $time ?></p>
                    </td>
                    </tr>
                    <?php endwhile ?>
                </tbody>
            </table>

        <?php else: ?>
        <!-- normal results -->
        <p class="text-center text-light bg-dark m-0">To see more information about a product, simply click on its name.</p>
        <p class="text-center text-light bg-dark m-0">To sort the contents by that column, click the table heading.</p>


            <table class="table table-success table-striped table-hover align-middle table-sm table-responsive">
                <thead class="">
                    <tr>
                        <th class="border text-center"><a href="products.php?sort=name" class="link-dark text-decoration-none">Name</a></th>
                        <th class="border text-center"><a href="products.php?sort=price" class="link-dark text-decoration-none">Price</a></th>
                        <th class="border text-center"><a href="products.php?sort=posted" class="link-dark text-decoration-none">Released Date and Time</a></th>
                    </tr>
                </thead>
                <tbody>
                <?php while($row = $statement->fetch()): ?>
                    <?php

                    $timestamp = strtotime($row['product_posted']);
                    if ($timestamp !== false) {
                        $time = date('F d, Y  g:i A', $timestamp);
                    } else {
                        $time = "Invalid date format";
                    }

                    ?>
                    <tr>
                        <td>
                            <p class="text-center"><a href="productDisplay.php?id=<?= $row['product_id'] ?>" class="link-primary text-decoration-none"><?= $row['product_name'] ?></a></p>
                        </td>
                        <td>
                            <p class="text-center">$<?= $row['product_price'] ?></p>
                        </td>
                        <td>
                            <p class="text-center"><?= $time ?></p>
                        </td>
                    </tr>
                    <?php endwhile ?>
                </tbody>
            </table>
        <?php endif ?>



    <?php include ('footer.php'); ?>


</body>
</html>