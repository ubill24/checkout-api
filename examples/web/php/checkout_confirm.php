<?php

parse_str($_SERVER['QUERY_STRING'], $output);
$data = $output['data'];
$code = $output['code'];
$data = json_decode($data);

if ($code == 'SUCCESS') {
    require_once 'templates/checkout/success.php';
} else {
    require_once 'templates/checkout/fail.php';
}
