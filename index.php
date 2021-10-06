<?php
session_start();
$maxID=0;
require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);
try {

    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
    $polaczenie->query("SET NAMES 'utf8'"); //ustawienie kodowania

    if ($polaczenie->connect_errno != 0) { //obsluga bledu
        throw new Exception(mysqli_connect_errno());
    } else {

        $pobierzMaxID = $polaczenie->query('SELECT MAX(id) as max from rezerwacje');
        $row = mysqli_fetch_array($pobierzMaxID);
        $maxID = $row['max'];
    }
    $polaczenie->close();
}
catch (Exception $e) {
        echo '<span style="color:red">Błąd serwera! Przepraszamy za niedogodności i prosimy o dokonanie rezerwacji w innym terminie!</span>';
        echo '<br>Informacja developerska:' . $e;
    }

for($i=0; $i<=$maxID; $i++){
    $spr='id:' . $i;    
    if (isset($_SESSION[$spr])){
        // echo '<h1>'.$spr.'</h1>';
        unset($_SESSION[$spr]);
    }
}
?>



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
<?php echo require_once("navbar.php")?>


    <section class="wall">
        <section>
            <span id="big-text">Witaj na naszej stronie głównej!</span>
            <span id="info-text">Miło nam Cię powitać na naszej stronie, gdzie możesz zarezerwować salę, w zależności
                od Twojego zapotrzebowania.
                <br>Zachęcamy do zapoznania się z naszą ofertą!</span>
            <div class="row">
                <div class=" col-lg-4">
                    <figure class="photos-main">
                        <img src="images/s1.bankietowa.jpg" alt="Zdjęcie sali bankietowej">
                        <div class="container">
                            <a href="s1.php">
                                <div class="column1">
                                    <span>Sala Bankietowa: zobacz szczegóły </span>
                                </div>
                            </a>
                        </div>
                    </figure>
                </div>

                <div class="col-lg-4">
                    <figure class="photos-main">
                        <img src="images/s2.basenowa.jpg" alt="Zdjęcie sali basenowej">

                        <div class="container">
                            <a href="s2.php">
                                <div class="column1">
                                    <span>Sala Basenowa: zobacz szczegóły </span>
                                </div>
                            </a>
                        </div>
                    </figure>
                </div>

                <div class="col-lg-4">
                    <figure class="photos-main">
                        <img src="images/s3.lustrzana.jpg" alt="Zdjęcie sali lustrzanej">

                        <div class="container">
                            <a href="s3.php">
                                <div class="column1">
                                    <span id="under-text">Sala Lustrzana: zobacz szczegóły </span>
                                </div>
                            </a>
                        </div>
                    </figure>
                </div>

                <a href="galery.php">
                    <section class="color-button1">
                        <span>Nasza galeria</span>
                    </section>
                </a>

                <div class="col-lg-4">
                    <figure class="photos-main">
                        <img src="images/s4.ciemna.jpg" alt="Zdjęcie sali ciemnej">

                        <div class="container">
                            <a href="s4.php">
                                <div class="column1">
                                    <span>Sala Ciemna: zobacz szczegóły </span>
                                </div>
                            </a>
                        </div>
                    </figure>
                </div>

                <div class="col-lg-4">
                    <figure class="photos-main">
                        <img src="images/s5.kameralna.jpg" alt="Zdjęcie sali kameralnej">

                        <div class="container">
                            <a href="s5.php">
                                <div class="column1">
                                    <span>Sala Kameralna: zobacz szczegóły </span>
                                </div>
                            </a>
                        </div>
                    </figure>
                </div>

                <div class="col-lg-4">
                    <figure class="photos-main">
                        <img src="images/s6.szkoleniowa.jpg" alt="Zdjęcie sali szkoleniowej">

                        <div class="container">
                            <a href="s6.php">
                                <div class="column1">
                                    <span>Sala Szkoleniowa: zobacz szczegóły </span>
                                </div>
                            </a>
                        </div>
                    </figure>
                </div>
            </div>
        </section>
    </section>
</body>
</html>