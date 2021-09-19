<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payment extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'admin/customer_model',
			'client/payment_model',
			'client/cart_model',
		));
	}

	public function checkout()
	{
		if (isset($_SESSION['id'])) {
			$this->form_validation->set_rules('payment', 'Phương thức thanh toán', 'required',
				array('required' => '<h5 style="color: red; height: 0px;">%s không được để trống!</h5>')
			);
			if ($this->form_validation->run() == FALSE) {
				$data['title_page'] = 'Checkout đơn hàng';
				$data['load_page'] = 'client/payment/checkout_view';
				$id = $_SESSION['id'];
				$data['customer_address'] = $this->customer_model->address_customer($id, false, true);
				$order_exist = $this->payment_model->select('*', TBL_ORDERS, 'WHERE customer_id = ' . $id . ' AND status = -2');
				$data['product_list'] = $this->cart_model->product_cart($order_exist[0]['id']);
				$this->load->view('layouts/fe_master_view', $data);
			} else {
				if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
					if ($_POST['payment'] == '0') {
						$params['order_date'] = date('Y-m-d H:i:s');
						$params['total_bill'] = 0;
						$params['customer_id'] = $_SESSION['id'];
						$params['payment_method'] = 2;
						$params['payment_status'] = -1;
						$params['status'] = 0;
						$order_exist = $this->payment_model->select('*', TBL_ORDERS, 'WHERE customer_id = ' . $_SESSION['id'] . ' AND status = -2');
						$data['product_list'] = $this->cart_model->product_cart($order_exist[0]['id']);
						$params_delete['customer_id'] = $_SESSION['id'];
						for ($i = 0; $i < count($data['product_list']); $i++) {
							$params['total_bill'] += $data['product_list'][$i]['total_price'];
							$params_delete['product_id'] = $data['product_list'][$i]['product_id'];
							$this->cart_model->delete_cart($params_delete);
						}
						$update_order = $this->payment_model->update_order($params);
						if (isset($update_order) && $update_order) {
							$this->session->set_flashdata('success', 'Đặt đơn hàng thành công!');
							redirect('client/home/index');
						}
					}else{
						$params['order_date'] = date('Y-m-d H:i:s');
						$params['total_bill'] = 0;
						$params['customer_id'] = $_SESSION['id'];
						$params['payment_method'] = 1;
						$params['payment_status'] = -1;
						$params['order_code'] = ramdomOrderNumber();
						$order_exist = $this->payment_model->select('*', TBL_ORDERS, 'WHERE customer_id = ' . $_SESSION['id'] . ' AND status = -2');
						$data['product_list'] = $this->cart_model->product_cart($order_exist[0]['id']);
						for ($i = 0; $i < count($data['product_list']); $i++) {
							$params['total_bill'] += $data['product_list'][$i]['total_price'];
						}
						$update_order = $this->payment_model->update_order($params, true);
						$data['order_detail'] = $this->payment_model->select(' *', TBL_ORDERS, ' WHERE id = '.$update_order);
						$_SESSION['order_code'] = $data['order_detail'][0]['code'];
						$_SESSION['total_pay'] = $data['order_detail'][0]['total_pay'];
						$_SESSION['order_id'] = $update_order;

						$data['title_page'] = 'Thanh toán đơn hàng';
						$vnpay = $this->config->item('vnpay');
						$data['expire'] = $vnpay['expire'];
						return $this->load->view('client/vnpay/index', $data);
					}
					echo_pre($_POST);
					die();
				}
			}
		} else {
			$this->form_validation->set_rules('payment', 'Phương thức thanh toán', 'required',
				array('required' => '<h5 style="color: red; height: 0px;">%s không được để trống!</h5>')
			);
			if ($this->form_validation->run() == FALSE) {
				$data['title_page'] = 'Checkout đơn hàng';
				$data['load_page'] = 'client/payment/checkout_view';
				$id = $_SESSION['customer_id'];
				$data['customer_address'] = $this->customer_model->address_customer($id, false, true);
				$order_exist = $this->payment_model->select('*', TBL_ORDERS, 'WHERE customer_id = ' . $id . ' AND status = -2');
				$data['product_list'] = $this->cart_model->product_cart($order_exist[0]['id']);
				$this->load->view('layouts/fe_master_view', $data);
			} else {
				if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
					if ($_POST['payment'] == '0') {
						$params['order_date'] = date('Y-m-d H:i:s');
						$params['total_bill'] = 0;
						$params['customer_id'] = $_SESSION['customer_id'];
						$params['payment_method'] = 2;
						$params['payment_status'] = -1;
						$params['status'] = 0;
						$order_exist = $this->payment_model->select('*', TBL_ORDERS, 'WHERE customer_id = ' . $_SESSION['customer_id'] . ' AND status = -2');
						$data['product_list'] = $this->cart_model->product_cart($order_exist[0]['id']);
						for ($i = 0; $i < count($data['product_list']); $i++) {
							$params['total_bill'] += $data['product_list'][$i]['total_price'];
//							$key = array_search($data['product_list'][$i]['product_id'], $_SESSION['product_id']);
//							if ($key > -1) {
//								unset($_SESSION['product_id'][$key]);
//								unset($_SESSION['quantity'][$key]);
//							}
						}
						$update_order = $this->payment_model->update_order($params);
						if (isset($update_order) && $update_order) {
							unset($_SESSION['product_id']);
							unset($_SESSION['quantity']);
							$this->session->set_flashdata('success', 'Đặt đơn hàng thành công!');
							redirect('client/home/index');
						}
					}else{
						$params['order_date'] = date('Y-m-d H:i:s');
						$params['total_bill'] = 0;
						$params['customer_id'] = $_SESSION['customer_id'];
						$params['payment_method'] = 1;
						$params['payment_status'] = -1;
						$params['order_code'] = ramdomOrderNumber();
						$order_exist = $this->payment_model->select('*', TBL_ORDERS, 'WHERE customer_id = ' . $_SESSION['customer_id'] . ' AND status = -2');
						$data['product_list'] = $this->cart_model->product_cart($order_exist[0]['id']);
						for ($i = 0; $i < count($data['product_list']); $i++) {
							$params['total_bill'] += $data['product_list'][$i]['total_price'];
						}
						$update_order = $this->payment_model->update_order($params, true);
						$data['order_detail'] = $this->payment_model->select(' *', TBL_ORDERS, ' WHERE id = '.$update_order);
						$_SESSION['order_code'] = $data['order_detail'][0]['code'];
						$_SESSION['total_pay'] = $data['order_detail'][0]['total_pay'];
						$_SESSION['order_id'] = $update_order;

						$data['title_page'] = 'Thanh toán đơn hàng';
						$vnpay = $this->config->item('vnpay');
						$data['expire'] = $vnpay['expire'];
						return $this->load->view('client/vnpay/index', $data);
					}
					echo_pre($_POST);
					die();
				}
			}
		}
	}

	public function shipping()
	{
		if (isset($_SESSION['id']) && $_SESSION['id']) {
			if ($_SERVER['REQUEST_METHOD'] = 'POST' && $_POST) {
				$data['title_page'] = 'Địa chỉ ship hàng';
				$data['load_page'] = 'client/payment/shipping_view';
				$data['address_customer'] = $this->customer_model->address_customer($_SESSION['id'], false);
				$data['province'] = $this->customer_model->select('*', 'provinces');
				$address = array();
				foreach ($_POST as $key => $value) {
					$address[$key] = htmlspecialchars($value);
				}
				$address['customer_id'] = $_SESSION['id'];
				if (isset($_POST['update'])) {
					$data['update_address'] = $this->payment_model->update_address($address);
					if (isset($data['update_address']) && $data['update_address']) {
						$this->session->set_flashdata('success', 'Cập nhật địa chỉ thành công!');
						redirect('client/payment/shipping');
					}
				} else {
					$data['insert_address'] = $this->payment_model->insert_address($address);
					if (isset($data['insert_address']) && $data['insert_address']) {
						redirect('client/cart/detail');
					}
				}
				$this->load->view('layouts/fe_master_view', $data);
			} else {
				$data['title_page'] = 'Địa chỉ ship hàng';
				$data['load_page'] = 'client/payment/shipping_view';
				$data['address_customer'] = $this->customer_model->address_customer($_SESSION['id'], false);
				$data['province'] = $this->customer_model->select('*', 'provinces');
				if (count($data['address_customer']) == 0) {
					$this->session->set_flashdata('error', 'Người dùng không tồn tại!');
					redirect('client/cart/detail');
				}
				$this->load->view('layouts/fe_master_view', $data);
			}
		}
	}

	public function change()
	{
		if (isset($_GET) && $_GET['cus_id'] && $_GET['id']) {
			$params['customer_id'] = $_GET['cus_id'];
			$params['id'] = $_GET['id'];
			$change_address = $this->payment_model->change_address($params);
			if (isset($change_address) && $change_address) {
				redirect('client/cart/detail');
			}
		}
	}

	public function ajax_address()
	{
		$params['customer_id'] = $this->input->post('customer_id');
		$params['address_id'] = $this->input->post('address_id');
		$data['update_customer'] = $this->customer_model->address_customer($params['customer_id'], $params['address_id']);
		$data['province'] = $this->customer_model->select('*', 'provinces');
		if (count($data['update_customer']) == 0) {
			$this->load->view('client/payment/ajax_address_view', $data);
		}
		$province_id = $data['update_customer'][0]['province_id'];
		$district_id = $data['update_customer'][0]['district_id'];
		$data['district'] = $this->customer_model->select('*', 'districts', 'WHERE province_id = ' . $province_id . '');
		$data['ward'] = $this->customer_model->select('*', 'wards', 'WHERE district_id = ' . $district_id . ' AND province_id = ' . $province_id . '');
		$this->load->view('client/payment/ajax_shipping_view', $data);
	}

	public function delete($id = null)
	{
		if (!isset($id) || $id == NULL) {
			redirect('client/payment/shipping');
		} else {
			$data['id'] = $id;
		}
		if (is_numeric($id)) {
			if (isset($_SESSION['id'])) {
				$params['address_id'] = $id;
				$params['customer_id'] = $_SESSION['id'];
				$delete = $this->payment_model->delete_address($params);
				if (isset($delete) && $delete) {
					$this->session->set_flashdata('success', 'Xóa địa chỉ thành công!');
					redirect('client/payment/shipping');
				}
			}
		} else {
			$this->session->set_flashdata('error', 'Địa chỉ không tồn tại!');
			redirect('client/payment/shipping');
		}
	}

	public function pay()
	{
		$data['title_page'] = 'Thanh toán vnpay';
		$vnpay = $this->config->item('vnpay');
//		$data['vnp_TmnCode'] = $vnpay['vnp_TmnCode'];
//		$data['vnp_Returnurl'] = $vnpay['vnp_Returnurl'];
//		$data['vnp_Url'] = $vnpay['vnp_Url'];
//		$data['vnp_HashSecret'] = $vnpay['vnp_HashSecret'];
//		$this->load->view('client/vnpay/vnpay_create_payment', $data);
		error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
		/**
		 * Description of vnpay_ajax
		 *
		 * @author xonv
		 */

//$vnp_TxnRef = $_POST['order_id']; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
		$vnp_TxnRef = $_SESSION['order_code']; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
		$vnp_OrderInfo = $_POST['order_desc'];
		$vnp_OrderType = $_POST['order_type'];
//$vnp_Amount = str_replace(',', '', $_POST['amount']) * 100;
		$vnp_Amount = str_replace(',', '', $_SESSION['total_pay']) * 100;
		$vnp_Locale = $_POST['language'];
		$vnp_BankCode = $_POST['bank_code'];
		$vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
		$vnp_ExpireDate = $_POST['txtexpire'];

		$inputData = array(
			"vnp_Version" => "2.0.0",
			"vnp_TmnCode" => $vnpay['vnp_TmnCode'],
			"vnp_Amount" => $vnp_Amount,
			"vnp_Command" => "pay",
			"vnp_CreateDate" => date('YmdHis'),
			"vnp_CurrCode" => "VND",
			"vnp_IpAddr" => $vnp_IpAddr,
			"vnp_Locale" => $vnp_Locale,
			"vnp_OrderInfo" => $vnp_OrderInfo,
			"vnp_OrderType" => $vnp_OrderType,
			"vnp_ReturnUrl" => $vnpay['vnp_Returnurl'],
			"vnp_TxnRef" => $vnp_TxnRef,
			"vnp_ExpireDate"=>$vnp_ExpireDate,
		);

		if (isset($vnp_BankCode) && $vnp_BankCode != "") {
			$inputData['vnp_BankCode'] = $vnp_BankCode;
		}
		ksort($inputData);
		$query = "";
		$i = 0;
		$hashdata = "";
		foreach ($inputData as $key => $value) {
			if ($i == 1) {
				$hashdata .= '&' . $key . "=" . $value;
			} else {
				$hashdata .= $key . "=" . $value;
				$i = 1;
			}
			$query .= urlencode($key) . "=" . urlencode($value) . '&';
		}

		$vnp_Url = $vnpay['vnp_Url'] . "?" . $query;
		if (isset($vnpay['vnp_HashSecret'])) {
			$vnpSecureHash = hash('sha256', $vnpay['vnp_HashSecret'] . $hashdata);
			$vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
		}
		$returnData = array('code' => '00'
		, 'message' => 'success'
		, 'data' => $vnp_Url);
		if (isset($_POST['redirect'])) {
			header('Location: ' . $vnp_Url);
			die();
		} else {
			echo json_encode($returnData);
		}
	}

	public function vnpay_return()
	{
		$data['title_page'] = 'Thanh toán vnpay';
		$vnpay = $this->config->item('vnpay');
		$data['vnp_HashSecret'] = $vnpay['vnp_HashSecret'];

		$vnp_SecureHash = $_GET['vnp_SecureHash'];
		$inputData = array();
		foreach ($_GET as $key => $value) {
			if (substr($key, 0, 4) == "vnp_") {
				$inputData[$key] = $value;
			}
		}
		unset($inputData['vnp_SecureHashType']);
		unset($inputData['vnp_SecureHash']);
		ksort($inputData);
		$i = 0;
		$hashData = "";
		foreach ($inputData as $key => $value) {
			if ($i == 1) {
				$hashData = $hashData . '&' . $key . "=" . $value;
			} else {
				$hashData = $hashData . $key . "=" . $value;
				$i = 1;
			}
		}
		$secureHash = hash('sha256',$data['vnp_HashSecret'] . $hashData);

		if ($secureHash == $vnp_SecureHash) {
			if ($_GET['vnp_ResponseCode'] == '00') {
				$params['order_code'] = $_GET['vnp_TxnRef'];
				$order_id = $this->payment_model->select(' *', TBL_ORDERS, ' WHERE code = '.$params['order_code']);
				$params['order_id'] = $order_id[0]['id'];
				$params['money'] = $_GET['vnp_Amount']/100;
				$params['note'] = $_GET['vnp_OrderInfo'];
				$params['vnp_response_code'] = $_GET['vnp_ResponseCode'];
				$params['code_vnpay'] = $_GET['vnp_TransactionNo'];
				$params['code_bank'] = $_GET['vnp_BankCode'];
				$params['bank_transaction'] = $_GET['vnp_BankTranNo'];
				$params['created_at'] = date('Y-m-d H:i:s', strtotime($_GET['vnp_PayDate']));
				$result_payment = $this->payment_model->payment_order($params);
				if (isset($result_payment) && $result_payment) {
					$data['product_list'] = $this->cart_model->product_cart($params['order_id']);
					if (isset($_SESSION['login'])) {
						$params_delete['customer_id'] = $_SESSION['id'];
						for ($i = 0; $i < count($data['product_list']); $i++) {
							$params_delete['product_id'] = $data['product_list'][$i]['product_id'];
							$this->cart_model->delete_cart($params_delete);
						}
					}else{
						unset($_SESSION['product_id']);
						unset($_SESSION['quantity']);
					}
					unset($_SESSION['order_code']);
					unset($_SESSION['total_pay']);
					unset($_SESSION['order_id']);
					$data['result'] = "GD Thanh cong";
				}
			} else {
				$data['result'] = "GD Khong thanh cong";
			}
		} else {
			$data['result'] = "Chu ky khong hop le";
		}

		$this->load->view('client/vnpay/vnpay_return', $data);
	}
}
