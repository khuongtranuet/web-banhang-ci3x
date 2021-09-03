<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'client/cart_model',
			'admin/customer_model',
		));
	}

	public function detail() {
		$data['title_page'] = 'Giỏ hàng';
		if (isset($_SESSION['login'])) {
			$id = $_SESSION['id'];
			$data['product_list'] = $this->cart_model->product_cart($id);
			$data['customer_address'] = $this->customer_model->address_customer($id, false, true);
			if (count($data['product_list']) > 0) {
				$data['load_page'] = 'client/cart/cart_login_view';
				if (isset($_POST) && $_POST) {
					echo_pre($_POST);
					die();
				}
			}else{
				$data['load_page'] = 'client/cart/cart_empty_view';
			}
		}else{
			$data['load_page'] = 'client/cart/cart_view';
		}
		$this->load->view('layouts/fe_master_view', $data);
	}

	public function ajax_list() {
		$params['product_id'] = $this->input->post('product_id');
		$params['quantity'] = $this->input->post('quantity');
		$params['customer_id'] = $this->input->post('customer_id');
		$params['is_delete'] = $this->input->post('is_delete');
		$update_product = $this->cart_model->update_product($params);
//		if(isset($update_product) && $update_product) {
//			$data['product_list'] = $this->cart_model->product_cart($params['customer_id']);
//			$this->load->view('client/cart/ajax_cart_view', $data);
//		}
	}

	public function delete() {
		if(isset($_GET) && $_GET) {
			$params['customer_id'] = $_GET['cus_id'];
			$params['product_id'] = $_GET['pd_id'];
			$delete = $this->cart_model->delete_cart($params);
			if (isset($delete) && $delete) {
				redirect('client/cart/detail');
			}
		}
	}
}
