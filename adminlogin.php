<!doctype html>
<html>


    <meta charset="utf-8" />
    <link rel="stylesheet" href="styleAdminlogin.css" />
	<div align="center">
    <title>Connexion</title>

    <body>
		<div class="container">
		<?php
			echo"<p>Bienvenue</p>";
			//lien de retour
			if(isset($_GET['id'])){
				switch ($_GET['id']){
					case "1":
						echo "<p class='machin' style='color: red'>Erreur identifiant</p>";
						break;
					case "2":
						echo "<p class='machin' style='color: blue'>Connectez-vous</p>";
						break;
					case "3":
						echo "<p class='machin' style='color: green'>Deconnecté</p>";
						break;
					case "4":
						echo "<p class='machin' style='color: black'>Impossible de se reconnecter sur cette page </p>";
						break;
				}
			}
			//formulaire
			echo "<form action='dologin.php' method='post'><br>
			Login&nbsp&nbsp&nbsp<input type='text' name='login'><br><br><br>
			Mdp&nbsp&nbsp&nbsp<input type='password' name='password'></p>
			<input type='submit' name='ok' value='Connexion'>
			<br><br>
			";

		?>
		
</html>


