<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'client/home_model',
			'client/product_model',
		));
	}

	/**
	 * Trang chủ quản trị
	 * URL: /admin/home/index
	 */
	public function index() {
		$data['title_page'] = 'Trang chủ';
		$data['load_page'] = 'client/home/index_view';
		$data['product_list'] = $this->home_model->product_list('1');
		$data['laptop_list'] = $this->home_model->product_list('2');
		$this->load->view('layouts/fe_master_view', $data);
	}

	public function login() {
		$this->form_validation->set_rules('mobile', 'Tên đăng nhập', 'required',
			array('required' => '<h5 style="color: red; height: 0px;">Chưa nhập thông tin đăng nhập!</h5>')
		);
		$this->form_validation->set_rules('password', 'Mật khẩu', 'required',
			array('required' => '<h5 style="color: red; height: 0px;">Chưa nhập mật khẩu đăng nhập!</h5>')
		);
		if ($this->form_validation->run() == FALSE) {
			$data['title_page'] = 'Đăng nhập';
			$data['load_page'] = 'client/home/login_view';
			$this->load->view('layouts/fe_master_view', $data);
		}else{
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
				if (isset($_POST['remember'])) {
					setcookie("mobile", $_POST['mobile']);
					setcookie("password", $_POST['password']);
				}
				if (!isset($_POST['remember']) && isset($_COOKIE['mobile']) && isset($_COOKIE['password'])) {
					setcookie("mobile", '');
					setcookie("password", '');
				}
				$result = $this->home_model->select(' *', ' customers', ' WHERE (email = "'.$_POST['mobile'].'" OR mobile = "'.$_POST['mobile'].'")');
				if(count($result) > 0) {
					$result = $result[0];
				}
				if(count($result) > 0 && $_POST['password'] == $result['password']) {
					$_SESSION['login'] = true;
					$_SESSION['id'] =  $result['id'];
					$_SESSION['email'] = $result['email'];
					$_SESSION['fullname'] = $result['fullname'];
					$_SESSION['avatar'] = $result['avatar'];
					$_SESSION['cart'] = array();
					$_SESSION['cart'][0] = 'a';
					$product_cart = $this->home_model->select(' *', TBL_CUSTOMER_PRODUCT, ' WHERE customer_id = '.$result['id']);
					foreach ($product_cart as $result_cart) {
						array_push($_SESSION['cart'], $result_cart['product_id']);
					}
					$this->session->set_flashdata('success', 'Chào mừng '.$result['fullname'].' đã trở lại, mua sắm vui vẻ cùng thế giới công nghệ nhé!');
					redirect('client/home/index');
				}else{
					$this->session->set_flashdata('error', 'Thông tin đăng nhập chưa chính xác!');
				}
				$data['title_page'] = 'Đăng nhập';
				$data['load_page'] = 'client/home/login_view';
				$this->load->view('layouts/fe_master_view', $data);
			}
		}
	}

	public function ajax_search() {
		$params['keyword'] = $this->input->post('keyword');
		$params['page_size'] = 5;
		$params['from'] = 0;
		$params['search'] = true;
		$data['result_search'] = $this->product_model->product_list($params, false);
		$this->load->view('client/home/ajax_search', $data);
	}
}
