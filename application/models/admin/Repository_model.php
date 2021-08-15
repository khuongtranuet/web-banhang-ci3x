<?php


class Repository_model extends CI_Model
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
	 * Hàm lấy danh sách kho hàng
	 */
	public function repository_list($params, $is_count) {
		$page_index = isset($params['page_index']) ? $params['page_index'] : 1;
		$page_size = isset($params['page_size']) ? $params['page_size'] : 10;
		$from = isset($params['from']) ? $params['from'] : 0;
		$keyword = isset($params['keyword']) ? $params['keyword'] : '';
		$this->db->select(' *, repositories.name AS name,repositories.id as id,
			provinces.id AS province_id, provinces.code AS province_code, provinces.name AS province_name, provinces.type AS province_type,
			districts.id AS district_id, districts.name AS district_name, districts.code AS district_code, districts.type AS district_type,
			wards.id AS ward_id, wards.name AS ward_name, wards.code AS ward_code, wards.type AS ward_type');
		$this->db->from( TBL_REPOSITORIES);
		$this->db->join('provinces', 'provinces.id = repositories.province_id');
		$this->db->join('districts', 'districts.id = repositories.district_id');
		$this->db->join('wards', 'wards.id = repositories.ward_id');
		$this->db->where(" repositories.id > 0");
		if ($keyword) {
			$this->db->where(" (repositories.name LIKE '%" . $keyword . "%' OR repositories.address LIKE '%" . $keyword . "%' 
								OR repositories.mobile LIKE '%" . $keyword . "%') ");
		}

		if ($is_count) {
			return $this->db->count_all_results();
		}
		$this->db->order_by('repositories.id', 'desc');
		$this->db->limit($page_size, $from);
		$query = $this->db->get();
		return $query->result_array();
	}

	/**
	 * Hàm truy vấn địa chỉ của khách hàng
	 */
	public function address_repository($id) {
		$this->db->select(' *, repositories.name AS name,repositories.id as id,
			provinces.id AS province_id, provinces.code AS province_code, provinces.name AS province_name, provinces.type AS province_type,
			districts.id AS district_id, districts.name AS district_name, districts.code AS district_code, districts.type AS district_type,
			wards.id AS ward_id, wards.name AS ward_name, wards.code AS ward_code, wards.type AS ward_type');
		$this->db->from( TBL_REPOSITORIES);
		$this->db->join('provinces', 'provinces.id = repositories.province_id');
		$this->db->join('districts', 'districts.id = repositories.district_id');
		$this->db->join('wards', 'wards.id = repositories.ward_id');
		$this->db->where(" repositories.id = '".$id."'");
		$query = $this->db->get();
		return $query->result_array();
	}

	/**
	 * Hàm thêm mới kho hàng
	 */
	public function insert_repository($data) {
		$repository = array();
		if (isset($data['name']) && $data['name'] != null) {
			$repository['name'] = $data['name'];
		}
		if (isset($data['mobile']) && $data['mobile'] != null) {
			$repository['mobile'] = $data['mobile'];
		}
		if (isset($data['province']) && $data['province'] != null) {
			$repository['province_id'] = $data['province'];
		}
		if (isset($data['district']) && $data['district'] != null) {
			$repository['district_id'] = $data['district'];
		}
		if (isset($data['ward']) && $data['ward'] != null) {
			$repository['ward_id'] = $data['ward'];
		}
		if (isset($data['address']) && $data['address'] != null) {
			$repository['address'] = $data['address'];
		}
		$repository['created_at'] = date('Y-m-d H:i:s');
		$repository['updated_at'] = date('Y-m-d H:i:s');
		$this->db->insert('repositories', $repository);
		return '1';
	}

	/**
	 * Hàm chỉnh sửa thông tin kho hàng
	 */
	public function update_repository($data, $id) {
		$repository = array();
		if (isset($data['name']) && $data['name'] != null) {
			$repository['name'] = $data['name'];
		}
		if (isset($data['mobile']) && $data['mobile'] != null) {
			$repository['mobile'] = $data['mobile'];
		}
		if (isset($data['province']) && $data['province'] != null) {
			$repository['province_id'] = $data['province'];
		}
		if (isset($data['district']) && $data['district'] != null) {
			$repository['district_id'] = $data['district'];
		}
		if (isset($data['ward']) && $data['ward'] != null) {
			$repository['ward_id'] = $data['ward'];
		}
		if (isset($data['address']) && $data['address'] != null) {
			$repository['address'] = $data['address'];
		}
		$repository['created_at'] = date('Y-m-d H:i:s');
		$repository['updated_at'] = date('Y-m-d H:i:s');
		$this->db->where('id', $id);
//		$sql = $this->db->set($repository)->get_compiled_update('repositories');
//		echo $sql;
		$this->db->update('repositories', $repository);
		return '1';
	}

	/**
	 * Hàm lấy thông tin sản phẩm theo kho hàng
	 */
	public function detail_repository_list($params, $is_count) {
		$page_index = isset($params['page_index']) ? $params['page_index'] : 1;
		$page_size = isset($params['page_size']) ? $params['page_size'] : 10;
		$from = isset($params['from']) ? $params['from'] : 0;
		$keyword = isset($params['keyword']) ? $params['keyword'] : '';
		$category = isset($params['category']) ? $params['category'] : -1;
		$sort = isset($params['sort']) ? $params['sort'] : -1;
		$this->db->select(' *, SUM(product_repository.quantity) AS total, products.name AS product_name, brands.name AS brand_name, categories.name AS category_name');
		$this->db->from('product_repository');
		$this->db->join('products', 'products.id = product_repository.product_id');
		$this->db->join('repositories', 'repositories.id = product_repository.repository_id');
		$this->db->join('brands', 'brands.id = products.brand_id');
		$this->db->join('categories', 'categories.id = products.category_id');
		if ($keyword) {
			$this->db->where(" (products.name LIKE '%" . $keyword . "%' OR categories.name LIKE '%" . $keyword . "%' 
							OR brands.name LIKE '%" . $keyword . "%') ");
		}
		if (isset($category) && $category != -1) {
			$this->db->where(" products.category_id = '". $category. "'");
		}
		$this->db->group_by("product_repository.product_id");
		if (isset($sort) && $sort != -1) {
			if ($sort == '0') {
				$this->db->order_by('total', 'ASC');
			}
			if ($sort == '1') {
				$this->db->order_by('total', 'DESC');
			}
		}else{
			$this->db->order_by('product_repository.product_id', 'DESC');
		}
		$this->db->limit($page_size, $from);
//		echo $category.'<br>';
//		echo $sort.'<br>';
//		echo $this->db->get_compiled_select();
		if ($is_count) {
			return $this->db->count_all_results();
		}
		$query = $this->db->get();

		return $query->result_array();
	}
}
