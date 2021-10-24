<?php
require_once "logmanagement.php";

session_start();
if ($_SESSION["admin"] != "admin") {
    header("Location: adminlogin.php?stat=1");
}

if (isset($_GET["archiver"])) {
    $nomFichier = $_GET["archiver"];
    //archiver logs
    rename(get_full_log_file_path(), "$logs_folder/$nomFichier");
} else if (isset($_GET["vider"])) {
    //vider logs
    unlink(get_full_log_file_path());
    fclose(open_log_file());
}

header("Location: admin.php");