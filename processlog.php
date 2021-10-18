<?php

session_start();
if ($_SESSION["admin"] != "admin") {
    header("Location: adminlogin.php");
}

if (isset($_GET["archiver"])) {
    //archiver logs
    rename("logs.csv", "logs.csv.archive");
} else if (isset($_GET["vider"])) {
    //archiver logs
    unlink("logs.csv");
}

header("Location: admin.php");