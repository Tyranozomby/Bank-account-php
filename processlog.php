<?php
require_once "logmanagement.php";
session_start();
if ($_SESSION["admin"] != "admin") {
    header("Location: adminlogin.php?stat=1");
}

if (isset($_GET["archiver"])) {
    //archiver logs
    rename($logs_folder . "/" . $log_file_name, $log_file_name . ".archive");
} else if (isset($_GET["vider"])) {
    //archiver logs
    unlink($logs_folder . "/" . $log_file_name);
}

header("Location: admin.php");