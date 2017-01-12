<?php

/**
 * pipwave OpenCart Plugin
 * 
 * @package Payment Gateway
 * @author pipwave Technical Team <technical@pipwave.com>
 * @version 1.0
 */
class ControllerPaymentPipwave extends Controller {

    public $api_url;
    public $sdk_url;
    public $loading_img;
    
    public function __construct($registry) {
        parent::__construct($registry);
        if($this->config->get('pipwave_test_mode') == '1') {
            $this->api_url = 'https://staging-api.pipwave.com/payment';
            $this->sdk_url = '//staging-checkout.pipwave.com/sdk/';
            $this->loading_img = '//staging-checkout.pipwave.com/images/loading.gif';
        } else {
            $this->api_url = 'https://api.pipwave.com/payment';
            $this->sdk_url = '//secure.pipwave.com/sdk/';
            $this->loading_img = '//secure.pipwave.com/images/loading.gif';
        }
    }

    public function index() {
        $data['button_confirm'] = $this->language->get('button_confirm');

        $this->load->model('checkout/order');
        $this->load->model('account/order');

        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        $caller_version = 'OpenCart_v' . VERSION;
        $data = array(
            'action' => 'initiate-payment',
            'timestamp' => time(),
            'api_key' => $this->config->get('pipwave_api_key'),
            'txn_id' => $this->session->data['order_id'] . "",
            'amount' => $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false),
            'currency_code' => $order_info['currency_code'],
            'short_description' => 'Payment for Order#' . $order_info['order_id'],
            'session_info' => array(
                'ip_address' => $order_info['ip'],
                'language' => $this->session->data['language'],
            ),
            'version' => $caller_version,
        );
        $data['tax_exempted_amount'] = $data['amount'];

        if (isset($this->session->data['guest'])) {
            $data['buyer_info'] = array(
                'id' => $this->session->data['guest']['email'],
                'email' => $this->session->data['guest']['email'],
                'contact_no' => $this->session->data['guest']['telephone'],
                'country_code' => $order_info['payment_iso_code_2'],
            );
        } else {
            $this->load->model('account/address');
            $this->load->model('account/customer_group');
            $buyer_address = $this->model_account_address->getAddress($this->customer->getAddressId());
            $customer_group = $this->model_account_customer_group->getCustomerGroup($this->customer->getGroupId());
            $processing_fee_ref = $this->config->get('pipwave_processing_fee_ref');
            $data['buyer_info'] = array(
                'id' => $this->customer->getId(),
                'email' => $this->customer->getEmail(),
                'first_name' => $this->customer->getFirstName(),
                'last_name' => $this->customer->getLastName(),
                'contact_no' => $this->customer->getTelephone(),
                'country_code' => $buyer_address['iso_code_2'],
                'surcharge_group' => isset($processing_fee_ref[$customer_group['customer_group_id']]) ? $processing_fee_ref[$customer_group['customer_group_id']] : ''
            );
        }

        $data['billing_info'] = array(
            'name' => $order_info['payment_firstname'] . ' ' . $order_info['payment_lastname'],
            'address1' => $order_info['payment_address_1'],
            'address2' => $order_info['payment_address_2'],
            'city' => $order_info['payment_city'],
            'state' => $order_info['payment_zone'],
            'zip' => $order_info['payment_postcode'],
            'country' => $order_info['payment_country'],
            'country_iso2' => $order_info['payment_iso_code_2'],
        );

        if ($this->cart->hasShipping()) {
            $data['shipping_info'] = array(
                'name' => $order_info['shipping_firstname'] . ' ' . $order_info['shipping_lastname'],
                'address1' => $order_info['shipping_address_1'],
                'address2' => $order_info['shipping_address_2'],
                'city' => $order_info['shipping_city'],
                'state' => $order_info['shipping_zone'],
                'zip' => $order_info['shipping_postcode'],
                'country' => $order_info['shipping_country'],
                'country_iso2' => $order_info['shipping_iso_code_2'],
            );
        }
        $data['api_override'] = array(
            'success_url' => $this->url->link('checkout/success', '', true),
            'fail_url' => $this->url->link('checkout/failure'),
            'notification_url' => $this->url->link('payment/pipwave/callback', '', true),
        );

        $signatureParam = array(
            'api_key' => $this->config->get('pipwave_api_key'),
            'api_secret' => $this->config->get('pipwave_api_secret'),
            'txn_id' => $data['txn_id'],
            'amount' => $data['amount'],
            'currency_code' => $data['currency_code'],
            'action' => $data['action'],
            'timestamp' => $data['timestamp']
        );
        $data['signature'] = $this->_generateSignature($signatureParam);

        $this->load->language('payment/pipwave');
        $this->load->model('catalog/product');
        $products = $this->cart->getProducts();
        foreach ($products as $key => $product) {
            $product_info = $this->model_catalog_product->getProduct($product['product_id']);
            $data['item_info'][] = array(
                "name" => $product['name'],
                "description" => $product['name'] . ' - ' . $product['model'],
                "amount" => $this->currency->format($product['price'], $order_info['currency_code'], $order_info['currency_value'], false),
                "currency_code" => $order_info['currency_code'],
                "quantity" => $product['quantity'],
                "sku" => $product_info['sku']
            );
        }

        $pipwave_res = $this->_sendRequest($data);
        $view_data = array(
            'text_pay_via' => $this->language->get('text_pay_via'),
            'url' => $this->sdk_url,
            'loading_img' => $this->loading_img
        );

        if (isset($pipwave_res['status']) && $pipwave_res['status'] == 200) {
            $view_data['api_data'] = json_encode([
                'api_key' => $this->config->get('pipwave_api_key'),
                'token' => $pipwave_res['token'],
                'caller_version' => $caller_version
            ]);
        } else {
            $view_data['error'] = $pipwave_res['message'];
        }

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/pipwave.tpl')) {
            return $this->load->view($this->config->get('config_template') . '/template/payment/pipwave.tpl', $view_data);
        } else {
            return $this->load->view('payment/pipwave.tpl', $view_data);
        }
    }

    public function callback() {
        header('HTTP/1.1 200 OK');
        echo "OK";
        $post_content = file_get_contents("php://input");
        $post_data = json_decode($post_content, true);
        $timestamp = (isset($post_data['timestamp']) && !empty($post_data['timestamp'])) ? $post_data['timestamp'] : time();
        $pw_id = (isset($post_data['pw_id']) && !empty($post_data['pw_id'])) ? $post_data['pw_id'] : '';
        $order_id = (isset($post_data['txn_id']) && !empty($post_data['txn_id'])) ? $post_data['txn_id'] : '';
        $amount = (isset($post_data['amount']) && !empty($post_data['amount'])) ? $post_data['amount'] : '';
        $final_amount = (isset($post_data['final_amount']) && !empty($post_data['final_amount'])) ? $post_data['final_amount'] : '';
        $currency_code = (isset($post_data['currency_code']) && !empty($post_data['currency_code'])) ? $post_data['currency_code'] : '';
        $transaction_status = (isset($post_data['transaction_status']) && !empty($post_data['transaction_status'])) ? $post_data['transaction_status'] : '';
        $payment_method = isset($post_data['payment_method_title']) ? $post_data['payment_method_title'] : null;
        $signature = (isset($post_data['signature']) && !empty($post_data['signature'])) ? $post_data['signature'] : '';
        // AFT Status
        $aft_status = isset($post_data['aft_status']) ? $post_data['aft_status'] : '';
        $aft_score = isset($post_data['aft_score']) ? $post_data['aft_score'] : '';
        $message = isset($post_data['message']) ? $post_data['message'] : '';

        $data_for_signature = array(
            'timestamp' => $timestamp,
            'api_key' => $this->config->get('pipwave_api_key'),
            'pw_id' => $pw_id,
            'txn_id' => $order_id,
            'amount' => $amount,
            'currency_code' => $currency_code,
            'transaction_status' => $transaction_status,
            'api_secret' => $this->config->get('pipwave_api_secret'),
        );

        $comment = array(
            sprintf("Paid with: %s", $payment_method),
            "pipwave Transaction ID: {$pw_id}"
        );
        $generatedSignature = $this->_generateSignature($data_for_signature);
        if ($signature != $generatedSignature) {
            $transaction_status = -1;
        }
        $orderStatus = $this->_getOrderStatus($transaction_status, $post_data['status']);
        $comment[] = $orderStatus['comment'];
        $order_status_id = $orderStatus['order_status_id'];
        if ($transaction_status != -1) {
            $this->load->model('checkout/order');
            $order_info = $this->model_checkout_order->getOrder($order_id);
            if ($order_info) {
                if (in_array($transaction_status, array(10, 20, 25))) {
                    $comment[] = sprintf("Currency: %s", $currency_code);
                    $comment[] = sprintf("Final Amount: %s", $final_amount);
                }
                if ($amount != $order_info['total']) {
                    $comment[] = "Amount mismatch";
                }
                if ($currency_code != $order_info['currency_code']) {
                    $comment[] = "Currency mismatch";
                }
                if (!empty($aft_status) && !empty($aft_score)) {
                    $comment[] = sprintf("AFT Status: %s", $aft_status);
                    $comment[] = sprintf("AFT Score: %s", $aft_score);
                }
                if (!empty($message)) {
                    $comment[] = sprintf("pipwave Message: %s", $message);
                }
            } else {
                $comment[] = "Invalid order";
            }
        }

        if ($transaction_status == 5 && !is_null($payment_method)) {
            $this->db->query("UPDATE `" . DB_PREFIX . "order` SET `payment_method` = '" . $payment_method . "' WHERE `order_id` = '" . (int) $order_id . "'");
        }
        $this->model_checkout_order->addOrderHistory($order_id, $order_status_id, implode("\n", $comment));
    }

    private function _getOrderStatus($transaction_status, $api_status) {
        $with_warning_msg = ($api_status == 3001) ? " (with warning)" : '';
        $order_status_id = $this->config->get('config_order_status_id');
        switch ($transaction_status) {
            case 5: // pending
                $note = "Payment Status: Pending$with_warning_msg";
                break;
            case 1: // failed
                $note = "Payment Status: Failed$with_warning_msg";
                $order_status_id = $this->config->get('pipwave_failed_status_id');
                break;
            case 2: // cancelled
                $note = "Payment Status: Cancelled$with_warning_msg";
                $order_status_id = $this->config->get('pipwave_canceled_status_id');
                break;
            case 10: // complete
                $note = "Payment Status: Completed$with_warning_msg";
                $order_status_id = $this->config->get('pipwave_complete_status_id');
                break;
            case 20: // refunded
                $note = "Payment Status: Refunded$with_warning_msg";
                $order_status_id = $this->config->get('pipwave_refund_status_id');
                break;
            case 25: // partial refunded
                $note = "Payment Status: Partial Refunded$with_warning_msg";
                $order_status_id = $this->config->get('pipwave_partial_refund_status_id');
                break;
            case -1: // signature mismatch
                $note = "Signature mismatch";
                break;
            default:
                $note = "Unknown payment status";
        }

        return array('comment' => $note, 'order_status_id' => $order_status_id);
    }

    private function _generateSignature($array) {
        ksort($array);
        $signature = "";
        foreach ($array as $key => $value) {
            $signature .= $key . ':' . $value;
        }
        return sha1($signature);
    }

    private function _sendRequest($data) {
        $agent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('x-api-key' => $this->config->get('pipwave_api_key')));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_URL, $this->api_url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($ch);
        if ($response == false) {
            echo "<pre>";
            echo 'CURL ERROR: ' . curl_errno($ch) . '::' . curl_error($ch);
            die;
        }
        curl_close($ch);

        return json_decode($response, true);
    }

}
