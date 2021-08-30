<?php


class Product_model extends CI_Model
{
	public function product_list($params, $is_count)
	{
		$page_index = isset($params['page_index']) ? $params['page_index'] : 1;
		$page_size = isset($params['page_size']) ? $params['page_size'] : 10;
		$keyword = $params['keyword'] ? $params['keyword'] : '';
		$brand = $params['brand'] ? $params['brand'] : -1;
		$category = $params['category'] ? $params['category'] : -1;
		$from = isset($params['from']) ? $params['from'] : 0;
		$this->db->select('
			p.id,
			p.name,
			b.name as brand,
			c.name as category,
			p.price,
			p.status,
			p.sold
		');
		$this->db->from(TBL_PRODUCTS . ' AS p');
		$this->db->join(TBL_CATEGORIES . ' AS c', 'p.category_id = c.id', 'LEFT');
		$this->db->join(TBL_BRANDS . ' AS b', 'p.brand_id = b.id', 'LEFT');
		if ($keyword) {
			$this->db->like('p.name', $keyword, 'both');
		}
		if ($brand != -1) {
			$this->db->where('p.brand_id', $brand);
		}
		if ($category != -1) {
			$this->db->where('p.category_id', $category);
		}
		if ($is_count) {
			return $this->db->count_all_results();
		}
		$this->db->order_by('p.id', 'asc');
		$this->db->limit($page_size, $from);

		$query = $this->db->get();

		return $query->result_array();
	}

	public function insert_product($product, $parent_id = null, $return_id = false)
	{
		$data = array();
		if ($parent_id != null) {
			$data['color'] = $product['color'];
			$data['name'] = trim($product['name']). ' '. trim($product['color']);
			$data['parent_id'] = $parent_id;
		} else {
			$data['name'] = $product['name'];
		}
		if (isset($product['brand_id']) && $product['brand_id'] != -1) {
			$data['brand_id'] = $product['brand_id'];
		}
		if (isset($product['category_id']) && $product['category_id'] != -1) {
			$data['category_id'] = $product['category_id'];
		}
		if (isset($product['price'])) {
			$data['price'] = $product['price'];
		}
		if (isset($product['description'])) {
			$data['description'] = $product['description'];
		}
		if (isset($product['priority']) && $product['priority']) {
			$data['priority'] = $product['priority'];
		}
		$this->db->insert(TBL_PRODUCTS, $data);
		if ($return_id == true) {
			return $this->db->insert_id();
		}
	}

	public function insert_eav($product_id, $attribute_id, $value)
	{
		$data = array(
			'product_id' => $product_id,
			'attribute_id' => $attribute_id,
			'value' => $value
		);
		$this->db->insert(TBL_PRODUCT_ATTRIBUTE, $data);
	}

	public function insert_img($product_id, $img, $main = false)
	{
		$data = array(
			'product_id' => $product_id,
			'path' => $img,
		);
		if ($main == true) {
			$data['type'] = 1;
		} else {
			$data['type'] = 0;
		}

		$this->db->insert(TBL_PRODUCT_IMAGES, $data);
	}

	public function query($select, $tbl, $param = '')
	{
		$sql = " SELECT $select FROM $tbl $param ";
		$result = $this->db->query($sql);
		return $result = $result->result_array();
	}
}
