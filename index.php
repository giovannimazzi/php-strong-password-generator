<?php

session_start();

require_once __DIR__ . '/functions.php';

$passlength = '';
$password = '';
$errors = [];
$selectedCharSets = [];
$allowRepeats = 'yes';

$isFormSubmitted = !empty($_GET);

if ($isFormSubmitted) {
  $passlength = $_GET['passlength'] ?? '';
  $selectedCharSets = $_GET['charsets'] ?? [];
  $allowRepeats = $_GET['repeat'] ?? 'yes';

  if ($passlength === '') {
    $errors[] = 'Inserisci la lunghezza della password.';
  } elseif (!is_numeric($passlength)) {
    $errors[] = 'La lunghezza deve essere un numero.';
  } elseif ((int) $passlength <= 0) {
    $errors[] = 'La lunghezza deve essere maggiore di zero.';
  }

  if (empty($selectedCharSets)) {
    $errors[] = 'Seleziona almeno un tipo di carattere.';
  }

  if (!in_array($allowRepeats, ['yes', 'no'])) {
    $errors[] = 'Scelta ripetizioni non valida.';
  }

  if (empty($errors)) {
    $charSets = getCharSets();
    $activeCharSets = [];

    foreach ($selectedCharSets as $selectedCharSet) {
      if (isset($charSets[$selectedCharSet])) {
        $activeCharSets[] = $charSets[$selectedCharSet];
      }
    }

    $password = generatePassword((int) $passlength, $activeCharSets, $allowRepeats === 'yes');

    if ($password === false) {
      $errors[] =
        'La lunghezza richiesta è troppo alta per i caratteri selezionati senza ripetizioni.';
    } else {
      $_SESSION['password'] = $password;

      header('Location: result.php');
      exit();
    }
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

     <!--  <?php if ($password !== ''): ?>
        <div class="alert alert-success" role="alert">
          La tua password è: <strong><?= htmlspecialchars(
            $password,
            ENT_QUOTES,
            'UTF-8',
          ) ?></strong>
        </div>
      <?php endif; ?> -->

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
            <div class="row mt-3">
              <div class="col-7">
                <span>Consenti ripetizioni di uno o più caratteri:</span>
              </div>

              <div class="col-5">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="repeat" id="repeatYes" value="yes" <?= $allowRepeats ===
                  'yes'
                    ? 'checked'
                    : '' ?>>
                  <label class="form-check-label" for="repeatYes">Sì</label>
                </div>

                <div class="form-check">
                  <input class="form-check-input" type="radio" name="repeat" id="repeatNo" value="no" <?= $allowRepeats ===
                  'no'
                    ? 'checked'
                    : '' ?>>
                  <label class="form-check-label" for="repeatNo">No</label>
                </div>
              </div>
            </div>

            <div class="row mt-3">
              <div class="col-7">
                <span>Caratteri consentiti:</span>
              </div>

              <div class="col-5">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="charsets[]" value="letters" id="letters" <?= in_array(
                    'letters',
                    $selectedCharSets,
                  )
                    ? 'checked'
                    : '' ?>>
                  <label class="form-check-label" for="letters">Lettere</label>
                </div>

                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="charsets[]" value="numbers" id="numbers" <?= in_array(
                    'numbers',
                    $selectedCharSets,
                  )
                    ? 'checked'
                    : '' ?>>
                  <label class="form-check-label" for="numbers">Numeri</label>
                </div>

                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="charsets[]" value="symbols" id="symbols" <?= in_array(
                    'symbols',
                    $selectedCharSets,
                  )
                    ? 'checked'
                    : '' ?>>
                  <label class="form-check-label" for="symbols">Simboli</label>
                </div>
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
