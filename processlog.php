<?php

require_once "logmanagement.php";

session_start();
if ($_SESSION["admin"] != "admin") {
    header("Location: adminlogin.php?stat=1");
}

if (isset($_GET["archiver"])) {

    $nomFichier = $_GET["archiver"];
    //verifiaction si le fichier existe deja
    if (in_array($nomFichier, get_all_log_files())) {
        header("Location: admin.php?stat=1#archiverPopUp");
        exit();
    } else {
        //archiver logs
        /** @noinspection PhpUndefinedVariableInspection */
        rename(get_full_log_file_path(), "$logs_folder/$nomFichier");
    }


} else if (isset($_GET["vider"])) {
    header("Location: adminlogin.php?stat=1");
    //vider logs
    unlink(get_full_log_file_path());
    fclose(open_log_file());
} else if (isset($_GET["supprimer"], $_GET["archive"])) {
    header("Location: adminlogin.php?stat=1");
    $archive = $_GET['archive'];
    /** @noinspection PhpUndefinedVariableInspection */
    unlink("$logs_folder/$archive");
}

header("Location: admin.php");