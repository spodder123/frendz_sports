<?php
$errorFlag = false;
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['password-confirm'];

    $firstName = filter_var($_POST['firstName'], FILTER_SANITIZE_STRING);
    $lastName = filter_var($_POST['lastName'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_NUMBER_INT);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $passwordConfirm = filter_var($_POST['password-confirm'], FILTER_SANITIZE_STRING);





    if ($password !== $passwordConfirm) {
        $errorFlag = true;
        $errorMessage = 'Passwords do not match. Please try again.';
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


        $query = "INSERT INTO users (user_name, user_email, user_firstname, user_lastname, user_password) VALUES (:uname, :uemail, :ufirstname , :ulastname, :upassword)";
        $statement = $db->prepare($query);
        $statement->bindValue(':uname', $username);
        $statement->bindValue(':uemail', $email);
        $statement->bindValue(':ufirstname', $firstName);
        $statement->bindValue(':ulastname', $lastName);
        $statement->bindValue(':upassword', $hashedPassword);
        $statement->execute();


        header('Location: login.php');
        exit;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sign Up Form</title>
    <link rel="stylesheet" href="./styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>


    <div id="content">
<?php include ('header.php'); ?>
    <h2 class="text-center mt-5">FS Sign Up Form</h1>
    <form class="bg-white p-4 rounded shadow-lg mb-5 mx-auto w-50 " method="post" action="signup.php">
        <div class="mb-3">
            <label for="firstName" class="form-label">First Name:</label>
            <input type="text" name="firstName" id="firstName" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="lastName" class="form-label">Last Name:</label>
            <input type="text" name="lastName" id="lastName" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email Address:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number:</label>
            <input type="tel" name="phone" id="phone" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password-confirm" class="form-label">Password confirm:</label>
            <input type="password" name="password-confirm" id="password-confirm" class="form-control" required>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-primary ">Sign Up</button>
        </div>
    </form>
    <div class="text-center mt-3">Already have an account? <a href="login.php" class="text-decoration-none">Log in</a></div>

    <?php if($errorFlag): ?>
        <p class="text-center my-3 text-danger"><?= $errorMessage ?></p>
    <?php endif ?>

    <?php include ('footer.php'); ?>
    </div>
</body>
</html>
