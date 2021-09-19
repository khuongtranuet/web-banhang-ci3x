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
	public function select($select, $tbl, $param = '')
	{
		$sql = " SELECT " . $select . " FROM " . $tbl . " " . $param . " ";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function change_address($data)
	{
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

	public function insert_address($data)
	{
		$address = array();
		if (isset($data['customer_id']) && $data['customer_id'] != null) {
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
		if (isset($customer_id) && $customer_id) {
			$address['created_at'] = date('Y-m-d H:i:s');
			$address['updated_at'] = date('Y-m-d H:i:s');
			$address['customer_id'] = $customer_id;
			$this->db->insert(TBL_ADDRESSES, $address);
		}
		return '1';
	}

	public function update_address($data)
	{
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

	public function delete_address($data)
	{
		$address_id = isset($data['address_id']) ? $data['address_id'] : '';
		$customer_id = isset($data['customer_id']) ? $data['customer_id'] : '';
		if ($address_id != '' && $customer_id != '') {
			$this->db->where('id', $address_id);
			$this->db->where('customer_id', $customer_id);
			$result = $this->db->delete(TBL_ADDRESSES);
			if (isset($result)) {
				return '1';
			}
		}
	}

	public function update_order($data, $is_vnpay = false)
	{
		$order = array();
		if (isset($data['customer_id']) && $data['customer_id']) {
			$order_id = $this->select(' id', TBL_ORDERS, ' WHERE customer_id = '.$data['customer_id'].' AND status = -2');
			if (isset($data['order_date']) && $data['order_date']) {
				$order['order_date'] = $data['order_date'];
			}
			if (isset($data['total_bill']) && $data['total_bill']) {
				$order['total_bill'] = $data['total_bill'];
				$order['total_pay'] = $data['total_bill'];
			}
			if (isset($data['payment_method']) && $data['payment_method']) {
				$order['payment_method'] = $data['payment_method'];
			}
			if (isset($data['payment_status']) && $data['payment_status']) {
				$order['payment_status'] = $data['payment_status'];
			}
			if (isset($data['status'])) {
				$order['status'] = $data['status'];
			}
			if (isset($data['order_code']) && $data['order_code']) {
				$order['code'] = $data['order_code'];
			}
			$order['updated_at'] = date('Y-m-d H:i:s');
			$this->db->where('customer_id', $data['customer_id']);
			$this->db->where('status', -2);
			$this->db->update(TBL_ORDERS, $order);
			if ($is_vnpay == true) {
				return $order_id[0]['id'];
			}else{
				return '1';
			}
		}
	}

	public function payment_order($data) {
		$payment = array();
		if (isset($data['order_code']) && $data['order_code']) {
			$payment['order_code'] = $data['order_code'];
		}
		if (isset($data['money']) && $data['money']) {
			$payment['money'] = $data['money'];
		}
		if (isset($data['note']) && $data['note']) {
			$payment['note'] = $data['note'];
		}
		if (isset($data['vnp_response_code']) && $data['vnp_response_code']) {
			$payment['vnp_response_code'] = $data['vnp_response_code'];
		}
		if (isset($data['code_vnpay']) && $data['code_vnpay']) {
			$payment['code_vnpay'] = $data['code_vnpay'];
		}
		if (isset($data['code_bank']) && $data['code_bank']) {
			$payment['code_bank'] = $data['code_bank'];
		}
		if (isset($data['bank_transaction']) && $data['bank_transaction']) {
			$payment['bank_transaction'] = $data['bank_transaction'];
		}
		if (isset($data['created_at']) && $data['created_at']) {
			$payment['created_at'] = $data['created_at'];
		}
		$check_exist = $this->select(' *', TBL_PAYMENTS, ' WHERE order_id = '.$data['order_id']);
		if (count($check_exist) > 0) {
			$this->db->where('order_id', $data['order_id']);
			$result = $this->db->update(TBL_PAYMENTS, $payment);
		}else{
			if (isset($data['order_id']) && $data['order_id']) {
				$payment['order_id'] = $data['order_id'];
			}
			$result = $this->db->insert(TBL_PAYMENTS, $payment);
		}
		if (isset($result)) {
			$this->db->where('code', $data['order_code']);
			$this->db->where('id', $data['order_id']);
			$this->db->update(TBL_ORDERS, ['status' => '0', 'payment_status' => 1]);
			return '1';
		}else{
			return '';
		}
	}
}
