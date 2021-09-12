<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statistic extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'admin/statistic_model'
		));
	}

	/**
	 * Danh sách khách hàng
	 * URL: /admin/statistic/product
	 */
	public function product() {
		$data['title_page'] = 'Thống kê sản phẩm';
		$data['load_page'] = 'admin/statistic/product_statistic_view';
		$this->load->view('layouts/be_master_view', $data);
	}

	/**
	 * Hàm lấy dữ liệu phân trang theo ajax
	 * URL: /admin/statistic/ajax_product_statistic
	 */
	public function ajax_product_statistic() {
		$params['keyword'] = $this->input->post('keyword');
		$params['type'] = $this->input->post('type');
		$params['cate'] = $this->input->post('cate');
		$params['start_date'] = $this->input->post('start_date');
		$params['end_date'] = $this->input->post('end_date');
		$params['page_index'] = $this->input->post('page_index');
		$params['page_size'] = 10;
		if ($params['page_index'] < 1) { $params['page_index'] = 1; }
		$data['from'] = $params['from'] = ($params['page_index'] - 1)* $params['page_size'];
		$total_record = $this->statistic_model->product_statistic($params, true);
		$data['product_statistic'] = $this->statistic_model->product_statistic($params, false);
		$data['pagination_link'] = paginate_ajax($total_record, $params['page_index'], $params['page_size']);
		$this->load->view('admin/statistic/ajax_product_view', $data);
	}
}
