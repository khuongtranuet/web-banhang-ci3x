<?php


class Customer_model extends CI_Model
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

	/**
	 * Hàm lấy danh sách khách hàng
	 */
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

	/**
	 * Hàm truy vấn địa chỉ của khách hàng
	 */
	public function address_customer($id, $is_count, $status_address = false) {
		$this->db->select('*, addresses.type AS address_type, addresses.status AS address_status,
						provinces.id AS province_id, provinces.code AS province_code, provinces.name AS province_name, provinces.type AS province_type,
						districts.id AS district_id, districts.name AS district_name, districts.code AS district_code, districts.type AS district_type,
						wards.id AS ward_id, wards.name AS ward_name, wards.code AS ward_code, wards.type AS ward_type');
		$this->db->from('addresses');
		$this->db->join('provinces', 'provinces.id = addresses.province_id');
		$this->db->join('districts', 'districts.id = addresses.district_id');
		$this->db->join('wards', 'wards.id = addresses.ward_id');
		$this->db->join('customers', 'customers.id = addresses.customer_id');
		$this->db->where('customers.id = '.$id.'');
		if($status_address == true) {
			$this->db->where("addresses.status = '1'");
		}
		if($is_count == true) {
			$this->db->group_by('addresses.customer_id');
		}
		$query = $this->db->get();

		return $query->result_array();
	}

	/**
	 * Hàm thêm mới khách hàng
	 */
	public function insert_customer($data) {
		$customer = array();
		$address = array();
		if (isset($data['fullname']) && $data['fullname'] != null) {
			$customer['fullname'] = $data['fullname'];
		}
		if (isset($data['birthday']) && $data['birthday'] != null) {
			$customer['birthday'] = $data['birthday'];
		}
		if (isset($data['mobile']) && $data['mobile'] != null) {
			$customer['mobile'] = $data['mobile'];
		}
		if (isset($data['email']) && $data['email'] != null) {
			$customer['email'] = $data['email'];
		}
		if (isset($data['gender']) && $data['gender'] != null) {
			$customer['gender'] = $data['gender'];
		}
		if (isset($data['password']) && $data['password'] != null) {
			$customer['password'] = $data['password'];
		}
		if (isset($data['status']) && $data['status'] != null) {
			$customer['status'] = $data['status'];
		}
		$customer['created_at'] = date('Y-m-d H:i:s');
		$customer['updated_at'] = date('Y-m-d H:i:s');
		$this->db->insert('customers', $customer);
		$customer_id = $this->db->insert_id();
		if (isset($data['total_address'])) {
			for ($i = 0; $i < $data['total_address']; $i++) {
				if (isset($data['province'.$i.'']) && $data['province'.$i.''] != null) {
					$address[$i]['province_id'] = $data['province'.$i.''];
				}
				if (isset($data['district'.$i.'']) && $data['district'.$i.''] != null) {
					$address[$i]['district_id'] = $data['district'.$i.''];
				}
				if (isset($data['ward'.$i.'']) && $data['ward'.$i.''] != null) {
					$address[$i]['ward_id'] = $data['ward'.$i.''];
				}
				if (isset($data['address'.$i.'']) && $data['address'.$i.''] != null) {
					$address[$i]['address'] = $data['address'.$i.''];
				}
				if (isset($data['type_address'.$i.'']) && $data['type_address'.$i.''] != null) {
					$address[$i]['type'] = $data['type_address'.$i.''];
				}
				if (isset($data['status_address'.$i.'']) && $data['status_address'.$i.''] != null) {
					$address[$i]['status'] = $data['status_address'.$i.''];
				}
				$address[$i]['created_at'] = date('Y-m-d H:i:s');
				$address[$i]['updated_at'] = date('Y-m-d H:i:s');
				$address[$i]['customer_id'] = $customer_id;
				$this->db->insert('addresses', $address[$i]);
			}
		}
		return '1';
	}

	/**
	 * Hàm cập nhật thông tin khách hàng
	 */
	public function update_customer($data, $id) {
		$customer = array();
		$address = array();
		if (isset($data['fullname']) && $data['fullname'] != null) {
			$customer['fullname'] = $data['fullname'];
		}
		if (isset($data['birthday']) && $data['birthday'] != null) {
			$customer['birthday'] = $data['birthday'];
		}
		if (isset($data['mobile']) && $data['mobile'] != null) {
			$customer['mobile'] = $data['mobile'];
		}
		if (isset($data['email']) && $data['email'] != null) {
			$customer['email'] = $data['email'];
		}
		if (isset($data['gender']) && $data['gender'] != null) {
			$customer['gender'] = $data['gender'];
		}
		if (isset($data['password']) && $data['password'] != null) {
			$customer['password'] = $data['password'];
		}
		if (isset($data['status']) && $data['status'] != null) {
			$customer['status'] = $data['status'];
		}
		$customer['created_at'] = date('Y-m-d H:i:s');
		$customer['updated_at'] = date('Y-m-d H:i:s');

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
		if (isset($data['status_address']) && $data['status_address'] != null) {
			$address['status'] = $data['status_address'];
		}
		$address['created_at'] = date('Y-m-d H:i:s');
		$address['updated_at'] = date('Y-m-d H:i:s');

		$this->db->where('id', $id);
//		$sql = $this->db->set($customer)->get_compiled_update('customers');
//		echo $sql;
		$this->db->update('customers', $customer);
		$address_id = $this->select('*', 'addresses', "WHERE customer_id = '".$id."' AND status = '1'");
		$address_id = $address_id[0]['id'];
		$this->db->where('id', $address_id);
		$this->db->update('addresses', $address);
		return '1';
	}

	/**
	 * Hàm xóa khách hàng
	 */
	public function delete_customer($id) {
		$sql = " DELETE FROM addresses WHERE customer_id IN";
		$sql .= " (SELECT customers.id FROM customers WHERE customers.id=" . $id . ");";
		$result = $this->db->query($sql);

		$this->db->where('id', $id);
		$result = $this->db->delete('customers');
		if (isset($result)) {
			return '1';
		}
	}

	public function register_customer($data) {
		$customer = array();
		if (isset($data['fullname']) && $data['fullname'] != null) {
			$customer['fullname'] = $data['fullname'];
		}
		if (isset($data['mobile']) && $data['mobile'] != null) {
			$customer['mobile'] = $data['mobile'];
		}
		if (isset($data['email']) && $data['email'] != null) {
			$customer['email'] = $data['email'];
		}
		if (isset($data['password']) && $data['password'] != null) {
			$customer['password'] = $data['password'];
		}
		if (isset($data['status']) && $data['status'] != null) {
			$customer['status'] = '1';
		}
		$customer['created_at'] = date('Y-m-d H:i:s');
		$customer['updated_at'] = date('Y-m-d H:i:s');
		$this->db->insert('customers', $customer);
		return '1';
	}
}
