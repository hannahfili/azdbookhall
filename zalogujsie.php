<?php
session_start();
if (isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany'] == true)) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <title>Logowanie</title>
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
<?php echo require_once("navbar-alt.php")?>

    <section class="form-wall">
        <section>          
                    <form action="zalogowany.php" method="post">
                    <figure id="quote">
                        Wpływamy na siebie nawzajem - i często zdarza się, że przelotne spotkanie, rozmowa, wymiana myśli, złośliwy żarcik nawet potrafią wyżłobić głęboki ślad w czyjejś pamięci i zaważyć nawet na całym życiu człowieka.
                        <br>
                        <figcaption id="quote-author"> - Małgorzata Musierowicz</figcaption>

                    </figure>
                    <a href="rejestracja.php">
                        <section class="color-button1">
                            <span>Nie masz konta? Zarejestruj się za darmo!</span>
                        </section>
                    </a>
                    <span id="big-text"><br>Logowanie</span>

                        <figure id="log-in">E-mail:<br>
                            <input type="text" name="email">
                            <br>Hasło:<br>
                            <input type="password" name="haslo">
                            <br><br>
                            <input type="submit" value="Zaloguj się">
                        </figure>
                   
                
                    <?php
                        if (isset($_SESSION['blad'])) {
                            echo $_SESSION['blad'];
                        }
                    ?>
            </form> 
        </section>
    </section>
</body>
</html>