<?php
defined('BASEPATH') or exit('No direct script access allowed');
use chriskacerguis\RestServer\RestController;
require APPPATH . 'libraries/RestController.php';

class Repository extends RestController
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'admin/repository_model'
		));
	}

	public function index_get() {
		$data['result_repository'] = $this->repository_model->repository_list('', false, true);
		header('Access-Control-Allow-Origin: *');
		echo json_encode([
			'code' => 200,
			'message' => 'Danh sách kho hàng',
			'data' => $data['result_repository'],
			'meta_data'=> null,
		]);
		die();
	}

	public function index_post() {
		if (isset($_POST)) {
			$params['name'] = $this->input->post('name');
			$params['mobile'] = $this->input->post('mobile');
			$params['province'] = $this->input->post('province');
			$params['district'] = $this->input->post('district');
			$params['ward'] = $this->input->post('ward');
			$params['address'] = $this->input->post('address');
			if ($params['name'] == '') {
				$error_exist['error_name'] = 'Không được để trống trường này!';
			}
			if ($params['mobile'] == '') {
				$error_exist['error_mobile'] = 'Không được để trống trường này!';
			}
			if($params['mobile'] !== '') {
				$result_mobile = $this->repository_model->select('*', 'repositories', 'WHERE mobile= ' . $params['mobile'] . '');
				if (count($result_mobile) > 0) {
					$error_exist['error_mobile'] = 'Số điện thoại đã tồn tại, kho đã tồn tại!';
				}
			}
			if ($params['province'] == '' || $params['province'] == '-1') {
				$error_exist['error_province'] = 'Không được để trống trường này!';
			}
			if ($params['district'] == '' || $params['district'] == '-1') {
				$error_exist['error_district'] = 'Không được để trống trường này!';
			}
			if ($params['ward'] == '' || $params['ward'] == '-1') {
				$error_exist['error_ward'] = 'Không được để trống trường này!';
			}
			if ($params['address'] == '') {
				$error_exist['error_address'] = 'Không được để trống trường này!';
			}
			if (isset($error_exist)) {
				header('Access-Control-Allow-Origin: *');
				$this->response([
					'code' => 200,
					'message' => 'Đã xảy ra lỗi!',
					'error' => $error_exist,
				], 200);
			}else{
				header('Access-Control-Allow-Origin: *');
				$data['insert_repository'] = $this->repository_model->insert_repository($params);
				if (isset($data['insert_repository']) && $data['insert_repository']) {
					header('Access-Control-Allow-Origin: *');
					$this->response([
						'code' => 201,
						'message' => 'Thêm mới kho hàng thành công!',
						'data' => $params,
						'meta_data' => null,
					], 201);
				}
			}
		}
		die();
	}

	public function index_delete($id = null) {
		if (!isset($id) || $id == NULL) {
			header('Access-Control-Allow-Origin: *');
			$this->response([
				'code' => 200,
				'message' => 'Thiếu id cần truy vấn!',
				'meta_data' => null,
			], 200);
		} else {
			if (is_numeric($id)) {
				$repository = $this->repository_model->select(' *', ' repositories', " WHERE id = '" . $id . "'");
				if (count($repository) == 0) {
					$this->response([
						'code' => 404,
						'message' => 'Không có thông tin cần truy vấn!',
						'meta_data' => null,
					], 404);
				}
				$delete = $this->repository_model->delete_repository($id);
				if (isset($delete) && $delete) {
					$this->response([
						'code' => 204,
						'message' => 'Xóa thành công!',
						'meta_data' => null,
					], 204);
				}
			}
		}
	}
}
