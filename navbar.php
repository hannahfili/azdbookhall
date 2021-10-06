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
    <div class="pasekNawigacji">
        <ul class="pasek">
            <?php
                if((isset($_SESSION['zalogowany'])&&($_SESSION['zalogowany']==true))){
                echo '<li style="float:right"><a href="logout.php">Wyloguj się</a></li>';
                echo '<li style="float:left"><a href="rezerwacja.php">Zarezerwuj salę</a></li>';
                echo '<li style="float:right"><a href="anuluj.php">Anuluj rezerwację</a></li>';
                }
                else{
                echo '<li style="float:right"><a href="rejestracja.php">Rejestracja</a></li>';
                echo '<li style="float:right"><a href="zalogujsie.php">Loguj</a></li>';
                }
            ?>
            <li style="float:left"><a class="active" href="about.us.php">O nas</a></li>
            <li style="float:left"><a href="galery.php">Galeria</a></li>
            <li id="title">
                <a  href="index.php">
                    Bookhall
                </a>
            </li>      
        </ul>
    </div>
 </body>
</html>