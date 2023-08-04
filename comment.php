<?php
require('connect.php');

session_start();

$captchaFailure = false;
$errorMessage = "";

if(isset($_GET['id'])){
    $_SESSION['commentProductID'] = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    if ( $_SESSION['captcha'] != filter_input(INPUT_POST, 'captcha', FILTER_SANITIZE_STRING)) {
        $_SESSION['commentName'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $_SESSION['commentText'] = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
        $errorMessage = "Incorrect CAPTCHA. Please try again.";
        $captchaFailure = true;

    } else {
    if(isset($_SESSION['user_id'])){

        $productID = $_SESSION['commentProductID'];
        $userID = $_SESSION['user_id'];

        $sql = "SELECT * FROM users WHERE user_id = :userID";
        $istatement = $db->prepare($sql);
        $istatement->bindValue(':userID', $userID);
        $istatement->execute();

        $info = $istatement->fetch();

        $name = $info['user_firstname'] . ' ' . $info['user_lastname'];
        $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);

        if(empty($comment)){
            echo "one is empty";
        }

        $query = "INSERT INTO comments (product_id, user_id, user_commentername, comment) VALUES (:productID, :userID, :uname, :comment)";
        $statement = $db->prepare($query);
        $statement->bindValue(':productID', $productID, PDO::PARAM_INT);
        $statement->bindValue(':userID', $userID, PDO::PARAM_INT);
        $statement->bindValue(':uname', $name);
        $statement->bindValue(':comment', $comment);
        $statement->execute();

        $_SESSION['commentName'] = "";
        $_SESSION['commentText'] = "";

        header('Location: products.php');
        exit();


    } else{
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);

        if(strlen(trim($name)) === 0){
            $name = "Anonymous";
        }

        $productID = $_SESSION['commentProductID'];
        $userID = 0;


        $query = "INSERT INTO comments (product_id, user_id, user_commentername, comment) VALUES (:productID, :userID, :uname, :comment)";
        $statement = $db->prepare($query);
        $statement->bindValue(':productID', $productID, PDO::PARAM_INT);
        $statement->bindValue(':userID', $userID, PDO::PARAM_INT);
        $statement->bindValue(':uname', $name);
        $statement->bindValue(':comment', $comment);
        $statement->execute();

        $_SESSION['commentName'] = "";

        header('Location: products.php');
        exit();

}
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment</title>
    <link rel="stylesheet" href="./styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>
<body>
    <div id="content">
    <?php include ('header.php'); ?>
    <br>
    <form method="post" action="comment.php">

        <?php if(!isset($_SESSION['user_id'])): ?>
        <label for="name">Name:</label>
        <input type="text" class="form-control" name="name" placeholder="name" value="<?= $_SESSION['commentName'] ?>" >
        <?php endif ?>

        <div class="mb-3">
        <label for="comment" class="form-label">Comment</label>
        <input type="text" class="form-control" id="comment" placeholder="comment" name="comment" value="<?= $_SESSION['commentText'] ?>" required>
        </div>

        <div class="mb-3">
        <label for="captcha" class="form-label">Please enter the CAPTCHA:</label>
        <img src="captcha.php" alt="CAPTCHA">
        <input type="text" class="form-control" id="captcha" placeholder="captcha" name="captcha" required>
        </div>


        <div class="d-grid gap-2 col-6 mx-auto">
            <input class="btn btn-primary" type="submit" value="Submit">
        </div>
    </form>

    <?php if($captchaFailure): ?>
        <div class="alert alert-danger" role="alert">
            <p class="text-center text-danger"><?= $errorMessage ?></p>
        </div>
    <?php endif ?>

        </div>
</body>
</html>
