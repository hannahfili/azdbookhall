<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
<title>Potwiedzenie usuwania</title>
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
    <section class="wall">
<?php


// echo '<h1>start!!! <3</h1>';
if (!(isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany'] == true))) {
    header('Location: index.php');
    exit();
} elseif (empty($_POST)) {
    echo '<span id="big-text">Nie wybrano żadnej rezerwacji do anulowania!</span>';
    echo '<a href="index.php">
    <section class="color-button1">
    <span>Powrót do strony głównej<span>
    </section>
    </a>';
}
else {
    // echo '<h1>JESTEM!!!</h1>';
    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT); //od teraz zamiast warningow rzucaj exceptions
    try {
        // echo '<h1>JESTEM2!!!</h1>';
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
        $polaczenie->query("SET NAMES 'utf8'"); //ustawienie kodowania

        if ($polaczenie->connect_errno != 0) { //obsluga bledu
            throw new Exception(mysqli_connect_errno());
        } else {
            $rezultat = $polaczenie->query("SELECT DATE_FORMAT(DATE(poczatekRezerwacji), '%d.%m.%Y') AS dataRezerwacjiFormat,
            TIME_FORMAT(TIME(poczatekRezerwacji), '%H:%i') as poczatekRezerwacjiT, TIME_FORMAT(TIME(koniecRezerwacji), '%H:%i')
            AS koniecRezerwacjiT, id, poczatekRezerwacji, koniecRezerwacji, id_sali, id_pracownika, tematSpotkania, uwagi FROM rezerwacje
            WHERE czyPotwierdzona=1 AND id_pracownika=" . $_SESSION['id'] . " AND DATE(poczatekRezerwacji)>=DATE(NOW()) ORDER BY (DATE(poczatekRezerwacji))");

            if (!$rezultat) {
                throw new Exception($polaczenie->error);
            }

            echo '<p id="big-text" class="warning">Czy na pewno chcesz anulować poniższe rezerwacje?</p>';
            echo '<div style="overflow-x:auto"><table class="tab">';
            echo '
            <table class="tab">
            <form>
            <thead>
                <tr>
                    <th class="nr">Nr </th>
                    <th class="data">Data </th>
                    <th class="start">Początek</th>
                    <th class="end">Koniec</th>
                    <th class="name-s">Nazwa sali </th>
                    <th class="theme">Temat spotkania </th>
                    <th class="comment">Uwagi </th>
                </tr>
            </thead>
            <tbody>';
                $nr=1;

                while ($row = mysqli_fetch_array($rezultat)) {
                    $spr = 'id:' . $row['id'];
                    if (isset($_POST[$spr])&&$_POST[$spr]==$row['id_sali']) {

                        // echo '<h1>???'.$_POST[$spr].'???</h1>';
                    
                    
                        echo "<tr>";
                        echo "<td data-label='Nr'><br>" . $nr . "</td>";
                        $nr++;
                        echo "<td data-label='Data'><br>" . $row['dataRezerwacjiFormat'] . "</td>";
                        echo "<td data-label='Początek rezerwacji'><br>" . $row['poczatekRezerwacjiT'] . "</td>";
                        echo "<td data-label='Koniec rezerwacji'><br>" . $row['koniecRezerwacjiT'] . "</td>";

                        $rezultat2 = $polaczenie->query("SELECT nazwa FROM sale WHERE id=" . $row['id_sali'] . "");
                        while ($row2 = mysqli_fetch_array($rezultat2)) {
                            echo "<td data-label='Nazwa sali'><br>" . $row2['nazwa'] . "</td>";
                        }
                        echo "<td data-label='Temat spotkania'><br>" . $row['tematSpotkania'] . "</td>";
                        $dodatkoweInfo = $row['uwagi'];
                        $dodatkoweInfo = str_replace("+kawa", "\r\nWymagany serwis kawowy", $dodatkoweInfo);
                        $dodatkoweInfo = str_replace("+catering1", "\r\nWymagany catering jednodaniowy", $dodatkoweInfo);
                        $dodatkoweInfo = str_replace("+catering2", "\r\nWymagany catering dwudaniowy", $dodatkoweInfo);

                        echo "<td data-label='Uwagi'><br>" . $dodatkoweInfo . "</td>";
                            echo "</tr>";
                            $_SESSION[$spr]=$row['id_sali'];
                            // echo $spr;
                            // echo '<h1>!!!'.$_SESSION[$spr].'!!!</h1>';
                            $_SESSION['usuwanie']=true;
                        }

                     }
                }
                echo '</table>';
                echo '</div>';
                echo '<br>';
                echo '<a href="anulowano.php">
                <section class="color-button2">
                <span>Anuluj powyższe rezerwacje</span>
                </section>
                </a>';
                echo '<a href="index.php">
                <section class="color-button1">
                <span>Powrót do strony głównej</span>
                </section>
                </a>';
                $polaczenie->close();

            }

        
            catch (Exception $e) {
                echo '<span style="color:red">Błąd serwera! Przepraszamy za niedogodności i prosimy o dokonanie rezerwacji w innym terminie!</span>';
                echo '<br>Informacja developerska:' . $e;
            }
        }

    ?>
</tbody>
</form>
</table>
</section>
</body>
</html>