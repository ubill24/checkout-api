<?php

$scriptPath = dirname(__FILE__);
$path = realpath($scriptPath . '/./');
$filepath = explode("wp-content",$path);
// print_r($filepath);
define('WP_USE_THEMES', false);
require(''.$filepath[0].'/wp-blog-header.php');
require(''.$filepath[0].'/wp-load.php');

parse_str($_SERVER['QUERY_STRING'], $output);

$data = $output['data'];
$code = $output['code'];
$data = json_decode($data);

function addBankRefToOrder($order_id, $bank_ref) {
    global $wpdb;
    $bank_ref_label = "_order_bank_ref";
    $bank_ref_value = $bank_ref;
   
    $wpdb->query( $wpdb->prepare( 
        "
            INSERT INTO $wpdb->postmeta
            ( post_id, meta_key, meta_value )
            VALUES ( %d, %s, %s )
        ", 
        $order_id, 
        $bank_ref_label, 
        $bank_ref_value 
    ) );
}

if ($code == 'PENDING') {

    $order_id = $data->reference_id;
    $invoice_number = $data->bill_code;
    $bill_date = $data->bill_date;
    $bill_amount = $data->amount;
    $currency = $data->currency;
    $bill_description = $data->description;
    $payment_url = $data->payment_url;
    $biller_code_url = $data->biller_codes;

    global $wpdb;
    
    $mypaylater = $wpdb->get_row("SELECT * FROM wp_wc_paylater where order_id= $order_id");
    if(is_null($mypaylater)) {
        $wpdb->query("INSERT INTO wp_wc_paylater ( order_id, invoice_number, bill_date, bill_amount, currency, bill_description, payment_url, darapay_code_url, wing_code_url )
        VALUES ( $order_id, '$invoice_number', '$bill_date', $bill_amount, '$currency', '$bill_description','$payment_url', '$biller_code_url[0]','$biller_code_url[1]' )");
    }
    
    $returnURL = site_url().'/my-account/paylater/?order_id='.$order_id;

    wp_redirect( $returnURL );
    exit;
}
