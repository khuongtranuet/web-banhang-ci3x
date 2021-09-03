<?php


class Cart_model extends CI_Model
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

	public function product_cart($id) {
		$this->db->select(' *');
		$this->db->from( TBL_CUSTOMER_PRODUCT);
		$this->db->join( TBL_PRODUCTS, TBL_CUSTOMER_PRODUCT.'.product_id = '.TBL_PRODUCTS.'.id');
		$this->db->join( TBL_PRODUCT_IMAGES, TBL_PRODUCT_IMAGES.'.product_id = '.TBL_PRODUCTS.'.id');
		$this->db->where(TBL_CUSTOMER_PRODUCT.'.customer_id = '.$id);
		$this->db->where(TBL_PRODUCT_IMAGES.'.type = 1');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function update_product($data) {
		$product_id = isset($data['product_id']) ? $data['product_id'] : '';
		$quantity = isset($data['quantity']) ? $data['quantity'] : '';
		$customer_id = isset($data['customer_id']) ? $data['customer_id'] : '';
		$is_delete = isset($data['is_delete']) ? $data['is_delete'] : '';
		if (is_array($product_id) && $is_delete == true && $customer_id != '') {
			for($i = 0; $i < count($product_id); $i++) {
				$this->db->where('customer_id', $customer_id);
				$this->db->where('product_id', $product_id[$i]);
				$result = $this->db->delete(TBL_CUSTOMER_PRODUCT);
			}
		}elseif (is_array($product_id) && is_array($quantity) && $customer_id != '') {

		}else{
			if ($product_id != '' && $quantity != '' && $customer_id != '' && $quantity > 0) {
				$product_cart = array();
				$product_cart['quantity'] = $quantity;
				$this->db->where('customer_id', $customer_id);
				$this->db->where('product_id', $product_id);
				$this->db->update( TBL_CUSTOMER_PRODUCT, $product_cart);
			}else{
				$this->db->where('customer_id', $customer_id);
				$this->db->where('product_id', $product_id);
				$result = $this->db->delete(TBL_CUSTOMER_PRODUCT);
			}
		}
		return '1';
	}

	public function delete_cart($data) {
		$product_id = isset($data['product_id']) ? $data['product_id'] : '';
		$customer_id = isset($data['customer_id']) ? $data['customer_id'] : '';
		if ($product_id != '' && $customer_id != '') {
			$this->db->where('customer_id', $customer_id);
			$this->db->where('product_id', $product_id);
			$result = $this->db->delete(TBL_CUSTOMER_PRODUCT);
			if (isset($result)) {
				return '1';
			}
		}
	}
}
