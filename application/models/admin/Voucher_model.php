<?php


class Voucher_model extends CI_Model
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
	public function voucher_list($params, $is_count) {
		$page_index = isset($params['page_index']) ? $params['page_index'] : 1;
		$page_size = isset($params['page_size']) ? $params['page_size'] : 10;
		$from = isset($params['from']) ? $params['from'] : 0;
		$keyword = isset($params['keyword']) ? $params['keyword'] : '';
		$type = isset($params['type']) ? $params['type'] : -1;
		$discount_type = isset($params['discount_type']) ? $params['discount_type'] : -1;
		$this->db->select(' *');
		$this->db->from( TBL_VOUCHERS);
		$this->db->where(TBL_VOUCHERS.".id > 0");
		if ($keyword) {
			$this->db->where(" (".TBL_VOUCHERS.".name LIKE '%" . $keyword . "%' OR ".TBL_VOUCHERS.".code LIKE '%" . $keyword . "%' 
							OR ".TBL_VOUCHERS.".discount LIKE '%" . $keyword . "%') ");
		}
		if (isset($type) && $type != -1) {
			$this->db->where(TBL_VOUCHERS.".type = '". $type. "'");
		}
		if (isset($discount_type) && $discount_type != -1) {
			$this->db->where(TBL_VOUCHERS.".discount_type = '". $discount_type. "'");
		}
		if ($is_count) {
			return $this->db->count_all_results();
		}
		$this->db->order_by(TBL_VOUCHERS.'.id', 'DESC');
		$this->db->limit($page_size, $from);
		$query = $this->db->get();

		return $query->result_array();
	}

	/**
	 * Hàm thêm mới mã giảm giá
	 */
	public function insert_voucher($data) {
		$voucher = array();
		if (isset($data['name']) && $data['name'] != null) {
			$voucher['name'] = $data['name'];
		}
		if (isset($data['code']) && $data['code'] != null) {
			$voucher['code'] = $data['code'];
		}
		if (isset($data['description']) && $data['description'] != null) {
			$voucher['information'] = $data['description'];
		}
		if (isset($data['discount']) && $data['discount'] != null) {
			$voucher['discount'] = $data['discount'];
		}
		if (isset($data['discount_type']) && $data['discount_type'] != null) {
			$voucher['discount_type'] = $data['discount_type'];
		}
		if (isset($data['condition']) && $data['condition'] != null) {
			$voucher['condition'] = $data['condition'];
		}
		if (isset($data['effective_date']) && $data['effective_date'] != null) {
			$voucher['effective_date'] = $data['effective_date'];
		}
		if (isset($data['expiration_date']) && $data['expiration_date'] != null) {
			$voucher['expiration_date'] = $data['expiration_date'];
		}
		if (isset($data['type']) && $data['type'] != null) {
			$voucher['type'] = $data['type'];
		}
		$voucher['created_at'] = date('Y-m-d H:i:s');
		$voucher['updated_at'] = date('Y-m-d H:i:s');
		$this->db->insert(TBL_VOUCHERS, $voucher);
		return '1';
	}

	/**
	 * Hàm cập nhật thông tin mã giảm giá
	 */
	public function update_voucher($data, $id) {
		$voucher = array();
		if (isset($data['name']) && $data['name'] != null) {
			$voucher['name'] = $data['name'];
		}
		if (isset($data['code']) && $data['code'] != null) {
			$voucher['code'] = $data['code'];
		}
		if (isset($data['description']) && $data['description'] != null) {
			$voucher['information'] = $data['description'];
		}
		if (isset($data['discount']) && $data['discount'] != null) {
			$voucher['discount'] = $data['discount'];
		}
		if (isset($data['discount_type']) && $data['discount_type'] != null) {
			$voucher['discount_type'] = $data['discount_type'];
		}
		if (isset($data['condition']) && $data['condition'] != null) {
			$voucher['condition'] = $data['condition'];
		}
		if (isset($data['effective_date']) && $data['effective_date'] != null) {
			$voucher['effective_date'] = $data['effective_date'];
		}
		if (isset($data['expiration_date']) && $data['expiration_date'] != null) {
			$voucher['expiration_date'] = $data['expiration_date'];
		}
		if (isset($data['type']) && $data['type'] != null) {
			$voucher['type'] = $data['type'];
		}
		$voucher['created_at'] = date('Y-m-d H:i:s');
		$voucher['updated_at'] = date('Y-m-d H:i:s');

		$this->db->where('id', $id);
		$this->db->update(TBL_VOUCHERS, $voucher);
		return '1';
	}

	/**
	 * Hàm xóa mã giảm giá
	 */
	public function delete_voucher($id) {
		$this->db->where('id', $id);
		$result = $this->db->delete(TBL_VOUCHERS);
		if (isset($result)) {
			return '1';
		}
	}
}
