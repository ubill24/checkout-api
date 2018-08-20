<?php

parse_str($_SERVER['QUERY_STRING'], $output);

$data = $output['data'];
$code = $output['code'];
$data = json_decode($data);

if ($code == 'PENDING') {
    require_once 'templates/payment/later.php';
}
