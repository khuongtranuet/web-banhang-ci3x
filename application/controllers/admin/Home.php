<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index() {
		$data['title_page'] = 'Trang chủ';
		$data['load_page'] = 'admin/home/index_view';
		$this->load->view('layouts/be_master_view', $data);
	}
}
