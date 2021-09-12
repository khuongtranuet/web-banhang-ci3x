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

	public function detail() {
		$data['title_page'] = 'Chi tiết đơn hàng của người dùng';
		$data['load_page'] = 'client/order/detail_view';
		$this->load->view('layouts/fe_master_view', $data);
	}
}
