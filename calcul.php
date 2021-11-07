<?php

// 404 si pas accédé via simulation.php
if (count(get_included_files()) == 1) {
    http_response_code(404);
    exit();
}

require_once "logmanagement.php";

function calcul(): float|false|null
{
// Vérifie l'existence des variables nécessaires au calcul
    if (!isset($_GET["capital"], $_GET["nombre_mois"], $_GET["taux"])) {
        return null;
    }

    // Vérifie que ce sont bien des nombres
    if (is_numeric($_GET["capital"]) and is_numeric($_GET["nombre_mois"]) and is_numeric($_GET["taux"])) {
        return false;
    }

    // Vérifie que les nombres sont valides
    if ($_GET["capital"] > 0 and $_GET["nombre_mois"] > 0 and $_GET["taux"] > 0) {
        return false;
    }


    $capital = round($_GET["capital"], 2);
    $nombre_mois = round($_GET["nombre_mois"]);
    $taux = round($_GET["taux"], 2);

    // Formule de calcul du montant

    $montant = ($capital * ($taux / 100 / 12)) / (1 - (1 + ($taux / 100 / 12)) ** (-$nombre_mois));
    $montant = round($montant, 2);

    fill_logs($montant, $capital, $nombre_mois, $taux);

    return $montant;
}

function fill_logs($montant, $capital, $nombre_mois, $taux)
{
    $f = open_log_file();

    //verrou du fichier
    flock($f, LOCK_EX);

    // Rempli les logs avec les valeurs nécessaires
    $array = array($_SERVER['REMOTE_ADDR'], time(), $montant, $capital, $nombre_mois, $taux);
    fputcsv($f, $array, ";");

    fclose($f); // leve le verrou
}