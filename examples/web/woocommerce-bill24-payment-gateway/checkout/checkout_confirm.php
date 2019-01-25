<?php

/**
 * Handles Responses.
 */

// /** Loads the WordPress Environment and Template */
$scriptPath = dirname(__FILE__);
$path = realpath($scriptPath . '/./');
$filepath = explode("wp-content",$path);
define('WP_USE_THEMES', false);
require(''.$filepath[0].'/wp-blog-header.php');
require(''.$filepath[0].'/wp-load.php');

class CheckoutConfirm {
    public function updateStatus($order_id) {
        global $wpdb;
        $order_status = $wpdb->get_results("UPDATE $wpdb->posts SET $wpdb->posts.post_status = 'wc-processing' WHERE $wpdb->posts.post_type='shop_order' and $wpdb->posts.id = $order_id");
    }
    public function updateTotalPrice($order_id, $new_total_price){
        global $wpdb;
        $wpdb->get_results("UPDATE wp_postmeta SET meta_value=$new_total_price where post_id=$order_id and meta_key = '_order_total'");
    }
    public function addFeeToOrder($order_id, $fee) {
        global $wpdb;
        $fee_label = "_order_fee";
        $fee_value = $fee;
       
        $wpdb->query( $wpdb->prepare( 
            "
                INSERT INTO $wpdb->postmeta
                ( post_id, meta_key, meta_value )
                VALUES ( %d, %s, %s )
            ", 
            $order_id, 
            $fee_label, 
            $fee_value 
        ) );
    }
    public function addBankRefToOrder($order_id, $bank_ref) {
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
}

parse_str($_SERVER['QUERY_STRING'], $output);
$data = $output['data'];
$code = $output['code'];

$data = json_decode($data);

if ($code == 'SUCCESS') {

    $order_id = $data->reference_id;
    $new_total_price = $data->total_amount;
    $fee = $data->fee_amount;
    $bank_ref = $data->bank_reference_no;

    $checkorder = new CheckoutConfirm();
    $checkorder->updateStatus($order_id);
    $checkorder->updateTotalPrice($order_id, $new_total_price);
    $checkorder->addFeeToOrder($order_id, $fee);
    $checkorder->addBankRefToOrder($order_id, $bank_ref);

    $order_key = get_post_meta( $order_id, '_order_key', true);
    $returnURL = site_url().'/checkout/order-received/'.$order_id.'/?key='.$order_key;

    wp_redirect( $returnURL );
    exit;
    
} else {
    require_once 'payment/fail.php';
}
