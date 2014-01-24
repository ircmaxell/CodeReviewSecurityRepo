<?php

$original = array(23, 18, 5, 8, 10, 16);

function getRunningTotal(array $array) {
    $total = 0;
    foreach ($array as $value) {
        $total += $value;
        yield $total;
    }
}

$total = iterator_to_array(getRunningTotal($original));

var_dump($total);