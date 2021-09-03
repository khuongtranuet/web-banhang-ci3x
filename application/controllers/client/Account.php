<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'client/account_model',
			'admin/customer_model',
		));
	}

	public function register() {
		$this->form_validation->set_rules('fullname', 'Họ và tên', 'required',
			array('required' => '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>')
		);
		$this->form_validation->set_rules('mobile', 'Số điện thoại', 'required|is_unique[customers.mobile]',
			array('required' => '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>',
				'is_unique'	=> '<h5 style="color: red; height: 0px;">Số điện thoại đã tồn tại!</h5>')
		);
		$this->form_validation->set_rules('email', 'Email', 'required|is_unique[customers.email]',
			array('required' => '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>',
				'is_unique'	=> '<h5 style="color: red; height: 0px;">Email đã tồn tại!</h5>')
		);
		$this->form_validation->set_rules('password', 'Mật khẩu', 'required|min_length[6]',
			array('required' => '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>',
				'min_length' => '<h5 style="color: red; height: 0px;">Mật khẩu phải có độ dài từ 6 kí tự!</h5>')
		);
		$this->form_validation->set_rules('confirm_password', 'Xác nhận mật khẩu', 'required|matches[password]',
			array('required' => '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>',
				'matches' => '<h5 style="color: red; height: 0px;">Mật khẩu chưa khớp!</h5>')
		);
		if ($this->form_validation->run() == FALSE) {
			$data['title_page'] = 'Đăng ký';
			$data['load_page'] = 'client/home/register_view';
			$this->load->view('layouts/fe_master_view', $data);
		}else{
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
				$customer = array();
				foreach ($_POST as $key => $value) {
					$customer[$key] = htmlspecialchars($value);
				}
				$data['insert_customer'] = $this->customer_model->insert_customer($customer);
				if (isset($data['insert_customer']) && $data['insert_customer']) {
					$this->session->set_flashdata('success', 'Đăng ký tài khoản thành công!');
					redirect('client/account/register');
				}
				$data['title_page'] = 'Đăng ký';
				$data['load_page'] = 'client/home/register_view';
				$this->load->view('layouts/fe_master_view', $data);
			}
		}
	}

	public function logout() {
		$logout = $this->uri->segment('3');
		if (isset($logout) && $logout == 'logout') {
			session_destroy();
			redirect('client/home/index');
		}
	}

	public function edit() {
		$data['title_page'] = 'Thông tin tài khoản người dùng';
		$data['load_page'] = 'client/account/edit_view';
		$this->load->view('layouts/fe_master_view', $data);
	}

	public function address() {
		$data['title_page'] = 'Thông tin địa chỉ người dùng';
		$data['load_page'] = 'client/account/address_view';
		$this->load->view('layouts/fe_master_view', $data);
	}
}
