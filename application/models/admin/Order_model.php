<?php


class Order_model extends CI_Model
{
	public function order_list($params, $is_count)
	{
		$page_index = isset($params['page_index']) ? $params['page_index'] : 1;
		$page_size = isset($params['page_size']) ? $params['page_size'] : 10;
		$keyword = $params['keyword'] ? $params['keyword'] : '';
		$payment_status = $params['payment_status'] ? $params['payment_status'] : -1;
		$order_date = $params['order_date'] ? $params['order_date'] : '';
		$from = isset($params['from']) ? $params['from'] : 0;
		$this->db->select('
			o.id,
			o.code,
			c.fullname,
			o.total_pay,
			o.order_date,
			o.payment_status		
		');
		$this->db->from(TBL_ORDERS . ' AS o');
		$this->db->join(TBL_CUSTOMERS . ' AS c', 'o.customer_id = c.id', 'LEFT');
		$this->db->where('o.delete', 0);
		if ($keyword) {
			$this->db->like('o.code', $keyword, 'both');
		}
		if ($payment_status != -1) {
			$this->db->where('o.payment_status', $payment_status);
		}
		if ($order_date) {
			$this->db->where('o.order_date', $order_date);
		}
		if ($is_count) {
			return $this->db->count_all_results();
		}
		$this->db->order_by('o.id', 'desc');
		$this->db->limit($page_size, $from);

		$query = $this->db->get();

		return $query->result_array();
	}

	public function query($select, $tbl, $param = '')
	{
		$sql = " SELECT $select FROM $tbl $param ";
		$result = $this->db->query($sql);

		return $result = $result->result_array();
	}

	public function insert_order($order)
	{
		$data = array(
			'status' => 0,
			'order_date' => date("Y-m-d H:i:s")
		);
		$data['code'] = date('md') . substr(implode(NULL,
				array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
		if (isset($order['customer_id']) && $order['customer_id'] != -1) {
			$data['customer_id'] = $order['customer_id'];
		}
		if (isset($order['address_id']) && $order['address_id'] != -1) {
			$data['address_id'] = $order['address_id'];
		}
		if (isset($order['repository_id']) && $order['repository_id'] != -1) {
			$data['repository_id'] = $order['repository_id'];
		}
		if (isset($order['payment_method']) && $order['payment_method']) {
			$data['payment_method'] = $order['payment_method'];
		}
		if (isset($order['payment_status']) && $order['payment_status']) {
			$data['payment_status'] = $order['payment_status'];
		}
		$this->db->insert(TBL_ORDERS, $data);
		return $this->db->insert_id();
	}

	public function insert_order_product($product)
	{
		$data = array(
			'order_id' => $product['order_id'],
			'product_id' => $product['product_id'],
			'quantity' => $product['quantity'],
			'unit_price' => $product['unit_price'],
			'total_price' => $product['total_price']
		);
		$this->db->insert(TBL_ORDER_PRODUCT, $data);
	}

	public function update_money($money, $id)
	{
		$data = array(
			'total_bill' => $money['total_bill'],
			'total_pay' => $money['total_pay'],
			'discount' => $money['discount']
		);
		$this->db->where('id', $id);
		$this->db->update(TBL_ORDERS, $data);
	}

	public function insert_order_voucher($order_id, $voucher_id)
	{
		$data = array(
			'order_id' => $order_id,
			'voucher_id' => $voucher_id
		);
		return $this->db->insert(TBL_ORDER_VOUCHER, $data);
	}

	public function delete($id)
	{
		$data = array(
			'delete' => 1
		);
		$this->db->where('id', $id);
		$this->db->update(TBL_ORDERS, $data);
	}

	public function edit($order)
	{
		$data = array(
			'status' => 0,
			'order_date' => date("Y-m-d H:i:s")
		);
		if (isset($order['customer_id']) && $order['customer_id'] != -1) {
			$data['customer_id'] = $order['customer_id'];
		}
		if (isset($order['address_id']) && $order['address_id'] != -1) {
			$data['address_id'] = $order['address_id'];
		}
		if (isset($order['repository_id']) && $order['repository_id'] != -1) {
			$data['repository_id'] = $order['repository_id'];
		}
		if (isset($order['payment_method']) && $order['payment_method']) {
			$data['payment_method'] = $order['payment_method'];
		}
		if (isset($order['payment_status']) && $order['payment_status']) {
			$data['payment_status'] = $order['payment_status'];
		}
		$this->db->where('id', $order['id']);
		return $this->db->update(TBL_ORDERS, $data);
	}

	public function delete_product($id)
	{
		$this->db->where('order_id', $id);
		return $this->db->delete(TBL_ORDER_PRODUCT);
	}

	public function delete_voucher($id)
	{
		$this->db->where('order_id', $id);
		return $this->db->delete(TBL_ORDER_VOUCHER
		);
	}

	public function detail($id)
	{
		$this->db->select('
			o.id,
			c.fullname,
			a.address,
			o.code,
			r.name,
			o.order_date,
			o.total_bill,
			o.discount,
			o.total_pay,
			o.payment_status,
			o.payment_method,
		');
		$this->db->from(TBL_ORDERS . ' AS o');
		$this->db->join(TBL_CUSTOMERS . ' AS c', 'o.customer_id=c.id', 'LEFT');
		$this->db->join(TBL_REPOSITORIES . ' AS r', 'o.repository_id=r.id', 'LEFT');
		$this->db->join(TBL_ADDRESSES . ' AS a', 'o.address_id=a.id', 'LEFT');
		$this->db->where('o.id', $id);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function voucher($order_id)
	{
		$this->db->select('v.name');
		$this->db->from(TBL_ORDER_VOUCHER . ' AS o');
		$this->db->join(TBL_VOUCHERS . ' AS v', 'o.voucher_id=v.id', 'LEFT');
		$this->db->where('v.type', 0);
		$this->db->where('o.order_id', $order_id);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_order_product($id)
	{
		$this->db->select('
		 	p.name,
		 	o.quantity,
		 	o.unit_price,
		 	o.total_price,
		');
		$this->db->from(TBL_ORDER_PRODUCT . ' AS o');
		$this->db->join(TBL_PRODUCTS . ' AS p', 'o.product_id = p.id', 'LEFT');
		$this->db->where('o.order_id', $id);
		$query = $this->db->get();
		return $query->result_array();
	}
}
