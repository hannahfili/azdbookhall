<?php

class DbConnect {
private $host="localhost";

private $db_user = 'id17104281_root';
// private $db_user="root";
private $db_password="PorzeczkA123!";
// private $db_password="";
private $db_name="id17104281_bookhall";
// private $db_name="bookhall";
    
    function connect(){
    
        
        try{
            $conn=new PDO('mysql:host=' . $this->host . '; dbname=' . $this->db_name, $this->db_user, $this->db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        catch(PDOException $e){
            echo 'Database Error: ' . $e->getMessage();
        }
    }
}
 


?>
