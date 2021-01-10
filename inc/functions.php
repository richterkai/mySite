<?php
function getContent(){
    if(isset($_GET['site'])){
        $filename = 'inc/content/'.$_GET['site'].'.php';
        if(file_exists ($filename)){
            include($filename);
        }else{
            header("Location: index.php");
        }
    }
}
function tryLogin(){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $username = htmlspecialchars(strip_tags($_POST['user'])); 
        $upass = htmlspecialchars(strip_tags($_POST['pass']));
        $myPDO = connectDB();
        $sql = "SELECT * FROM tb_login WHERE username = ?";
        $maske = $myPDO->prepare($sql);
        $maske->bindValue(1,$username,PDO::PARAM_STR);
        $maske->execute();
        $db = $maske->fetch();
            if($db && $db['passwort'] === $upass){
               echo "login erfolgreich";
            }else{
                echo "<br> <br> <div> Username oder Passwort falsch! </div>";
        }
    }
}

function connectDB(){
    readConfig();
    return new PDO('mysql:host='.ARR['HOST'].';dbname='.ARR['DBNAME'], ARR['USER'], ARR['PASS']);
}

function readConfig(){
    $arr = parse_ini_file("C:/XAMPP/meineconfig/guestbook.ini",FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    define('ARR',$arr);
}

?>