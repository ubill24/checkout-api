<?php

parse_str($_SERVER['QUERY_STRING'], $output);

$data = $output['data'];
$code = $output['code'];
$data = json_decode($data);

if ($code == 'PENDING') {
    include_once 'payment/later.php';
}
