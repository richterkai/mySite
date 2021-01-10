<?php
//class/class_View.inc.php
class GBVIEW{
   
    public function __construct($gbData){
        foreach($gbData as $value){

            echo $value['gb_name'] . " schrieb um: ";           
            echo $value['gb_date'] . "<br>";
            echo $value['gb_content'] . "<br><hr>";
        }
   
    }
}
?>