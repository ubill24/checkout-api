<?php

if (isset($_POST['submit'])) {
    $token = $_POST['api_token'];
    $api_url = 'https://checkoutapi-demo.bill24.net/transaction/init';

    $checkout_confirm = 'http://localhost:8081/checkout-api/examples/web/php/checkout/checkout_confirm.php';
    $checkout_cancel = 'http://localhost:8081/checkout-api/examples/web/php/checkout/checkout_cancel.php';
    $pay_later_url  = 'http://localhost:8081/checkout-api/examples/web/php/checkout/pay_later.php';

    $data = [
        'reference_id' => $_POST['order_code'],
        'amount' => $_POST['amount'],
        'currency' => $_POST['currency'],
        'description' => $_POST['description'],
        'confirm_url' => $checkout_confirm,
        'cancel_url' => $checkout_cancel,
        'pay_later_url' => $pay_later_url
    ];
    $data_string = json_encode($data);

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $api_url,
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
        $response_message = array(
            'code'=>$response_body['code'],
            'message'=>$response_body['message']
        );
        $url = http_build_query($response_message);
        header("Location: ". $checkout_cancel . "?" . $url);
    }
}
