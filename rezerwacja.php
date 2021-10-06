<?php
session_start();

if(!(isset($_SESSION['zalogowany'])&&($_SESSION['zalogowany']==true))){
  header('Location: index.php');
  exit();
}

function isWeekend($date)
{
    return (date('N', strtotime($date)) >= 6);
}
if(isset($_POST['liczbaOsob'])){ //sprawdź poprawność formularza
    $liczba_check = false;

  if ($_POST['liczbaOsob'] <= 0) {
    $_SESSION['e_liczba'] = "Wprowadzono nieprawidłową liczbę osób!";
} elseif ($_POST['liczbaOsob'] > 400) {
    $_SESSION['e_liczba'] = "Maksymalna liczba osób, którą można pomieścić wynosi 400!";
} else {
    require_once "connect.php";
    try {
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
        $polaczenie->query("SET NAMES 'utf8'"); //ustawienie kodowania

        if ($polaczenie->connect_errno != 0) { //obsluga bledu
            throw new Exception(mysqli_connect_errno());
        } else {

            $pobierzMaxLiczbeOsob = $polaczenie->query('SELECT liczbaOsob from sale where nazwa=' . '"' . $_POST['saleDostepne'] . '"');
            $row = mysqli_fetch_array($pobierzMaxLiczbeOsob);
            $maxLiczbaOsob = $row['liczbaOsob'];

            if($_POST['liczbaOsob']<=$maxLiczbaOsob){
                $liczba_check = true;
                
            }
        }
        $polaczenie->close();
    }
    catch (Exception $e) {
            echo '<span style="color:red">Błąd serwera! Przepraszamy za niedogodności i prosimy o dokonanie rezerwacji w innym terminie!</span>';
            echo '<br>Informacja developerska:' . $e;
        }

    $czasR = $_POST['godzinaR'] . ':' . $_POST['minutaR'];
    $czasZ = $_POST['godzinaZ'] . ':' . $_POST['minutaZ'];
    $h16 = '16:00';

    $godzinaRozp = strtotime($czasR);
    $godzinaZak = strtotime($czasZ);
    $szesnasta = strtotime($h16);

    $godzinaRozpF = date("H:i:s", $godzinaRozp);
    $godzinaZakF = date("H:i:s", $godzinaZak);
    $szesnastaF = date("H:i:s", $szesnasta);

    if ($godzinaZakF == $szesnastaF) {
        $minimum = date("H:i:s", strtotime('+30 minutes', $godzinaRozp));
    } else {
        $minimum = date("H:i:s", strtotime('+40 minutes', $godzinaRozp));
        $godzinaZakF = date("H:i:s", strtotime('+10 minutes', $godzinaZak));
    }

    $godzina_check = false;

    if ($godzinaZakF >= $minimum && $godzinaZakF <= $szesnastaF) {
        $godzina_check = true;
        unset($_SESSION['e_time']);
    } elseif ($godzinaZakF <= $godzinaRozpF) {
        $_SESSION['e_time'] = "Czas zakończenia rezerwacji musi być późniejszy niż czas rozpoczęcia!";
    } elseif ($godzinaZakF < $minimum) {
        $_SESSION['e_time'] = "Minimalny czas rezerwacji musi wynosić przynajmniej pół godziny, do którego doliczane jest 10 minut przerwy";
    } else {
        $_SESSION['e_time'] = "Rezerwacja może kończyć się maksymalnie o 16:00!";
    }
    if (isset($_POST['catering'])) {
        if (isset($_POST['kawa'])) {
            $dodatkoweInfo = nl2br($_POST['uwagi'] . "+" . $_POST['catering'] . "+" . $_POST['kawa']);
        } else {
            $dodatkoweInfo = nl2br($_POST['uwagi'] . "+" . $_POST['catering']);

        }
    } else {
        if (isset($_POST['kawa'])) {
            $dodatkoweInfo = nl2br($_POST['uwagi'] . "+" . $_POST['kawa']);

        } else {
            $dodatkoweInfo = $_POST['uwagi'];
        }
    }
    $dzien_check=false;
    if (!isWeekend($_POST['dataRezerwacji'])) {
        $dzien_check = true;
        $dzien = $_POST['dataRezerwacji'];
        // echo 'DZIEN REZERWACJI: '. $dzien;
    }
    else{
        $_SESSION['e_weekend']="Dzień rezerwacji nie może przypadać na weekend. Zmień termin!";
    }

    //laczymy z baza danych!
    if ($liczba_check && $godzina_check && $dzien_check) {
        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT); //od teraz zamiast warningow rzucaj exceptions
        try {
            $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
            $polaczenie->query("SET NAMES 'utf8'"); //ustawienie kodowania

            if ($polaczenie->connect_errno != 0) { //obsluga bledu
                throw new Exception(mysqli_connect_errno());
            } else {

                $pobierzIDsali = $polaczenie->query('SELECT id from sale where nazwa=' . '"' . $_POST['saleDostepne'] . '"');
                $row = mysqli_fetch_array($pobierzIDsali);
                $idSali = $row['id'];

                $czyMoznaRezerwowac = true;

                $rezultat = $polaczenie->query("SELECT id, TIME(poczatekRezerwacji) AS poczatekRezerwacjiT,
              TIME(koniecRezerwacji) AS koniecRezerwacjiT, id_sali, id_pracownika, czyPotwierdzona,
                tematSpotkania, uwagi FROM rezerwacje
            WHERE czyPotwierdzona=1 AND id_sali='" . $idSali . "' AND DATE(poczatekRezerwacji)='" . $dzien . "'");

                while ($row = mysqli_fetch_array($rezultat)) { //TU SKOŃCZYŁAM
                    // echo nl2br($godzinaRozpF . " " . $godzinaZakF . "\n");
                    if (!(($godzinaRozpF < $row['poczatekRezerwacjiT'] && $godzinaZakF <= $row['poczatekRezerwacjiT'])
                        || ($godzinaRozpF >= $row['koniecRezerwacjiT'] && $godzinaZakF > $row['koniecRezerwacjiT']))) {
                        // echo "JEST";
                        $czyMoznaRezerwowac = false;
                        break;
                    }
                }

                if ($czyMoznaRezerwowac) {
                  unset($_SESSION['e_termin']);
                //   echo '<h1>date: ' . $_POST['dataRezerwacji'] . '</h1>';
                //   echo '<h1>timeBegin: ' . $godzinaRozpF . '</h1>';
                //   echo '<h1>timeEnd: ' . $godzinaZakF . '</h1>';

                  $format = 'Y-m-d H:i:s';
                  $datetimeBeginString=$_POST['dataRezerwacji'] . ' ' . $godzinaRozpF;
                  $datetimeEndString=$_POST['dataRezerwacji'] . ' ' . $godzinaZakF;

                  $datetimeBegin = DateTime::createFromFormat($format, $datetimeBeginString);
                  $datetimeEnd = DateTime::createFromFormat($format, $datetimeEndString);
                  
                  $datetimeBeginString=$datetimeBegin->format('Y-m-d H:i:s');
                  $datetimeEndString=$datetimeEnd->format('Y-m-d H:i:s');
                  // echo "Format: $format; " . $datetimeBegin->format('Y-m-d H:i:s') . "\n";
                  // echo "Format: $format; " . $datetimeEnd->format('Y-m-d H:i:s') . "\n";
                  $idPracownika=$_SESSION['id'];
                  $polaczenie->query("SET NAMES 'utf8'");
                  $temat=htmlentities($_POST['temat'],ENT_QUOTES, "UTF-8");
                  $temat=mysqli_real_escape_string($polaczenie, $_POST['temat']);
                  
                  $dodatkoweInfo=htmlentities($dodatkoweInfo,ENT_QUOTES, "UTF-8");
                  $dodatkoweInfo=mysqli_real_escape_string($polaczenie, $dodatkoweInfo);
                  $dodatkoweInfo=str_replace("&lt;br /", "", $dodatkoweInfo);
                  $dodatkoweInfo=str_replace("&gt;", " ", $dodatkoweInfo);
                  $dodatkoweInfo=str_replace('\r\n', "", $dodatkoweInfo);
                  // $dodatkoweInfo=preg_replace( "/\r|\n/", ",", $dodatkoweInfo);
                  

                    if ($polaczenie->query("INSERT INTO rezerwacje
                VALUES(NULL, '$datetimeBeginString', '$datetimeEndString', '$idSali', '$idPracownika', '1','$temat', '$dodatkoweInfo')")) {
                        $_SESSION['udanaRezerwacja'] = true;
                        $_SESSION['dataRezerwacji']=$_POST['dataRezerwacji'];
                        $_SESSION['poczatekRezerwacji']=$godzinaRozpF;
                        $_SESSION['koniecRezerwacji']=$godzinaZakF;
                        $_SESSION['nazwaSali']=$_POST['saleDostepne'];
                        $_SESSION['dodatkoweInfo']=$dodatkoweInfo;
                        $_SESSION['temat']=$temat;
                        //echo $_SESSION['udanaRejestracja'];
                        
                        header('Location: zarezerwowano.php');

                    } else {
                        throw new Exception($polaczenie->error);
                    }
                }
                else{
                  $_SESSION['e_termin']=nl2br("Rezerwacja sali w tym terminie jest niemożliwa.\nSprawdź dostępność sali i wybierz inny termin.");
                }

            

            $polaczenie->close();
        }
      }
        catch (Exception $e) {
            echo '<span style="color:red">Błąd serwera! Przepraszamy za niedogodności i prosimy o dokonanie rezerwacji w innym terminie!</span>';
            echo '<br>Informacja developerska:' . $e;
        }

    }

}
}


?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <!--<title>Zarezerwuj salę w BookHall</title>-->
    <title></title>
    <meta charset="UTF-8" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <meta name="description" content="Możliwość rezerwacji sal na spotkania" />
    <meta name="keywords" content="rezerwacja, sale, konferencja" />
    <meta name="author" content="Wiktoria Nowak, Hanna Filipowska" />
    <meta name="viewport" content="widh=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="style-v2.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
            function getVal() {
                var number = document.querySelector('input').value;
                $.ajax({
                    url: 'wczytajSale.php',
                    method: 'post',
                    data: 'number=' + number
                }).done(function (saleDostepne) {
                    console.log(saleDostepne);
                    saleDostepne = JSON.parse(saleDostepne);
                    $('#saleDostepne').empty();
                    $('#szczegoly').empty();
                    saleDostepne.forEach(function (sala) {
                        var nazwaSali = sala.nazwa;
                        nazwaSali = nazwaSali.toLowerCase();
                        $('#saleDostepne').append('<option>' + sala.nazwa + '</option>');
                        $('#szczegoly').append('<li><a href="' + nazwaSali +
                            '.php" class="links" target="_blank">' + sala.nazwa +
                            ' - sprawdź szczegóły</a></li>');

                    })
                    if ($('#szczegoly').is(':empty')) {
                        $('#szczegoly').append('<p style="color:red">Brak!!! Maksymalna liczba osób to 400!</p>')

                    }
                })
            }
            </script>
        
    </head>
    <body>
        <?php echo require_once("navbar-alt.php")?>

          <?php if ((isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany'] == true))): ?>
    


          <section class="form-wall">



        <form method="post">
            <span id="big-text">Zarezerwuj salę!</span>
            <label for="sale">Na jak wiele osób potrzebujesz sali?</label><br>

            <input id="liczba-os" type="text" placeholder="Maksymalna liczba osób=400" onblur="getVal()"
                autofocus="autofocus" name="liczbaOsob" size="30"
                value="<?php echo isset($_POST['liczbaOsob']) ? $_POST['liczbaOsob'] : '' ?>" required><br>
            <?php
                if (isset($_SESSION['e_liczba'])) {
                    echo '<label for="error" class="error">' . $_SESSION['e_liczba'] . '</label>';
                    unset($_SESSION['e_liczba']);
                }
            ?>

            <br>


            <!-- <label for="linkiSal">Sale, które pomieszczą te osoby:</label><br>
            <ul id="szczegoly" style"list-style-type: none">

            </ul>

            <br><br> -->

            <label for="saleDostepne">Wybierz salę:</label><br>
            <select class="form-control" id="saleDostepne" name="saleDostepne">

            </select>

            <br><br>

            <label for="dzien">Wybierz dzień rezerwacji:</label><br>
            <input type="date" id="dataRezerwacji" name="dataRezerwacji" min="<?php echo date('Y-m-d'); ?>"
                value="<?php echo isset($_POST['dataRezerwacji']) ? $_POST['dataRezerwacji'] : '' ?>" required>
                <?php
        if(isset($_SESSION['e_termin'])){
          echo '<h3 class="error">' . $_SESSION['e_termin'] . '</h3>';
          unset($_SESSION['e_termin']);
        }
        elseif(isset($_SESSION['e_weekend'])){
            echo '<h3 class="error">' . $_SESSION['e_weekend'] . '</h3>';
          unset($_SESSION['e_weekend']);
        }
        ?>
            <br><br>

            <label for="czas-poczatek">Wybierz godzinę rozpoczęcia rezerwacji:</label><br>
            <select name="godzinaR" id="godzinaR">
                <option <?php if (isset($_POST['godzinaR']) && ($_POST['godzinaR'] == '08')) {?>selected="true" <?php }
                ;?>value="08">08</option>
                <option <?php if (isset($_POST['godzinaR']) && ($_POST['godzinaR'] == '09')) {?>selected="true" <?php }
                ;?>value="09">09</option>
                <?php

                  for ($i = 10; $i <= 16; $i++) {
                    echo '<option ';
                    if (isset($_POST['godzinaR']) && $_POST['godzinaR'] == $i) {
                        echo 'selected="true"';
                    }

                    echo 'value="' . $i . '">' . $i . '</option>';
                    }
                    ?>
            </select>
            <select name="minutaR" id="minutaR">
                <option <?php if (isset($_POST['minutaR']) && $_POST['minutaR'] == '00') {?>selected="true" <?php }
                  ;?>value="00">00</option>
                <option <?php if (isset($_POST['minutaR']) && $_POST['minutaR'] == '05') {?>selected="true" <?php }
                ;?>value="05">05</option>
                <?php
                  for ($i = 10; $i < 60; $i += 5) {
                    echo '<option ';
                    if (isset($_POST['minutaR']) && $_POST['minutaR'] == $i) {
                        echo 'selected="true"';
                    }

                    echo 'value="' . $i . '">' . $i . '</option>';
                    }
                    ?>
            </select>

            <br><br>

            <label for="czas-koniec">Wybierz godzinę zakończenia rezerwacji:</label><br>
            <select name="godzinaZ" id="godzinaZ">
                <option <?php if (isset($_POST['godzinaZ']) && ($_POST['godzinaZ'] == '08')) {?>selected="true" <?php }
                  ;?>value="08">08</option>
                <option <?php if (isset($_POST['godzinaZ']) && ($_POST['godzinaZ'] == '09')) {?>selected="true" <?php }
                  ;?>value="09">09</option>
                <?php

                for ($i = 10; $i <= 16; $i++) {
                  echo '<option ';
                  if (isset($_POST['godzinaZ']) && $_POST['godzinaZ'] == $i) {
                    echo 'selected="true"';
                  }

                  echo 'value="' . $i . '">' . $i . '</option>';
                }
                ?>

            </select>
            <select name="minutaZ" id="minutaZ">
                <option <?php if (isset($_POST['minutaZ']) && ($_POST['minutaZ'] == '00')) {?>selected="true" <?php }
                ;?>value="00">00</option>
                <option <?php if (isset($_POST['minutaZ']) && ($_POST['minutaZ'] == '05')) {?>selected="true" <?php }
                ;?>value="05">05</option>
                <?php
                  for ($i = 10; $i < 60; $i += 5) {
                    echo '<option ';
                    if (isset($_POST['minutaZ']) && $_POST['minutaZ'] == $i) {
                        echo 'selected="true"';
                    }

                    echo 'value="' . $i . '">' . $i . '</option>';
                  }
                ?>
            </select>
            <?php
                  if (isset($_SESSION['e_time'])) {
                     echo '<br><label for="blad" class="error">' . $_SESSION['e_time'] . '</label>';
                  }
            ?>
            <br><br>

            <label for="temat">Temat spotkania</label><br>
            <input type="text" id="temat" name="temat" minlength="5" maxlength="255" size="30"
                value="<?php echo isset($_POST['temat']) ? $_POST['temat'] : '' ?>" required>

            <br><br>

            <label for="opcjeDodatkowe">Wybierz opcje dodatkowe</label><br>
            <input type="radio" id="catering1" name="catering" value="catering1"
                <?php if (isset($_POST['catering']) && $_POST['catering'] == 'catering1') {?>checked="checked" <?php }
            ;?>>
            <label for="catering1">Catering 1-daniowy</label><br>
            <input type="radio" id="catering2" name="catering" value="catering2"
                <?php if (isset($_POST['catering']) && $_POST['catering'] == 'catering2') {?>checked="checked" <?php }
            ;?>>
            <label for="catering2">Catering 2-daniowy</label><br>
            <input type="checkbox" id="kawa" name="kawa" value="kawa"
                <?php if (isset($_POST['kawa'])) {?>checked="checked" <?php }
              ;?>>
            <label for="kawa">Serwis kawowy + ciastka</label><br>

            <br><br>
            <label for="uwagi">Uwagi:</label><br>

            <textarea id="uwagi" name="uwagi" rows="4" cols="50">
              <?php echo isset($_POST['uwagi']) ? $_POST['uwagi'] : '' ?>
            </textarea>

            <br><br>

            <input type="submit" value="Rezerwuj salę">
            <a href="ndex.php">
                        <section class="color-button2">
                            <span>Powrót do strony głównej</span>
                        </section>
            </a>
        </form>

        <?php else: ?>
        Aby zarezerwować salę, musisz być zalogowany. Zaloguj się<br>
        <a href="zalogujsie.php">Zaloguj się</a><br>

        <?php endif?>

    </section>
</body>
</html>