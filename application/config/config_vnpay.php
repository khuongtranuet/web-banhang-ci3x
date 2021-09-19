<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Ho_Chi_Minh');
$config['vnpay'] = array (
	'vnp_TmnCode' => 'Y4U88XFK',
//	'vnp_TmnCode' => '9WW7ZHNN',
	'vnp_HashSecret' => 'DTHXNFNBUMNKFKQOZVHTXUXNUQUUXMTV',
//	'vnp_HashSecret' => 'BZXBPEBZGJPVVJTHJOZJGRJGMNRUPTYH',
	'vnp_Url' => 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html',
	'vnp_Returnurl' => 'http://localhost:81/web-banhang-ci3x/client/payment/vnpay_return',
	'expire' => date('YmdHis',strtotime('+15 minutes',strtotime(date("YmdHis")))),
);
?>
