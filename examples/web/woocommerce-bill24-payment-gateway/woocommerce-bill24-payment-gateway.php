<?php
/*
 * Plugin Name: Woocommerce Bill24 Payment Gateway
 * Description: Allow your customer to pay via local bank in Cambodia.
 * Author: Bill24
 * Author URI: https://bill24.net
 * Version: 1.0.1
 *
 * /*
 * This action hook registers our PHP class as a WooCommerce payment gateway
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Make sure WooCommerce is active
if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) return;

add_filter( 'woocommerce_payment_gateways', 'bill24_add_gateway_class', 11 );
function bill24_add_gateway_class( $gateways ) {
	$gateways[] = 'WC_bill24_Gateway'; // your class name is here
	return $gateways;
}
/*
 * The class itself, please note that it is inside plugins_loaded action hook
 */
add_action( 'plugins_loaded', 'bill24_init_gateway_class' );
function bill24_init_gateway_class() {
	
	class WC_bill24_Gateway extends WC_Payment_Gateway {
		function __construct() {
			$this->id = "bill24"; // global ID
			$this->method_title = __( "Bill24", 'bill24' );// Show Title
			$this->method_description = __( "bill24 Payment Gateway Plug-in for WooCommerce", 'bill24' );// Show Description
			$this->title = __( "Bill24 Vertical", 'bill24' );// vertical tab title
			$this->icon = null;
			$this->has_fields = true;
			$this->init_form_fields(); // setting defines
			$this->init_settings(); // load time variable setting
			// Turn these settings into variables we can use
			foreach ( $this->settings as $setting_key => $value ) {
				$this->$setting_key = $value;
			}
			// further check of SSL if you want
            // add_action( 'admin_notices', array( $this,	'do_ssl_check' ) );
			// Save settings
			if ( is_admin() ) {
				add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
            }

			add_action( 'woocommerce_api_callback', array( $this, 'webhook' ) );
            	
		} // Here is the  End __construct()

		// administration fields for specific Gateway
		public function init_form_fields() {
			$this->form_fields = array(
				'enabled' => array(
					'title'		=> __( 'Enable / Disable', 'bill24' ),
					'label'		=> __( 'Enable this payment gateway', 'bill24' ),
					'type'		=> 'checkbox',
					'default'	=> 'no',
				),
				'title' => array(
					'title'		=> __( 'Title', 'bill24' ),
					'type'		=> 'textarea',
					'desc_tip'	=> __( 'Payment title of checkout process.', 'bill24' ),
					'default'	=> __( 'Bill24', 'bill24' ),
				),
				'description' => array(
					'title'		=> __( 'Description', 'bill24' ),
					'type'		=> 'textarea',
					'desc_tip'	=> __( 'Payment title of checkout process.', 'bill24' ),
					'default'	=> __( 'Pay easily via local bank in Cambodia', 'bill24' ),
					'css'		=> 'max-width:450px;'
				),
				'api_login' => array(
					'title'		=> __( 'Bill24 WebAPI Client', 'bill24' ),
					'type'		=> 'text',
					'desc_tip'	=> __( 'This is the API Login provided by bill24.net when you signed up for an account.', 'bill24' ),
				),
				'environment' => array(
					'title'		=> __( 'Bill24.net Test Mode', 'bill24' ),
					'label'		=> __( 'Enable Test Mode', 'bill24' ),
					'type'		=> 'checkbox',
					'description' => __( 'This is the test mode of gateway.', 'bill24' ),
					'default'	=> 'no',
				)
			);		
		}
		
		public function webhook() {

			if($_SERVER["REQUEST_METHOD"] == "POST" && $_SERVER["CONTENT_TYPE"] == "application/json")
			{
				$json = file_get_contents('php://input');
				$data = json_decode($json, true);

				$order_id = $data["checkout_ref"];
				$customer_order = wc_get_order($order_id);
				$customer_order->payment_complete();
				$customer_order->add_order_note( 'Hey, your order is paid! Thank you!', true );
				wc_reduce_stock_levels( $order_id );

				if( ! WC()->cart->is_empty()) {
					WC()->cart->empty_cart();
				}
			
				$new_total_price = $data['total_amount'];

				global $wpdb;
				$wpdb->get_results("UPDATE wp_postmeta SET meta_value=$new_total_price where post_id=$order_id and meta_key = '_order_total'");

				$fee_label = "_order_fee";
				$fee_value = $data['customer_fee'];
				
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
				
				// Add data response to wp_webhooks_response
				$bank_name = $data["bank_name"];
				$bank_ref = $data["bank_ref"];
				$checkout_ref = $data["checkout_ref"];
				$currency = $data["currency"];
				$customer_code = $data["customer_code"];
				$customer_fee = $data["customer_fee"];
				$customer_name = $data["customer_name"];
				$customer_phone = $data["customer_phone "];
				$customer_sync_code = $data["customer_sync_code"];
				$hook_description = $data["description"];
				$paid_by = $data["paid_by"];
				$paid_date = $data["paid_date"];
				$supplier_fee = $data["supplier_fee"];
				$tnx_id = $data["tnx_id"];
				$total_amount = $data["total_amount"];
				$tran_amount = $data["tran_amount"];
				
				$wpdb->query("INSERT INTO wp_wc_webhooks_response (bank_name,bank_ref,checkout_ref,currency,customer_code,customer_fee,customer_name,customer_phone,
						customer_sync_code,hook_description,paid_by,paid_date,supplier_fee,tnx_id,total_amount,
						tran_amount) VALUES('$bank_name','$bank_ref','$checkout_ref','$currency','$customer_code','$customer_fee','$customer_name','$customer_phone',
					'$customer_sync_code','$hook_description','$paid_by','$paid_date','$supplier_fee','$tnx_id','$total_amount','$tran_amount')" 				
				);

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
		
		// Response handled for payment gateway
		public function process_payment( $order_id ) {
			global $woocommerce;
			$customer_order = new WC_Order( $order_id );
            $environment = ( $this->environment == "yes" ) ? 'TRUE' : 'FALSE';// checking for transiction
            $environment_url = ( "FALSE" == $environment ) 
                                ? 'https://checkoutapi.bill24.net/transaction/init'
                            : 'https://checkoutapi-demo.bill24.net/transaction/init'; // Decide which URL to post to

            $token = $this->api_login;
            $url = $environment_url;
			$call_back_url = plugins_url('woocommerce-bill24-payment-gateway/checkout/checkout_confirm.php', dirname(__FILE__));
            $cancel_url = $customer_order->get_cancel_order_url();
            $pay_later_url = plugins_url('woocommerce-bill24-payment-gateway/checkout/pay_later.php', dirname(__FILE__));

			$payload = array(
				"x_currency"            => get_woocommerce_currency(),
				"x_amount"             	=> $customer_order->get_total(),
				"x_invoice_num"        	=> str_replace( "#", "", $customer_order->get_order_number() ),
			);
			
			$data = [
                "currency"=> $payload['x_currency'], 
                "amount"=> $payload['x_amount'],
                "reference_id"=> $payload['x_invoice_num'], 
                "language"=> "km", 
                "callback_url"=>  $call_back_url, 
                "webview"=> false, 
                "cancel_url"=> $cancel_url, 
                "pay_later_url"=> $pay_later_url, 
                "description"=> "Order from Online Shop." ,
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
                    "Accept: application/json",
                    "token: $token"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
			$response_body = json_decode($response, true);

			global $wpdb;
			$myposts = $wpdb->get_row("SELECT * FROM wp_posts");
			//Add column if not present.
			if(!isset($myposts->tran_id)){
				$wpdb->query("ALTER TABLE wp_posts ADD tran_id varchar(255) NOT NULL");
			}

			$tran_id = $response_body['data']['tran_id'];
			global $wpdb;
			$wpdb->query( $wpdb->prepare( 
				"
					UPDATE $wpdb->posts
					SET tran_id = %s WHERE ID=%d
				", 
				$tran_id,
				$order_id
			) );

			if ($response_body['code'] == 'SUCCESS') {

				$payment_url = $response_body['data']['payment_url'];
                return array(
                    'result'   => 'success',
                    'redirect' => $payment_url,
                );
                
            } else {

                wc_add_notice( $r['response_reason_text'], 'error' );
                wc_add_notice( $response, 'error' );

                $customer_order->add_order_note( 'Error: '. $r['response_reason_text'] );
            }
	
		}
		
		// Validate fields
		public function validate_fields() {
			return true;
		}

		// public function do_ssl_check() {
		// 	if( $this->enabled == "yes" ) {
		// 		if( get_option( 'woocommerce_force_ssl_checkout' ) == "no" ) {
		// 			echo "<div class=\"error\"><p>". sprintf( __( "<strong>%s</strong> is enabled and WooCommerce is not forcing the SSL certificate on your checkout page. Please ensure that you have a valid SSL certificate and that you are <a href=\"%s\">forcing the checkout pages to be secured.</a>" ), $this->method_title, admin_url( 'admin.php?page=wc-settings&tab=checkout' ) ) ."</p></div>";	
		// 		}
		// 	}		
		// }
	}
}

// add bank reference to thank you page
add_action( 'woocommerce_thankyou', 'show_custom_text_by_variation_id', 20 ); 
function show_custom_text_by_variation_id( $order_id ) {
	$order = wc_get_order( $order_id );
	$bank_ref = get_post_meta( $order->get_order_number(), '_order_bank_ref', true);
    foreach( $order->get_items() as $item ) {
        if ( isset( $item[ 'variation_id' ] ) ) {
            echo '<h2>Bank Reference: </h2> Bank Reference No: &nbsp; <b> ' .$bank_ref .'</b>';
        }
	}
}

// add bank reference to order view page
add_action('woocommerce_order_details_after_order_table', 'action_woocommerce_order_details_after_customer_details', 10, 2);
function action_woocommerce_order_details_after_customer_details($order) {
	$bank_ref = get_post_meta( $order->get_order_number(), '_order_bank_ref', true);
	if ($bank_ref) {
		echo '<h2>Bank Reference </h2> Bank Reference Number: &nbsp; <b> ' .$bank_ref .'</b>' ;
	}
}

// add order fee in order details in view order page
add_filter( 'woocommerce_get_order_item_totals', 'add_custom_order_fee_row', 30, 3 );
function add_custom_order_fee_row( $total_rows, $order, $tax_display ) {
	global $wpdb;
	$fee = get_post_meta( $order->get_order_number(), '_order_fee', true);

    // Set last total row in a variable and remove it.
    $gran_total = $total_rows['order_total'];
    unset( $total_rows['order_total'] );

    // Insert a new row
    $total_rows['recurr_not'] = array(
        'label' => __( 'Fee :', 'woocommerce' ),
		'value' => wc_price($fee),
    );

    // Set back last total row
    $total_rows['order_total'] = $gran_total;

    return $total_rows;
}

// add order fee to view order admin page
add_action('woocommerce_admin_order_totals_after_tax', 'custom_admin_order_totals_after_tax', 10, 1 );
function custom_admin_order_totals_after_tax( $orderid ) {
 
    // Here set your data and calculations
	$label = __( 'Fee', 'sport_sp' );
	$fee = get_post_meta( $orderid, '_order_fee', true);
	$value = wc_price($fee);
 
    // Output
    ?>
        <tr>
            <td class="label"><?php echo $label; ?>:</td>
            <td width="1%"></td>
            <td class="custom-total"><?php echo $value; ?></td>
        </tr>
    <?php
}


// ------------------
// 1. Register new endpoint to use for My Account page
// Note: Resave Permalinks or it will give 404 error
 
function add_paylater_endpoint() {
    add_rewrite_endpoint( 'paylater', EP_ROOT | EP_PAGES );
}
 
add_action( 'init', 'add_paylater_endpoint' );
 
 
// ------------------
// 2. Add new query var
 
function paylater_query_vars( $vars ) {
    $vars[] = 'paylater';
    return $vars;
}
 
add_filter( 'query_vars', 'paylater_query_vars', 0 );
 
 
// // ------------------
// // 3. Insert the new endpoint into the My Account menu
 
// // function paylater_link_my_account( $items ) {
// //     $items['paylater'] = 'Paylater Bill';
// //     return $items;
// // }
 
// // add_filter( 'woocommerce_account_menu_items', 'paylater_link_my_account' );
 
 
// ------------------
// 4. Add content to the new endpoint
function paylater_content($order) {
	echo '<h2>Bill24 Paylater</h2>';
	$order_id = $_GET['order_id'];
	echo do_shortcode("[paylater order_id=$order_id]");
}
 
add_action( 'woocommerce_account_paylater_endpoint', 'paylater_content' );
// Note: add_action must follow 'woocommerce_account_{your-endpoint-slug}_endpoint' format

function paylater_shortcode( $atts, $content = null ){
	extract( shortcode_atts( array(
		'order_id' => 'order_id',
		), $atts ) );

		global $wpdb;
		$mypaylater = $wpdb->get_row("SELECT * FROM wp_wc_paylater where order_id= $order_id");
		return "
			Invoice Number : <a href='" .$mypaylater->payment_url ."' target='_blank' style='color: #5083ec;'>" .$mypaylater->invoice_number ."</a><br/><br/>"
			."
			<table class='table table-bordered'>
				<thead>
				<tr style='text-align: left'>
					<th scope='col'>Reference No.</th>
					<th scope='col'>Bill Date</th>
					<th scope='col'>Description</th>
					<th scope='col'>Amount</th>
				</tr>
				</thead>
				<tbody>
				<tr style='text-align: left'>
					<th scope='row'>" .$mypaylater->order_id ."</th>
					<td>" .$mypaylater->bill_date ."</td>
					<td>" .$mypaylater->bill_description ."</td>
					<td>" .$mypaylater->bill_amount ."&nbsp;<span class='badge badge-primary'>" .$mypaylater->currency ."</span></td>
				</tr>
				</tbody>
			</table>
			<div class='payment-box' style='margin-top: 20px;width: 100%;float: left;border: 1px solid #ccc;padding: 15px;display: flex; margin-bottom: 15px;'>
				
				<div class='agencies'>
					<strong class='agencies-title'><h3>Pay with agencies:</h3></strong>
					<div class='agencies-img'>
						<img src='" .$mypaylater->darapay_code_url ."' style='max-width: 80px; margin-right: 10px'>
					  	<img src='" .$mypaylater->wing_code_url ."' style='max-width: 80px'>
					</div>
				</div>
			</div>
			"
			
		;
}
add_shortcode( 'paylater', 'paylater_shortcode' );

//create webhook_response_table in database
function my_plugin_create_paylater() {

	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'wc_paylater';

	$paylater = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		order_id int NOT NULL,
		invoice_number varchar(100) NOT NULL,
		bill_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		bill_amount int NOT NULL,
		currency varchar(50) NOT NULL,
		bill_description varchar(255) NOT NULL,
		payment_url varchar(255) NOT NULL,
		darapay_code_url varchar(255) NOT NULL,
		wing_code_url varchar(255) NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $paylater );
}
register_activation_hook( __FILE__, 'my_plugin_create_paylater' );


//create webhook_response_table in database
function my_plugin_create_db() {

	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'wc_webhooks_response';

	$webhook_response = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		bank_name varchar(100) NOT NULL,
		bank_ref varchar(100) NOT NULL,
		checkout_ref varchar(100) NOT NULL,
		currency varchar(100) NOT NULL,
		customer_code varchar(100) NOT NULL,
		customer_fee int NOT NULL,
		customer_name varchar(100) NOT NULL,
		customer_phone varchar(100) NOT NULL,
		customer_sync_code varchar(100) NOT NULL,
		hook_description varchar(100) NOT NULL,
		paid_by varchar(100) NOT NULL,
		paid_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		supplier_fee int NOT NULL,
		tnx_id int NOT NULL,
		total_amount int NOT NULL,
		tran_amount int NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $webhook_response );
}
register_activation_hook( __FILE__, 'my_plugin_create_db' );
