
<div id="login">
<h1> LOGIN </h1>
    <form action="index.php?site=login" method="POST">
	<input type="text" name="user" placeholder="User"><br>
	<input type="password" name="pass" placeholder="Password"><br><br>
    <input type="submit" value="login">
    </form>
    <?php tryLogin(); ?>
	
    <!--<a href = "regist.php">Registrieren</a>-->
</div>