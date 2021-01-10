<?php
//class/class_Model.inc

class GBModel{
    private static $myPDO;//Datenbankhandler
  
    // Datenbankverbindung    
    private static function connectDB(){
       //self::readConfig();//covid.ini  
       self::$myPDO =  new PDO('mysql:host='.ARR['HOST'].';dbname='.ARR['DBNAME'], ARR['USER'], ARR['PASS']);
    }

    // SQL Injektionsicherheit
    private static function setSQlinj($sql){// Anfrage wird zwischengespeichert
      self::connectDB(); 
      return self::$myPDO->prepare($sql);//Objekt der Maske mit Adresse im Arbeitsspeicher
    }

    public static function sendData($name, $text, $date){
      $sql = "INSERT INTO tb_guestbook(gb_name, gb_content, gb_date) VALUES (?,?,?)"; 
      $maske = self::setSQlinj($sql);// SQL Sicherheit
      $maske->bindValue(1,$name,PDO::PARAM_STR);
      $maske->bindValue(2,$text,PDO::PARAM_STR);
      $maske->bindValue(3,$date,PDO::PARAM_STR);
      $maske->execute();     
    }

    public static function getAllGBentries(){
      $sql = "SELECT gb_name, gb_content, gb_date FROM tb_guestbook ORDER BY gb_date LIMIT 25";
      $maske = self::setSQlinj($sql);// SQL Sicherheit
      $maske->execute(); //Ausführen mit Maske aus Arbeitsspeicher
      return $maske->fetchAll();
    }

}
?>