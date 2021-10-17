<?php

if(isset($_POST['login'], $_POST['password']) && $_POST['login'] != "" && $_POST['password'] != ""){

    if (file_exists("admin_pass.csv")){
        $file = "admin_pass.csv";
        $fp=fopen($file,"r");

        while($data= fgetcsv($fp, 1024, ";")){

            foreach($data as $v) {
                echo $v . " | ";
            }
        }
        fclose($fp);
    } else {
        echo("Le fichier <strong>admin_pass.csv</strong> n'existe pas !");
    }
}

?>
