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
		$this->form_validation->set_rules('color', 'màu sắc', 'callback_color_check');
		$this->form_validation->set_rules('name', 'tên sản phẩm', 'required|max_length[1000]|is_unique[products.name]');
		$this->form_validation->set_rules('price', 'giá sản phẩm', 'required');
		if ($this->input->post('attribute_id') && $this->input->post('value')) {
			$this->form_validation->set_rules('attribute_id[]', 'Thông số', 'callback_attribute_check');
			$this->form_validation->set_rules('value[]', 'giá trị', 'callback_value_check');
		}
		$this->form_validation->set_rules('main_img', 'Ảnh chính', 'callback_main_img_check');
		$this->form_validation->set_rules('img[]', 'Ảnh phụ', 'callback_img_check');
		if ($this->form_validation->run() == false) {
			$data['title_page'] = 'QL Sản phẩm';
			$data['attribute'] = $this->product_model->query('id,name', TBL_ATTRIBUTES, ' ORDER BY name ASC');
			$data['category'] = $this->product_model->query('id,name', TBL_CATEGORIES);
			$data['brand'] = $this->product_model->query('id,name', TBL_BRANDS);
			$data['load_page'] = 'admin/product/add_view';
			$this->load->view('layouts/be_master_view', $data);
		} else {
			$product = array();
			$product['name'] = htmlspecialchars($_POST['name']);
			$product['price'] = $_POST['price'];
			$product['brand_id'] = $_POST['brand_id'];
			$product['category_id'] = $_POST['category_id'];
			$product['description'] = htmlspecialchars($_POST['description']);
			$product['priority'] = $_POST['priority'];
			$new_id = $this->product_model->insert_product($product, null, true);

			if ($this->input->post('attribute_id') && $this->input->post('value')) {
				$count_attribute = count($_POST['attribute_id']);
				for ($i = 0; $i < $count_attribute; $i++) {
					$this->product_model->insert_eav($new_id, $_POST['attribute_id'][$i], $_POST['value'][$i]);
				}
			}
			if (!empty($_FILES['main_img']['name'])) {
				$main_img = unique_img($_FILES['main_img']['name']);
				if (move_uploaded_file($_FILES['main_img']['tmp_name'], 'uploads/product_image/' . $main_img)) {
					$this->product_model->insert_img($new_id, $main_img, true);
				}
			}

			if (count($_FILES['img']['name']) != 1 && !empty($_FILES['img']['name'][0])) {
				$name_count = count($_FILES['img']['name']);
				for ($i = 0; $i < $name_count; $i++) {
					$name = unique_img($_FILES['img']['name'][$i]);
					if (move_uploaded_file($_FILES['img']['tmp_name'][$i], 'uploads/product_image/' . $name)) {
						$this->product_model->insert_img($new_id, $name);
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
		}
	}

	public function main_img_check()
	{
		if ($_FILES['main_img']['error'] != 4) {
			$fileName = $_FILES['main_img']['name'];
			$fileSize = $_FILES['main_img']['size'];
			$fileError = $_FILES['main_img']['error'];
			$fileExt = explode('.', $fileName);
			$fileActualExt = strtolower(end($fileExt));
			$allowed = array('jpg', 'jpeg', 'png');
			if ($fileError === 0) {
				if (in_array($fileActualExt, $allowed)) {
					if ($fileSize > 5000000) {
						$this->form_validation->set_message('main_img_check', 'Tệp của bạn quá lớn!');
						return false;
					} else {
						return true;
					}
				} else {
					$this->form_validation->set_message('main_img_check', 'Bạn không thể tải lên loại tệp này!');
					return false;
				}
			} else {
				$this->form_validation->set_message('main_img_check', 'Có lỗi khi xảy ra khi tải tệp!');
				return false;
			}
		}
	}

	public function img_check()
	{
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
						if ($fileSize > 5000000) {
							$this->form_validation->set_message('img_check', 'Tệp của bạn quá lớn!');
							return false;
						} else {
							return true;
						}
					} else {
						$this->form_validation->set_message('img_check', 'Bạn không thể tải lên loại tệp này!');
						return false;
					}
				} else {
					$this->form_validation->set_message('img_check', 'Có lỗi khi xảy ra khi tải tệp!');
					return false;
				}
			}
		}
	}

	public function color_check($color)
	{
		if (strpos($color, ',')) {
			if (in_array('', explode(',', $color))) {
				$this->form_validation->set_message('color_check', '{field} không đúng định dạng');
				return false;
			} else {
				$color_array = explode(',', $color);
				$count_color = array_count_values($color_array);
				foreach ($count_color as $value) {
					if ($value > 1) {
						$this->form_validation->set_message('color_check', '{field} không trùng nhau');
						return false;
					}
				}
				return true;
			}
			return true;
		} else {
			return true;
		}
	}

	public function attribute_check()
	{
		$attribute_id = $this->input->post('attribute_id');
		if (count($attribute_id) > 0) {
			foreach (array_count_values($attribute_id) as $value) {
				if ($value > 1) {
					$this->form_validation->set_message('attribute_check', 'Thông số không được trùng nhau');
					return false;
				}
			}
			return true;
		} else {
			return true;
		}
	}

	public function value_check()
	{
		$value = $this->input->post('value');
		if (count($value) > 0) {
			foreach ($value as $value) {
				if (empty($value)) {
					$this->form_validation->set_message('value_check', 'Giá trị không được bỏ trống');
					return false;
				} else {
					return true;
				}
			}
		}
	}

	public function edit($id)
	{
		if (!isset($_POST['parent_id'])) {
			if ($this->input->post('attribute_id') && $this->input->post('value')) {
				$this->form_validation->set_rules('attribute_id[]', 'Thông số', 'callback_attribute_check');
				$this->form_validation->set_rules('value[]', 'giá trị', 'callback_value_check');
				$this->form_validation->set_rules('img[]', 'Ảnh phụ', 'callback_img_check');
			}
			$this->form_validation->set_rules('color', 'Màu sắc', 'callback_color_edit_check');
			if ($_SERVER['REQUEST_METHOD'] == "POST") {
				if ($_POST['name'] != $_POST['old_name']) {
					$this->form_validation->set_rules('name', 'tên sản phẩm',
						'required|max_length[1000]|is_unique[products.name]'
					);
				} else {
					$this->form_validation->set_rules('name', 'tên sản phẩm',
						'required|max_length[1000]'
					);
				}
			}
		}
		if (isset($_POST['parent_id'])) {
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				if ($_POST['color'] != $_POST['old_color']) {
					$this->form_validation->set_rules('color', 'Màu sắc', 'callback_unique_color_check');
				}
			}
		}
		$this->form_validation->set_rules('price', 'giá sản phẩm', 'required');
		$this->form_validation->set_rules('main_img', 'Ảnh chính', 'callback_main_img_check');
		if ($this->form_validation->run() == false) {
			$data['title_page'] = 'QL Sản phẩm';
			$data['load_page'] = 'admin/product/edit_view';
			$data['product'] = $this->product_model->query('*', TBL_PRODUCTS, 'WHERE id =' . $id)[0];
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
		} else {
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
					if ($this->product_model->delete_attribute($_POST['id'])) {
						for ($i = 0; $i < count($_POST['attribute_id']); $i++) {
							$this->product_model->insert_eav($_POST['id'], $_POST['attribute_id'][$i], $_POST['value'][$i]);
						}
					}
				}
				if (!empty($_FILES['main_img']['name'])) {
					$this->product_model->unlink_img($_POST['id'], true);
					if ($this->product_model->delete_img($_POST['id'], true)) {
						$main_img = unique_img($_FILES['main_img']['name']);
						if (move_uploaded_file($_FILES['main_img']['tmp_name'], 'uploads/product_image/' . $main_img)) {
							$this->product_model->insert_img($_POST['id'], $main_img, true);
						}
					}
				}

				if (count($_FILES['img']['name']) != 1 && !empty($_FILES['img']['name'][0])) {
					$this->product_model->unlink_img($_POST['id']);
					if ($this->product_model->delete_img($_POST['id'], false)) {
						$name_count = count($_FILES['img']['name']);
						for ($i = 0; $i < $name_count; $i++) {
							$name = unique_img($_FILES['img']['name'][$i]);
							if (move_uploaded_file($_FILES['img']['tmp_name'][$i], 'uploads/product_image/' . $name)) {
								$this->product_model->insert_img($_POST['id'], $name);
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
					$this->product_model->unlink_img($_POST['id'], true);
					if ($this->product_model->delete_img($_POST['id'], true)) {
						$main_img = unique_img($_FILES['main_img']['name']);
						if (move_uploaded_file($_FILES['main_img']['tmp_name'], 'uploads/product_image/' . $main_img)) {
							$this->product_model->insert_img($_POST['id'], $main_img, true);
						}
					}
				}
				redirect('admin/product/index');
			}
		}
	}

	public function unique_color_check()
	{
		if (count($this->product_model->query('*',
				TBL_PRODUCTS,
				"WHERE color ='" . $_POST['color'] . "' AND parent_id =" . $_POST['parent_id'])) > 0) {
			$this->form_validation->set_message('unique_color_check', '{field} đã tồn tại với sản phẩm này');
			return false;
		} else {
			return true;
		}
	}

	public function color_edit_check()
	{
		if (strpos($_POST['color'], ',')) {
			if (in_array('', explode(',', $_POST['color']))) {
				$this->form_validation->set_message('color_edit_check', '{field} không đúng định dạng');
				return false;
			} else {
				$color = explode(',', $_POST['color']);
				if (count($color) > 1) {
					$count_color = array_count_values($color);
					foreach ($count_color as $value) {
						if ($value > 1) {
							$this->form_validation->set_message('color_edit_check', '{field} không trùng nhau');
							return false;
						}
					}
					return true;
				} else {
					foreach ($color as $value) {
						if (count($this->product_model->query('*', TBL_PRODUCTS, "WHERE color ='"
								. $value
								. "' AND parent_id ="
								. $_POST['id']
								. " AND `delete` = 0")) > 0) {
							$this->form_validation->set_message('color_edit_check', '{field} này đã tồn tại');
							return false;
						}
					}
					return true;
				}
			}
		} elseif (count($this->product_model->query('*',
				TBL_PRODUCTS, "WHERE color ='" . $_POST['color'] . "' AND parent_id =" . $_POST['id'])) > 0) {
			$this->form_validation->set_message('color_edit_check', '{field} này đã tồn tại');
			return false;
		}
		return true;
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

	public
	function delete($id)
	{
		$this->product_model->delete_attribute($id);
		$this->product_model->delete($id);
		redirect('admin/product/index');
	}
}
