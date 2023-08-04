<?php
// Start the session
//session_start();


?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark" data-bs-theme="dark">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="products.php">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Login</a>
        </li>
        <?php if (isset($_SESSION['user_role']) && ($_SESSION['user_role'] == 'admin' || $_SESSION['user_role'] == 'user')): ?>
          <li class="nav-item">
            <a class="nav-link" href="index.php?logout=true">Logout</a>
          </li>
        <?php endif; ?>
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'): ?>
          <li class="nav-item">
            <a class="nav-link" href="adminDashboard.php">Admin</a>
          </li>
        <?php endif; ?>
      </ul>
      <form class="d-flex" method="GET" action="products.php">
        <select id="category" name="category" class="form-select form-select-sm" aria-label=".form-select-sm example">
          <option value="1" <?php if (isset($_GET['category']) && $_GET['category'] == 1) echo 'selected'; ?>>All categories</option>
          <?php foreach($catALL as $cat): ?>
            <option value="<?= $cat['category_id'] ?>" <?php if (isset($_GET['category']) && $_GET['category'] == $cat['category_id']) echo 'selected'; ?>><?= $cat['category_name'] ?></option>
          <?php endforeach; ?>
        </select>
        <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>" >
        <button class="btn btn-outline-light btn-sm" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
