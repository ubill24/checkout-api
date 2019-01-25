<?php

parse_str($_SERVER['QUERY_STRING'], $output);
$data = $output['data'];
$code = $output['code'];
$data = json_decode($data);

if ($code == 'SUCCESS') {
    include_once 'success.php';
} else {
    include_once 'fail.php';
}
