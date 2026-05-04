<?php
session_start();

// Protezione accesso diretto
if (empty($_SESSION['password'])) {
  header('Location: index.php');
  exit();
}

$password = $_SESSION['password'];

// svuota la sessione per evitare riuso al refresh
unset($_SESSION['password']);
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Password generata</title>

  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
  <!-- Stylesheet -->
  <link rel="stylesheet" href="css/style.css" />

</head>
<body>
  <div class="container mt-5">
    
    <h1 class="mb-4 text-center">Password generata</h1>

    <div class="alert alert-success text-center" role="alert">
      La tua password è:
      <br>
      <strong>
        <?= htmlspecialchars($password, ENT_QUOTES, 'UTF-8') ?>
      </strong>
    </div>

    <div class="text-center">
      <a href="index.php" class="btn btn-primary">
        Torna al form
      </a>
    </div>

  </div>
</body>
</html>