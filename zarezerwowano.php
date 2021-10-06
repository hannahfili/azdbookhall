<?php
session_start();
if(!isset($_SESSION['udanaRezerwacja'])){
    header('Location: index.php');
    exit();
}
    
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Rezerwacja sal </title>
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


    <section class="mess-wall">
        <section>
            <span id="big-text">Dziękujemy za rezerwację w systemie!</span>
    <?php
    if(isset($_SESSION['udanaRezerwacja'])){
        

        echo 'Dane rezerwacji:<br>';
        $format = 'd.m.Y';
       $date = DateTime::createFromFormat($format, $_SESSION['dataRezerwacji']);

       $dataStr=strtotime($_SESSION['dataRezerwacji']);
       $dataF=date("d.m.Y", $dataStr);

        echo 'Data rezerwacji: '. $dataF .'<br>';
        echo 'Godzina rozpoczęcia rezerwacji: ' . $_SESSION['poczatekRezerwacji'] . '<br>';
        echo 'Godzina zakończenia rezerwacji: ' . $_SESSION['koniecRezerwacji'] . '<br>';
        echo 'Temat spotkania: ' . $_SESSION['temat'] . '<br>';
        echo 'Nazwa sali konferencyjnej: ' . $_SESSION['nazwaSali'] . '<br>';
        $dodatkoweInfo=$_SESSION['dodatkoweInfo'];
        $dodatkoweInfo=str_replace("+kawa", "\r\nWymagany serwis kawowy", $dodatkoweInfo);
        $dodatkoweInfo=str_replace("+catering1", "\r\nWymagany catering jednodaniowy", $dodatkoweInfo);
        $dodatkoweInfo=str_replace("+catering2", "\r\nWymagany catering dwudaniowy", $dodatkoweInfo);
        echo 'Dodatkowe informacje:<br>' . $dodatkoweInfo . '<br>';

        unset($_SESSION['udanaRezerwacja']);
        unset($_SESSION['dataRezerwacji']);
        unset($_SESSION['poczatekRezerwacji']);
        unset($_SESSION['koniecRezerwacji']);
        unset($_SESSION['temat']);
        unset($_SESSION['nazwaSali']);
        unset($_SESSION['dodatkoweInfo']);
    }
    ?>
        <a href="anuluj.php">
                    <section class="color-button1">
                        <span>Anuluj rezerwację</span>
                    </section>
        </a>
        <a href="index.php">
                    <section class="color-button2">
                        <span>Strona główna</span>
                    </section>
        </a>
    </section>
</section>
</body>
</html>