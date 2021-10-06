<?php
session_start();

function get_working_hours()
{
    $times = array();

    $start = '08:00:00';
    $startTime = strtotime($start);
    $times[0] = $startTime;

    for ($i = 1; $i < 8; $i++) {
        $times[$i] = $startTime + (60 *60);
        $startTime = $times[$i];
    }
    return $times;
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <meta name="description" content="Możliwość rezerwacji sal na spotkania" />
    <meta name="keywords" content="rezerwacja, sale, konferencja" />
    <meta name="author" content="Wiktoria Nowak, Hanna Filipowska" />
    <meta name="viewport" content="widh=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="style-v2.css" />
    <title>Sala Kameralna</title>
</head>
<body>
    <?php echo require_once("navbar-alt.php")?>

    <section class="wall">
        <section>
            <span id="big-text">Sala Kameralna</span>
            <div class="row">
                <div class="col-lg-6">
                    <figure class="photos-main">
                    <img src="images/s5.kameralna.jpg" alt="Zdjęcie sali kameralnej">
                    </figure>
                </div>

                <div class=" col-lg-6">
                    <div class="container">
                        <span id="info-text">Oferujemy kameralne, wygodne i nowocześnie urządzone miejsce dla 10 osób. Wyposażenie sali to między innymi: wysokiej klasy projektor o rozdzielczości FULL HD, wskaźnik laserowy, flipchart, kącik kawowy wraz z ekspresem, każde stanowisko z dostępem do zasilania 230V i portem USB.</span>
                    </div>

                    <form method="post">
                        <label for="wyborDaty">Wybierz dzień, aby sprawdzić dostępność sali</label><br>
                            <input type="date" id="data" name="data" min="<?php echo date('Y-m-d'); ?>"><br>
                            <input type="submit" value="Sprawdź dostępność">
                    </form>
                        
                        <?php
                        if(isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany'] == true)){
                            if(isset($_POST['data'])) {

                                // echo '<p id="demo">Dzień dobry!</p>';
                            require_once 'DbConnect.php';
                            try {
                                $db = new DbConnect;
                                $conn = $db->connect();
                        
                                $stmt = $conn->prepare("SELECT TIME(poczatekRezerwacji) AS poczatekRezerwacjiT, TIME(koniecRezerwacji) AS koniecRezerwacjiT FROM
                                rezerwacje WHERE id_sali=5 AND DATE(poczatekRezerwacji)=DATE('" . $_POST['data'] . "') AND czyPotwierdzona=1");
                                $stmt->execute();
                                $datyDostepne = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        
                                $times = get_working_hours();
                                $c = count($times);
                        
                                $temp=$_POST['data'];
                                $temp2=strtotime($temp);
                                $temp3 = date("d.m.Y.", $temp2);
                                echo '<br>Dostępność sali w dniu ' . $temp3 . '<br><br>';
                                echo '<div style="overflow-x:auto">
                                <table class="bar">
                                
                                <tbody>
                                <tr>
                                <td data-label="Godzina" id="poczatkowy"></td>';
                        
                                if ($datyDostepne) {
                        
                                    echo 'Czerwony - sala zajęta<br>Zielony - sala wolna<br><br>';
                                    $licznikWolnosci = 0;
                                    $wolneGodziny = array();
                                    $licznik = 0;
                        
                                    for ($i = 0; $i < $c; $i++) {
                                        $zajeta = false;
                                        $gruba = false;
                        
                                        foreach ($datyDostepne as $dataDostepna) {
                                            // echo $times[0] . "!!! " . $dataDostepna['poczatekRezerwacjiT'] . " " . $dataDostepna['koniecRezerwacjiT'] . "<br><br>";
                        
                                            $a = $dataDostepna['poczatekRezerwacjiT'];
                                            $b = $dataDostepna['koniecRezerwacjiT'];
                        
                                            $godzinaRozp = strtotime($a);
                                            $godzinaZak = strtotime($b);
                        
                                            $timesF = date("H:i:s", $times[$i]);
                                            $godzinaRozpF = date("H:i:s", $godzinaRozp);
                                            $godzinaZakF = date("H:i:s", $godzinaZak);
                        
                                            if ($times[$i] >= $godzinaRozp && $times[$i] < $godzinaZak) {
                                                $zajeta = true;
                                                // echo $timesF." TAK ". $godzinaRozpF . " " . $godzinaZakF . "<br><br>";
                                                if ($i % 2 != 0) {
                                                    $gruba = true;
                                                }
                                                break;
                                            } else {
                                                $zajeta = false;
                                                if ($i % 2 != 0) {
                                                    $gruba = true;
                                                }
                                            }
                        
                                        }
                                        if ($zajeta) {
                                            if ($gruba) {
                                                echo '<td  class="gruba zajeta"></td>';
                                            } else {
                                                echo '<td  class="zajeta"></td>';
                                            }
                                        } else {
                                            $licznikWolnosci++;
                                            if ($gruba) {
                                                echo '<td   class="gruba wolna"></td>';
                                            } else {
                                                echo '<td  class="wolna"></td>';
                                            }
                                        }
                                        if ($zajeta || ($i == $c - 1)) {
                                            $licznikWolnosci = 0;
                                        }
                                        if ($licznikWolnosci == 1) {
                                            $wolneGodziny[$licznik] = $times[$i];
                                            $licznik++;
                                        }
                        
                                    }
                        
                                } else {
                        
                                    echo 'Sala jest dostępna przez cały dzień! :)<br><br><br>';
                        
                                    for ($i = 0; $i < $c; $i++) {
                                        if ($i % 2 == 0) {
                                            echo '<td  class="gruba wolna"></td>';
                                        } else {
                                            echo '<td  class="wolna"></td>';
                                        }
                                    }
                                }echo '<td  id="koncowy">
                                </tr>
                                </tbody>
                        
                                <thead>
                                <tr>';
                                for ($i = 1; $i <= $c; $i++) {
                                    $timesF = date("H:i", $times[$i - 1]);
                                    if (!($i == 0 || $i == $c) && $i % 2 != 0) {
                                        echo '<th data-label="Godzina"  colspan="2" class="bottom">' . $timesF . '</th>';
                                    } else if ($i == $c) {
                                        echo '<th data-label="Godzina"   colspan="2" class="bottom">16:00</th>';
                                    }
                        
                                }
                                echo "</tr>
                                </thead>
                                </div>";
                        
                                if ($datyDostepne) {
                                echo '<br>Dostępna od godziny:<br>';
                                    $wolneGodzinyCount = count($wolneGodziny);
                                    for ($j = 0; $j < $wolneGodzinyCount; $j++) {
                                        $timesF2 = date("H:i", $wolneGodziny[$j]);
                                        if ($j != $wolneGodzinyCount - 1) {
                                            echo $timesF2 . ', ';
                                        } else {
                                            echo $timesF2 . '.';
                                        }
                                    }
                                }
                        
                            } catch (PDOException $e) {
                                die($e->getMessage());
                            }
                        
                            unset($_POST['data']);
                            echo '</tr></table></div>';
                            echo '<form method="post" action="rezerwacjaW.php">';
                            echo '<input type="hidden" name="wybranaSala" value="Kameralna">';
                            echo '<input type="submit" value="Zarezerwuj salę">';
                            echo '</form>';
                        }

                        }
                            
                        else{
                            echo '<p class="error">Aby zobaczyć dostępność sali, musisz być zalogowany</p>';
                            echo '<a href="zalogujsie.php">
                            <section class="color-button2">
                            <span>Zaloguj się</span>
                            </section>
                            </a>';

                        }
                        ?>
    
            </div>
        </div>
    </section> 
</section>
</body>
</html>