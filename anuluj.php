<?php
session_start();
if (!(isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany'] == true))) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
  <title>Komunikat</title>
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
            <section>
                <?php
                require_once "connect.php";
                mysqli_report(MYSQLI_REPORT_STRICT); //od teraz zamiast warningow rzucaj exceptions
                try {
                    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
                    $polaczenie->query("SET NAMES 'utf8'"); //ustawienie kodowania

                    if ($polaczenie->connect_errno != 0) { //obsluga bledu
                        throw new Exception(mysqli_connect_errno());
                    } else {
                        $rezultat = $polaczenie->query("SELECT DATE_FORMAT(DATE(poczatekRezerwacji), '%d.%m.%Y') AS dataRezerwacjiFormat,
                            TIME_FORMAT(TIME(poczatekRezerwacji), '%H:%i') as poczatekRezerwacjiT, TIME_FORMAT(TIME(koniecRezerwacji), '%H:%i')
                            AS koniecRezerwacjiT, id, poczatekRezerwacji, koniecRezerwacji, id_sali, id_pracownika, tematSpotkania, uwagi FROM rezerwacje
                            WHERE czyPotwierdzona=1 AND id_pracownika=" . $_SESSION['id'] . " AND DATE(poczatekRezerwacji)>=DATE(NOW())
                            ORDER BY poczatekRezerwacji");

                    if (!$rezultat) {
                        throw new Exception($polaczenie->error);
                    }
                    if (mysqli_num_rows($rezultat) < 1) {
                        echo '<span id="big-text">Nie masz żadnych rezerwacji do anulowania!</span>';
                        echo '<a href="index.php">
                        <section class="color-button2">
                        <span>Powrót do strony głównej</span>
                        </section>
                        </a>';
                    } else {
                        $pomocneID = 1;
                        echo '<form method="post" action="zapytanie.php">';
                        echo '<div style="overflow-x:auto"><table class="tab" >';
                        echo "
                        <table class='tab'>

                        <thead>
                            <tr>
                            <th class='nr'>Nr </th>
                            <th class='data'>Data </th>
                            <th class='start'>Początek</th>
                            <th class='end'>Koniec</th>
                            <th class='name-s'>Nazwa sali </th>
                            <th class='theme'>Temat spotkania </th>
                            <th class='comment'>Uwagi </th>
                            <th class='check'>Potwierdź </th>
                            </tr>
                            </thead>
                            <tbody>";

                                while ($row = mysqli_fetch_array($rezultat)) {
                                    echo "<tr>";
                                    echo "<td data-label='Nr'><br>" . $pomocneID . "</td>";
                                    $pomocneID++;
                                    echo "<td data-label='Data'><br>" . $row['dataRezerwacjiFormat'] . "</td>";
                                    echo "<td data-label='Początek rezerwacji'><br>" . $row['poczatekRezerwacjiT'] . "</td>";
                                    echo "<td data-label='Koniec rezerwacji'><br>" . $row['koniecRezerwacjiT'] . "</td>";

                                    $rezultat2 = $polaczenie->query("SELECT nazwa FROM sale WHERE id=" . $row['id_sali'] . "");
                                    while ($row2 = mysqli_fetch_array($rezultat2)) {
                                        echo "<td data-label='Nazwa sali'><br>" . $row2['nazwa'] . "</td>";
                                    }
                                    echo "<td data-label='Temat spotkania'><br>" . $row['tematSpotkania'] . "</td>";
                                    // echo "<td>" . $row['uwagi'] . "</td>";
                                    $dodatkoweInfo = $row['uwagi'];
                                    $dodatkoweInfo = str_replace("+kawa", "<br>\r\nWymagany serwis kawowy", $dodatkoweInfo);
                                    $dodatkoweInfo = str_replace("+catering1", "<br>\r\nWymagany catering jednodaniowy", $dodatkoweInfo);
                                    $dodatkoweInfo = str_replace("+catering2", "<br>\r\nWymagany catering dwudaniowy", $dodatkoweInfo);

                                    echo "<td data-label='Uwagi'><br>" . $dodatkoweInfo . "</td>";
                                    echo '<td data-label="Potwierdź"><input type="checkbox" class="czyWybrano" name="id:'
                                        . $row['id'] .
                                        '" value=' . $row['id_sali'] . '></td>';

                                    echo "</tr>";
                                }
                                echo '</table>';
                                echo '</div>';
                                echo '<input type="submit" class="color-button2" value="Anuluj wybrane rezerwacje">';
                                echo '<a href="index.php">
                                <section class="color-button1">
                                <span>Powrót do strony głównej</span>
                                </section>
                                </a>';

                                $rezultat->free_result();
                                $polaczenie->close();
                            }
                        }

                        } catch (Exception $e) {
                            echo '<span style="color:red">Błąd serwera! Przepraszamy za niedogodności i prosimy o dokonanie rezerwacji w innym terminie!</span>';
                            echo '<br>Informacja developerska:' . $e;
                        }
                    ?>
                </tbody>
            </form>
        </table>
        </section>    
    </section>
</body>
</html>