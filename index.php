<?php

$passlength = '';
$password = '';
$errors = [];
$isFormSubmitted = !empty($_GET);

$charSets = [
  'letters' => array_merge(range('a', 'z'), range('A', 'Z')),
  'numbers' => range(0, 9),
  'symbols' => [
    '!',
    '?',
    '&',
    '%',
    '$',
    '<',
    '>',
    '^',
    '+',
    '-',
    '*',
    '/',
    '(',
    ')',
    '[',
    ']',
    '{',
    '}',
    '@',
    '#',
    '_',
    '=',
  ],
];

function generatePassword($length, $activeCharSets)
{
  $passwordChars = [];
  $availableChars = [];

  foreach ($activeCharSets as $charSet) {
    $availableChars = array_merge($availableChars, $charSet);
  }

  for ($i = 0; $i < $length; $i++) {
    $randomIndex = random_int(0, count($availableChars) - 1);
    $passwordChars[] = $availableChars[$randomIndex];
  }

  return implode('', $passwordChars);
}

if ($isFormSubmitted) {
  $passlength = $_GET['passlength'] ?? '';

  if ($passlength === '') {
    $errors[] = 'Inserisci la lunghezza della password.';
  } elseif (!is_numeric($passlength)) {
    $errors[] = 'La lunghezza deve essere un numero.';
  } elseif ((int) $passlength <= 0) {
    $errors[] = 'La lunghezza deve essere maggiore di zero.';
  }

  if (empty($errors)) {
    $activeCharSets = [$charSets['letters'], $charSets['numbers'], $charSets['symbols']];

    $password = generatePassword((int) $passlength, $activeCharSets);
  }
}

$hasErrors = !empty($errors);
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="Master Boolean in Web Development [152] - Specializzazione PHP/Laravel - Assegnazione L03
"
    />
    <meta name="author" content="Giovanni Mazzi" />
    <title>EX - Password Generator</title>

    <!-- Icona Progetto -->
    <!-- <link rel="icon" href="./assets/img/..." /> -->
    <link
      rel="icon"
      href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🔑</text></svg>"
    />

    <!-- Bootstrap Icons -->
    <!-- <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    /> -->

    <!-- Google Fonts -->
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://..."
      rel="stylesheet"
    /> -->

    <!-- Bootstrap CSS -->
     <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
      crossorigin="anonymous"
    />

    <!-- Reset Style -->
    <!-- <link rel="stylesheet" href="css/reset_style.css" /> -->

    <!-- Stylesheet -->
    <link rel="stylesheet" href="css/style.css" />

  </head>
  <body>
    <div class="container mt-5">
      <h1 class="mb-2 text-center">Strong Password Generator</h1>
      <h2 class="mb-2 text-center text-light">Genera una password sicura</h2>
      
      <?php if ($hasErrors) { ?>
        <div class="alert alert-info" role="alert">
          <?php foreach ($errors as $error) { ?>
            <div><?php echo $error; ?></div>
          <?php } ?>
        </div>
      <?php } ?>

      <?php if ($password !== ''): ?>
        <div class="alert alert-success" role="alert">
          La tua password è: <strong><?= htmlspecialchars(
            $password,
            ENT_QUOTES,
            'UTF-8',
          ) ?></strong>
        </div>
      <?php endif; ?>

      <div class="card form-card">
        <div class="card-body">
          <form action="" method="GET">
            <div class="row">
              <div class="col-7 d-flex align-items-center">
                <label for="passlength" class="form-label mb-0">Lunghezza password:</label>
              </div>
              <div class="col-5">
                <input 
                  class="form-control w-50" 
                  type="number" 
                  aria-label="password length" 
                  min=0 
                  step=1 
                  name="passlength" 
                  id="passlength" 
                  value="<?php echo $passlength; ?>">
              </div>
            </div>
            <div class="d-flex gap-2 mt-2">
              <button class="btn btn-primary" type="submit">Invia</button>
              <a href="index.php" class="btn btn-secondary">Annulla</a>
            </div>
          </form>
        </div>
      </div>
    </div>  
  </body>
</html>
