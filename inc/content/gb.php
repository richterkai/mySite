<?php include "class/gb_class_Controller.inc.php"?>
<?php include "class/gb_class_Model.inc.php"?>
<?php include "class/gb_class_View.inc.php"?>

   <h1>Gästebuch</h1>
   <?php new GBController()?>
   <form method="POST">
      <label for="name"> Name: </label><br>
      <input type="text" id="name" name="name"><br>
      <label for="message"> Message: </label><br>
      <input type="text" id="message" name="message"><br>
      <input type="submit"></input>
   </form> 
 