<?php


class Home_model extends CI_Model
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

	public function product_list($type = null) {
		$this->db->select(' *, product_images.id AS product_images_id');
		$this->db->from(' products');
		$this->db->join('product_images', 'product_images.product_id = products.id');
		if(isset($type) && $type == 1) {
			$this->db->where("products.category_id = '1'");
		}
		if(isset($type) && $type == 2) {
			$this->db->where("products.category_id = '2'");
		}
		$this->db->where(TBL_PRODUCT_IMAGES.".type = '1'");
		$this->db->order_by('products.sold', 'DESC');
		$this->db->limit('10');
		$query = $this->db->get();
		return $query->result_array();
	}
}
