<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'client/order_model'
		));
	}

	public function history() {
		$data['title_page'] = 'Quản lý đơn hàng của người dùng';
		$data['load_page'] = 'client/order/order_view';
		$this->load->view('layouts/fe_master_view', $data);
	}

	/**
	 * Hàm lấy dữ liệu phân trang theo ajax
	 * URL: /client/order/ajax_list
	 */
	public function ajax_list() {
		$params['page_index'] = $this->input->post('page_index');
		$params['page_size'] = 10;
		if ($params['page_index'] < 1) { $params['page_index'] = 1; }
		$data['from'] = $params['from'] = ($params['page_index'] - 1)* $params['page_size'];
		if(isset($_SESSION['id'])) {
			$params['customer_id'] = $_SESSION['id'];
		}
		$total_record = $this->order_model->order_list($params, true);
		$data['result_order'] = $this->order_model->order_list($params, false);
		$data['pagination_link'] = paginate_ajax2($total_record, $params['page_index'], $params['page_size']);
		$this->load->view('client/order/ajax_list_view', $data);
	}

	public function detail($id = null) {
		if (!isset($id) || $id == NULL) {
			redirect('client/order/history');
		}else{
			$data['id'] = $id;
		}
		$data['title_page'] = 'Chi tiết đơn hàng của người dùng';
		$data['load_page'] = 'client/order/detail_view';
		if (is_numeric($id)) {
			$data['order'] = $this->order_model->detail_order($id);
			$data['order_product'] = $this->order_model->order_product($id);
			if (count($data['order']) == 0) {
				$this->session->set_flashdata('error', 'Đơn hàng không tồn tại!');
				redirect('client/order/history');
			}
		}else{
			$this->session->set_flashdata('error', 'Đơn hàng không tồn tại!');
			redirect('client/order/history');
		}
		$this->load->view('layouts/fe_master_view', $data);
	}
}
