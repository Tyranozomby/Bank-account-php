<?php

require "calcul.php";

$montant = calcul();
if ($montant == false) {
    unset($montant);
}
?>

<!doctype html>
<html lang="fr">
<meta charset="utf-8"/>

<head>
    <title>Formulaire de simulation</title>
    <link rel="stylesheet" href="style.css"/>
</head>

<body>
<div>
    <h1>Prêt Bancaire</h1>

    <?php
    if (isset($_GET["stat"]) and $_GET["stat"] == 1) {
        echo "<p class='info' style='color: red'>Erreur dans les champs</p>";
    }
    ?>

    <form action='' method='get'>
        <div class="form-group">
            <div class="labels">
                <label for="capital">Capital</label>
                <label for="nombre_mois">Durée (Mois)</label>
                <label for="taux">Taux (%)</label>
            </div>

            <div class="inputs">
                <?php
                if (isset($_GET["capital"], $_GET["nombre_mois"], $_GET["taux"])) {
                    echo "<input type='number' id='capital' name='capital' min='0' step='0.01' value='" . $_GET["capital"] . "' required>";
                    echo "<input type='number' id='nombre_mois' name='nombre_mois' min='0' step='0.01' value='" . $_GET["nombre_mois"] . "' required>";
                    echo "<input type='number' id='taux' name='taux' min='0' max='100' step='0.01' value='" . $_GET["taux"] . "' required>";
                } else { ?>
                    <input type='number' id='capital' name='capital' step='0.01' min='0' required>
                    <input type='number' id='nombre_mois' name='nombre_mois' step='0.01' min='0' required>
                    <input type='number' id='taux' name='taux' step='0.01' min='0' max='100' required>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
        if (isset($montant)) {
            echo "<p class='result'>Montant à rembourser par mois : $montant €</p>";
        } else {
            echo "<br/><br/>";
        }
        ?>
        <button type='submit'>Calculer</button>
    </form>
</div>
</body>
</html>