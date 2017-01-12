<?php

// Heading
$_['heading_title'] = 'pipwave';

// Text
$_['text_payment'] = 'Payment';
$_['text_success'] = 'Success: You have modified pipwave account details!';
$_['text_edit'] = 'Edit pipwave';
$_['text_pipwave'] = '<a href="https://www.pipwave.com/" target="_blank"><img src="view/image/payment/pipwave.png" alt="pipwave" title="pipwave" /></a>';

// Entry
$_['entry_api_key'] = 'pipwave API Key';
$_['entry_api_secret'] = 'pipwave API Secret';
$_['entry_status'] = 'Status';
$_['entry_sort_order'] = 'Sort Order';
$_['entry_test_mode'] = 'Test';
$_['entry_order_status'] = 'Order Status';
$_['entry_complete_status'] = 'Order Paid Status';
$_['entry_refund_status'] = 'Order Refunded Status';
$_['entry_partial_refund_status'] = 'Order Partial Refunded Status';
$_['entry_canceled_status'] = 'Order Canceled Status';
$_['entry_failed_status'] = 'Order Failed Status';
$_['entry_geo_zone'] = 'Geo Zone';
$_['entry_processing_fee_group'] = 'Processing Fee Group';
$_['entry_processing_fee_ref'] = 'Reference ID';
// Help
$_['tooltip_api_key'] = "API Key provided by pipwave in <a href='https://merchant.pipwave.com/development-setting/index' target='_blank' style='text-decoration: underline;'>Development > Setting</a>.";
$_['tooltip_api_secret'] = "API Secret provided by pipwave in <a href='https://merchant.pipwave.com/development-setting/index' target='_blank' style='text-decoration: underline;'>Development > Setting</a>.";
$_['tooltip_processing_fee_group'] = "Create one or more groups to impose processing fee on selected payment method in pipwave <a href='https://merchant.pipwave.com/account/set-processing-fee-group#general-processing-fee-group' target='_blank' style='text-decoration: underline;'>Account > General</a>.<br>Reference ID will be passed in pipwave checkout API to indicate which processing fee group in effect.";
// Error
$_['error_permission'] = 'Warning: You do not have permission to modify payment pipwave!';
$_['error_api_key'] = 'pipwave API key cannot be blank';
$_['error_api_secret'] = 'pipwave API secret cannot be blank';
$_['error_processing_fee_ref'] = 'Reference ID cannot be blank if processing fee group is selected.';

// Information
$_['step_title'] = 'What you should do next:';
$_['step_sign_in'] = 'Sign in to <b><a href="https://merchant.pipwave.com" target="_blank" >pipwave Merchant Center</a></b>. ';
$_['step_sign_up'] = 'If you do not have a pipwave account, <b><a href="https://merchant.pipwave.com/site/signup">sign up now!</a></b> It is quick and easy.';
$_['step_setup'] = 'After sign in, go to <b>Setup > Payments</b>.';
$_['step_configure'] = "Configure the payment methods which you would like to offer your customers and it's done!";
$_['step_more_info'] = 'To know more about pipwave, click <b><a href="https://www.pipwave.com" target="_blank" >here</a></b>.';
