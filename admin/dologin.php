<?php

$admin_file_name = "admin_pass.csv";

if (!isset($_POST['login'], $_POST['password']) || $_POST['login'] == "" || $_POST['password'] == "") {
    error();
}

if (!file_exists($admin_file_name)) {
    error();
}


$fp = fopen($admin_file_name, "r");

while ($data = fgetcsv($fp, 1024, ";")) {

    if ($data[0] == $_POST['login']) {

        if (hash('sha256', strip_tags($_POST['password'])) == $data[1]) {
            session_start();
            $_SESSION["admin"] = "admin";
            header('Location: index.php');
        } else {
            fclose($fp);
            error();
        }
        fclose($fp);

    }
}

error();


function error()
{
    header('Location: adminlogin.php?stat=1');
    exit();
}