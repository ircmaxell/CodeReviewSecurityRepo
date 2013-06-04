<?php
$f = fopen('result.csv', 'w');
for ($i = 0; $i < 2000; $i++) {
    $date = trim(exec('git log | head -n3'));
    if (substr($date, 0, 4) != 'Date') {
        $date = trim(exec('git log | head -n4'));
    }
    $date = trim(substr($date, 6));

    passthru('phploc --log-csv tmp.csv --exclude vendor .');
    $t = fopen('tmp.csv', 'r');
    if ($i === 0) {
        fputcsv($f, array_merge(array("Date"), fgetcsv($t)));
    } else {
        fgetcsv($t);
    }
    fputcsv($f, array_merge(array($date), fgetcsv($t)));
    $time--;
    fclose($t);
    passthru('git checkout HEAD~10');
}