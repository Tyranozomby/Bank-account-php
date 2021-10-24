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
        echo "<p class='info error'>Erreur dans les champs</p>";
    }
    ?>

    <form action='' method='get' class="listeBoutons">
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
        $file = "logs.csv";
        if (file_exists($file)) {
            echo "<a class='popButton' href='#logs'>Historique</a>";
        }
        ?>
        <a class="popButton" href='README.html'>Readme</a>
        <link rel="stylesheet" href="stylePopUp.css">
        <div id="logs" class="modal">
            <div class="modal_content">
                <h1>Historique</h1>
                <a href="#" class="modal_close">&times;</a>
                <?php
                if (file_exists($file) && $fp = fopen($file, "r")) {
                    $titre = fgets($fp);
                    $data = array();
                    while ($ligne = fgetcsv($fp, 1024, ';')) {
                        array_push($data, $ligne);
                    }

                    $dataSize = count($data);

                    echo "<table><thead><tr><th>Capital</th><th>Mois</th><th>Taux</th><th>Montant (€/mois)</th></thead></tr>";
                    for ($i = 0; $i < 10; $i++) {
                        if ($dataSize - 1 < $i) break;
                        $ligne = $data[$dataSize - 1 - $i];

                        echo "<tr>";
                        echo "<td>$ligne[3] €</td>";
                        echo "<td>$ligne[4]</td>";
                        echo "<td>" . number_format($ligne[5], 2) . " %</td>";
                        echo "<td>$ligne[2]</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    fclose($fp);
                }
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>