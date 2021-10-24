<?php

require "calcul.php";
require_once "logmanagement.php";

$montant = calcul();
if ($montant === null) {
    unset($montant);
} else if ($montant === false) {
    header("Location: simulation.php?err");
    exit();
}
?>

<!doctype html>
<html lang="fr">
<meta charset="utf-8"/>

<head>
    <title>Formulaire de simulation</title>
    <link rel="stylesheet" href="style.css"/>
</head>

<body>
<script type="text/javascript">
    function loadData(elem){
        const row = elem.parentElement.parentElement

        const capital = row.childNodes[0].innerText;
        const mois = row.childNodes[1].innerText;
        const taux = row.childNodes[2].innerText;



        let capitalelem = document.getElementById("capital");
        let moiselem = document.getElementById("nombre_mois");
        let tauxelem = document.getElementById("taux");
        if (!(capitalelem.value === capital && moiselem.value === mois && tauxelem.value === taux)) {
            capitalelem.value = capital;
            moiselem.value = mois;
            tauxelem.value = taux;
            const elems = document.getElementsByClassName("result")
            if (elems.length > 0) elems[0].remove()
        }

        location.hash = "";

    }

</script>

<div>
    <h1>Prêt Bancaire</h1>

    <?php
    if (isset($_GET["err"])) {
        echo "<p class='info error'>Erreur dans les champs</p>";
    }
    ?>

    <form action='' method='get' class="box">
        <div class="form-group">
            <div class="labels">
                <label for="capital">Capital</label>
                <label for="nombre_mois">Mois</label>
                <label for="taux">Taux (%)</label>
            </div>

            <div class="inputs">
                <?php
                if (isset($_GET["capital"], $_GET["nombre_mois"], $_GET["taux"])) {
                    echo "<input type='number' id='capital' name='capital' min='0' step='0.01' value='" . $_GET["capital"] . "' required>";
                    echo "<input type='number' id='nombre_mois' name='nombre_mois' min='0' step='0.01' value='" . $_GET["nombre_mois"] . "' required>";
                    echo "<input type='number' id='taux' name='taux' min='0' max='100' step='0.01' value='" . $_GET["taux"] . "' required>";
                } else { ?>
                    <input type='number' id='capital' name='capital' step='0.01' min='0' required>
                    <input type='number' id='nombre_mois' name='nombre_mois' step='0.01' min='0' required>
                    <input type='number' id='taux' name='taux' step='0.01' min='0' max='100' required>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
        if (isset($montant)) {
            echo "<p class='result success'>Montant à rembourser par mois : $montant €</p>";
        } else {
            echo "<br/><br/>";
        }
        ?>
        <button type='submit'>Calculer</button>
    </form>
    <div>
        <br/><br/>

        <?php
        if (file_exists(get_full_log_file_path())) {
            /** @noinspection HtmlUnknownAnchorTarget */
            echo "<a class='popButton' href='#logs'>Historique</a>";
        }
        ?>
        <a class="popButton" href='README.html'>Readme</a>
        <link rel="stylesheet" href="stylePopUp.css">
        <div id="logs" class="modal">
            <div class="modal_content">
                <h1>Historique</h1>
                <a href="#" class="modal_close">&times;</a>
                <?php
                print_logs_table(null,10, [3, 4, 5, 2], [
                        2 => fn($data) => "<a class='popButton' style=' padding: 2%; background-color: black;' onclick='loadData(this)'>$data</a>"
                ]);
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>