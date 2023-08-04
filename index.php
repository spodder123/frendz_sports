<?php

require('connect.php');
session_start();
$firstLoggedin = false;
if (isset($_SESSION['login_success']) && $_SESSION['login_success']) {
   //echo "Login successful!";
    $firstLoggedin = true;

    $query = "SELECT user_firstname,user_lastname FROM users WHERE user_id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $_SESSION['user_id']);
    $statement->execute();
    $name = $statement->fetch();
    $_SESSION['login_success'] = false;
}

if (isset($_GET['logout'])) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php');
        exit;
    }
    session_destroy();
    header('Location: index.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frendz Sports</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>
<body>
    <div id="content" class="bg-light">


    <?php include ('header.php'); ?>


    <div class="my-5">
        <?php if($firstLoggedin): ?>
        <h2 class="text-center">Welcome to Frendz Sports <span class="fst-italic"><?= $name['user_firstname'] ?> <?= $name['user_lastname'] ?>, You Logged in Successfully!</span></h2>
        <?php else: ?>
            <h2 class="text-center">Welcome to Frendz Sports</h2>
        <?php endif ?>
        <p>
            At Frendz Sports, we are dedicated to providing you with top-quality soccer equipment to elevate your game. We offer a wide range of products, from soccer jerseys and football boots to indoor football shoes and accessories. Our commitment to excellence is reflected in our exceptional customer service and loyal customer base. Explore our exciting products today and discover how we can help you take your soccer game to the next level.
        </p>
    </div>

    <div class="my-5">
        <h2 class="text-center">Benefits of Signing Up as a Verified Consumer</h2>
        <p>
            As a verified consumer on our website, you will gain access to a range of features designed to enhance your shopping experience. By signing up, you will be able to sort and search products more efficiently, view your order history, and receive notifications about new products and exclusive offers. Plus, as your personal details will be securely stored on our site, you can save time during the checkout process. Don't miss out on the benefits of being a verified consumer at Frendz Sports so sign up now!
        </p>
    </div>

    <div class="my-2">
        <h2 class="text-center">Customer Satisfaction: Our Top Priority for an Exceptional Shopping Experience</h2>
        <p>
            Our company's core focus is customer satisfaction. We offer a wide range of thoughtfully curated products, ensuring your needs are met. Our user-friendly website and secure payment options guarantee a seamless shopping experience. With exceptional customer support, we value your feedback and continuously improve to exceed expectations. Join us to become a part of our valued customer community and experience the joy of shopping with confidence in our commitment to your satisfaction.
        </p>
    </div>
    <?php include ('footer.php'); ?>
    </div>
</body>
</html>