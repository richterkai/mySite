<?php
class Controller{
    
   function __construct(){
        //echo __METHOD__;//Magische Konstanten
        $this->readConfig();
        if(!isset($_POST['alter']) OR ($_POST['alter']) == "Alle"){
            $alter = '';
        }else $alter = $_POST['alter']; 
        $max = Model::getMaxCovidFaelle($alter); //get abfangen und an model weitergeben
        $data = Model::getAllCovidData($alter);
        $arr =[];
        foreach($data as $spalte){//vorbereitung für View
            $arr[] = $spalte['meldewoche'];
            $arr[] = $spalte['faelle'];
        }
       
        new View($max,$arr);
    }
    
    private function readConfig(){
       $arr = file("C:/XAMPP/meineconfig/covid.ini",FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);// assoziatives Array Einlesen /r/n
        foreach($arr as $line){// HOST=localhost
            if(substr($line,0,1) != '#'){// # Kommentare ignorieren
               list($name,$value) = explode('=',$line); //zuordnung HOST=
               define($name,$value);//Konstante definieren
            }
        }
    }
    
}