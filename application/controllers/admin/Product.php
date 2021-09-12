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
				} else {
					$color = explode(',', $_POST['color']);
					$count_color = array_count_values($color);
					foreach ($count_color as $value) {
						if ($value > 1) {
							$errors['color'] = 'Màu sắc không trùng nhau';
						}
					}
				}
			}
			if (empty($_POST['name'])) {
				$errors['name'] = 'Tên sản phẩm không được trống';
			} elseif (strlen($_POST['name']) > 1000) {
				$errors['name'] = 'Tên sản phẩm dài quá 1000 ký tự';
			} elseif (count($this->product_model->query('name', TBL_PRODUCTS, "WHERE name ='" . $_POST['name'] . "' AND `delete` = 0")) > 0) {
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
			$product['description'] = htmlspecialchars($_POST['description']);
			$product['priority'] = $this->input->post('priority');
			$new_id = $this->product_model->insert_product($product, null, true);

			if ($this->input->post('attribute_id') && $this->input->post('value')) {
				for ($i = 0;
					 $i < count($_POST['attribute_id']);
					 $i++) {
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
			if (!empty($_POST['color'])) {
				if (strpos($_POST['color'], ',')) {
					$color = explode(',', $_POST['color']);
					foreach ($color as $data) {
						$product['color'] = $data;
						$new_son_id = $this->product_model->insert_product($product, $new_id, true);
						if (isset($main_img)) {
							$this->product_model->insert_img($new_son_id, $main_img, true);
						}
					}
				} else {
					$product['color'] = $_POST['color'];
					$new_son_id = $this->product_model->insert_product($product, $new_id, true);
					if (isset($main_img)) {
						$this->product_model->insert_img($new_son_id, $main_img, true);
					}
				}
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

	public function edit($id)
	{
		$errors = array();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (!isset($_POST['parent_id'])) {
				if (strpos($_POST['color'], ',')) {
					if (in_array('', explode(',', $_POST['color']))) {
						$errors['color'] = 'Màu sắc không đúng định dạng';
					} else {
						$color = explode(',', $_POST['color']);
						if (count($color) > 1) {
							$count_color = array_count_values($color);
							foreach ($count_color as $value) {
								if ($value > 1) {
									$errors['color'] = 'Màu sắc không trùng nhau';
								}
							}
						} else {
							foreach ($color as $value) {
								if (count($this->product_model->query('*', TBL_PRODUCTS, "WHERE color ='"
										. $value
										. "' AND parent_id ="
										. $_POST['id']
										. " AND `delete` = 0")) > 0) {
									$errors['color'] = 'Màu sắc này đã tồn tại';
								}
							}
						}
					}
				} elseif (count($this->product_model->query('*', TBL_PRODUCTS, "WHERE color ='" . $_POST['color'] . "' AND parent_id =" . $_POST['id'])) > 0) {
					$errors['color'] = 'Màu sắc này đã tồn tại';
				}
				if (empty($_POST['name'])) {
					$errors['name'] = 'Tên sản phẩm không được trống';
				} elseif (strlen($_POST['name']) > 1000) {
					$errors['name'] = 'Tên sản phẩm dài quá 1000 ký tự';
				} else {
					if ($_POST['name'] != $_POST['old_name']) {
						if (count($this->product_model->query('name', TBL_PRODUCTS, "WHERE name ='" . $_POST['name'] . "'")) > 0) {
							$errors['name'] = 'Tên sản phẩm đã tồn tại';
						}
					}
				}
				if ($this->input->post('attribute_id') && $this->input->post('value')) {
					if (count($_POST['attribute_id']) > 0) {
						$count = array_count_values($_POST['attribute_id']);
						foreach ($count as $value) {
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
			}
			if (!$_POST['price']) {
				$errors['price'] = 'Giá sản phẩm bắt buộc nhập';
			}
			if (isset($_POST['parent_id'])) {
				if ($_POST['color'] != $_POST['old_color']) {
					if (count($this->product_model->query('*', TBL_PRODUCTS, "WHERE color ='" . $_POST['color'] . "' AND parent_id =" . $_POST['parent_id'])) > 0) {
						$errors['color'] = 'Màu sắc này đã tồn tại';
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
				if (!isset($_POST['parent_id'])) {
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
		}
		if (isFormValidated($errors) && $_SERVER['REQUEST_METHOD'] == 'POST') {
			if (!isset($_POST['parent_id'])) {
				$product = array();
				$product['id'] = $_POST['id'];
				$product['name'] = htmlspecialchars($_POST['name']);
				$product['price'] = $_POST['price'];
				$product['brand_id'] = $_POST['brand_id'];
				$product['category_id'] = $_POST['category_id'];
				$product['description'] = htmlspecialchars($_POST['description']);
				$product['priority'] = $this->input->post('priority');
				$this->product_model->edit($product);

				if ($this->input->post('attribute_id') && $this->input->post('value')) {
					$this->product_model->delete_attribute($_POST['id']);
					for ($i = 0;
						 $i < count($_POST['attribute_id']);
						 $i++) {
						$this->product_model->insert_eav($_POST['id'], $_POST['attribute_id'][$i], $_POST['value'][$i]);
					}
				}
				if (!empty($_FILES['main_img']['name'])) {
					$this->product_model->delete_img($_POST['id'], true);
					if (move_uploaded_file($_FILES['main_img']['tmp_name'], 'uploads/product_image/' . $main_img)) {
						$this->product_model->insert_img($_POST['id'], $main_img, true);
					}
				}
				if (isset($name) && isset($tmp_name)) {
					$this->product_model->delete_img($_POST['id'], false);
					if (count($name) > 0 && count($tmp_name) > 0) {
						for ($i = 0; $i < count($name); $i++) {
							if (move_uploaded_file($tmp_name[$i], 'uploads/product_image/' . $name[$i])) {
								$this->product_model->insert_img($_POST['id'], $name[$i]);
							}
						}
					}
				}
				if (!empty($_POST['color'])) {
					if (strpos($_POST['color'], ',')) {
						$color = explode(',', $_POST['color']);
						foreach ($color as $data) {
							$product['color'] = $data;
							$new_son_id = $this->product_model->insert_product($product, $_POST['id'], true);
							if (isset($main_img)) {
								$this->product_model->insert_img($new_son_id, $main_img, true);
							} elseif (isset($_POST['old_img']) && $_POST['old_img']) {
								$this->product_model->insert_img($new_son_id, $_POST['old_img'], true);
							}
						}
					} else {
						$product['color'] = $_POST['color'];
						$new_son_id = $this->product_model->insert_product($product, $_POST['id'], true);
						if (isset($main_img)) {
							$this->product_model->insert_img($new_son_id, $main_img, true);
						} elseif (isset($_POST['old_img']) && $_POST['old_img']) {
							$this->product_model->insert_img($new_son_id, $_POST['old_img'], true);
						}
					}
				}
				redirect('admin/product/index');
			} else {
				$product = array();
				$product['id'] = $_POST['id'];
				$product['price'] = $_POST['price'];
				$product['color'] = htmlspecialchars($_POST['color']);
				$this->product_model->edit($product, $_POST['father_name']);

				if (!empty($_FILES['main_img']['name'])) {
					$this->product_model->delete_img($_POST['id'], true);
					if (move_uploaded_file($_FILES['main_img']['tmp_name'], 'uploads/product_image/' . $main_img)) {
						$this->product_model->insert_img($_POST['id'], $main_img, true);
					}
				}
				redirect('admin/product/index');
			}
		} else {
			$data['title_page'] = 'QL Sản phẩm';
			$data['load_page'] = 'admin/product/edit_view';
			$data['product'] = $this->product_model->query('*', TBL_PRODUCTS, 'WHERE id =' . $id)[0];
			$data['errors'] = $errors;
			if (!$data['product']['parent_id']) {
				$data['category'] = $this->product_model->query('id,name', TBL_CATEGORIES);
				$data['brand'] = $this->product_model->query('id,name', TBL_BRANDS);
				$data['attribute'] = $this->product_model->query('id,name', TBL_ATTRIBUTES, 'ORDER BY name ASC');
				$data['old_attribute'] = $this->product_model->query('*', TBL_PRODUCT_ATTRIBUTE, 'WHERE product_id =' . $id);
				if (count($this->product_model->get_img($data['product']['id'], true)) > 0) {
					$data['main_img'] = $this->product_model->get_img($data['product']['id'], true);
				}
			} else {
				$data ['old_color'] = $data['product']['color'];
				$data['father_name'] = $this->product_model->query('name', TBL_PRODUCTS, 'WHERE id =' . $data['product']['parent_id'])[0]['name'];
			}
			if (count($main_img = $this->product_model->get_img($id, true)) > 0) {
				$data['main_img'] = $main_img[0]['path'];
			}
			$this->load->view('layouts/be_master_view', $data);
		}
	}

	public
	function detail($id)
	{
		$data['title_page'] = 'QL Sản phẩm';
		$data['load_page'] = 'admin/product/detail_view';
		$data['product'] = $this->product_model->detail($id)[0];
		$select = 'a.name,p.value';
		$param = 'LEFT JOIN attributes as a ON a.id= p.attribute_id ';
		$param .= 'WHERE product_id =' . $id;
		$data['attribute'] = $this->product_model->query($select, TBL_PRODUCT_ATTRIBUTE . ' AS p', $param);
		if (count($main_img = $this->product_model->get_img($id, true)) > 0) {
			$data['main_img'] = $main_img[0]['path'];
		}
		if (!$data['product']['parent_id']) {
			$data['child'] = $this->product_model->query('id,name', TBL_PRODUCTS, 'WHERE parent_id = ' . $id . ' AND `delete` = 0 ');
		}
		$data['img'] = $this->product_model->get_img($id);
		$this->load->view('layouts/be_master_view', $data);
	}

	public function delete($id)
	{
		$this->product_model->delete_attribute($id);
		$this->product_model->delete($id);
		redirect('admin/product/index');
	}
}
