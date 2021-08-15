<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'admin/customer_model'
		));
	}

	/**
	 * Danh sách khách hàng
	 * URL: /admin/customer/index
	 */
	public function index() {
		$data['title_page'] = 'Ql Khách hàng';
		$data['load_page'] = 'admin/customer/list_view';
		$this->load->view('layouts/be_master_view', $data);
	}

	/**
	 * Hàm lấy dữ liệu phân trang theo ajax
	 * URL: /admin/customer/ajax_list
	 */
	public function ajax_list() {
		$params['keyword'] = $this->input->post('keyword');
		$params['type'] = $this->input->post('type');
		$params['status'] = $this->input->post('status');
		$params['page_index'] = $this->input->post('page_index');
		$params['page_size'] = 10;

		if ($params['page_index'] < 1) { $params['page_index'] = 1; }
		$data['from'] = $params['from'] = ($params['page_index'] - 1)* $params['page_size'];
		$total_record = $this->customer_model->customer_list($params, true);

		$data['result_customer'] = $this->customer_model->customer_list($params, false);
		$data['pagination_link'] = paginate_ajax($total_record, $params['page_index'], $params['page_size']);
		$this->load->view('admin/customer/ajax_list_view', $data);
	}

	/**
	 * Chi tiết thông tin khách hàng
	 * URL: /admin/customer/detail/(id khách hàng)
	 */
	public function detail($id = null) {
		if (!isset($id) || $id == NULL) {
			redirect('admin/customer/index');
		}else{
			$data['id'] = $id;
		}
		$data['title'] = 'Thông tin người dùng';
		$data['load_page'] = 'admin/customer/detail_view';
		if (is_numeric($id)) {
			$data['customer'] = $this->customer_model->address_customer($id, true);
			$data['address'] = $this->customer_model->address_customer($id, false);
			if (count($data['customer']) == 0) {
				$this->session->set_flashdata('error', 'Người dùng không tồn tại!');
				redirect('admin/customer/index');
			}
		}else{
			$this->session->set_flashdata('error', 'Người dùng không tồn tại!');
			redirect('admin/customer/index');
		}
		$this->load->view('layouts/be_master_view', $data);
	}

	/**
	 * Thêm mới khách hàng
	 * URL: /admin/customer/add
	 */
	public function add() {
		$this->form_validation->set_rules('fullname', 'Tên người dùng', 'required',
			array('required' => '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>')
		);
		$this->form_validation->set_rules(
			'mobile', 'Số điện thoại',
			'required|is_unique[customers.mobile]',
			array(
				'required'	=> '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>',
				'is_unique'	=> '<h5 style="color: red; height: 0px;">Số điện thoại đã tồn tại!</h5>'
			)
		);
		$this->form_validation->set_rules(
			'email', 'Địa chỉ email',
			'required|is_unique[customers.email]',
			array(
				'required'	=> '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>',
				'is_unique'	=> '<h5 style="color: red; height: 0px;">Email đã tồn tại!</h5>'
			)
		);
		$this->form_validation->set_rules('gender', 'Giới tính', 'greater_than[-1]',
			array('greater_than' => '<h5 style="color: red; height: 0px;">Vui lòng chọn trường này!</h5>'));
		$this->form_validation->set_rules('password', 'Mật khẩu', 'required',
			array('required' => '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>'));
		$this->form_validation->set_rules('status', 'Trạng thái', 'greater_than[-1]',
			array('greater_than' => '<h5 style="color: red; height: 0px;">Vui lòng chọn trường này!</h5>'));
		$this->form_validation->set_rules('province', 'Tỉnh/Thành phố', 'greater_than[-1]',
			array('greater_than' => '<h5 style="color: red; height: 0px;">Vui lòng chọn trường này!</h5>'));
		$this->form_validation->set_rules('district', 'Quận/Huyện', 'greater_than[-1]',
			array('greater_than' => '<h5 style="color: red; height: 0px;">Vui lòng chọn Tỉnh/Thành phố!</h5>'));
		$this->form_validation->set_rules('ward', 'Xã/Phường/Thị trấn', 'greater_than[-1]',
			array('greater_than' => '<h5 style="color: red; height: 0px;">Vui lòng chọn Quận/Huyện!</h5>'));
		$this->form_validation->set_rules('address', 'Địa chỉ', 'required',
			array('required' => '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>'));
		$this->form_validation->set_rules('type_address', 'Loại địa chỉ', 'required',
			array('required' => '<h5 style="color: red; height: 0px;">Vui lòng chọn trường này!</h5>'));
		$this->form_validation->set_rules('status_address', 'Cài đặt địa chỉ', 'required',
			array('required' => '<h5 style="color: red; height: 0px;">Vui lòng chọn trường này!</h5>'));
		if ($this->form_validation->run() == FALSE) {
			$data['title'] = 'Thêm mới người dùng';
			$data['load_page'] = 'admin/customer/add_view';
			$data['province'] = $this->customer_model->select('*', 'provinces');
			$this->load->view('layouts/be_master_view', $data);
		}else{
			$data['title'] = 'Thêm mới người dùng';
			$data['load_page'] = 'admin/customer/add_view';
			$data['province'] = $this->customer_model->select('*', 'provinces');

			$customer = array();
			foreach ($_POST as $key => $value) {
				$customer[$key] = htmlspecialchars($value);
			}
			$data['insert_customer'] = $this->customer_model->insert_customer($customer);
			if (isset($data['insert_customer']) && $data['insert_customer']) {
				$this->session->set_flashdata('success', 'Thêm khách hàng mới thành công!');
				redirect('admin/customer/index');
			}
			$this->load->view('layouts/be_master_view', $data);
		}
	}

	/**
	 * Chỉnh sửa khách hàng
	 * URL: /admin/customer/edit/(id khách hàng)
	 */
	public function edit($id = null) {
		if (!isset($id) || $id == NULL) {
			redirect('admin/customer/index');
		}else{
			$data['id'] = $id;
			$this->session->set_flashdata('id', $id);
		}
		$this->form_validation->set_rules('fullname', 'Tên người dùng', 'required',
			array('required' => '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>')
		);
		$this->form_validation->set_rules(
			'mobile', 'Số điện thoại',
			'required|callback_mobile_check',
			array(
				'required'	=> '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>'
			)
		);
		$this->form_validation->set_rules(
			'email', 'Địa chỉ email',
			'required|callback_email_check',
			array(
				'required'	=> '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>'
			)
		);
		$this->form_validation->set_rules('gender', 'Giới tính', 'greater_than[-1]',
			array('greater_than' => '<h5 style="color: red; height: 0px;">Vui lòng chọn trường này!</h5>'));
		$this->form_validation->set_rules('password', 'Mật khẩu', 'required',
			array('required' => '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>'));
		$this->form_validation->set_rules('status', 'Trạng thái', 'greater_than[-1]',
			array('greater_than' => '<h5 style="color: red; height: 0px;">Vui lòng chọn trường này!</h5>'));
		$this->form_validation->set_rules('province', 'Tỉnh/Thành phố', 'greater_than[-1]',
			array('greater_than' => '<h5 style="color: red; height: 0px;">Vui lòng chọn trường này!</h5>'));
		$this->form_validation->set_rules('district', 'Quận/Huyện', 'greater_than[-1]',
			array('greater_than' => '<h5 style="color: red; height: 0px;">Vui lòng chọn Tỉnh/Thành phố!</h5>'));
		$this->form_validation->set_rules('ward', 'Xã/Phường/Thị trấn', 'greater_than[-1]',
			array('greater_than' => '<h5 style="color: red; height: 0px;">Vui lòng chọn Quận/Huyện!</h5>'));
		$this->form_validation->set_rules('address', 'Địa chỉ', 'required',
			array('required' => '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>'));
		$this->form_validation->set_rules('type_address', 'Loại địa chỉ', 'required',
			array('required' => '<h5 style="color: red; height: 0px;">Vui lòng chọn trường này!</h5>'));
		$this->form_validation->set_rules('status_address', 'Cài đặt địa chỉ', 'required',
			array('required' => '<h5 style="color: red; height: 0px;">Vui lòng chọn trường này!</h5>'));

		if ($this->form_validation->run() == FALSE) {
			$data['title'] = 'Chỉnh sửa người dùng';
			$data['load_page'] = 'admin/customer/edit_view';
			if (is_numeric($id)) {
				$data['province'] = $this->customer_model->select('*', 'provinces');
				$data['customer'] = $this->customer_model->address_customer($id, true, true);
				if (count($data['customer']) == 0) {
					$this->session->set_flashdata('error', 'Người dùng không tồn tại!');
					redirect('admin/customer/index');
				}
				$province_id = $data['customer'][0]['province_id'];
				$district_id = $data['customer'][0]['district_id'];
				$data['district'] = $this->customer_model->select('*', 'districts', 'WHERE province_id = '.$province_id.'');
				$data['ward'] = $this->customer_model->select('*', 'wards', 'WHERE district_id = '.$district_id.' AND province_id = '.$province_id.'');
			}else{
				$this->session->set_flashdata('error', 'Người dùng không tồn tại!');
				redirect('admin/customer/index');
			}
			$this->load->view('layouts/be_master_view', $data);
		}else{
			$data['title'] = 'Chỉnh sửa người dùng';
			$data['load_page'] = 'admin/customer/edit_view';
			if (is_numeric($id)) {
				$data['province'] = $this->customer_model->select('*', 'provinces');
				$data['customer'] = $this->customer_model->address_customer($id, true, true);
				if (count($data['customer']) == 0) {
					$this->session->set_flashdata('error', 'Người dùng không tồn tại!');
					redirect('admin/customer/index');
				}
				$province_id = $data['customer'][0]['province_id'];
				$district_id = $data['customer'][0]['district_id'];
				$data['district'] = $this->customer_model->select('*', 'districts', 'WHERE province_id = '.$province_id.'');
				$data['ward'] = $this->customer_model->select('*', 'wards', 'WHERE district_id = '.$district_id.' AND province_id = '.$province_id.'');
				if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
					$customer = array();
					foreach ($_POST as $key => $value) {
						$customer[$key] = htmlspecialchars($value);
					}
					$data['update_customer'] = $this->customer_model->update_customer($customer, $id);
					if (isset($data['update_customer']) && $data['update_customer']) {
						$this->session->set_flashdata('success', 'Chỉnh sửa thông tin khách hàng thành công!');
						redirect('admin/customer/index');
					}
				}
			}else{
				$this->session->set_flashdata('error', 'Người dùng không tồn tại!');
				redirect('admin/customer/index');
			}
			$this->load->view('layouts/be_master_view', $data);
		}
	}

	/**
	 * Hàm callback rule check số điện thoại tồn tại
	 */
	public function mobile_check($mobile) {
		$id = $this->session->flashdata('id');
		$customer = $this->customer_model->select('*', 'customers', 'WHERE id = '.$id.'');
		if (isset($customer) && count($customer) > 0) {
			if ($customer[0]['mobile'] == $mobile) {
				return TRUE;
			}
		}
		$check = $this->customer_model->select('*', 'customers', "WHERE mobile = '".$mobile."'");
		if(isset($check) && count($check) > 0) {
			$this->form_validation->set_message('mobile_check', '<h5 style="color: red; height: 0px;">Số điện thoại đã tồn tại!</h5>');
			return FALSE;
		}else{
			return TRUE;
		}
	}

	/**
	 * Hàm callback rule check email tồn tại
	 */
	public function email_check($email) {
		$id = $this->session->flashdata('id');
		$customer = $this->customer_model->select('*', 'customers', 'WHERE id = '.$id.'');
		if (isset($customer) && count($customer) > 0) {
			if ($customer[0]['email'] == $email) {
				return TRUE;
			}
		}
		$check = $this->customer_model->select('*', 'customers', "WHERE email = '".$email."'");
		if(isset($check) && count($check) > 0) {
			$this->form_validation->set_message('email_check', '<h5 style="color: red; height: 0px;">Email đã tồn tại!</h5>');
			return FALSE;
		}else{
			return TRUE;
		}
	}

	/**
	 * Xóa khách hàng
	 * URL: /admin/customer/delete/(id khách hàng)
	 */
	public function delete($id = null) {
		if (!isset($id) || $id == NULL) {
			redirect('admin/customer/index');
		}else{
			$data['id'] = $id;
		}
		if (is_numeric($id)) {
			$customer = $this->customer_model->address_customer($id, true, true);
			if (count($customer) == 0) {
				$this->session->set_flashdata('error', 'Người dùng không tồn tại!');
				redirect('admin/customer/index');
			}
			$delete = $this->customer_model->delete_customer($id);
			if (isset($delete) && $delete) {
				$this->session->set_flashdata('success', 'Xóa khách hàng thành công!');
				redirect('admin/customer/index');
			}
		}else {
			$this->session->set_flashdata('error', 'Người dùng không tồn tại!');
			redirect('admin/customer/index');
		}
	}
}
