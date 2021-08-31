<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Voucher extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'admin/voucher_model'
		));
	}

	/**
	 * Danh sách mã giảm giá
	 * URL: /admin/voucher/index
	 */
	public function index()
	{
		$data['title_page'] = 'Ql mã giảm giá';
		$data['load_page'] = 'admin/voucher/list_view';
		$this->load->view('layouts/be_master_view', $data);
	}

	/**
	 * Hàm lấy dữ liệu phân trang theo ajax
	 * URL: /admin/voucher/ajax_list
	 */
	public function ajax_list()
	{
		$params['keyword'] = $this->input->post('keyword');
		$params['type'] = $this->input->post('type');
		$params['discount_type'] = $this->input->post('discount_type');
		$params['page_index'] = $this->input->post('page_index');
		$params['page_size'] = 10;
		if ($params['page_index'] < 1) {
			$params['page_index'] = 1;
		}
		$data['from'] = $params['from'] = ($params['page_index'] - 1) * $params['page_size'];
		$total_record = $this->voucher_model->voucher_list($params, true);
		$data['result_voucher'] = $this->voucher_model->voucher_list($params, false);
		$data['pagination_link'] = paginate_ajax($total_record, $params['page_index'], $params['page_size']);
		$this->load->view('admin/voucher/ajax_list_view', $data);
	}

	/**
	 * Thêm mới mã giảm giá
	 * URL: /admin/voucher/add
	 */
	public function add()
	{
		$this->form_validation->set_rules('name', 'Tiêu đề mã giảm giá', 'required',
			array('required' => '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>')
		);
		$this->form_validation->set_rules(
			'code', 'Mã giảm giá',
			'required|is_unique[' . TBL_VOUCHERS . '.code]',
			array(
				'required' => '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>',
				'is_unique' => '<h5 style="color: red; height: 0px;">Mã giảm giá đã tồn tại!</h5>'
			)
		);
		$this->form_validation->set_rules('discount', 'Giá trị giảm giá', 'required',
			array('required' => '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>'));
		$this->form_validation->set_rules('discount_type', 'Loại giảm giá', 'required',
			array('required' => '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>'));
		$this->form_validation->set_rules('condition', 'Điều kiện giảm giá', 'required',
			array('required' => '<h5 style="color: red; height: 0px;">Vui lòng chọn trường này!</h5>'));
		$this->form_validation->set_rules('effective_date', 'Thời gian bắt đầu', 'required',
			array('required' => '<h5 style="color: red; height: 0px;">Vui lòng chọn trường này!</h5>'));
		$this->form_validation->set_rules('expiration_date', 'Thời gian bắt đầu', 'required',
			array('required' => '<h5 style="color: red; height: 0px;">Vui lòng chọn trường này!</h5>'));
		$this->form_validation->set_rules('type', 'Loại mã', 'greater_than[-1]',
			array('greater_than' => '<h5 style="color: red; height: 0px;">Vui lòng chọn trường này!</h5>'));
		if ($this->form_validation->run() == FALSE) {
			$data['title'] = 'Thêm mới mã giảm giá';
			$data['load_page'] = 'admin/voucher/add_view';
			$this->load->view('layouts/be_master_view', $data);
		} else {
			$data['title'] = 'Thêm mới mã giảm giá';
			$data['load_page'] = 'admin/voucher/add_view';

			$voucher = array();
			foreach ($_POST as $key => $value) {
				$voucher[$key] = htmlspecialchars($value);
			}
			$data['insert_$voucher'] = $this->voucher_model->insert_voucher($voucher);
			if (isset($data['insert_$voucher']) && $data['insert_$voucher']) {
				$this->session->set_flashdata('success', 'Thêm mã giảm giá mới thành công!');
				redirect('admin/voucher/index');
			}
			$this->load->view('layouts/be_master_view', $data);
		}
	}

	/**
	 * Chỉnh sửa mã giảm giá
	 * URL: /admin/voucher/edit/(id mã giảm giá)
	 */
	public function edit($id = null)
	{
		if (!isset($id) || $id == NULL) {
			redirect('admin/voucher/index');
		} else {
			$data['id'] = $id;
			$this->session->set_flashdata('id', $id);
		}
		$this->form_validation->set_rules('name', 'Tiêu đề mã giảm giá', 'required',
			array('required' => '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>')
		);
		$this->form_validation->set_rules(
			'code', 'Mã giảm giá',
			'required|callback_code_check',
			array(
				'required' => '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>',
			)
		);
		$this->form_validation->set_rules('discount', 'Giá trị giảm giá', 'required',
			array('required' => '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>'));
		$this->form_validation->set_rules('discount_type', 'Loại giảm giá', 'required',
			array('required' => '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>'));
		$this->form_validation->set_rules('condition', 'Điều kiện giảm giá', 'required',
			array('required' => '<h5 style="color: red; height: 0px;">Vui lòng chọn trường này!</h5>'));
		$this->form_validation->set_rules('effective_date', 'Thời gian bắt đầu', 'required',
			array('required' => '<h5 style="color: red; height: 0px;">Vui lòng chọn trường này!</h5>'));
		$this->form_validation->set_rules('expiration_date', 'Thời gian bắt đầu', 'required',
			array('required' => '<h5 style="color: red; height: 0px;">Vui lòng chọn trường này!</h5>'));
		$this->form_validation->set_rules('type', 'Loại mã', 'greater_than[-1]',
			array('greater_than' => '<h5 style="color: red; height: 0px;">Vui lòng chọn trường này!</h5>'));

		if ($this->form_validation->run() == FALSE) {
			$data['title'] = 'Chỉnh sửa mã giảm giá';
			$data['load_page'] = 'admin/voucher/edit_view';
			if (is_numeric($id)) {
				$data['voucher'] = $this->voucher_model->select(' *', TBL_VOUCHERS, ' WHERE id = ' . $id . '');
				if (count($data['voucher']) == 0) {
					$this->session->set_flashdata('error', 'Mã giảm giá không tồn tại!');
					redirect('admin/voucher/index');
				}
			} else {
				$this->session->set_flashdata('error', 'Mã giảm giá không tồn tại!');
				redirect('admin/voucher/index');
			}
			$this->load->view('layouts/be_master_view', $data);
		} else {
			$data['title'] = 'Chỉnh sửa mã giảm giá';
			$data['load_page'] = 'admin/voucher/edit_view';
			if (is_numeric($id)) {
				$data['voucher'] = $this->voucher_model->select(' *', TBL_VOUCHERS, ' WHERE id = ' . $id . '');
				if (count($data['voucher']) == 0) {
					$this->session->set_flashdata('error', 'Mã giảm giá không tồn tại!');
					redirect('admin/voucher/index');
				}
				if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
					$voucher = array();
					foreach ($_POST as $key => $value) {
						$voucher[$key] = htmlspecialchars($value);
					}
					$data['update_voucher'] = $this->voucher_model->update_voucher($voucher, $id);
					if (isset($data['update_voucher']) && $data['update_voucher']) {
						$this->session->set_flashdata('success', 'Chỉnh sửa thông tin mã giảm giá thành công!');
						redirect('admin/voucher/index');
					}
				} else {
					$this->session->set_flashdata('error', 'Mã giảm giá không tồn tại!');
					redirect('admin/voucher/index');
				}
				$this->load->view('layouts/be_master_view', $data);
			}
		}
	}

	/**
	 * Hàm callback rule check code giảm giá tồn tại
	 */
	public function code_check($code) {
		$id = $this->session->flashdata('id');
		$voucher = $this->voucher_model->select(' *', TBL_VOUCHERS, 'WHERE id = '.$id.'');
		if (isset($voucher) && count($voucher) > 0) {
			if ($voucher[0]['code'] == $code) {
				return TRUE;
			}
		}
		$check = $this->voucher_model->select(' *', TBL_VOUCHERS, "WHERE code = '".$code."'");
		if(isset($check) && count($check) > 0) {
			$this->form_validation->set_message('code_check', '<h5 style="color: red; height: 0px;">Mã giảm giá đã tồn tại!</h5>');
			return FALSE;
		}else{
			return TRUE;
		}
	}

	/**
	 * Chi tiết thông tin mã giảm giá
	 * URL: /admin/voucher/detail/(id mã giảm giá)
	 */
	public function detail($id = null) {
		if (!isset($id) || $id == NULL) {
			redirect('admin/voucher/index');
		}else{
			$data['id'] = $id;
		}
		$data['title'] = 'Chi tiết mã giảm giá';
		$data['load_page'] = 'admin/voucher/detail_view';
		if (is_numeric($id)) {
			$data['voucher'] = $this->voucher_model->select(' *', TBL_VOUCHERS, ' WHERE id = '.$id.'');
			if (count($data['voucher']) == 0) {
				$this->session->set_flashdata('error', 'Mã giảm giá không tồn tại!');
				redirect('admin/voucher/index');
			}
		}else{
			$this->session->set_flashdata('error', 'Mã giảm giá không tồn tại!');
			redirect('admin/voucher/index');
		}
		$this->load->view('layouts/be_master_view', $data);
	}

	/**
	 * Xóa khách hàng
	 * URL: /admin/voucher/delete/(id mã giảm giá)
	 */
	public function delete($id = null) {
		if (!isset($id) || $id == NULL) {
			redirect('admin/voucher/index');
		}else{
			$data['id'] = $id;
		}
		if (is_numeric($id)) {
			$voucher = $this->voucher_model->select(' *', TBL_VOUCHERS, ' WHERE id = '.$id.'');
			if (count($voucher) == 0) {
				$this->session->set_flashdata('error', 'Mã giảm giá không tồn tại!');
				redirect('admin/voucher/index');
			}
			$delete = $this->voucher_model->delete_voucher($id);
			if (isset($delete) && $delete) {
				$this->session->set_flashdata('success', 'Xóa mã giảm giá thành công!');
				redirect('admin/voucher/index');
			}
		}else {
			$this->session->set_flashdata('error', 'Mã giảm giá không tồn tại!');
			redirect('admin/voucher/index');
		}
	}
}
