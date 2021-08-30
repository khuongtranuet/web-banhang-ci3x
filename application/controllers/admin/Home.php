<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'admin/home_model'
		));
	}

	/**
	 * Trang chủ quản trị
	 * URL: /admin/home/index
	 */
	public function index() {
		$data['title_page'] = 'Trang chủ';
		$data['load_page'] = 'admin/home/index_view';
		$this->load->view('layouts/be_master_view', $data);
	}
	/**
	 * Hàm lấy dữ liệu tỉnh/TP
	 * URL: /admin/home/province
	 */
	public function ajax_provinces() {
		$data['province'] = $this->home_model->select('*', 'provinces');
		$this->load->view('admin/home/provinces', $data);
	}
	/**
	 * Hàm lấy dữ liệu quận/huyện từ tỉnh theo ajax
	 * URL: /admin/home/ajax_district
	 */
	public function ajax_district() {
//		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
//			if (isset($_GET['province_id']))  {
//				$param['province_id'] = $_GET['province_id'];
//			}
		echo $this->input->post('id_address');
			$param['province_id'] = $this->input->post('id_address');
			$data['district'] = $this->home_model->select('*', 'districts', 'WHERE province_id = ' . $param['province_id'] . '');
			$this->load->view('admin/ajax/ajax_address_view', $data);
//			$this->load->view('admin/home/districts', $data);
//		}
	}

	/**
	 * Hàm lấy dữ liệu xã/phường từ quận/huyện theo ajax
	 * URL: /admin/home/ajax_ward
	 */
	public function ajax_ward() {
//		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
//			if (isset($_GET['district_id'])) {
//				$param['district_id'] = $_GET['district_id'];
//			}
			$param['district_id'] = $this->input->post('id_address');
			$data['ward'] = $this->home_model->select('*', 'wards', 'WHERE district_id = ' . $param['district_id'] . '');
			$this->load->view('admin/ajax/ajax_address_view', $data);
//			$this->load->view('admin/home/wards', $data);
//		}
	}
}
