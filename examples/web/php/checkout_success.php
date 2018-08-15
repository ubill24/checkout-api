<?php
    $curl = curl_init();
    $auth_token = 'd66f822f559c4b32ab1641ff43789d1e';

    curl_setopt($curl, CURLOPT_URL, "https://checkoutapi-demo.bill24.net/transaction/init");
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json","Accept: application/json", "token: $auth_token"));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $output = curl_exec($curl);
//    $output = json_decode($output);

    print_r($output);
    curl_close($curl);
