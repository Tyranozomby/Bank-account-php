<?php

require_once "logmanagement.php";

// 404 si pas accédé via simulation.php
if (count(get_included_files()) == 1) {
    http_response_code(404);
    exit();
}

function calcul(): float|false|null
{
// Vérifie l'existence des variables nécessaires au calcul sinon redirige
    if (!isset($_GET["capital"], $_GET["nombre_mois"], $_GET["taux"])) {
        return null;
    }

        // Crée les variables $capital, $nombre_mois, $taux en vérifiant que ce sont bien des nombres sinon redirige
        if (is_numeric($_GET["capital"]) and is_numeric($_GET["nombre_mois"]) and is_numeric($_GET["taux"])) {
            $capital = round($_GET["capital"], 2);
            $nombre_mois = round($_GET["nombre_mois"], 2);
            $taux = round($_GET["taux"], 2);
        } else {
            header("Location: simulation.php?stat=1");
            exit();
        }
    // Crée les variables $capital, $nombre_mois, $taux en vérifiant que ce sont bien des nombres sinon redirige

    if (!is_numeric($_GET["capital"]) or !is_numeric($_GET["nombre_mois"]) or !is_numeric($_GET["taux"])) {
        return false;
    }


    $capital = $_GET["capital"];
    $nombre_mois = $_GET["nombre_mois"];
    $taux = $_GET["taux"];

    // Formule de calcul du montant

    $montant = ($capital * ($taux / 100 / 12)) / (1 - (1 + ($taux / 100 / 12)) ** (-$nombre_mois));
    $montant = round($montant, 2);

    fill_logs($montant, $capital, $nombre_mois, $taux);

    return $montant;


}

function fill_logs($montant, $capital, $nombre_mois, $taux)
{
    $f = open_log_file();
    // Crée le fichier et ajoute les colonnes s'il n'existe pas
    if (!file_exists("archives/logs.csv")) {
        $f = fopen("archives/logs.csv", 'w');
        $array = array("ip", "date", "Montant", "Capital", "Nombredemois", "Taux");
        fputcsv($f, $array, ";");
        fclose($f);
    }

    //verrou du fichier
    flock($f, LOCK_EX);

    // Rempli les logs avec les valeurs nécessaires
    $array = array($_SERVER['REMOTE_ADDR'], time(), $montant, $capital, $nombre_mois, $taux);
    fputcsv($f, $array, ";");

    fclose($f); // leve le verrou
}


