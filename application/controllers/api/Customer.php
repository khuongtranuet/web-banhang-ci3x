<?php
defined('BASEPATH') or exit('No direct script access allowed');
use chriskacerguis\RestServer\RestController;
require APPPATH . 'libraries/RestController.php';
require APPPATH . 'helpers/php-jwt-master/src/JWT.php';
use Firebase\JWT\JWT;

class Customer extends RestController
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'admin/customer_model'
		));
	}

	public function index_get() {
		$params = [];
		if (isset($_GET['page']) && isset($_GET['page_size'])) {
			$data['page'] = $params['page_index'] = $_GET['page'];
			$data['page_size'] = $params['page_size'] = $_GET['page_size'];
			$params['from'] = ($params['page_index'] - 1) * $params['page_size'];
		}
		if (isset($_GET['keyword'])) {
			$params['keyword'] = $_GET['keyword'];
		}
		if (isset($_GET['type'])) {
			$params['type'] = $_GET['type'];
		}
		if(isset($_GET['status'])) {
			$params['status'] = $_GET['status'];
		}
		if (isset($id)) {
			header('Access-Control-Allow-Origin: *');
			$params['id'] = $id;
			$data['result_customer'] = $this->customer_model->customer_list($params, false);
		} else {
			header('Access-Control-Allow-Origin: *');
			$data['result_customer'] = $this->customer_model->customer_list($params, false);
			$data['total_rows'] = $this->customer_model->customer_list($params, true);
			$this->response([
				'code' => 200,
				'message' => 'Danh sách khách hàng!',
				'data' => $data['result_customer'],
				'meta_data'=> [
					'page' => (int)$data['page'],
					'page_size' => (int)$data['page_size'],
					'total_rows' => $data['total_rows'],
				],
			], 200);
		}
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
				$customer = $this->customer_model->address_customer($id, true, true);
				if (count($customer) == 0) {
					$this->response([
						'code' => 404,
						'message' => 'Không có thông tin cần truy vấn!',
						'meta_data' => null,
					], 404);
				}
				$delete = $this->customer_model->delete_customer($id);
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

	public function index_post() {
		if (isset($_POST)) {
			$customer = array();
			foreach ($_POST as $key => $value) {
				if($_POST[$key] == '') {
					$error_exist[$key] = 'Trường này không được để trống!';
				}
				if($_POST[$key] !== '' && $key == 'mobile') {
					$result_mobile = $this->customer_model->select('*', 'customers', 'WHERE mobile= ' . $_POST['mobile'] . '');
					if (count($result_mobile) > 0) {
						$error_exist['mobile'] = 'Số điện thoại đã tồn tại, khách hàng đã tồn tại!';
					}
				}
				if($_POST[$key] !== '' && $key == 'email') {
					$result_email = $this->customer_model->select('*', 'customers', 'WHERE email= "'. $_POST['email'] .'"');
					if (count($result_email) > 0) {
						$error_exist['email'] = 'Email đã tồn tại, khách hàng đã tồn tại!';
					}
				}
				$customer[$key] = htmlspecialchars($value);
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
				$data['insert_customer'] = $this->customer_model->insert_customer($customer);
				if (isset($data['insert_customer']) && $data['insert_customer']) {
					header('Access-Control-Allow-Origin: *');
					$this->response([
						'code' => 201,
						'message' => 'Thêm mới khách hàng thành công!',
						'data' => $customer,
						'meta_data' => null,
					], 201);
				}
			}
			die();
		}
	}

	public function login_post() {
//		$a = getallheaders();
//		echo_pre($a['Authorization']);
//		$token = explode(" ", $a['Authorization'])[1];
//		echo $token;
//		die();
		if (isset($_POST)) {
			$customer = array();
			foreach ($_POST as $key => $value) {
				if ($_POST[$key] == '') {
					$error_exist[$key] = 'Trường này không được để trống!';
				}
				$customer[$key] = htmlspecialchars($value);
			}
			if (isset($error_exist)) {
				header('Access-Control-Allow-Origin: *');
				$this->response([
					'code' => 200,
					'message' => 'Đã xảy ra lỗi!',
					'error' => $error_exist,
				], 200);
			} else {
				$check_exist = $this->customer_model->select(' *', 'customers', 'WHERE (email = "' . $customer['mobile'] . '" 
			OR mobile = "' . $customer['mobile'] . '")');
				if (count($check_exist) > 0) {
//					echo_pre($check_exist);
//					echo $check_exist[0]['password'];
					if (password_verify($customer['password'], $check_exist[0]['password'])) {
						$key = "123ABC";
						$payload = array(
							'fullname' => $check_exist[0]['fullname'],
							'user_id' => $check_exist[0]['id']

						);
						$token = JWT::encode($payload, $key);
						header('Access-Control-Allow-Origin: *');
						header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
						header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization');
						$this->response([
							'code' => 200,
							'message' => 'Đăng nhập thành công!',
							'token' => $token,
							'data' => $payload,
							'meta_data' => null,
						], 200);
					}else{
						header('Access-Control-Allow-Origin: *');
						header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
						header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization');
						$this->response([
							'code' => 400,
							'message' => 'Đăng nhập thất bại!',
						], 400);
					}
				} else {
					header('Access-Control-Allow-Origin: *');
					header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
					header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization');
					$this->response([
						'code' => 400,
						'message' => 'Đăng nhập thất bại!',
					], 400);
				}
			}
		}
	}

	public function register_post() {
		if (isset($_POST)) {
			$customer = array();
			foreach ($_POST as $key => $value) {
				if($_POST[$key] == '') {
					$error_exist[$key] = 'Trường này không được để trống!';
				}
				if($_POST[$key] !== '' && $key == 'mobile') {
					$result_mobile = $this->customer_model->select('*', 'customers', 'WHERE mobile= ' . $_POST['mobile'] . '');
					if (count($result_mobile) > 0) {
						$error_exist['mobile'] = 'Số điện thoại đã tồn tại, khách hàng đã tồn tại!';
					}
				}
				if($_POST[$key] !== '' && $key == 'email') {
					$result_email = $this->customer_model->select('*', 'customers', 'WHERE email= "'. $_POST['email'] .'"');
					if (count($result_email) > 0) {
						$error_exist['email'] = 'Email đã tồn tại, khách hàng đã tồn tại!';
					}
				}
				$customer[$key] = htmlspecialchars($value);
			}
			if($customer['password'] != $customer['confirm_password']) {
				$error_exist['confirm_password'] = 'Mật khẩu không khớp!';
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
				$customer['password'] = password_hash($customer['password'], PASSWORD_DEFAULT);
				$data['insert_customer'] = $this->customer_model->register_customer($customer);
				if (isset($data['insert_customer']) && $data['insert_customer']) {
					header('Access-Control-Allow-Origin: *');
					$this->response([
						'code' => 201,
						'message' => 'Đăng ký thành công!',
						'data' => null,
						'meta_data' => null,
					], 201);
				}
			}
			die();
		}
	}
}
