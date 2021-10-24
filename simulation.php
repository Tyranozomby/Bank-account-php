
<?php

require "calcul.php";
require_once "logmanagement.php";

$montant = calcul();
if ($montant === null) {
    unset($montant);
} else if ($montant === false) {
    header("Location: simulation.php?err");
    exit();
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
    if (isset($_GET["err"])) {
        echo "<p class='info error'>Erreur dans les champs</p>";
    }
    ?>

    <form action='' method='get' class="box">
        <div class="form-group">
            <div class="labels">
                <label for="capital">Capital</label>
                <label for="nombre_mois">Mois</label>
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
            echo "<p class='result success'>Montant à rembourser par mois : $montant €</p>";
        } else {
            echo "<br/><br/>";
        }
        ?>
        <button type='submit'>Calculer</button>
    </form>
    <div>
        <br/><br/>

        <?php

        if (file_exists($log_file_name)) {
            /** @noinspection HtmlUnknownAnchorTarget */
            echo "<a class='popButton' href='#logs'>Historique</a>";
        }
        ?>
        <a class="popButton" href='README.html'>Readme</a>
        <link rel="stylesheet" href="stylePopUp.css">
        <div id="logs" class="modal">
            <div class="modal_content">
                <h1>Historique</h1>
                <a href="#" class="modal_close">&times;</a>
                <?php print_logs_table(10); ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>