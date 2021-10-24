<?php
// 404 si accedé directement
if (count(get_included_files()) == 1) {
    http_response_code(404);
    exit();
}

$logs_folder = "archives";

$log_file_name = "logs.csv";

$log_header = array("ip", "date", "Montant", "Capital", "Nombredemois", "Taux");


/**
 * @param string | null
 * @param bool $read
 * @return false|resource
 * @noinspection PhpMissingReturnTypeInspection
 */
function open_log_file(string $file_name = null, bool $read = false)
{
    global $log_file_name, $log_header, $logs_folder;

    $file = $logs_folder . "/" . ($file_name ?? $log_file_name);

    if (!file_exists($logs_folder)) {
        mkdir("archives");
    } else if (!is_dir($logs_folder)) {
        return false;
    }

    // Crée le fichier et ajoute les colonnes s'il n'existe pas
    if (!file_exists($file)) {
        $f = fopen($file, 'w' . ($read ? '+' : ''));
        flock($f, LOCK_EX);
        fputcsv($f, $log_header, ";");
        flock($f, LOCK_UN);


    } else {
        $f = fopen($file, 'a' . ($read ? '+' : ''));
    }

    if ($read) {
        rewind($f);
    }
    return $f;
}

function get_all_log_files(): array
{
    return array_diff(scandir("archives"), array('.', '..'));
}

function get_logs_data(string $filename = null): false|array
{
    $logfile = open_log_file($filename,true);

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


/**
 * @param null $limit_from_last
 * @param int[]| null $columns
 * @param array $col_callbacks
 */
function print_logs_table(string $filename = null,$limit_from_last = null, array $columns = null, array $col_callbacks = [])
{
    $data = get_logs_data($filename);
    if($data == false) return;
    $dataSize = count($data);

    $header_display = array("IP", "Date", "Montant (€/mois)", "Capital", "Mois", "Taux");

    $limit_from_last ??= $dataSize;
    $columns ??= range(0, count($header_display) - 1);


    $to_show = array_map(fn($colnum) => $header_display[$colnum], $columns);


    echo "
<table>
    <thead>
        <tr>";
    foreach ($to_show as $value) {
        echo "<td>$value</td>";
    }
    echo "
        </tr>
    </thead>";


    for ($i = 0; $i < $limit_from_last; $i++) {
        if ($dataSize - 1 < $i) break;
        $ligne = $data[$dataSize - 1 - $i];

        echo "<tr>";
        foreach ($columns as $colnum) {
            $coldata = $ligne[$colnum];
            if ($colnum == 5) $coldata = number_format($coldata, 2) . " %";
            if ($colnum == 2) $coldata = $coldata . " €";
            if ($colnum == 1) {
                $coldata = date_format(date_create_from_format("U", $coldata), 'Y-m-d H:i:s');
            }

            if (isset($col_callbacks[$colnum])) {
                $coldata = $col_callbacks[$colnum]($coldata);
            }
            echo "<td>$coldata</td>";
        }
        echo "</tr>";
    }
    echo "
</table>";

}




