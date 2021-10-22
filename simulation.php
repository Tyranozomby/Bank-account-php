<?php

require "calcul.php";

$montant = calcul();
if ($montant == false) {
    unset($montant);
}
?>

<!doctype html>
<html lang="fr">
<meta charset="utf-8" />

<head>
    <title>Formulaire de simulation</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <div>
        <h1>Prêt Bancaire</h1>

        <?php
        if (isset($_GET["stat"]) and $_GET["stat"] == 1) {
            echo "<p class='info' style='color: red'>Erreur dans les champs</p>";
        }
        ?>

        <form action='' method='get' class="listeboutons">
            <div class="form-group">
                <div class="labels">
                    <label for="capital">Capital</label>
                    <label for="nombre_mois">Mois</label>
                    <label for="taux">Taux (%)</label>
                </div>

                <div class="inputs">
                    <?php
                    if (isset($_GET["capital"], $_GET["nombre_mois"], $_GET["taux"])) {
                        echo "<input type='number' id='capital' name='capital' min='0' step='any' value='" . $_GET["capital"] . "' required>";
                        echo "<input type='number' id='nombre_mois' name='nombre_mois' min='0' step='any' value='" . $_GET["nombre_mois"] . "' required>";
                        echo "<input type='number' id='taux' name='taux' min='0' step='any' value='" . $_GET["taux"] . "' required>";
                    } else {
                        echo "<input type='number' id='capital' name='capital' step='any' min='0' required>";
                        echo "<input type='number' id='nombre_mois' name='nombre_mois' step='any' min='0' required>";
                        echo "<input type='number' id='taux' name='taux' step='any' min='0' required>";
                    }
                    ?>
                </div>
            </div>
            <?php
            if (isset($montant)) {
                echo "<p class='result'>Montant : $montant €</p>";
            } else {
                echo "<br/><br/>";
            }
            ?>
            <button type='submit'>Calculer</button>
        </form>
        <div>
            <br /><br />
            <?php
             $file = "logs.csv";
            if (file_exists($file)){
                echo "<a href='#Logs'>&nbspHistorique&nbsp</a>";
            }
           ?>
            <link rel="stylesheet" href="stylePopUp.css">
            <div id="Logs" class="modal">
                <div class="modal_content">
                    <h1>Historique :</h1>
                    <div align="center">
                        <div style="height: 400px;">
                            <a href="#" class="modal_close">&times;</a>
                            <?php
                           
                            if (file_exists($file) && $fp = fopen($file, "r")) {
                                $titre = fgets($fp);
                                $data = array();
                                while ($ligne = fgetcsv($fp, 1024, ';')) {
                                    array_push($data, $ligne);
                                }

                                $datasize = count($data);

                                echo "<table border = '1' cellpadding='8' cellspacing='18'><thead><tr><td>Capital</td><td>Mois</td><td>Taux</td><td>Montant</td></thead></tr><tr>";
                                for ($i = 0; $i < 10; $i++) {
                                    if ($datasize - 1  < $i) break;
                                    $ligne = $data[$datasize - 1 - $i];
                                    echo "<tr>
                                    <td>$ligne[3]</td>
                                    <td>$ligne[4]</td>
                                    <td>$ligne[5]</td>
                                    <td>$ligne[2]</td>
                                    </tr>";
                                }
                                echo "</table>";
                                fclose($fp);
                            }
                           
                            ?>
                        </div>


                    </div>

                </div>

</body>

</html>