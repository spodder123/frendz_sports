<?php

require('connect.php');
session_start();

$errorFlag = false;
$errorMessage = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'user-email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $firstName = filter_input(INPUT_POST, 'user-firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastName = filter_input(INPUT_POST, 'user-lastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $userRole = filter_input(INPUT_POST, 'user-role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'user-password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $passwordConfirm = filter_input(INPUT_POST, 'password-confirm', FILTER_SANITIZE_FULL_SPECIAL_CHARS);



    if (empty($username) || empty($email) || empty($firstName) || empty($lastName) || empty($userRole) ||empty($password) || empty($passwordConfirm)) {
        $errorFlag = true;
        $errorMessage = "All fields are required.";
    } if ($password !== $passwordConfirm) {
        $errorFlag = true;
        $errorMessage = 'Passwords do not match. Please try again.';
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (user_name, user_email, user_firstname, user_lastname, user_password, user_role) VALUES (:username, :useremail, :userfirstname, :userlastname, :userpassword, :userrole)";
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':useremail', $email);
        $statement->bindValue(':userfirstname', $firstName);
        $statement->bindValue(':userlastname', $lastName);
        $statement->bindValue(':userpassword', $hashedPassword);
        $statement->bindValue(':userrole', $userRole);
        $statement->execute();


        header('Location: adminDashboard.php');
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
    <title>Add User</title>
    <link rel="stylesheet" href="./styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>
<body>
    <div id="content">
    <?php include ('header.php'); ?>

    <div class="row mb-3 shadow-sm p-3 mb-5 bg-body rounded px-0 mx-0">
        <h2 class="col text-center">Add New User</h2>
    </div>

    <form action="addUser.php" method="post">

    <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <input type="text" class="form-control" id="username" placeholder="Username of the user" name="username" required>
    </div>
    <div class="mb-3">
      <label for="user-email" class="form-label">Email</label>
      <input type="text" class="form-control" id="user-email" placeholder="Email of the user" name="user-email" required>
    </div>
    <div class="mb-3">
      <label for="user-firstname" class="form-label">First Name</label>
      <input type="text" class="form-control" id="user-firstname" placeholder="Firstname of the user" name="user-firstname" required>
    </div>
    <div class="mb-3">
      <label for="user-lastname" class="form-label">Last Name</label>
      <input type="text" class="form-control" id="user-lastname" placeholder="Lastname of the user" name="user-lastname" required>
    </div>
    <div class="mb-3">
      <label for="user-password" class="form-label">Password</label>
      <input type="password" class="form-control" id="user-password" placeholder="Password of the user" name="user-password" required>
    </div>
    <div class="mb-3">
      <label for="password-confirm" class="form-label">Re-type Password</label>
      <input type="password" class="form-control" id="password-confirm" placeholder="Re-type password of the user" name="password-confirm" required>
    </div>
    <div class="mb-3">
      <label for="user-role" class="form-label">User Role</label>
      <input type="text" class="form-control" id="user-role" placeholder="Role of the user (Type 'admin' or 'user')" name="user-role" required>
    </div>
      <div class="row mb-3">
        <div class="col d-grid gap-2 d-md-flex justify-content-md-end">
          <input type="submit" name="post-btn" class="btn btn-primary" value="Add User">
        </div>
      </div>
    </form>
    <?php if($errorFlag): ?>
      <div class="alert alert-danger" role="alert">
        <p class="text-center text-danger"><?= $errorMessage ?></p>
      </div>
    <?php endif ?>

    <?php include ('footer.php'); ?>
  </div>
</body>
</html>
