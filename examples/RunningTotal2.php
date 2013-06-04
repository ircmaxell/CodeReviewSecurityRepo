<?php

$original = array(23, 18, 5, 8, 10, 16);

$total = array();
$runningSum = 0;

foreach ($original as $number) {
    $runningSum += $number;
    $total[] = $runningSum;
}

var_dump($total);