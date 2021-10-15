<?php

if (isset($_GET["montant"], $_GET["capital"], $_GET["nombre_mois"], $_GET["taux"])
//    and is_int($_GET["montant"]) and is_int($_GET["capital"]) and is_int($_GET["nombre_mois"]) and is_int($_GET["taux"])
) {

    $montant = $_GET["montant"];
    $capital = $_GET["capital"];
    $nombre_mois = $_GET["nombre_mois"];
    $taux = $_GET["taux"];

    $montant = ($capital * ($taux / 12)) / (1 - (1 + ($taux / 12)) ** (-$nombre_mois));
    echo $montant;

    $f = fopen("logs.cvs", 'a');
    $array = array($_SERVER['REMOTE_ADDR'], getdate(), $montant, $capital, $nombre_mois, $taux);
    fputcsv($f, $array);

} else {
    header("Location: simulation.php");
}