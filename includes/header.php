<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>PHP CRUD MYSQL</title>
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <!-- BOOTSTRAP 4 -->
  <link rel="stylesheet" href="https://bootswatch.com/4/yeti/bootstrap.min.css">
  <!-- FONT AWESOME -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
</head>

<body>
  <nav class="navbar navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="index.php">PHP MySQL CRUD</a>

      <!-- Menú dinámico -->
      <ul class="navbar-nav ml-auto d-flex flex-row">
        <?php if (isset($_SESSION['username'])): ?>
          <li class="nav-item mx-2">
            <a class="nav-link text-white" href="profile.php">
              <i class="fas fa-user"></i> <?= htmlspecialchars($_SESSION['username']); ?>
            </a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link text-white" href="logout.php">
              <i class="fas fa-sign-out-alt"></i> Cerrar sesión
            </a>
          </li>
        <?php else: ?>
          <li class="nav-item mx-2">
            <a class="nav-link text-white" href="login.php">
              <i class="fas fa-sign-in-alt"></i> Iniciar sesión
            </a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link text-white" href="register.php">
              <i class="fas fa-user-plus"></i> Registrarse
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>