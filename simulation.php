<?php

// Vérifie l'existence des variables nécessaires au calcul sinon redirige
if (isset($_GET["capital"], $_GET["nombre_mois"], $_GET["taux"])) {

    // Crée les variables $capital, $nombre_mois, $taux en vérifiant que ce sont bien des nombres sinon redirige
    foreach ($_GET as $k => $v) {
        if (is_numeric($v)) {
            $$k = $v;
        } else {
            redirect();
        }
    }
    $taux /= 100;

    // Formule de calcul du montant
    $montant = ($capital * ($taux / 12)) / (1 - (1 + ($taux / 12)) ** (-$nombre_mois));
    $montant = round($montant, 2);

    // Crée le fichier et ajoute les colonnes s'il n'existe pas
    if (!file_exists("logs.csv")) {
        $f = fopen("logs.csv", 'w');
        $array = array("ip", "date", "Montant", "Capital", "Nombredemois", "Taux");
        fputcsv($f, $array, ";");
        fclose($f);
    }

    // Essaye d'ouvrir le fichier et boucle tant qu'il n'y arrive pas (c'est qu'il est utilisé par un autre utilisateur)
    $f = fopen("logs.csv", 'a');
    if ($f == false) {
        while ($f == false) {
            usleep(10);
            $f = fopen("logs.csv", 'a');
        }
    }

    // Rempli les logs avec les valeurs nécessaires
    $array = array($_SERVER['REMOTE_ADDR'], time(), $montant, $capital, $nombre_mois, $taux);
    fputcsv($f, $array, ";");
    fclose($f);

}

// Fonction de redirection vers lui-même lorsqu'il y a une erreur dans les valeurs
function redirect()
{
    header("Location: simulation.php?id=1");
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
    if (isset($_GET["id"]) and $_GET["id"] == 1) {
        echo "<p class='info' style='color: red'>Erreur dans les champs</p>";
    }
    ?>

    <form action='' method='get'>
        <div class="form-group">
            <div class="labels">
                <label for="capital">Capital</label>
                <label for="nombre_mois">Mois</label>
                <label for="taux">Taux (%)</label>
            </div>

            <div class="inputs">
                <?php
                if (isset($_GET["capital"], $_GET["nombre_mois"], $_GET["taux"])) {
                    $taux = $taux * 100;
                    echo "<input type='number' id='capital' name='capital' step='any' min='0' value='$capital' required>";
                    echo "<input type='number' id='nombre_mois' name='nombre_mois' step='any' min='0' value='$nombre_mois' required>";
                    echo "<input type='number' id='taux' name='taux' step='any' min='0' value='$taux' required>";
                } else {
                    echo "<input type='number' id='capital' name='capital' step='any' min='0'required>";
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
            echo "<br/>";
        }
        ?>
        <button type='submit'>Calculer</button>
    </form>
</div>
</body>
</html>


