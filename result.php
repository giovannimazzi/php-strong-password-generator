<?php

session_start();

$password = $_SESSION['password'] ?? '';
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

    <?php if ($password !== '') { ?>
      <div class="alert alert-success" role="alert">
        La tua password è:
        <strong><?= htmlspecialchars($password, ENT_QUOTES, 'UTF-8') ?></strong>
      </div>
    <?php } else { ?>
      <div class="alert alert-warning" role="alert">
        Nessuna password generata.
      </div>
    <?php } ?>

    <a href="index.php" class="btn btn-primary">Torna al form</a>
  </div>
</body>
</html>