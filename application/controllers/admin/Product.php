<?php


class Product extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'admin/product_model'
		));
	}

	public function index()
	{
		$data['title_page'] = 'QL Sản phẩm';
		$data['load_page'] = 'admin/product/list_view';
		$data['category'] = $this->product_model->query('id,name', TBL_CATEGORIES);
		$data['brand'] = $this->product_model->query('id,name', TBL_BRANDS);
		$this->load->view('layouts/be_master_view', $data);
	}

	public function ajax_list()
	{
		$params['keyword'] = $this->input->post('keyword');
		$params['brand'] = $this->input->post('brand');
		$params['category'] = $this->input->post('category');
		$params['page_index'] = $this->input->post('page_index');
		$params['page_size'] = 10;
		if ($params['page_index'] < 1) {
			$params['page_index'] = 1;
		}
		$data['from'] = $params['from'] = ($params['page_index'] - 1) * $params['page_size'];
		$total_record = $this->product_model->product_list($params, true);

		$data['result_product'] = $this->product_model->product_list($params, false);
		$data['pagination_link'] = paginate_ajax($total_record, $params['page_index'], $params['page_size']);
		$this->load->view('admin/product/ajax_list_view', $data);
	}

	public function add()
	{
		$errors = array();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (strpos($_POST['color'], ',')) {
				if (in_array('', explode(',', $_POST['color']))) {
					$errors['color'] = 'Màu sắc không đúng định dạng';
				}
			}
			if (empty($_POST['name'])) {
				$errors['name'] = 'Tên sản phẩm không được trống';
			} elseif (strlen($_POST['name']) > 1000) {
				$errors['name'] = 'Tên sản phẩm dài quá 1000 ký tự';
			} elseif (count($this->product_model->query('name', TBL_PRODUCTS, "WHERE name ='" . $_POST['name'] . "'"))>0) {
				$errors['name'] = 'Tên sản phẩm đã tồn tại';
			}
			if (!$_POST['price']) {
				$errors['price'] = 'Giá sản phẩm bắt buộc nhập';
			}
			if ($this->input->post('attribute_id') && $this->input->post('value')) {
				if (count($_POST['attribute_id']) > 0) {
					foreach (array_count_values($_POST['attribute_id']) as $value) {
						if ($value > 1) {
							$errors['attribute_id'] = 'Các thuộc tính không được trùng nhau';
						}
					}
				}
				if (count($_POST['value']) > 0) {
					foreach ($_POST['value'] as $value) {
						if (empty($value)) {
							$errors['value'] = 'Các trường nhập không được bỏ trống';
						}
					}
				}
			}
			if (count($_FILES) > 0) {
				if ($_FILES['main_img']['error'] != 4) {
					$fileName = $_FILES['main_img']['name'];
					$fileSize = $_FILES['main_img']['size'];
					$fileError = $_FILES['main_img']['error'];
					$fileExt = explode('.', $fileName);
					$fileActualExt = strtolower(end($fileExt));
					$allowed = array('jpg', 'jpeg', 'png');
					if ($fileError === 0) {
						if (in_array($fileActualExt, $allowed)) {
							if ($fileSize < 5000000) {
								$main_img = uniqid('img-', true) . "." . $fileActualExt;
							} else {
								$errors['main_img'] = 'Tệp của bạn quá lớn!';
							}
						} else {
							$errors['main_img'] = "Bạn không thể tải lên loại tệp này!";
						}
					} else {
						$errors['main_img'] = "Có lỗi khi xảy ra khi tải tệp!";
					}
				}
				$name = array();
				$tmp_name = array();
				for ($i = 0; $i < count($_FILES['img']['name']); $i++) {
					if ($_FILES['img']['error'][$i] !== 4) {
						$fileName = $_FILES['img']['name'][$i];
						$fileSize = $_FILES['img']['size'][$i];
						$fileError = $_FILES['img']['error'][$i];
						$fileExt = explode('.', $fileName);
						$fileActualExt = strtolower(end($fileExt));
						$allowed = array('jpg', 'jpeg', 'png');
						if ($fileError === 0) {
							if (in_array($fileActualExt, $allowed)) {
								if ($fileSize < 5000000) {
									$name[$i] = uniqid('img-', true) . "." . $fileActualExt;
									$tmp_name[$i] = $_FILES['img']['tmp_name'][$i];
								} else {
									$errors['img'] = 'Tệp của bạn quá lớn!';
								}
							} else {
								$errors['img'] = "Bạn không thể tải lên loại tệp này!";
							}
						} else {
							$errors['img'] = "Có lỗi khi xảy ra khi tải tệp!";
						}
					}
				}
			}
		}
		if (isFormValidated($errors) && $_SERVER['REQUEST_METHOD'] == 'POST') {
			$product = array();
			$product['name'] = htmlspecialchars($_POST['name']);
			$product['price'] = $_POST['price'];
			$product['brand_id'] = $_POST['brand_id'];
			$product['category_id'] = $_POST['category_id'];
			$product['description'] = $_POST['description'];
			$product['priority'] = $this->input->post('priority');
			$new_id = $this->product_model->insert_product($product,null,true);

			if ($this->input->post('attribute_id') && $this->input->post('value')) {
				for ($i = 0; $i < count($_POST['attribute_id']); $i++) {
					$this->product_model->insert_eav($new_id, $_POST['attribute_id'][$i], $_POST['value'][$i]);
				}
			}
			if (!empty($_FILES['main_img']['name'])) {
				if (move_uploaded_file($_FILES['main_img']['tmp_name'], 'uploads/product_image/' . $main_img)) {
					$this->product_model->insert_img($new_id, $main_img, true);
				}
			}
			if (isset($name) && isset($tmp_name)) {
				if (count($name) > 0 && count($tmp_name) > 0) {
					for ($i = 0; $i < count($name); $i++) {
						if (move_uploaded_file($tmp_name[$i], 'uploads/product_image/' . $name[$i])) {
							$this->product_model->insert_img($new_id, $name[$i]);
						}
					}
				}
			}
			if (strpos($_POST['color'],',')) {
				$color = explode(',', $_POST['color']);
				foreach ($color as $data) {
					$product['color'] = $data;
					$this->product_model->insert_product($product,$new_id,false);
				}
			} else {
				$product['color'] = $_POST['color'];
				$this->product_model->insert_product($product,$new_id,false);
			}
			redirect('admin/product/index');
		} else {
			$data['errors'] = $errors;
			$data['title_page'] = 'QL Sản phẩm';
			$data['attribute'] = $this->product_model->query('id,name', TBL_ATTRIBUTES, ' ORDER BY name ASC');
			$data['category'] = $this->product_model->query('id,name', TBL_CATEGORIES);
			$data['brand'] = $this->product_model->query('id,name', TBL_BRANDS);
			$data['load_page'] = 'admin/product/add_view';
			$this->load->view('layouts/be_master_view', $data);
		}
	}
}
