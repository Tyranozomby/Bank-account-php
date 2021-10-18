<?php

if (isset($_POST['login'], $_POST['password']) && $_POST['login'] != "" && $_POST['password'] != "") {

    if (file_exists("admin_pass.csv")) {
        $file = "admin_pass.csv";
        $fp = fopen($file, "r");

        while ($data = fgetcsv($fp, 1024, ";")) {

            if ($data[0] == $_POST['login']) {

                if (hash('sha256', $_POST['password']) == $data[1]) {
                    echo "good password";
                } else {
                    echo "wrong password";
                }
            }
        }
        fclose($fp);
    } else {
        echo "Le fichier <strong>admin_pass.csv</strong> n'existe pas !";
    }
} else {
    echo "veuillez compléter tous les champs";
}
