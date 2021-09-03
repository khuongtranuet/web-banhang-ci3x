<?php


class Payment_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Hàm truy vấn dữ liệu theo tham số truyền vào
	 */
	public function select($select, $tbl, $param = '') {
		$sql = " SELECT " . $select . " FROM " . $tbl . " " . $param . " ";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function change_address($data) {
		$customer_id = isset($data['customer_id']) ? $data['customer_id'] : '';
		$id = isset($data['id']) ? $data['id'] : '';
		if ($customer_id != '' && $id != '') {
			$address = array('status' => 0);
			$this->db->where('status', 1);
			$this->db->where('customer_id', $customer_id);
			$this->db->update(TBL_ADDRESSES, $address);

			$address = array('status' => 1);
			$this->db->where('customer_id', $customer_id);
			$this->db->where('id', $id);
			$this->db->update(TBL_ADDRESSES, $address);
		}
		return '1';
	}
}
