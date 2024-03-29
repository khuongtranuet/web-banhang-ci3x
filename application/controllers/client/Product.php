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
			$data['province'] = $this->product_model->select(' *', TBL_PROVINCES);
			$data['product_review'] = $this->product_model->product_review($id);
			$total_stars = 0;
			for ($i = 0; $i < count($data['product_review']); $i++) {
				$total_stars += $data['product_review'][$i]['stars'];
			}
			if (count($data['product_review']) > 0) {
				$data['sub_stars'] = round(($total_stars / count($data['product_review'])), 1);
			}
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
				if (isset($_SESSION['id'])) {
					$params['customer_id'] = $_SESSION['id'];
					$params['product_id'] = $this->input->post('product_id');
					if (isset($_SESSION['cart'])) {
						$key = array_search($params['product_id'], $_SESSION['cart']);
						if ($key == '') {
							array_push($_SESSION['cart'], $params['product_id']);
						}
					}
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
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['review'])) {
				echo_pre($_POST);
				die();
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

	public function pd_list($id = null) {
		if (!isset($id) || $id == NULL) {
			redirect('client/home/index');
		}else{
			$data['id'] = $id;
		}
		$data['title_page'] = 'Danh sách sản phẩm';
		$data['load_page'] = 'client/product/product_list_view';
		if (is_numeric($id)) {
			$data['cate'] = $this->product_model->select(' *', TBL_CATEGORIES, ' WHERE id = '.$id);
			if (count($data['cate']) == 0) {
				$this->session->set_flashdata('error', 'Danh mục sản phẩm không tồn tại!');
				redirect('client/home/index');
			}
			$data['cate'] = $data['cate'][0];
			$data['brand'] = $this->product_model->select(' *', TBL_BRANDS, ' WHERE id IN (SELECT brand_id FROM ' . TBL_PRODUCTS . ' WHERE category_id = '.$id.')');
		}else{
			$this->session->set_flashdata('error', 'Danh mục sản phẩm không tồn tại!');
			redirect('client/home/index');
		}
		$this->load->view('layouts/fe_master_view', $data);
	}

	public function ajax_list() {
		$params['keyword'] = $this->input->post('keyword');
		$params['brand'] = $this->input->post('brand');
		$params['sort'] = $this->input->post('sort');
		$params['cate_id'] = $this->input->post('cate_id');
		$params['price'] = $this->input->post('price');
		$params['price_laptop'] = $this->input->post('price_laptop');
		$params['price_accessory'] = $this->input->post('price_accessory');
		$params['ram'] = $this->input->post('ram');
		$params['rom'] = $this->input->post('rom');
		$params['screen'] = $this->input->post('screen');
		$params['cpu'] = $this->input->post('cpu');
		$params['card'] = $this->input->post('card');
		$params['hard_drive'] = $this->input->post('hard_drive');
		$params['screen_resolution'] = $this->input->post('screen_resolution');
		$params['frequency'] = $this->input->post('frequency');
		$params['page_index'] = $this->input->post('page_index');
		$params['page_size'] = 10;
		if ($params['page_index'] < 1) { $params['page_index'] = 1; }
		$data['from'] = $params['from'] = ($params['page_index'] - 1)* $params['page_size'];
		$data['total_record'] = $total_record = $this->product_model->product_list($params, true);
		$data['result_product'] = $this->product_model->product_list($params, false);
		$data['cate'] = $this->product_model->select(' *', TBL_CATEGORIES, ' WHERE id = '.$params['cate_id']);
		$data['cate'] = $data['cate'][0];
		$data['pagination_link'] = paginate_ajax2($total_record, $params['page_index'], $params['page_size']);
		$this->load->view('client/product/ajax_list_view', $data);
	}

	public function ajax_stock_store() {
		$params['product_id'] = $this->input->post('product_id');
		$params['province'] = $this->input->post('province');
		$params['district'] = $this->input->post('district');
		$data['stock_store'] = $this->product_model->stock_store($params);
		$this->load->view('client/product/ajax_stock_store', $data);
	}
}
