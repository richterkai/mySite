<?php include "class/class_Controller.inc.php" ?>
<?php include "class/class_View.inc.php" ?>
<?php include "class/class_Model.inc.php" ?>

   <h1>Covid</h1>
   <form method="POST">
       <select name="alter" onchange="this.form.submit()">
       <?php
       function s($s){ // was ist selected
            if(isset($_POST['alter']) AND $_POST['alter'] == $s){
                return 'selected';
            }       
       }
            echo '<option '.s('Alle').'> Alle </option>
            <option '.s('0-4').'> 0-4 </option>
            <option '.s('5-9').'> 5-9 </option>
            <option '.s('10-14').'> 10-14 </option>
            <option '.s('15-19').'> 15-19 </option>
            <option '.s('20-24').'> 20-24 </option>
            <option '.s('25-29').'> 25-29 </option>
            <option '.s('30-39').'> 30-39 </option>
            <option '.s('40-49').'> 40-49 </option>
            <option '.s('50-59').'> 50-59 </option>
            <option '.s('60-69').'> 60-69 </option>
            <option '.s('70-79').'> 70-79 </option>
            <option '.s('80-89').'> 80-89 </option>
            <option '.s('90+').'> 90+ </option>
            <option '.s('unbekannt').'> unbekannt </option>'
            ?>

            </select>
   </form> 
    <?php new Controller() ?>
    <img src="grafik.png">
