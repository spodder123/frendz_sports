<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>
<body>
<?php include ('header.php'); ?>
<br>
    <table class="table table-secondary">
          <tr class="table-primary">
              <td  class="text-center fw-bold">
                Add Product
              </td>
              <td  class="text-center">
                <a href="addProduct.php" class="btn btn-primary">Add</a>
              </td>
          </tr>
          <tr class="table-primary">
              <td  class="text-center fw-bold">
                Add Category
              </td>
              <td  class="text-center">
                <a href="addCategory.php" class="btn btn-primary">Add</a>
              </td>
          </tr>
          <tr class="table-primary">
              <td  class="text-center fw-bold">
                Add User
              </td>
              <td  class="text-center">
                <a href="addUser.php" class="btn btn-primary">Add</a>
              </td>
          </tr>
          <tr class="table-primary">
              <td  class="text-center fw-bold">
                Edit Product
              </td>
              <td  class="text-center">
                <a href="EditProduct.php" class="btn btn-primary">Edit</a>
              </td>
          </tr>
          <tr class="table-primary">
              <td  class="text-center fw-bold">
                Edit Category
              </td>
              <td  class="text-center">
                <a href="EditCategory.php" class="btn btn-primary">Edit</a>
              </td>
          </tr>
          <tr class="table-primary">
              <td  class="text-center fw-bold">
                Edit User
              </td>
              <td  class="text-center">
                <a href="EditUser.php" class="btn btn-primary">Edit</a>
              </td>
          </tr>
          <tr class="table-primary">
              <td  class="text-center fw-bold">
                Moderate Comments
              </td>
              <td  class="text-center">
                <a href="EditComment.php" class="btn btn-primary">Moderate</a>
              </td>
          </tr>
    </table>

<?php include ('footer.php'); ?>
</body>
</html>