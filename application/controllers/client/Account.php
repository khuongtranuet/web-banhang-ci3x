<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'client/account_model',
			'client/payment_model',
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
		if (isset($_SESSION['id']) && $_SESSION['id']) {
			if ($_SERVER['REQUEST_METHOD'] = 'POST' && $_POST) {
				$data['title_page'] = 'Thông tin địa chỉ người dùng';
				$data['load_page'] = 'client/account/address_view';
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
						redirect('client/account/address');
					}
				} else {
					$data['insert_address'] = $this->payment_model->insert_address($address);
					if (isset($data['insert_address']) && $data['insert_address']) {
						$this->session->set_flashdata('success', 'Thêm mới địa chỉ thành công!');
						redirect('client/account/address');
					}
				}
				$this->load->view('layouts/fe_master_view', $data);
			} else {
				$data['title_page'] = 'Thông tin địa chỉ người dùng';
				$data['load_page'] = 'client/account/address_view';
				$data['address_customer'] = $this->customer_model->address_customer($_SESSION['id'], false);
				$data['province'] = $this->customer_model->select('*', 'provinces');
				if (count($data['address_customer']) == 0) {
					$this->session->set_flashdata('error', 'Người dùng không tồn tại!');
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
				redirect('client/account/address');
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
			$this->load->view('client/account/ajax_address_view', $data);
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
			redirect('client/account/address');
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
					redirect('client/account/address');
				}
			}
		} else {
			$this->session->set_flashdata('error', 'Địa chỉ không tồn tại!');
			redirect('client/account/address');
		}
	}
}
