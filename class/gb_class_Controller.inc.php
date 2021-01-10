<?php
//class/class_Controller.php
//Author: Kai Richter

class GBController{
	function __construct(){
		$this->readConfig();
		if(!isset($_POST['name']) && !isset($_POST['message'])){
		}else{		
			$name = htmlspecialchars(strip_tags($_POST['name']));
			$text = htmlspecialchars(strip_tags($_POST['message']));
			GBModel::sendData($name,$text, date("d.m.Y H:i"));
			header('Location: index.php?site=GB'); // .$SERVER['PHP_SELF'] findet die aktuelle Seite von alleine
			exit;
		}
		$gbData = GBModel::getAllGBentries();
		new GBView($gbData);
	}

private function readConfig(){
		$arr = parse_ini_file("C:/XAMPP/meineconfig/guestbook.ini",FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);// assoziatives Array Einlesen /r/n
		define('ARR',$arr);
		
    }
}