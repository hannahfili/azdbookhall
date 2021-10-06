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
<?php echo require_once("navbar.php")?>
  <form>

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
            echo '<p>Nie masz żadnych rezerwacji do anulowania!</p>';
            echo '<a href=""index.php"">
            <section class="galeria-przycisk">
                <span>Powrót do strony głównej</span>
            </section>
        </a>';
        } else {
            $pomocneID = 1;
            echo '<form method="post" action="zapytanie.php">';
            echo '<div style="overflow-x:auto"><table border="1">';
            echo "
<tr>
<th>Nr</th>
<th>Data</th>
<th>Początek rezerwacji</th>
<th>Koniec rezerwacji</th>
<th>Nazwa sali</th>
<th>Temat spotkania</th>
<th>Uwagi</th>
<th>Czy anulować?</th>
</tr>";

            while ($row = mysqli_fetch_array($rezultat)) {
                echo "<tr>";
                echo "<td>" . $pomocneID . "</td>";
                $pomocneID++;
                echo "<td>" . $row['dataRezerwacjiFormat'] . "</td>";
                echo "<td>" . $row['poczatekRezerwacjiT'] . "</td>";
                echo "<td>" . $row['koniecRezerwacjiT'] . "</td>";

                $rezultat2 = $polaczenie->query("SELECT nazwa FROM sale WHERE id=" . $row['id_sali'] . "");
                while ($row2 = mysqli_fetch_array($rezultat2)) {
                    echo "<td>" . $row2['nazwa'] . "</td>";
                }
                echo "<td>" . $row['tematSpotkania'] . "</td>";
                // echo "<td>" . $row['uwagi'] . "</td>";
                $dodatkoweInfo = $row['uwagi'];
                $dodatkoweInfo = str_replace("+kawa", "\r\nWymagany serwis kawowy", $dodatkoweInfo);
                $dodatkoweInfo = str_replace("+catering1", "\r\nWymagany catering jednodaniowy", $dodatkoweInfo);
                $dodatkoweInfo = str_replace("+catering2", "\r\nWymagany catering dwudaniowy", $dodatkoweInfo);

                echo "<td>" . $dodatkoweInfo . "</td>";
                echo '<td><input type="checkbox" class="czyWybrano" name="id:'
                    . $row['id'] .
                    '" value=' . $row['id'] . '></td>';

                echo "</tr>";
            }
            echo '</table>';
            echo '</div>';
            echo '<input type="submit" class="button" value="Anuluj wybrane rezerwacje">';
            echo '</form><br>';
            echo '<a href="index.php" class="button">Powrót do strony głównej</a>';

            $rezultat->free_result();
            $polaczenie->close();
        }
    }

} catch (Exception $e) {
    echo '<span style="color:red">Błąd serwera! Przepraszamy za niedogodności i prosimy o dokonanie rezerwacji w innym terminie!</span>';
    echo '<br>Informacja developerska:' . $e;
}

?>
</form>
</body>
</html>