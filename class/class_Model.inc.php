<?php
//class/class_Model.inc

class Model{
    private static $myPDO;//Datenbankhandler
  
    // Datenbankverbindung    
    private static function connectDB(){
       //self::readConfig();//covid.ini  
       self::$myPDO =  new PDO('mysql:host='.HOST.';dbname='.DBNAME, USER, PASS);
    }
    // SQL Injektionsicherheit
    private static function setSQlinj($sql){// Anfrage wird zwischengespeichert
      self::connectDB(); 
      return self::$myPDO->prepare($sql);//Objekt der Maske mit Adresse im Arbeitsspeicher
    }
    // Rückgabe Ergebnis SQL Anfrage
    private static function getAll($maske){//für viele Daten
        $maske->execute(); //Ausführen mit Maske aus Arbeitsspeicher
        return $maske->fetchAll();//assoziatives Array wird zurückgeliefert
    }
    private static function getOne($maske){// nur 1 Wert wiederzugeben
        $maske->execute(); 
        return $maske->fetchcolumn();//max 1 true, 1, text
    }   
    // SQL Abfrage von außen zugänglich
    public static function getAllCovidData($alter){
  
	        $sql = "SELECT meldewoche, SUM(faelle) AS faelle FROM tb_covid WHERE altersgruppe LIKE ? GROUP BY meldewoche";
         
            //$sql = "SELECT meldewoche, SUM(faelle) AS faelle FROM tb_covid GROUP BY meldewoche";
            //"SELECT meldewoche, SUM(faelle) AS faelle FROM tb_covid WHERE altersgruppe BETWEEN 20 AND 24 GROUP BY meldewoche"
            $maske = self::setSQlinj($sql);// SQL Sicherheit
            $maske->bindValue(1,'%'.$alter.'',PDO::PARAM_STR);
            return self::getAll($maske);//Ergebnis der Anfrage zurückliefern
            
    }

    // SQL Abfrage von außen zugänglich
    public static function getMaxCovidFaelle($alter){
        //"SELECT MAX(faelle) FROM tb_covid"
      
            $sql = "SELECT SUM(faelle) FROM `tb_covid` WHERE altersgruppe LIKE ? GROUP BY meldewoche ORDER BY SUM(faelle) DESC LIMIT 1 ";
         
            //SELECT SUM(faelle) FROM `tb_covid` WHERE altersgruppe LIKE "%50-59%" GROUP BY meldewoche ORDER BY SUM(faelle) DESC LIMIT 1 
           // SELECT SUM(faelle) FROM `tb_covid` GROUP BY meldewoche
           //SELECT SUM(faelle) FROM `tb_covid` GROUP BY meldewoche ORDER BY SUM(faelle) DESC LIMIT 1
            $maske = self::setSQlinj($sql);// SQL Sicherheit
            $maske->bindValue(1,'%'.$alter.'',PDO::PARAM_STR);
            return self::getOne($maske);
        
    }
    
}

//$data = Model::getAllCovidData();
//var_dump($data);
?>