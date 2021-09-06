<?php


class Product_model extends CI_Model
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

	public function detail_product($id, $params = null) {
		$this->db->select(' *, product_images.id AS product_images_id,'.TBL_PRODUCTS.'.name AS product_name,'
						.TBL_PRODUCTS.'.description AS product_description,'.TBL_PRODUCTS.'.status AS product_status,'
						.TBL_PRODUCTS.'.parent_id AS product_parent,'
						.TBL_BRANDS.'.name AS brand_name,'
						.TBL_CATEGORIES.'.name AS category_name,');
		$this->db->from(TBL_PRODUCTS);
		$this->db->join(TBL_PRODUCT_IMAGES, TBL_PRODUCT_IMAGES.'.product_id = '.TBL_PRODUCTS.'.id');
		$this->db->join(TBL_BRANDS, TBL_BRANDS.'.id = '.TBL_PRODUCTS.'.brand_id');
		$this->db->join(TBL_CATEGORIES, TBL_CATEGORIES.'.id = '.TBL_PRODUCTS.'.category_id');
		if (!isset($params['product_cart'])) {
			$this->db->where(TBL_PRODUCTS . ".parent_id IS NULL");
		}
		$this->db->where(TBL_PRODUCT_IMAGES.".type = '1'");
		$this->db->where(TBL_PRODUCTS.'.id = '.$id);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function product_child($id) {
		$this->db->select(' *, '.TBL_PRODUCTS.'.id AS product_id');
		$this->db->from(TBL_PRODUCTS);
		$this->db->join(TBL_PRODUCT_IMAGES, TBL_PRODUCT_IMAGES.'.product_id = '.TBL_PRODUCTS.'.id');
		$this->db->where(TBL_PRODUCTS.'.parent_id = '.$id);
		$this->db->where(TBL_PRODUCT_IMAGES.".type = '1'");
		$query = $this->db->get();
		return $query->result_array();
	}

	public function ramdom_product_connect($id) {
		$product = $this->select(' *', TBL_PRODUCTS, ' WHERE id = '.$id);
		if (count($product) > 0) {
			$brand_id = $product[0]['brand_id'];
			$category_id = $product[0]['category_id'];
		}
		$this->db->select(' *, '.TBL_PRODUCTS.'.id AS product_id ,.'.TBL_PRODUCT_IMAGES.'.id AS product_images_id');
		$this->db->from(TBL_PRODUCTS);
		$this->db->join(TBL_PRODUCT_IMAGES, TBL_PRODUCT_IMAGES.'.product_id = .'.TBL_PRODUCTS.'.id');
		$this->db->where(TBL_PRODUCTS.'.category_id = '.$category_id);
		$this->db->where(TBL_PRODUCTS.'.brand_id = '.$brand_id);
		$this->db->where(TBL_PRODUCTS.'.parent_id IS NULL');
		$this->db->where(TBL_PRODUCT_IMAGES.'.type = 1');
		$this->db->where(TBL_PRODUCTS.'.id NOT IN ('.$id.')');
		$this->db->order_by('RAND()');
		$this->db->limit('4');
		$query = $this->db->get();
		return $query->result_array();
	}
}
