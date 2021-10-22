<?php

if (isset($_POST['login'], $_POST['password']) && $_POST['login'] != "" && $_POST['password'] != "") {

    if (file_exists("admin_pass.csv")) {
        $file = "admin_pass.csv";
        $fp = fopen($file, "r");

        while ($data = fgetcsv($fp, 1024, ";")) {

            if ($data[0] == $_POST['login']) {

                if (hash('sha256', strip_tags($_POST['password'])) == $data[1]) {
                    session_start();
                    $_SESSION["admin"] = "admin";
                    header('Location: admin.php');
                } else {
                    header('Location: adminlogin.php?id=1');
                }
                fclose($fp);
                exit();
            }
        }
        header('Location: adminlogin.php?id=1');
        fclose($fp);
    } else {
        header('Location: adminlogin.php?id=1');
    }
} else {
    header('Location: adminlogin.php?id=1');
}
