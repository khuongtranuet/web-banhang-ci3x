<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Repository extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'admin/repository_model'
		));
	}

	/**
	 * Danh sách kho hàng
	 * URL: /admin/repository/index
	 */
	public function index()
	{
		$data['title_page'] = 'Ql Kho hàng';
		$data['load_page'] = 'admin/repository/list_view';
		$this->load->view('layouts/be_master_view', $data);
	}

	/**
	 * Hàm lấy dữ liệu phân trang theo ajax
	 * URL: /admin/repository/ajax_list
	 */
	public function ajax_list()
	{
		$params['keyword'] = $this->input->post('keyword');
		$params['page_index'] = $this->input->post('page_index');
		$params['page_size'] = 10;

		if ($params['page_index'] < 1) {
			$params['page_index'] = 1;
		}
		$data['from'] = $params['from'] = ($params['page_index'] - 1) * $params['page_size'];
		$total_record = $this->repository_model->repository_list($params, true);

		$data['result_repository'] = $this->repository_model->repository_list($params, false);
		$data['pagination_link'] = paginate_ajax($total_record, $params['page_index'], $params['page_size']);
		$this->load->view('admin/repository/ajax_list_view', $data);
	}

	/**
	 * Hàm thêm mới kho hàng
	 * URL: /admin/repository/add
	 */
	public function add() {
		$this->form_validation->set_rules('name', 'Tên kho hàng', 'required',
			array('required' => '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>')
		);
		$this->form_validation->set_rules(
			'mobile', 'Số điện thoại',
			'required|is_unique[repositories.mobile]',
			array(
				'required' => '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>',
				'is_unique' => '<h5 style="color: red; height: 0px;">Số điện thoại đã tồn tại!</h5>'
			)
		);
		$this->form_validation->set_rules('province', 'Tỉnh/Thành phố', 'greater_than[-1]',
			array('greater_than' => '<h5 style="color: red; height: 0px;">Vui lòng chọn trường này!</h5>'));
		$this->form_validation->set_rules('district', 'Quận/Huyện', 'greater_than[-1]',
			array('greater_than' => '<h5 style="color: red; height: 0px;">Vui lòng chọn Tỉnh/Thành phố!</h5>'));
		$this->form_validation->set_rules('ward', 'Xã/Phường/Thị trấn', 'greater_than[-1]',
			array('greater_than' => '<h5 style="color: red; height: 0px;">Vui lòng chọn Quận/Huyện!</h5>'));
		$this->form_validation->set_rules('address', 'Địa chỉ', 'required',
			array('required' => '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>'));
		if ($this->form_validation->run() == FALSE) {
			$data['title'] = 'Thêm mới kho hàng';
			$data['load_page'] = 'admin/repository/add_view';
			$data['province'] = $this->repository_model->select('*', 'provinces');
			$this->load->view('layouts/be_master_view', $data);
		} else {
			$data['title'] = 'Thêm mới kho hàng';
			$data['load_page'] = 'admin/repository/add_view';
			$data['province'] = $this->repository_model->select('*', 'provinces');

			$repository = array();
			foreach ($_POST as $key => $value) {
				$repository[$key] = htmlspecialchars($value);
			}
			$data['insert_repository'] = $this->repository_model->insert_repository($repository);
			if (isset($data['insert_repository']) && $data['insert_repository']) {
				$this->session->set_flashdata('success', 'Thêm kho hàng mới thành công!');
				redirect('admin/repository/index');
			}
			$this->load->view('layouts/be_master_view', $data);
		}
	}

	/**
	 * Hàm chỉnh sửa thông tin kho hàng
	 * URL: /admin/repository/edit/(id kho hàng)
	 */
	public function edit($id = null) {
		if (!isset($id) || $id == NULL) {
			redirect('admin/repository/index');
		}else{
			$data['id'] = $id;
			$this->session->set_flashdata('id', $id);
		}
		$this->form_validation->set_rules('name', 'Tên kho hàng', 'required',
			array('required' => '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>')
		);
		$this->form_validation->set_rules(
			'mobile', 'Số điện thoại',
			'required|callback_mobile_check',
			array(
				'required' => '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>'
			)
		);
		$this->form_validation->set_rules('province', 'Tỉnh/Thành phố', 'greater_than[-1]',
			array('greater_than' => '<h5 style="color: red; height: 0px;">Vui lòng chọn trường này!</h5>'));
		$this->form_validation->set_rules('district', 'Quận/Huyện', 'greater_than[-1]',
			array('greater_than' => '<h5 style="color: red; height: 0px;">Vui lòng chọn Tỉnh/Thành phố!</h5>'));
		$this->form_validation->set_rules('ward', 'Xã/Phường/Thị trấn', 'greater_than[-1]',
			array('greater_than' => '<h5 style="color: red; height: 0px;">Vui lòng chọn Quận/Huyện!</h5>'));
		$this->form_validation->set_rules('address', 'Địa chỉ', 'required',
			array('required' => '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>'));
		if ($this->form_validation->run() == FALSE) {
			$data['title'] = 'Chỉnh sửa kho hàng';
			$data['load_page'] = 'admin/repository/edit_view';
			if (is_numeric($id)) {
				$data['province'] = $this->repository_model->select('*', 'provinces');
				$data['repository'] = $this->repository_model->address_repository($id);
				if (count($data['repository']) == 0) {
					$this->session->set_flashdata('error', 'Kho hàng không tồn tại!');
					redirect('admin/repository/index');
				}
				$province_id = $data['repository'][0]['province_id'];
				$district_id = $data['repository'][0]['district_id'];
				$data['district'] = $this->repository_model->select('*', 'districts', 'WHERE province_id = '.$province_id.'');
				$data['ward'] = $this->repository_model->select('*', 'wards', 'WHERE district_id = '.$district_id.' AND province_id = '.$province_id.'');
			}else{
				$this->session->set_flashdata('error', 'Kho hàng không tồn tại!');
				redirect('admin/repository/index');
			}
			$this->load->view('layouts/be_master_view', $data);
		}else{
			$data['title'] = 'Chỉnh sửa kho hàng';
			$data['load_page'] = 'admin/repository/edit_view';
			if (is_numeric($id)) {
				$data['province'] = $this->repository_model->select('*', 'provinces');
				$data['repository'] = $this->repository_model->address_repository($id);
				if (count($data['repository']) == 0) {
					$this->session->set_flashdata('error', 'Kho hàng không tồn tại!');
					redirect('admin/repository/index');
				}
				$province_id = $data['repository'][0]['province_id'];
				$district_id = $data['repository'][0]['district_id'];
				$data['district'] = $this->repository_model->select('*', 'districts', 'WHERE province_id = '.$province_id.'');
				$data['ward'] = $this->repository_model->select('*', 'wards', 'WHERE district_id = '.$district_id.' AND province_id = '.$province_id.'');
				if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
					$repository = array();
					foreach ($_POST as $key => $value) {
						$repository[$key] = htmlspecialchars($value);
					}
					$data['update_repository'] = $this->repository_model->update_repository($repository, $id);
					if (isset($data['update_repository']) && $data['update_repository']) {
						$this->session->set_flashdata('success', 'Chỉnh sửa thông tin kho hàng thành công!');
						redirect('admin/repository/index');
					}
				}
			}else{
				$this->session->set_flashdata('error', 'Kho hàng không tồn tại!');
				redirect('admin/repository/index');
			}
			$this->load->view('layouts/be_master_view', $data);
		}
	}

	/**
	 * Hàm callback rule check số điện thoại tồn tại
	 */
	public function mobile_check($mobile) {
		$id = $this->session->flashdata('id');
		$repository = $this->repository_model->select('*', 'repositories', 'WHERE id = '.$id.'');
		if (isset($repository) && count($repository) > 0) {
			if ($repository[0]['mobile'] == $mobile) {
				return TRUE;
			}
		}
		$check = $this->repository_model->select('*', 'repositories', "WHERE mobile = '".$mobile."'");
		if(isset($check) && count($check) > 0) {
			$this->form_validation->set_message('mobile_check', '<h5 style="color: red; height: 0px;">Số điện thoại đã tồn tại!</h5>');
			return FALSE;
		}else{
			return TRUE;
		}
	}

	/**
	 * Hiển thị thông tin chi tiết kho hàng
	 * URL: /admin/repository/edit/(id kho hàng)
	 */
	public function detail($id = null) {
		if (!isset($id) || $id == NULL) {
			redirect('admin/repository/index');
		}else{
			$data['id'] = $id;
		}
		if (is_numeric($id)) {
			$data['repository'] = $this->repository_model->address_repository($id);
			if (count($data['repository']) == 0) {
				$this->session->set_flashdata('error', 'Kho hàng không tồn tại!');
				redirect('admin/repository/index');
			}
			$data['title_page'] = 'Chi tiết kho hàng';
			$data['load_page'] = 'admin/repository/detail_view';
			$data['category'] = $this->repository_model->select(' *', ' categories', " WHERE parent_id = '0'");
		}else{
			$this->session->set_flashdata('error', 'Kho hàng không tồn tại!');
			redirect('admin/repository/index');
		}
		$this->load->view('layouts/be_master_view', $data);
	}

	/**
	 * Hàm lấy dữ liệu hàng trong kho theo ajax
	 * URL: /admin/repository/ajax_detail_list
	 */
	public function ajax_detail_list() {
		$params['keyword'] = $this->input->post('keyword');
		$params['category'] = $this->input->post('category');
		$params['sort'] = $this->input->post('sort');
		$params['page_index'] = $this->input->post('page_index');
		$params['page_size'] = 10;

		if ($params['page_index'] < 1) { $params['page_index'] = 1; }
		$data['from'] = $params['from'] = ($params['page_index'] - 1)* $params['page_size'];
		$total_record = $this->repository_model->detail_repository_list($params, true);

		$data['detail_repository'] = $this->repository_model->detail_repository_list($params, false);
		$data['pagination_link'] = paginate_ajax($total_record, $params['page_index'], $params['page_size']);
		$this->load->view('admin/customer/ajax_detail_view', $data);
	}
}
