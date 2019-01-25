<?php

parse_str($_SERVER['QUERY_STRING'], $output);
$error_code = $output['code'];
$error_message = $output['message'];
require_once 'payment/fail.php';