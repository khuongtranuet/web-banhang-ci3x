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
		$this->db->select('*, addresses.type AS address_type, addresses.status AS address_status, addresses.id AS address_id,
						addresses.mobile AS address_mobile, addresses.fullname AS address_fullname,
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
		if($is_count != '' && is_numeric($is_count)) {
			$this->db->where(TBL_ADDRESSES.'.id ='.$is_count);
		}
		if($is_count == true) {
			$this->db->group_by('addresses.customer_id');
		}
		$this->db->order_by('addresses.status', 'DESC');
		$query = $this->db->get();

		return $query->result_array();
	}

	/**
	 * Hàm thêm mới khách hàng
	 */
	public function insert_customer($data, $is_customer = false) {
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
		if (isset($data['type']) && $data['type'] != null) {
			$customer['type'] = $data['type'];
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
		if (isset($data['fullname_address']) && $data['fullname_address'] != null) {
			$address['fullname'] = $data['fullname_address'];
		}
		if (isset($data['mobile_address']) && $data['mobile_address'] != null) {
			$address['mobile'] = $data['mobile_address'];
		}
		if (isset($data['type_address']) && $data['type_address'] != null) {
			$address['type'] = $data['type_address'];
		}
		if (isset($data['status_address']) && $data['status_address'] != null) {
			$address['status'] = $data['status_address'];
		}
		if (isset($data['fullname']) && $data['fullname'] != null) {
			$address['fullname'] = $data['fullname'];
		}
		if (isset($data['mobile']) && $data['mobile'] != null) {
			$address['mobile'] = $data['mobile'];
		}
		$address['created_at'] = date('Y-m-d H:i:s');
		$address['updated_at'] = date('Y-m-d H:i:s');

		$id_customer = $this->select(' *', TBL_CUSTOMERS, ' WHERE mobile = '.$data['mobile']);
		$update = array('status' => 0,);
		$this->db->where('customer_id', $id_customer[0]['id']);
		$this->db->update(TBL_ADDRESSES, $update);
		if ($is_customer == true) {
			$check_exist = $this->select(' *, '.TBL_ORDERS.'.status AS order_status, '.TBL_ORDERS.'.id AS order_id'
				, TBL_CUSTOMERS, 'JOIN '.TBL_ADDRESSES.' ON '.TBL_ADDRESSES.'.customer_id
			 = '.TBL_CUSTOMERS.'.id
			  JOIN '.TBL_ORDERS.' ON '.TBL_ORDERS.'.customer_id = '.TBL_CUSTOMERS.'.id AND '.TBL_ORDERS.'.address_id = '.TBL_ADDRESSES.'.id WHERE '.TBL_CUSTOMERS.'.mobile = '.$data['mobile'].' 
			  AND '.TBL_ORDERS.'.status = -2');
			if (count($check_exist) > 0) {
				$check_address = $this->select(' *', TBL_ORDERS, ' WHERE address_id = '.$check_exist[0]['address_id']);
				if (count($check_address) == 1 && $check_address[0]['status'] = -2) {
					$check_address_customer = $this->select(' *', TBL_ADDRESSES, ' WHERE customer_id = '.$check_address[0]['customer_id']);
					if (count($check_address_customer) == 1) {
						$this->db->where('order_id', $check_exist[0]['order_id']);
						$this->db->delete(TBL_ORDER_PRODUCT);

						$this->db->where('id', $check_exist[0]['order_id']);
						$this->db->delete(TBL_ORDERS);

						$this->db->where('id', $check_address[0]['address_id']);
						$this->db->delete(TBL_ADDRESSES);

						$this->db->where('id', $check_address_customer[0]['customer_id']);
						$this->db->delete(TBL_CUSTOMERS);
					}elseif (count($check_address_customer) > 1) {
						$this->db->where('order_id', $check_exist[0]['order_id']);
						$this->db->delete(TBL_ORDER_PRODUCT);

						$this->db->where('id', $check_exist[0]['order_id']);
						$this->db->delete(TBL_ORDERS);

						$this->db->where('id', $check_address[0]['address_id']);
						$this->db->delete(TBL_ADDRESSES);
					}
				}elseif (count($check_address) > 1) {
					$this->db->where('order_id', $check_exist[0]['order_id']);
					$this->db->delete(TBL_ORDER_PRODUCT);

					$this->db->where('id', $check_exist[0]['order_id']);
					$this->db->delete(TBL_ORDERS);
				}
			}
			$check_customer_exist = $this->select(' *', TBL_CUSTOMERS, ' WHERE mobile = '.$data['mobile']);
			if (count($check_customer_exist) > 0) {
				$check_address_exist = $this->select(' *', TBL_ADDRESSES, ' WHERE customer_id = '.$check_customer_exist[0]['id'].' AND mobile = '
				.$data['mobile']);
				if (count($check_address_exist) > 0) {
					for ($i = 0; $i < count($check_address_exist); $i++) {
						if ($check_address_exist[$i]['province_id'] == $data['province'] && $check_address_exist[$i]['district_id'] == $data['district'] &&
							$check_address_exist[$i]['ward_id'] == $data['ward']) {
							$update_address = array(
								'fullname' => $data['fullname'],
								'address' => $data['address'],
							);
							$this->db->where('id', $check_address_exist[$i]['id']);
							$this->db->update(TBL_ADDRESSES, $update_address);
							$params['address_id'] = $check_address_exist[$i]['id'];
							$is_update = true;
						}
					}
					if (!isset($is_update)) {
						$address['customer_id'] = $check_customer_exist[0]['id'];
						$this->db->insert(TBL_ADDRESSES, $address);
						$params['address_id'] = $this->db->insert_id();
					}
//					if ($check_address_exist[0]['province_id'] == $data['province'] && $check_address_exist[0]['district_id'] == $data['district'] &&
//						$check_address_exist[0]['ward_id'] == $data['ward']) {
//						$update_address = array(
//							'fullname' => $data['fullname'],
//							'address' => $data['address'],
//						);
//						$this->db->where('id', $check_address_exist[0]['id']);
//						$this->db->update(TBL_ADDRESSES, $update_address);
//						$params['address_id'] = $check_address_exist[0]['id'];
//					}else{
//						$address['customer_id'] = $check_customer_exist[0]['id'];
//						$this->db->insert(TBL_ADDRESSES, $address);
//						$params['address_id'] = $this->db->insert_id();
//					}
				}else{
					$address['customer_id'] = $check_customer_exist[0]['id'];
					$this->db->insert(TBL_ADDRESSES, $address);
					$params['address_id'] = $this->db->insert_id();
				}
				$params['customer_id'] = $check_customer_exist[0]['id'];
			}else{
				$this->db->insert(TBL_CUSTOMERS, $customer);
				$params['customer_id'] = $this->db->insert_id();
				$address['customer_id'] = $params['customer_id'];
				$this->db->insert('addresses', $address);
				$params['address_id'] = $this->db->insert_id();
			}
		}
		if($is_customer == true) {
			$_SESSION['customer_id'] = $params['customer_id'];
			$passersby = array();
			$passersby['customer_id'] = $params['customer_id'];
			$passersby['address_id'] = $params['address_id'];
			if (isset($_SESSION['product_id'])) {
				$passersby['product_id'] = $_SESSION['product_id'];
			}
			if (isset($_SESSION['quantity'])) {
				$passersby['quantity'] = $_SESSION['quantity'];
			}
			$this->insert_order_passersby($passersby);
		}
		return '1';
	}

	public function insert_order_passersby($data) {
		$product_id = isset($data['product_id']) ? $data['product_id'] : '';
		$quantity = isset($data['quantity']) ? $data['quantity'] : '';
		$customer_id = isset($data['customer_id']) ? $data['customer_id'] : '';
		if (is_array($product_id) && is_array($quantity) && $customer_id != '') {
			$address_id = isset($data['address_id']) ? $data['address_id'] : '';
			if ($address_id != '') {
				$order_exist = $this->select('*', TBL_ORDERS, 'WHERE customer_id = ' . $customer_id . ' AND status = -2');
				if (count($order_exist) > 0) {
					$order_id = $order_exist[0]['id'];
					$this->db->where('order_id', $order_id);
					$this->db->delete(TBL_ORDER_PRODUCT);

					$this->db->set('address_id', $address_id);
					$this->db->where('id', $order_id);
					$this->db->update(TBL_ORDERS);
					foreach ($product_id as $key => $value) {
						$product_detail = $this->select('*', TBL_PRODUCTS, ' WHERE id = ' . $product_id[$key]);
						$order_product = array(
							'product_id' => $product_id[$key],
							'order_id' => $order_id,
							'quantity' => $quantity[$key],
							'unit_price' => $product_detail[0]['price'],
							'total_price' => $product_detail[0]['price'] * $quantity[$key],
							'created_at' => date('Y-m-d H:i:s'),
							'updated_at' => date('Y-m-d H:i:s'),
						);
						$this->db->insert(TBL_ORDER_PRODUCT, $order_product);
					}
				} else {
					$code = ramdomOrderNumber();
					$order = array(
						'customer_id' => $customer_id,
						'address_id' => $address_id,
						'code' => $code,
						'status' => -2,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s'),
					);
					$this->db->insert(TBL_ORDERS, $order);
					$order_id = $this->db->insert_id();
					foreach ($product_id as $key => $value) {
						$product_detail = $this->select('*', TBL_PRODUCTS, ' WHERE id = ' . $product_id[$key]);
						$order_product = array(
							'product_id' => $product_id[$key],
							'order_id' => $order_id,
							'quantity' => $quantity[$key],
							'unit_price' => $product_detail[0]['price'],
							'total_price' => $product_detail[0]['price'] * $quantity[$key],
							'created_at' => date('Y-m-d H:i:s'),
							'updated_at' => date('Y-m-d H:i:s'),
						);
						$this->db->insert(TBL_ORDER_PRODUCT, $order_product);
					}
				}
			}
		}
	}

	/**
	 * Hàm cập nhật thông tin khách hàng
	 */
	public function update_customer($data, $id, $params = null) {
		$customer = array();
		$address = array();
		if (isset($data['avatar']) && $data['avatar'] != null) {
			$customer['avatar'] = $data['avatar'];
		}
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
		if (isset($data['fullname_address']) && $data['fullname_address'] != null) {
			$address['fullname'] = $data['fullname_address'];
		}
		if (isset($data['mobile_address']) && $data['mobile_address'] != null) {
			$address['mobile'] = $data['mobile_address'];
		}
		if (isset($data['type_address']) && $data['type_address'] != null) {
			$address['type'] = $data['type_address'];
		}
		if (isset($data['status_address']) && $data['status_address'] != null) {
			$address['status'] = $data['status_address'];
		}
		if (!isset($params['update_client'])) {
			$address['created_at'] = date('Y-m-d H:i:s');
			$address['updated_at'] = date('Y-m-d H:i:s');
		}

		$this->db->where('id', $id);
//		$sql = $this->db->set($customer)->get_compiled_update('customers');
//		echo $sql;
		$this->db->update('customers', $customer);
		if (!isset($params['update_client'])) {
			$address_id = $this->select('*', 'addresses', "WHERE customer_id = '" . $id . "' AND status = '1'");
			$address_id = $address_id[0]['id'];
			$this->db->where('id', $address_id);
			$this->db->update('addresses', $address);
		}
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
}
