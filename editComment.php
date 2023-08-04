<?php
require('connect.php');
session_start();
$query = "SELECT * FROM comments";
$statement = $db->prepare($query);
$statement->execute();
$rows = $statement->fetchAll();

function generateRandomNumber() {
    $min = 1000000000;
    $max = 9999999999;


    $randomNumber = rand($min, $max);

    return $randomNumber;
}

function productName($id ,$db){
    $query1 = 'SELECT * FROM products WHERE product_id = :id';
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':id',$id,PDO::PARAM_INT);
    $statement1->execute();
    $info = $statement1->fetch();

    return $info['product_name'];
}

function disemvowel($string) {
    $vowels = array('a', 'e', 'i', 'o', 'u');
    $result = '';
    for ($i = 0; $i < strlen($string); $i++) {
      if (!in_array(strtolower($string[$i]), $vowels)) {
        $result .= $string[$i];
      }
    }
    return $result;
  }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $commentID = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    if (isset($_POST['update-btn'])) {
        $commentView = filter_input(INPUT_POST, 'view', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
         $disemvowel = isset($_POST['disemvowel']) && $_POST['disemvowel'] == 'yes';

        if($disemvowel){
            $bq = "SELECT comment FROM comments WHERE comment_id = :commentID";
            $statement1 = $db->prepare($bq);
            $statement1->bindValue(':commentID', $commentID, PDO::PARAM_INT);
            $statement1->execute();
            $comment = $statement1->fetch();

            $disemvowelledComment = disemvowel($comment['comment']);


            $query = "UPDATE comments SET comment = :disemvowelledComment, comment_view = :commentView, comment_disemvowel = :disemvowel WHERE comment_id = :commentID";
                $statement = $db->prepare($query);
                $statement->bindValue(':disemvowelledComment', $disemvowelledComment);
                $statement->bindValue(':commentView', $commentView);
                $statement->bindValue(':disemvowel', 'yes');
                $statement->bindValue(':commentID', $commentID, PDO::PARAM_INT);
                $statement->execute();

                header('Location: adminDashboard.php');

        } else{

            $query = "UPDATE comments SET comment_view = :commentView WHERE comment_id = :commentID";
                $statement = $db->prepare($query);
                $statement->bindValue(':commentView', $commentView);
                $statement->bindValue(':commentID', $commentID, PDO::PARAM_INT);
                $statement->execute();

                header('Location: adminDashboard.php');
        }


    } else if(isset($_POST['delete-btn'])){
        $query = "DELETE FROM comments WHERE comment_id = :commentID";
            $statement = $db->prepare($query);
            $statement->bindValue(':commentID', $commentID, PDO::PARAM_INT);
            $statement->execute();
            header('Location: adminDashboard.php');
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderate Comments</title>
    <link rel="stylesheet" href="./styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>
<body>
    <div id="content">
    <?php include ('header.php'); ?>
    <div class="row mb-3 shadow-sm p-3 mb-5 bg-body rounded px-0 mx-0">
        <h2 class="col text-center">Moderate Comments</h2>
    </div>
    <?php foreach ($rows as $key => $row): ?>

    <div class="row">
        <div class="col-6 border d-flex flex-column justify-content-center align-items-center bg-dark bg-gradient text-light">
            <p>Product: <?= productName($row['product_id'], $db) ?></p>
            <p>Comment: <?= $row['comment'] ?></p>
        </div>
            <div class="col-6">
            <form action="editComment.php" method="POST">
            <input type="hidden" name="id" value="<?= $row['comment_id'] ?>">
            <p>View mode <i class="fw-lighter">(Set the visibility for the users)</i></p>
            <div class="form-check">
                <?php $rdn = generateRandomNumber() ?>
                <input class="form-check-input" type="radio" name="view" id="view_<?= $rdn?>" value="public" <?php echo $row['comment_view'] == 'public' ? 'checked' : ''; ?>>
                <label class="form-check-label" for="view_<?= $rdn ?>">
                Public
                </label>
            </div>

            <div class="form-check">
            <?php $rdn = generateRandomNumber() ?>
                <input class="form-check-input" type="radio" name="view" id="view_<?= $rdn?>" value="hide" <?php echo $row['comment_view'] == 'hide' ? 'checked' : ''; ?>>
                <label class="form-check-label" for="view_<?= $rdn ?>">
                Hide
                </label>
            </div>
            <br>
                <p>Comment Disemvowel</p>
                <?php $rdn = generateRandomNumber() ?>
                <?php if($row['comment_disemvowel'] == 'no'): ?>
            <div class="col-4 form-check mt-4">
                <input class="form-check-input me-3" type="checkbox" value="yes" id="disemvowel_<?= $rdn?>" name="disemvowel">
                <label class="form-check-label" for="disemvowel_<?= $rdn ?>">
                Check this box to disemvowel the comment.
                </label>
            </div>
            <?php else: ?>
                <p><em>Disemvowelled</em></p>
            <?php endif ?>

            <div class="col d-grid gap-2 d-md-flex justify-content-md-end">
            <input type="submit" name="update-btn" class="btn btn-success" value="Update">
            <input type="submit" name="delete-btn" class="btn btn-danger" value="Delete" onclick="return confirm('Are you sure you wish to delete this comment?')">
            </div>
            </form>
            </div>
        </div>
    <?php if($key !== array_key_last($rows)): ?>
        <hr class="mb-0 mt-1">
    <?php endif ?>
    <?php endforeach ?>

    <?php include ('footer.php'); ?>
    </div>
</body>
</html>