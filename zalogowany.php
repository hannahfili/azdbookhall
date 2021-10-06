<?php
session_start();
if (!isset($_POST['email']) || !isset($_POST['haslo'])) {
    header('Location:zalogujsie.php');
    exit();
}
require_once "connect.php";

$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
if ($polaczenie->connect_errno != 0) { //obsluga bledu
    echo "Error: " . $polaczenie->connect_errno;

}
else {
    $email = $_POST["email"];
    $haslo = $_POST["haslo"];

    $email = htmlentities($email, ENT_QUOTES, "UTF-8");

    if ($rezultat = @$polaczenie->query(
        sprintf("SELECT * FROM pracownicy WHERE email='%s'",
            mysqli_real_escape_string($polaczenie, $email)
        ))) 

    { 
        $liczba_userow = $rezultat->num_rows;

        if ($liczba_userow > 0) {

            $wiersz = $rezultat->fetch_assoc();

            if (password_verify($haslo, $wiersz['haslo']) == true) {
                
                $_SESSION['zalogowany'] = true;

                
                $_SESSION['id'] = $wiersz['id'];
                $_SESSION['imie'] = $wiersz['imie'];
                $_SESSION['nazwisko'] = $wiersz['nazwisko'];
                $_SESSION['email'] = $wiersz['email'];
                $_SESSION['dzial'] = $wiersz['dzial'];
                $_SESSION['czyPracuje'] = $wiersz['czyPracuje'];
                unset($_SESSION['blad']);

                $rezultat->close(); 

                header('Location: index.php');

            } //sprawdz czy haslo zgadza sie z hashem
            else{
            $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy e-mail lub hasło!</span>';
            header('Location: zalogujsie.php');
            }

        } else {
            //nie ma takiej osoby w bazie danych
            $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy e-mail lub hasło!</span>';
            header('Location: zalogujsie.php');

        }

    }

    $polaczenie->close();
}
