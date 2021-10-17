<!doctype html>
<html>


    <meta charset="utf-8" />
    <link rel="stylesheet" href="styleSimulation.css" />
	<div align="center">
    <title>Connexion</title>

    <body>
		<div class="container">
		<?php
			echo"<p>Pret Bancaire</p>";
			//lien de retour
			if(isset($_GET['id'])){
				switch ($_GET['id']){
					case "1":
						echo "<p class='machin' style='color: red'>Erreur dans les champs</p>";
						break;
				}
			}
			//formulaire
			echo "<form action='calcul.php' method='get'>
			Montant&nbsp&nbsp&nbsp<input type='text' name='montant'><br><br><br>
			Capital&nbsp&nbsp&nbsp<input type='text' name='capital'></p>
			Mois&nbsp&nbsp&nbsp<input type='text' name='nombre_mois'></p>
			Taux&nbsp&nbsp&nbsp<input type='text' name='taux'></p>
			<input type='submit' name='calculer' value='Calculer'>
			<br><br>
			";
		
		?>
		
</html>


