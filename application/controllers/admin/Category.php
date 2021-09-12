<?php


class Category extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'admin/category_model'
		));
	}

	public function index()
	{
		$data['title_page'] = 'QL Danh mục';
		$data['load_page'] = 'admin/category/list_view';
		$this->load->view('layouts/be_master_view', $data);
	}

	public function ajax_list()
	{
		$params['keyword'] = $this->input->post('keyword');
		$params['type'] = $this->input->post('type');
		$params['page_index'] = $this->input->post('page_index');
		$params['page_size'] = 10;

		if ($params['page_index'] < 1) {
			$params['page_index'] = 1;
		}
		$data['from'] = $params['from'] = ($params['page_index'] - 1) * $params['page_size'];
		$total_record = $this->category_model->category_list($params, true);

		$data['result_category'] = $this->category_model->category_list($params, false);
		$data['pagination_link'] = paginate_ajax($total_record, $params['page_index'], $params['page_size']);
		$this->load->view('admin/category/ajax_list_view', $data);
	}

	public function add()
	{
		$this->form_validation->set_rules(
			'name', 'Tên danh mục', 'required|max_length[1000]|is_unique[categories.name]',
			array(
				'required' => '%s không được bỏ trống',
				'max_length' => '%s không dài quá 1000 ký tự',
				'is_unique' => '%s đã tồn tại'
			)
		);

		if ($this->form_validation->run() == FALSE) {
			$data['title_page'] = 'QL Danh mục';
			$data['load_page'] = 'admin/category/add_view';
			$data['category_id'] = $this->category_model->query('*', TBL_CATEGORIES);
			$this->load->view('layouts/be_master_view', $data);
		} else {
			$category = array();
			if (isset($_FILES['image']['name']) && $_FILES['image']['name']) {
				$config['upload_path'] = './uploads/category_image/';
				$config['allowed_types'] = 'jpg|png';
				$config['max_size'] = 10000;
				$config['encrypt_name'] = true;
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('image')) {
					$data['error'] = $this->upload->display_errors();
					$data['title_page'] = 'QL Danh mục';
					$data['load_page'] = 'admin/category/add_view';
					$data['category_id'] = $this->category_model->query('*', TBL_CATEGORIES);
					return $this->load->view('layouts/be_master_view', $data);
				} else {
					$image = $this->upload->data();
					$category['image'] = $image['file_name'];
				}
			}
			$category['name'] = $_POST['name'];
			$category['description'] = $_POST['description'];
			$category['parent_id'] = $_POST['parent_id'];
			$category['status'] = $_POST['status'];
			if($this->category_model->insert($category)) {
				$this->session->set_flashdata('success', 'Thêm danh mục mới thành công!');
			} else {
				$this->session->set_flashdata('error', 'Thêm danh mục mới thất bại!');
			}
			redirect('admin/category/index');
			die();
		}
	}

	public function edit($id)
	{
		if (isset($_POST['old_name']) && !empty($_POST['name'])) {
			if ($_POST['old_name'] == $_POST['name']) {
				$validation = '';
			} else {
				$validation = '|is_unique[categories.name]';
			}
		} else {
			$validation = '|is_unique[categories.name]';
		}
		$this->form_validation->set_rules(
			'name', 'Tên danh mục', 'required|max_length[1000]' . $validation,
			array(
				'required' => '%s không được bỏ trống',
				'max_length' => '%s không dài quá 1000 ký tự',
				'is_unique' => '%s đã tồn tại'
			)
		);

		if ($this->form_validation->run() == FALSE) {
			$data['title_page'] = 'QL Danh mục';
			$data['load_page'] = 'admin/category/edit_view';
			$data['category_id'] = $this->category_model->query('*', TBL_CATEGORIES);
			$old_value = $this->category_model->query('*', TBL_CATEGORIES, 'WHERE id=' . $id);
			$data['old_value'] = $old_value[0];
			$this->load->view('layouts/be_master_view', $data);
		} else {
			$category = array();
			if (isset($_FILES['image']['name']) && $_FILES['image']['name']) {
				$config['upload_path'] = './uploads/category_image/';
				$config['allowed_types'] = 'jpg|png';
				$config['max_size'] = 10000;
				$config['encrypt_name'] = true;
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('image')) {
					$data['error'] = $this->upload->display_errors();
					$data['title_page'] = 'QL Danh mục';
					$data['load_page'] = 'admin/category/add_view';
					$data['category_id'] = $this->category_model->query('*', TBL_CATEGORIES);
					return $this->load->view('layouts/be_master_view', $data);
				} else {
					$image = $this->upload->data();
					unlink('uploads/category_image/' . $_POST['old_image']);
					$category['image'] = $image['file_name'];
				}
			}
			$category['id'] = $_POST['id'];
			$category['name'] = $_POST['name'];
			$category['description'] = $_POST['description'];
			$category['parent_id'] = $_POST['parent_id'];
			$category['status'] = $_POST['status'];
			if($this->category_model->edit($category)) {
				$this->session->set_flashdata('success', 'Cập nhật danh mục thành công!');
			} else {
				$this->session->set_flashdata('error', 'Cập nhật danh mục thất bại!');
			}
			redirect('admin/category/index');
			die();
		}
	}

	public function detail($id)
	{
		$data['title_page'] = 'QL Danh mục';
		$data['load_page'] = 'admin/category/detail_view';
		$result = $this->category_model->query('*', TBL_CATEGORIES, 'WHERE id =' . $id);
		if ($result[0]['parent_id']) {
			$parent = $this->category_model->query('*', TBL_CATEGORIES, 'WHERE id =' . $result[0]['parent_id']);
			if (count($parent) != 0) {
				$data['parent'] = $parent[0]['name'];
			}
		}
		$children = $this->category_model->query('*', TBL_CATEGORIES, 'WHERE parent_id = ' . $result[0]['id']);
		if (count($children) != 0) {
			$data['children'] = $children;
		}
		$data['result'] = $result[0];
		$this->load->view('layouts/be_master_view', $data);
	}

	public function delete($id)
	{
		if($this->category_model->delete($id)) {
			$this->session->set_flashdata('success', 'Xoá danh mục thành công!');
		} else {
			$this->session->set_flashdata('error', 'Xoá danh mục thất bại!');
		}
		redirect('admin/category/index');
		die();
	}

}
