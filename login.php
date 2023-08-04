<?php

require('connect.php');
session_start();
$errorFlag = false;
$errorMessage = "";

if (isset($_POST['submit'])) {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);


	$query = 'SELECT * FROM users WHERE user_name = :uname';
	$statement = $db->prepare($query);
    $statement->bindValue(':uname', $username);
    $statement->execute();
    $user = $statement->fetch();

    if (!empty($user) && password_verify($password, $user['user_password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_role'] = $user['user_role'];
		$_SESSION['login_success'] = true;
        header('Location: index.php');
        exit();
    } else {
		$errorFlag = true;
        $errorMessage = 'Invalid username or password';
    }

}



?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<link rel="stylesheet" href="./styles.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>
<body>

	<div id="content">
  <?php include ('header.php'); ?>
		<div class="container mt-5">
			<div class="row justify-content-center">
				<div class="col-md-6">
					<div class="card shadow-lg">
						<div class="card-header">
							<h2 class="text-center">FS Login Form</h2>
						</div>
						<div class="card-body">
							<form method="POST" action="login.php" id="login">
								<div class="mb-3">
									<label for="username" class="form-label">Username:</label>
									<input class="form-control" type="text" name="username" id="username" required>
								</div>
								<div class="mb-3">
									<label for="password" class="form-label">Password:</label>
									<input class="form-control" type="password" name="password" id="password" required>
								</div>
								<input class="btn btn-primary w-100" type="submit" name="submit" value="Login">
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<p class="text-center my-3">Don't have an account? <a href="signup.php" class="text-decoration-none">Sign up</a> here!</p>
		<p class="text-center my-3">Already have an account? <a href="login.php" class="text-decoration-none">Log in</a> here!</p>

		<?php if($errorFlag): ?>
	    	<div class="alert alert-danger" role="alert">
				<p class="text-center text-danger"><?= $errorMessage ?></p>
			</div>
	    <?php endif ?>

      <?php include ('footer.php'); ?>
		</div>
</body>
</html>