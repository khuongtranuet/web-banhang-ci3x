<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'client/cart_model',
			'client/product_model',
			'admin/customer_model',
		));
	}

	public function detail() {
		$data['title_page'] = 'Giỏ hàng';
		if (isset($_SESSION['login'])) {
			$id = $_SESSION['id'];
			$data['product_list'] = $this->cart_model->product_cart($id, true);
			$data['customer_address'] = $this->customer_model->address_customer($id, false, true);
			if (count($data['product_list']) > 0) {
				$data['load_page'] = 'client/cart/cart_login_view';
			}else{
				$data['load_page'] = 'client/cart/cart_empty_view';
			}
		}else{
//			$a = array(1,2,3,4,5,6,7,8);
//			$_SESSION['product'] = $a;
//			echo_pre($_SESSION['product']);
//			array_push($_SESSION['product'], 6);
//			echo_pre($_SESSION['product']);
//			$key = array_search (5, $_SESSION['product']);
//			unset($_SESSION['product'][$key]);
//			echo_pre($_SESSION['product']);
//			die();
			if (isset($_SESSION['product_id']) && $_SESSION['product_id']) {
				if (count($_SESSION['product_id']) > 0) {
					$data['load_page'] = 'client/cart/cart_view';
					$data['province'] = $this->customer_model->select('*', 'provinces');
					$product_id = $_SESSION['product_id'];
					$quantity = $_SESSION['quantity'];
//					$data['quantity'] = $_SESSION['quantity'];
					$data['product_list'] = array();
					$data['quantity'] = array();
					$params['product_cart'] = true;
					$i = 0;
					foreach ($product_id as $key => $value) {
						$product = $this->product_model->detail_product($product_id[$key], $params);
						$data['product_list'][$i] = $product[0];
						$data['quantity'][$i] = $quantity[$key];
						$i++;
					}
					if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
						$customer = array();
						foreach ($_POST as $key => $value) {
							$customer[$key] = htmlspecialchars($value);
						}
						$customer['type'] = '0';
						$customer['type_address'] = '0';
						$customer['status_address'] = 1;
						$insert_customer = $this->customer_model->insert_customer($customer, true);
						if (isset($insert_customer) && $insert_customer) {
							redirect('client/payment/checkout');
						}
					}
				}else{
					$data['load_page'] = 'client/cart/cart_empty_view';
				}
			}else{
				$data['load_page'] = 'client/cart/cart_empty_view';
			}
		}
		$this->load->view('layouts/fe_master_view', $data);
	}

	public function ajax_list() {
		if (isset($_SESSION['login'])) {
			$params['product_id'] = $this->input->post('product_id');
			$params['quantity'] = $this->input->post('quantity');
			$params['customer_id'] = $this->input->post('customer_id');
			$params['is_delete'] = $this->input->post('is_delete');
			$address_customer = $this->customer_model->address_customer($params['customer_id'], false, true);
			$params['address_id'] = $address_customer[0]['address_id'];
			$update_product = $this->cart_model->update_product($params);
		}else{
			$params['product_id'] = $this->input->post('product_id');
			$params['quantity'] = $this->input->post('quantity');
			if ($params['product_id'] != '' && $params['quantity'] != '' && $params['quantity'] > 0) {
				$key = array_search ($params['product_id'], $_SESSION['product_id']);
				$_SESSION['quantity'][$key] = $params['quantity'];
			}else{
				$key = array_search ($params['product_id'], $_SESSION['product_id']);
				unset($_SESSION['product_id'][$key]);
				unset($_SESSION['quantity'][$key]);
				$this->session->set_flashdata('success', 'Xóa sản phẩm thành công!');
			}
		}
	}

	public function ajax_total_cart() {
		$params['product_id'] = $this->input->post('product_id');
		$params['quantity'] = $this->input->post('quantity');
		$data['total'] = 0;
		if ($params['product_id'] != '') {
			for ($i = 0; $i < count($params['product_id']); $i++) {
				$product = $this->cart_model->select(' *', TBL_PRODUCTS, 'WHERE id =' . $params['product_id'][$i]);
				$data['total'] += $product[0]['price'] * $params['quantity'][$i];
			}
		}else{
			$data['total'] = 0;
		}
		$this->load->view('client/cart/ajax_total_view', $data);
	}

	public function delete() {
		if (isset($_SESSION['login'])) {
			if(isset($_GET) && $_GET) {
				$params['customer_id'] = $_GET['cus_id'];
				$params['product_id'] = $_GET['pd_id'];
				$delete = $this->cart_model->delete_cart($params);
				if (isset($delete) && $delete) {
					redirect('client/cart/detail');
				}
			}
		}else{
			if(isset($_GET) && $_GET) {
				$params['product_id'] = $_GET['product_id'];
				$key = array_search ($params['product_id'], $_SESSION['product_id']);
				if ($key > -1) {
					unset($_SESSION['product_id'][$key]);
					unset($_SESSION['quantity'][$key]);
					$this->session->set_flashdata('success', 'Xóa sản phẩm thành công!');
					redirect('client/cart/detail');
				}
			}
		}
	}
}
