<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
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

    <section class="wall">
        <section>
            <span id="big-text">Informacje o Nas</span>
            <div class="row">
                <div class=" col-lg-6">
                    <div class="container">
                        <span id="info-text">Bardzo miło nam Cię powitać. 
                            <br>Jesteśmy nową firmą na rynku, tworzoną przez kilka zaangażowanych osób, która zajmuje się rezerwowaniem sal naszym klientom w zależności od tego, czego akurat potrzebują. 
                            <br>Posiadamy w swojej ofercie sale, które mogą posłużyć ci w celach biznesowych, pomóc przeprowadzić ważne spotkanie, a także sale, które są czysto rekreacyjne i dzięki rezerwacji obejrzysz seans w fantastycznej jakości, przeprowadzisz kurs tańca, urządzisz wystawny bankiet i wiele innych. 
                            <br> Zachęcamy do zapoznania się z naszą ofertą!
                        </span>
                    </div>

                    <a href="galery.php">
                        <section class="color-button2">
                            <span>Zobacz naszą Galerię</span>
                        </section>
                    </a>
                </div>
                <div class="col-lg-6">
                    <figure class="photos-main">
                        <img src="images/kitten.jpg" alt="Zdjęcie słodkiego kotka, który cieszy się, że tu jesteś" style="max-width: 100%; height: auto;">
                    </figure>
                </div>
            </div>    
    </section> 
</section>
</body>
</html>