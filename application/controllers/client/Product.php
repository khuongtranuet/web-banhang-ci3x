<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'admin/home_model'
		));
	}

	public function detail() {
		$data['title_page'] = 'Sản phẩm';
		$data['load_page'] = 'client/product/detail_product_view';
		$this->load->view('layouts/fe_master_view', $data);
	}
}
