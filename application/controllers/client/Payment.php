<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payment extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'client/payment_model',
			'admin/customer_model',
		));
	}

	public function checkout()
	{
		$data['title_page'] = 'Checkout đơn hàng';
		$data['load_page'] = 'client/payment/checkout_view';
		$this->load->view('layouts/fe_master_view', $data);
	}

	public function shipping()
	{
		if (isset($_SESSION['id']) && $_SESSION['id']) {
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
}
