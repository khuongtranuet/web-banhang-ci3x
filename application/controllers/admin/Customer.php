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

	public function index() {
		$data['title_page'] = 'Ql Khách hàng';
		$data['load_page'] = 'admin/customer/list_view';
		$this->load->view('layouts/be_master_view', $data);
	}

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

	public function detail($id = null) {
		if (!isset($id) || $id == NULL) {
			redirect('admin/customer/index');
		}else{
			$data['id'] = $id;
		}
		$data['title'] = 'Thông tin người dùng';
		$data['load_page'] = 'admin/customer/detail_view';
		$this->load->view('layouts/be_master_view', $data);
	}
}
