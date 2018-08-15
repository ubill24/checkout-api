<?php

if (isset($_POST['submit'])) {
    $token = $_POST['api_token'];
    $url = 'https://checkoutapi-dev0.bill24.net/transaction/init';
    $checkout_confirm = 'http://localhost/checkout-api/checkout_confirm.php';
    $checkout_cancel = 'http://localhost/checkout-api/checkout_cancel.php';

    $data = [
        'reference_id' => $_POST['order_code'],
        'amount' => $_POST['amount'],
        'currency' => $_POST['currency'],
        'description' => $_POST['description'],
        'confirm_url' => $checkout_confirm,
        'cancel_url' => $checkout_cancel
    ];
    $data_string = json_encode($data);

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data_string,
        CURLOPT_HTTPHEADER => array(
            "Cache-Control: no-cache",
            "Content-Type: application/json",
            "token: $token"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    $response_body = json_decode($response, true);

    if ($response_body['code'] == 'SUCCESS') {
        $payment_url = $response_body['data']['payment_url'];
        header('Location: ' . $payment_url);
    } else {
        echo $response_body['code'];
    }
}
