<?php

require_once "../util/logmanagement.php";

session_start();
if ($_SESSION["admin"] != "admin") {
    header("Location: adminlogin.php?stat=1");
}

if (isset($_GET["archiver"])) {

    $nomFichier = $_GET["archiver"];
    // Vérification si le fichier existe deja
    if (in_array($nomFichier, get_all_log_files())) {
        header("Location: index.php?stat=1#archiverPopUp");
    } else {
        $fullpath = "../archives/$nomFichier";
        if (dirname($fullpath) != "../archives") {
            echo "here";
            header("Location: index.php?stat=2#archiverPopUp");
            exit();
        }
        rename(get_full_log_file_path(), $fullpath);
        ensure_log_file_exists();
        header("Location: index.php?archive=$nomFichier");
    }
    exit();


} else if (isset($_GET["vider"])) {
    //vider logs
    unlink(get_full_log_file_path());
    ensure_log_file_exists();
} else if (isset($_GET["supprimer"], $_GET["archive"])) {
    $archive = $_GET['archive'];
    unlink("$app_log_folder/$archive");
}

header("Location: index.php");