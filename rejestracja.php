<?php
session_start();
if(isset($_SESSION['zalogowany'])&&($_SESSION['zalogowany']==true)){
    header('Location: index.php');
    exit();
  }

if (isset($_POST['email'])) {

    $udanaWalid = true;

    // SPRAWDZANIE IMIENIA
    $imie = $_POST['imie'];

    if (!(strlen($imie) > 3 && strlen($imie) <= 255)) {
        $udanaWalid = false;
        $_SESSION['e_imie'] = "Imię musi zawierać od 3 do 255 znaków!";
    }

    $isThereNumber = false;

    for ($i = 0; $i < strlen($imie); $i++) {
        if (ctype_digit($imie[$i])) {
            $isThereNumber = true;
            break;
        }
    }

    if ($isThereNumber == true) {
        $udanaWalid = false;
        $isThereNumber = false;
        $_SESSION['e_imie'] = "Imię nie może zawierać cyfr";
    }

    $imie=strtolower($imie);
    $imie=ucfirst($imie);
    mb_internal_encoding('UTF-8');
    $imie=mb_convert_case($imie, MB_CASE_TITLE);

    //SPRAWDZANIE NAZWISKA
    $nazwisko = $_POST['nazwisko'];

    if (!(strlen($nazwisko) > 3 && strlen($nazwisko) <= 255)) {
        $udanaWalid = false;
        $_SESSION['e_nazwisko'] = "Nazwisko musi zawierać od 3 do 255 znaków!";
    }

    for ($i = 0; $i < strlen($nazwisko); $i++) {
        if (ctype_digit($nazwisko[$i])) {
            $isThereNumber = true;
            break;
        }
    }

    if ($isThereNumber == true) {
        $udanaWalid = false;
        $isThereNumber = false;
        $_SESSION['e_nazwisko'] = "Nazwisko nie może zawierać cyfr";
    }

    $nazwisko=strtolower($nazwisko);
    $nazwisko=ucfirst($nazwisko);
    mb_internal_encoding('UTF-8');
    $nazwisko=mb_convert_case($nazwisko, MB_CASE_TITLE);

    //SPRAWDZENIA E-MAILA
    $email=$_POST['email'];
    $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);


    if ((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email)) {
        $udanaWalid = false;
        $_SESSION['e_email'] = "Podaj poprawny adres e-mail! (@azd.pl)";
    }
    else{
        $koncowka=substr($email,-7);
        if($koncowka!="@azd.pl"){
            $udanaWalid = false;
            $_SESSION['e_email'] = "Podaj firmowy adres e-mail!";
        }
    }

    //SPRAWDZANIE HASLA
    $haslo1 = $_POST['haslo1'];
    $haslo2 = $_POST['haslo2'];

    if (strlen($haslo1) < 8 || strlen($haslo1) > 20) {
        $udanaWalid = false;
        $_SESSION['e_haslo'] = "Hasło musi posiadać od 8 do 20 znaków!";
    }

    if ($haslo1 != $haslo2) {
        $udanaWalid = false;
        $_SESSION['e_haslo'] = "Podane hasła nie są idetyczne!";
    }
    $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);

    
    //DODAWANIE DZIALU
    $dzial=$_POST['dzial'];

    //Czy zaakceptowano regulamin?
    if (!isset($_POST['regulamin'])) {
        $udanaWalid = false;
        $_SESSION['e_regulamin'] = "Potwierdź akceptację regulaminu!";
    }

    //Bot or not?
    $sekret = "6LeYYuMaAAAAACLVgO3qwcL6tN5rh8VZzuzhie21";

    $sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $sekret . '&response=' . $_POST['g-recaptcha-response']);

    $odpowiedz = json_decode($sprawdz);

    if ($odpowiedz->success == false) {
        $udanaWalid = false;
        $_SESSION['e_bot'] = "Potwierdź, że nie jesteś botem!";
    }

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT); //od teraz zamiast warningow rzucaj exceptions
    try {
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
        $polaczenie->query("SET NAMES 'utf8'"); //ustawienie kodowania

        if ($polaczenie->connect_errno != 0) { //obsluga bledu
            throw new Exception(mysqli_connect_errno());
        }
        
        else {
            //Czy email juz istnieje?

            $rezultat = $polaczenie->query("SELECT id FROM pracownicy WHERE email='$email'");

            if (!$rezultat) {
                throw new Exception($polaczenie->error);
            }
            $ile_takich_maili = $rezultat->num_rows;
            if ($ile_takich_maili > 0) {
                $udanaWalid = false;
                $_SESSION['e_email'] = "Istnieje już konto przypisane do tego adresu e-mail!";
            }

            if ($udanaWalid == true) {
                //Hurra, wszystkie testy zaliczone, dodajemy pracownika do bazy!

                if($polaczenie->query("INSERT INTO pracownicy 
                VALUES(NULL, '$imie', '$nazwisko', '$haslo_hash', '$email', '$dzial','1')")){
                    $_SESSION['udanaRejestracja']=true;
                    //echo $_SESSION['udanaRejestracja'];
                    header('Location: witamy.php');

                }
                else{
                    throw new Exception($polaczenie->error);
                }
            }
        }

            $polaczenie->close();
    }


     catch (Exception $e) {
        echo '<span style="color:red">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
        echo '<br>Informacja developerska:' . $e;
    }
}

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <title>Rejestracja</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <meta name="description" content="Możliwość rezerwacji sal na spotkania" />
    <meta name="keywords" content="rezerwacja, sale, konferencja" />
    <meta name="author" content="Wiktoria Nowak, Hanna Filipowska" />
    <meta name="viewport" content="widh=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="style-v2.css" />
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
     <?php echo require_once("navbar-alt.php")?>

    <section class="form-wall">
        <section>
                <form method="post">
                <div id="quote">
                    Cieszymy się, że jesteś z nami. Został Ci już tylko jeden krok by zostać naszym klientem!
                </div>
                <a href="zalogujsie.php">
                    <section class="color-button2">
                        <span>Masz już konto? Zaloguj się!</span>
                    </section>
                </a>

                <span id="big-text"><br>Rejestracja</span>
                    <!-- <figure id="rejestracja"> -->
                    <figure id="log-in">
                        Imię:
                        <br><input type="text" name="imie"><br>

                        <?php
                            if (isset($_SESSION['e_imie'])) {
                                echo '<div class="error">' . $_SESSION['e_imie'] . '</div>';
                                unset($_SESSION['e_imie']);
                            }
                        ?>

                        Nazwisko:
                        <br><input type="text" name="nazwisko"><br>

                        <?php
                            if (isset($_SESSION['e_nazwisko'])) {
                                echo '<div class="error">' . $_SESSION['e_nazwisko'] . '</div>';
                                unset($_SESSION['e_nazwisko']);
                            }
                        ?>

                        E-mail:
                        <br><input type="text" name="email"><br>

                        <?php
                            if (isset($_SESSION['e_email'])) {
                                echo '<div class="error">' . $_SESSION['e_email'] . '</div>';
                                unset($_SESSION['e_email']);
                            }
                        ?>

                        Twoje hasło:
                        <br><input type="password" name="haslo1"><br>

                        <?php
                            if (isset($_SESSION['e_haslo'])) {
                                echo '<div class="error">' . $_SESSION['e_haslo'] . '</div>';
                            unset($_SESSION['e_haslo']);
                        }
                        ?>

                        Powtórz hasło:
                        <br><input type="password" name="haslo2"><br>



                        <label for="dzial">Dział firmy:</label><br>
                        <select id="dzial" name="dzial">

                            <option value="administracja">Administracja</option>
                            <option value="HR">Dział Human Resources</option>
                            <option value="IT">Dział IT</option>
                            <option value="realizacja inwestycji">Realizacja inwestycji</option>
                            <option value="ksiegowosc">Księgowość</option>

                        </select>
                        <br>

                        <label id="check-regulamin">
                            <input type="checkbox" name="regulamin">Akceptuję regulamin<br>
                        </label>

                        <?php
                            if (isset($_SESSION['e_regulamin'])) {
                                echo '<div class="error">' . $_SESSION['e_regulamin'] . '</div>';
                                unset($_SESSION['e_regulamin']);
                            }
                        ?>

                        <div class="g-recaptcha" data-sitekey="6LeYYuMaAAAAAFTxXcGGUNCBfidb5klqzNw9MFgE"></div><br><br>

                        <?php
                            if (isset($_SESSION['e_bot'])) {
                                echo '<div class="error">' . $_SESSION['e_bot'] . '</div>';
                                unset($_SESSION['e_bot']);
                            }
                        ?>

                        <input type="submit" value="Zarejestruj się">
                        </figure>
            </form><br>
        </section>
    </section>
</body>
</html>