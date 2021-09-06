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

	public function insert_address($data) {
		$address = array();
		if(isset($data['customer_id']) && $data['customer_id'] != null) {
			$customer_id = $data['customer_id'];
			$address_old = array('status' => 0);
			$this->db->where('status', 1);
			$this->db->where('customer_id', $customer_id);
			$this->db->update(TBL_ADDRESSES, $address_old);
		}
		if (isset($data['fullname']) && $data['fullname'] != null) {
			$address['fullname'] = $data['fullname'];
		}
		if (isset($data['mobile']) && $data['mobile'] != null) {
			$address['mobile'] = $data['mobile'];
		}
		if (isset($data['province']) && $data['province'] != null) {
			$address['province_id'] = $data['province'];
		}
		if (isset($data['district']) && $data['district'] != null) {
			$address['district_id'] = $data['district'];
		}
		if (isset($data['ward']) && $data['ward'] != null) {
			$address['ward_id'] = $data['ward'];
		}
		if (isset($data['address']) && $data['address'] != null) {
			$address['address'] = $data['address'];
		}
		if (isset($data['type_address']) && $data['type_address'] != null) {
			$address['type'] = $data['type_address'];
		}
		$address['status'] = 1;
		if(isset($customer_id) && $customer_id) {
			$address['created_at'] = date('Y-m-d H:i:s');
			$address['updated_at'] = date('Y-m-d H:i:s');
			$address['customer_id'] = $customer_id;
			$this->db->insert(TBL_ADDRESSES, $address);
		}
		return '1';
	}

	public function update_address($data) {
		$address = array();
		if (isset($data['fullname']) && $data['fullname'] != null) {
			$address['fullname'] = $data['fullname'];
		}
		if (isset($data['mobile']) && $data['mobile'] != null) {
			$address['mobile'] = $data['mobile'];
		}
		if (isset($data['province']) && $data['province'] != null) {
			$address['province_id'] = $data['province'];
		}
		if (isset($data['district']) && $data['district'] != null) {
			$address['district_id'] = $data['district'];
		}
		if (isset($data['ward']) && $data['ward'] != null) {
			$address['ward_id'] = $data['ward'];
		}
		if (isset($data['address']) && $data['address'] != null) {
			$address['address'] = $data['address'];
		}
		if (isset($data['type_address']) && $data['type_address'] != null) {
			$address['type'] = $data['type_address'];
		}
		if (isset($data['customer_id']) && $data['customer_id'] != null) {
			$this->db->where('customer_id', $data['customer_id']);
		}
		if (isset($data['address_id']) && $data['address_id'] != null) {
			$this->db->where('id', $data['address_id']);
		}
		$this->db->update(TBL_ADDRESSES, $address);
		return '1';
	}

	public function delete_address($data) {
		$address_id = isset($data['address_id']) ? $data['address_id'] : '';
		$customer_id = isset($data['customer_id']) ? $data['customer_id'] : '';
		if($address_id != '' && $customer_id != '') {
			$this->db->where('id', $address_id);
			$this->db->where('customer_id', $customer_id);
			$result = $this->db->delete(TBL_ADDRESSES);
			if (isset($result)) {
				return '1';
			}
		}
	}
}
