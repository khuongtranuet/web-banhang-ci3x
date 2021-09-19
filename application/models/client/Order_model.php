<?php


class Order_model extends CI_Model
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
	 * Hàm lấy danh sách đơn hàng
	 */
	public function order_list($params, $is_count) {
		$page_index = isset($params['page_index']) ? $params['page_index'] : 1;
		$page_size = isset($params['page_size']) ? $params['page_size'] : 10;
		$from = isset($params['from']) ? $params['from'] : 0;
		$customer_id = isset($params['customer_id']) ? $params['customer_id'] : '';
		$this->db->select(' *');
		$this->db->from( TBL_ORDERS);
		$this->db->where(TBL_ORDERS.".id > 0");
		$this->db->where(TBL_ORDERS.".status != -2");
		if (isset($customer_id) && $customer_id != '') {
			$this->db->where(TBL_ORDERS.'.customer_id = '.$customer_id);
		}
		if ($is_count) {
			return $this->db->count_all_results();
		}
		$this->db->order_by(TBL_ORDERS.'.id', 'desc');
		$this->db->limit($page_size, $from);
		$query = $this->db->get();

		return $query->result_array();
	}

	/**
	 * Hàm lấy thông tin chi tiết đơn hàng
	 */
	public function detail_order($id) {
		if (isset($id) && $id != '') {
			$this->db->select(' *, '.TBL_ORDERS.'.status AS order_status, '.TBL_ORDERS.'.code AS order_code, ');
			$this->db->from(TBL_ORDERS);
			$this->db->join(TBL_ADDRESSES, TBL_ADDRESSES.'.id = '.TBL_ORDERS.'.address_id');
			$this->db->join(TBL_WARDS, TBL_WARDS.'.id = '.TBL_ADDRESSES.'.ward_id');
			$this->db->where(TBL_ORDERS.'.id = '.$id);
			$query = $this->db->get();

			return $query->result_array();
		}
	}

	/**
	 * Hàm lấy thông tin các sản phẩm từng đơn hàng
	 */
	public function order_product($id) {
		if (isset($id) && $id != '') {
			$this->db->select(' *');
			$this->db->from(TBL_ORDER_PRODUCT);
			$this->db->join(TBL_PRODUCTS, TBL_PRODUCTS.'.id = '.TBL_ORDER_PRODUCT.'.product_id');
			$this->db->join(TBL_PRODUCT_IMAGES, TBL_PRODUCT_IMAGES.'.product_id = '.TBL_PRODUCTS.'.id');
			$this->db->where(TBL_ORDER_PRODUCT.'.order_id = '.$id);
			$this->db->where(TBL_PRODUCT_IMAGES.'.type = 1');
			$query = $this->db->get();

			return $query->result_array();
		}
	}
}
