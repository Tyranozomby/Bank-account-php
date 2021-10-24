<?php
// 404 si accedé directement
if (count(get_included_files()) == 1) {
    http_response_code(404);
    exit();
}

$log_file_name = "logs.csv";

$log_header = array("ip", "date", "Montant", "Capital", "Nombredemois", "Taux");


/**
 * @return false|resource
 * @noinspection PhpMissingReturnTypeInspection
 */
function open_log_file(bool $read = false)
{
    global $log_file_name, $log_header;

    // Crée le fichier et ajoute les colonnes s'il n'existe pas
    if (!file_exists($log_file_name)) {
        $f = fopen($log_file_name, 'w' . ($read ? '+' :''));
        flock($f, LOCK_EX);
        fputcsv($f, $log_header, ";");
        flock($f, LOCK_UN);


    } else {
        $f = fopen($log_file_name, 'a'. ($read ? '+' :'') );
    }

    if($read){
        rewind($f);
    }
    return $f;
}

function get_logs_data(): false|array
{
    $logfile = open_log_file(true);

    if ($logfile == false) return false;

    flock($logfile, LOCK_SH);

    fgets($logfile); // on saute la ligne header

    $data = array();
    while ($ligne = fgetcsv($logfile, separator: ';')) {
        array_push($data, $ligne);
    }

    fclose($logfile);

    return $data;
}


function print_logs_table($limit_from_last = null)
{
    $data = get_logs_data();


    $dataSize = count($data);
    $limit_from_last ??= $dataSize;


    echo "
<table>
    <thead>
        <tr>
            <th>Capital</th>
            <th>Mois</th>
            <th>Taux (%)</th>
            <th>Montant (€/mois)</th>
        </tr>
    </thead>";


    for ($i = 0; $i < $limit_from_last; $i++) {
        if ($dataSize - 1 < $i) break;
        $ligne = $data[$dataSize - 1 - $i];

        echo "<tr>";
            echo "<td>$ligne[3]</td>";
            echo "<td>$ligne[4]</td>";
            echo "<td>" . number_format($ligne[5], 2) . "</td>";
            echo "<td>$ligne[2]</td>";
        echo "</tr>";
    }
    echo "
</table>";

}




