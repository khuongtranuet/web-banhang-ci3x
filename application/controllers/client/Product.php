<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'client/product_model',
			'client/cart_model',
			'admin/customer_model',
		));
	}

	public function detail($id = null) {
		if (!isset($id) || $id == NULL) {
			redirect('client/home/index');
		} else {
			$data['id'] = $id;
		}
		if (is_numeric($id)) {
			$data['title_page'] = 'Sản phẩm';
			$data['load_page'] = 'client/product/detail_product_view';
			$data['detail_product'] = $this->product_model->detail_product($id);
			$data['attribute_product'] = $this->product_model->select(' *', TBL_PRODUCT_ATTRIBUTE, 'JOIN '.TBL_ATTRIBUTES.'
			 ON '.TBL_ATTRIBUTES.'.id = '.TBL_PRODUCT_ATTRIBUTE.'.attribute_id WHERE product_id = '.$id);
			$data['product_image'] = $this->product_model->select(' *', TBL_PRODUCT_IMAGES, ' WHERE product_id ='.$id.' AND type = 0');
			$data['child_product'] = $this->product_model->product_child($id);
			$data['product_connect'] = $this->product_model->ramdom_product_connect($id);
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
				if (isset($_SESSION['id'])) {
					$params['customer_id'] = $_SESSION['id'];
					$params['product_id'] = $this->input->post('product_id');
					$params['quantity'] = $this->input->post('quantity');
					$insert = $this->cart_model->insert_cart($params);
					if (isset($insert) && $insert) {
						$this->session->set_flashdata('success', 'Thêm sản phẩm vào giỏ hàng thành công!');
					}
				}else{
					$params['product_id'] = $this->input->post('product_id');
					$params['quantity'] = $this->input->post('quantity');
					if (isset($_SESSION['product_id']) && isset($_SESSION['quantity'])) {
						$key = array_search($params['product_id'], $_SESSION['product_id']);
						if ($key > -1) {
							$_SESSION['quantity'][$key] += $params['quantity'];
						}else{
							array_push($_SESSION['product_id'], $params['product_id']);
							array_push($_SESSION['quantity'], $params['quantity']);
						}
						$this->session->set_flashdata('success', 'Thêm sản phẩm vào giỏ hàng thành công!');
					}else{
						$_SESSION['product_id'] = array();
						$_SESSION['quantity'] = array();
						array_push($_SESSION['product_id'], $params['product_id']);
						array_push($_SESSION['quantity'], $params['quantity']);
						$this->session->set_flashdata('success', 'Thêm sản phẩm vào giỏ hàng thành công!');
					}
				}
			}
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['buy'])) {
				if (isset($_SESSION['id'])) {
					$params['customer_id'] = $_SESSION['id'];
					$params['product_id'] = $this->input->post('product_id');
					$params['quantity'] = $this->input->post('quantity');
					$address_customer = $this->customer_model->address_customer($params['customer_id'], false, true);
					$params['address_id'] = $address_customer[0]['address_id'];
					$insert = $this->cart_model->insert_cart($params);
					if (isset($insert) && $insert) {
						redirect('client/payment/checkout');
					}
				}else{
					$params['product_id'] = $this->input->post('product_id');
					$params['quantity'] = $this->input->post('quantity');
					if (isset($_SESSION['product_id']) && isset($_SESSION['quantity'])) {
						$key = array_search($params['product_id'], $_SESSION['product_id']);
						if ($key > -1) {
							$_SESSION['quantity'][$key] += $params['quantity'];
						}else{
							array_push($_SESSION['product_id'], $params['product_id']);
							array_push($_SESSION['quantity'], $params['quantity']);
						}
						$this->session->set_flashdata('success', 'Thêm sản phẩm vào giỏ hàng thành công!');
						redirect('client/cart/detail');
					}else{
						$_SESSION['product_id'] = array();
						$_SESSION['quantity'] = array();
						array_push($_SESSION['product_id'], $params['product_id']);
						array_push($_SESSION['quantity'], $params['quantity']);
						$this->session->set_flashdata('success', 'Thêm sản phẩm vào giỏ hàng thành công!');
						redirect('client/cart/detail');
					}
				}
			}
		}else{
			$this->session->set_flashdata('error', 'Sản phẩm không tồn tại!');
			redirect('client/home/index');
		}
		$this->load->view('layouts/fe_master_view', $data);
	}

	public function ajax_carousel() {
		$params['product_id'] = $this->input->post('product_id');
		$data['image_main'] = $this->product_model->select(' *', TBL_PRODUCT_IMAGES, ' WHERE product_id = '.$params['product_id'].' AND type = 1');
		$data['list_images'] = $this->product_model->select(' *', TBL_PRODUCT_IMAGES, ' WHERE product_id = '.$params['product_id'].' AND type = 0');
		$this->load->view('client/product/ajax_carousel_view', $data);
	}
}
