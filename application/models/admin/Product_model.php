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
		$this->db->where('p.delete', 0);
		$this->db->where('p.parent_id',null);
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
		$this->db->order_by('p.id', 'desc');
		$this->db->limit($page_size, $from);

		$query = $this->db->get();

		return $query->result_array();
	}

	public function insert_product($product, $parent_id = null, $return_id = false)
	{
		$data = array();
		if ($parent_id != null) {
			$data['color'] = $product['color'];
			$data['name'] = trim($product['name']) . ' ' . trim($product['color']);
			$data['parent_id'] = $parent_id;
			$data['price'] = $product['price'];
		} else {
			$data['name'] = $product['name'];
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
		}
		$this->db->insert(TBL_PRODUCTS, $data);
		if ($return_id == true) {
			return $this->db->insert_id();
		}
	}

	public function detail($id)
	{
		$this->db->select('
			p.id,
			p.category_id,
			p.brand_id,
			p.name,
			p.price,
			p.parent_id,
			c.name as category,
			b.name as brand,
			p.description,
			p.priority,
			p.color
		');
		$this->db->from(TBL_PRODUCTS . ' AS p');
		$this->db->join(TBL_CATEGORIES . ' AS c', 'p.category_id = c.id', 'LEFT');
		$this->db->join(TBL_BRANDS . ' AS b', 'p.brand_id = b.id', 'LEFT');
		$this->db->where('p.id', $id);
		$query = $this->db->get();
		return $query->result_array();
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

	public function get_img($id, $main = false)
	{
		$this->db->select('path');
		$this->db->from(TBL_PRODUCT_IMAGES);
		if ($main == true) {
			$this->db->where('type', 1);
		} else {
			$this->db->where('type', 0);
		}
		$this->db->where('product_id', $id);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function query($select, $tbl, $param = '')
	{
		$sql = " SELECT $select FROM $tbl $param ";
		$result = $this->db->query($sql);
		return $result = $result->result_array();
	}

	public function delete_attribute($id){
		$this->db->where('product_id',$id);
		$this->db->delete(TBL_PRODUCT_ATTRIBUTE);
	}
	public  function delete_img($id,$main = false) {
		$this->db->where('product_id',$id);
		if ($main == true) {
			$this->db->where('type',1);
		} else {
			$this->db->where('type',0);
		}
		$this->db->delete(TBL_PRODUCT_IMAGES);
	}

	public function edit($product,$parent_name = null) {
		$data = array();
		if ($parent_name != null) {
			$data['color'] = $product['color'];
			$data['name'] = $parent_name . ' ' . trim($product['color']);
			$data['price'] = $product['price'];
		} else {
			$data['name'] = $product['name'];
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
		}
		$this->db->where('id',$product['id']);
		$this->db->update(TBL_PRODUCTS,$data);
	}

	public function delete($id) {
		$data = array(
			'delete' => 1
		);
		$this->db->where('id', $id);
		$this->db->update(TBL_PRODUCTS,$data);
	}
}
