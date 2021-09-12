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
			$data['title_page'] = 'Checkout đơn hàng';
			$data['load_page'] = 'client/payment/checkout_view';
			$id = $_SESSION['id'];
			$data['customer_address'] = $this->customer_model->address_customer($id, false, true);
			$order_exist = $this->payment_model->select('*', TBL_ORDERS, 'WHERE customer_id = '.$id.' AND status = -2');
			$data['product_list'] = $this->cart_model->product_cart($order_exist[0]['id']);
			$this->load->view('layouts/fe_master_view', $data);
		}else{
			$data['title_page'] = 'Checkout đơn hàng';
			$data['load_page'] = 'client/payment/checkout_view';
			$id = $_SESSION['customer_id'];
			$data['customer_address'] = $this->customer_model->address_customer($id, false, true);
			$order_exist = $this->payment_model->select('*', TBL_ORDERS, 'WHERE customer_id = '.$id.' AND status = -2');
			$data['product_list'] = $this->cart_model->product_cart($order_exist[0]['id']);
			$this->load->view('layouts/fe_master_view', $data);
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
}
