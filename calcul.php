<?php

function calcul(): float|bool
{
// Vérifie l'existence des variables nécessaires au calcul sinon redirige
    if (isset($_GET["capital"], $_GET["nombre_mois"], $_GET["taux"])) {

        // Crée les variables $capital, $nombre_mois, $taux en vérifiant que ce sont bien des nombres sinon redirige
        if (is_numeric($_GET["capital"]) and is_numeric($_GET["nombre_mois"]) and is_numeric($_GET["taux"])) {
            $capital = $_GET["capital"];
            $nombre_mois = $_GET["nombre_mois"];
            $taux = $_GET["taux"];
        } else {
            header("Location: simulation.php?stat=1");
            exit();
        }

        // Formule de calcul du montant
        $montant = ($capital * ($taux / 100 / 12)) / (1 - (1 + ($taux / 100 / 12)) ** (-$nombre_mois));
        $montant = round($montant, 2);

        fill_logs($montant, $capital, $nombre_mois, $taux);
        return $montant;
    }
    return false;
}

function fill_logs($montant, $capital, $nombre_mois, $taux)
{
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