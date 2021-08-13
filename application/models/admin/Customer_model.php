<?php


class Customer_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function customer_list($params, $is_count) {
		$page_index = isset($params['page_index']) ? $params['page_index'] : 1;
		$page_size = isset($params['page_size']) ? $params['page_size'] : 10;
		$from = isset($params['from']) ? $params['from'] : 0;
		$keyword = isset($params['keyword']) ? $params['keyword'] : '';
		$type = isset($params['type']) ? $params['type'] : -1;
		$status = isset($params['status']) ? $params['status'] : -1;
		$this->db->select(' *');
		$this->db->from( TBL_CUSTOMERS);
		$this->db->where(" customers.id > 0");
		if ($keyword) {
			$this->db->where(" (customers.fullname LIKE '%" . $keyword . "%' OR customers.email LIKE '%" . $keyword . "%' 
							OR customers.mobile LIKE '%" . $keyword . "%') ");
		}
		if (isset($type) && $type != -1) {
			$this->db->where(" customers.type = '". $type. "'");
		}
		if (isset($status) && $status != -1) {
			$this->db->where(" customers.status = '". $status. "'");
		}
		if ($is_count) {
			return $this->db->count_all_results();
		}
		$this->db->order_by('customers.id', 'desc');
		$this->db->limit($page_size, $from);
		$query = $this->db->get();

		return $query->result_array();
	}
}
