<?php
session_start();
if(!isset($_SESSION['udanaRejestracja'])){
    header('Location: index.php');
    exit();
}
else{
    unset($_SESSION['udanaRejestracja']);
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
<title>Witamy</title>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <meta name="description" content="Możliwość rezerwacji sal na spotkania" />
  <meta name="keywords" content="rezerwacja, sale, konferencja" />
  <meta name="author" content="Wiktoria Nowak, Hanna Filipowska" />
  <meta name="viewport" content="widh=device-width, initial-scale=1.0" />
  <link rel="stylesheet" type="text/css" href="style-v2.css" />
</head>
<body>
  <?php echo require_once("navbar.php")?>
    <section class="mess-wall">
    <section>
      <form>
            <span id="big-text"> Dziękujemy za rejestrację w serwisie!<br> Możesz już zalogować się na swoje konto!</span>
            <div>
            <a href="zalogujsie.php">
              <section class="color-button1">
                  <span>Zaloguj się na swoje konto</span>
              </section>
            </a>
            </div>
            <div>
            <a href="index.php">
              <section class="color-button2">
                  <span>Strona główna</span>
              </section>
            </a>
            </div>
      </form>
  </section>
</section>
</body>
</html>