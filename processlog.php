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
        $fullpath = "$logs_folder/$nomFichier";
        if(dirname($fullpath) != "archives"){
            header("Location: admin.php?stat=2#archiverPopUp");
            exit();
        }
        rename(get_full_log_file_path(), $fullpath);
        ensure_log_file_exists();
        header("Location: admin.php?archive=$nomFichier");
        exit();
    }


} else if (isset($_GET["vider"])) {
    header("Location: adminlogin.php?stat=1");
    //vider logs
    unlink(get_full_log_file_path());
    ensure_log_file_exists();
} else if (isset($_GET["supprimer"], $_GET["archive"])) {
    header("Location: adminlogin.php?stat=1");
    $archive = $_GET['archive'];
    unlink("$logs_folder/$archive");
}

header("Location: admin.php");