<?php

    require_once 'DbConnect.php';
    
    if(isset($_POST['number']) && is_numeric($_POST['number'])){
        $db=new DbConnect;
        $conn=$db->connect();

        $stmt=$conn->prepare("SELECT nazwa, liczbaOsob FROM sale WHERE liczbaOsob>=".$_POST['number']);
        $stmt->execute();
        $saleDostepne=$stmt->fetchAll(PDO::FETCH_ASSOC);
        unset($_POST['number']);
        echo json_encode($saleDostepne);
        
    } else {
        echo json_encode([]);
    }



    function wczytajSale(){
        $db=new DbConnect;
        $conn=$db->connect();

        $stmt=$conn->prepare("SELECT * FROM sale");
        $stmt->execute();
        $sale=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $sale;
    }

?>