<?php
require('connect.php');
session_start();

if(isset($_GET['id'])){
    $id = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);

    $query = "SELECT * FROM users WHERE user_id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $row = $statement->fetch();
} else {
    $query = "SELECT * FROM users";
    $statement = $db->prepare($query);
    $statement->execute();
    $rows = $statement->fetchAll();
}

$errorFlag = false;
$errorMessage = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user_id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'user-email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $firstName = filter_input(INPUT_POST, 'user-firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastName = filter_input(INPUT_POST, 'user-lastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $userRole = filter_input(INPUT_POST, 'user-role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


    if (isset($_POST['update-btn'])) {

        if(isset($_POST['change-password'])){
            $changedPassword = filter_input(INPUT_POST, 'user-password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $hashedPassword = password_hash($changedPassword, PASSWORD_DEFAULT);

            $query = "UPDATE users SET user_name = :username, user_email = :useremail, user_firstname = :userfirstname, user_lastname = :userlastname, user_password = :userpassword, user_role = :userrole WHERE user_id = :userid";
            $statement = $db->prepare($query);
            $statement->bindValue(':username', $username);
            $statement->bindValue(':useremail', $email);
            $statement->bindValue(':userfirstname', $firstName);
            $statement->bindValue(':userlastname', $lastName);
            $statement->bindValue(':userpassword', $hashedPassword);
            $statement->bindValue(':userrole', $userRole);
            $statement->bindValue(':userid', $user_id, PDO::PARAM_INT);
            $statement->execute();

            header('Location: editUser.php');
             exit;

        } else{

            $query = "UPDATE users SET user_name = :username, user_email = :useremail, user_firstname = :userfirstname, user_lastname = :userlastname, user_role = :userrole WHERE user_id = :userid";
            $statement = $db->prepare($query);
            $statement->bindValue(':username', $username);
            $statement->bindValue(':useremail', $email);
            $statement->bindValue(':userfirstname', $firstName);
            $statement->bindValue(':userlastname', $lastName);
            $statement->bindValue(':userrole', $userRole);
            $statement->bindValue(':userid', $user_id, PDO::PARAM_INT);
            $statement->execute();


            header('Location: editUser.php');
            exit;

        }
    } else if(isset($_POST['delete-btn'])){
        $query = "DELETE FROM users WHERE user_id = :userid";
        $statement = $db->prepare($query);
        $statement->bindValue(':userid', $user_id, PDO::PARAM_INT);
        $statement->execute();


        header('Location: editUser.php');
        exit;

    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Users</title>
    <link rel="stylesheet" href="./styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>

<body>
    <div id="content">
<?php include ('header.php'); ?>

    <?php if(isset($_GET['id'])): ?>
        <div class="row mb-3 shadow-sm p-3 mb-5 bg-body rounded px-0 mx-0">
            <h2 class="col text-center">Editing User</h2>
        </div>
    <form action="editUser.php" method="post">
        <input type="hidden" name="id" value="<?= $row['user_id'] ?>">

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" placeholder="Username of the user" name="username" value="<?= $row['user_name'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="user-email" class="form-label">Email</label>
            <input type="text" class="form-control" id="user-email" placeholder="Email of the user" name="user-email" value="<?= $row['user_email'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="user-firstname" class="form-label">First Name</label>
            <input type="text" class="form-control" id="user-firstname" placeholder="Firstname of the user" name="user-firstname" value="<?= $row['user_firstname'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="user-lastname" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="user-lastname" placeholder="Lastname of the user" name="user-lastname" value="<?= $row['user_lastname'] ?>" required>
            </div>

        <div class="mb-3">
            <label for="user-role" class="form-label">User Role</label>
            <input type="text" class="form-control" id="user-role" placeholder="Role of the user (Type 'admin' or 'user')" name="user-role" value="<?= $row['user_role'] ?>" required>
        </div>

        <div class="row d-flex align-items-center">

        <div class="col-8 my-3">
            <label for="user-password" class="form-label">Change Password <i class="fw-lighter">(Optional)</i></label>
            <input class="form-control" type="password" id="user-password" name="user-password">
        </div>


        <div class="col-4 form-check mt-4">
            <input class="form-check-input me-3" type="checkbox" value="" name="change-password" id="change-password">
            <label class="form-check-label" for="change-password">
                Check this box to change the password.
            </label>
        </div>

        </div>


        <div class="col d-grid gap-2 d-md-flex justify-content-md-end">
            <input type="submit" name="update-btn" class="btn btn-success" value="Update">
            <input type="submit" name="delete-btn" class="btn btn-danger" value="Delete" onclick="return confirm('Are you sure you wish to delete this category?')">
        </div>
    </form>
    <?php else: ?>
        <div class="row mb-3 shadow-sm p-3 mb-5 bg-body rounded px-0 mx-0">
            <h2 class="col text-center">Edit Users</h2>
        </div>
        <p class="text-center text-light bg-dark mt-0 mb-1 border-warning border border-1">To edit a user, simply click on their username.</p>

        <?php foreach($rows as $key => $row): ?>


        <div class="row text-center bg-warning w-80 px-0 mx-0">
            <p class="text-white d-flex flex-column"><a href="editUser.php?id=<?= $row['user_id'] ?>" class="text-decoration-none link-dark">username: <?= $row['user_name'] ?></a> name: <?= $row['user_firstname'] ?> <?= $row['user_lastname'] ?></p>
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