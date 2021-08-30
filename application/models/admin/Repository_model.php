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
	public function repository_list($params, $is_count, $is_api = false) {
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
		if (isset($params['id'])) {
			$this->db->where(" repositories.id = '".$params['id']."'");
		}
		if ($keyword) {
			$this->db->where(" (repositories.name LIKE '%" . $keyword . "%' OR repositories.address LIKE '%" . $keyword . "%' 
								OR repositories.mobile LIKE '%" . $keyword . "%') ");
		}

		if ($is_count) {
			return $this->db->count_all_results();
		}
		$this->db->order_by('repositories.id', 'desc');
		if ($is_api) {
			$this->db->limit($page_size, $from);
		}
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
		$brand = isset($params['brand']) ? $params['brand'] : -1;
		$repository_id = isset($params['repository_id']) ? $params['repository_id'] : -1;
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
		if (isset($brand) && $brand != -1) {
			$this->db->where(" products.brand_id = '". $brand. "'");
		}
		if (isset($repository_id) && $repository_id != -1) {
			$this->db->where(" product_repository.repository_id = '". $repository_id. "'");
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
		$sql = $this->db->get_compiled_select();
		if ($is_count) {
			$result = $this->db->query($sql)->result_array();
			return count($result);
		}
		$sql .= " LIMIT ".$from.", ".$page_size."";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	/**
	 * Hàm lấy thông tin kho hàng
	 */
	public function delete_repository($id) {
		$this->db->where('repository_id', $id);
		$result = $this->db->delete('product_repository');

		$this->db->where('id', $id);
		$result = $this->db->delete('repositories');
		if (isset($result)) {
			return '1';
		}
	}

	/**
	 * Hàm lấy thông tin nhập kho
	 */
	public function store_list($params, $is_count, $detail = null)
	{
		$page_index = isset($params['page_index']) ? $params['page_index'] : 1;
		$page_size = isset($params['page_size']) ? $params['page_size'] : 10;
		$from = isset($params['from']) ? $params['from'] : 0;
		$keyword = isset($params['keyword']) ? $params['keyword'] : '';
		$start_date = isset($params['start_date']) ? $params['start_date'] : '';
		$end_date = isset($params['end_date']) ? $params['end_date'] : '';

		$this->db->select(' *, repositories.name AS repository_name, products.name AS product_name, brands.name AS brand_name,
			categories.name AS category_name, product_repository.id AS store_id');
		$this->db->from('product_repository');
		$this->db->join('products', 'products.id = product_repository.product_id');
		$this->db->join('repositories', 'repositories.id = product_repository.repository_id');
		$this->db->join('brands', 'brands.id = products.brand_id');
		$this->db->join('categories', 'categories.id = products.category_id');
		$this->db->where('product_repository.repository_id > 0');
		if ($keyword) {
			$this->db->where(" (repositories.name LIKE '%" . $keyword . "%') ");
		}
		if (isset($start_date) && $start_date) {
			$this->db->where(" product_repository.import_date >= '" . $start_date . "'");
		}
		if (isset($end_date) && $end_date) {
			$this->db->where(" product_repository.import_date <= '" . $end_date . "'");
		}
		if ($detail == null) {
			$this->db->group_by(array("product_repository.repository_id", "product_repository.import_date"));
			$this->db->order_by('product_repository.import_date', 'DESC');
		}
		if (isset($detail['repository_id'])) {
			$this->db->where(" product_repository.repository_id = '".$detail['repository_id']."'");
		}
		if (isset($detail['import_date'])) {
			$this->db->where(" product_repository.import_date = '".$detail['import_date']."'");
		}
		if (isset($params['id']) && $params['id']) {
			$this->db->where(" product_repository.id = '".$params['id']."'");
		}
		$sql = $this->db->get_compiled_select();
		if ($is_count) {
			$result = $this->db->query($sql)->result_array();
			return count($result);
		}
		if ($detail == null) {
			$sql .= " LIMIT " . $from . ", " . $page_size . "";
		}
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	/**
	 * Thêm thông tin nhập kho
	 */
	public function insert_store($data) {
		$story = array();
		if (isset($data['repository']) && $data['repository'] != null) {
			$story['once']['repository_id'] = $data['repository'];
		}
		if (isset($data['import_date']) && $data['import_date'] != null) {
			$story['once']['import_date'] = date("Y-m-d H:i:s", strtotime($data['import_date']));
		}
		if (isset($data['product']) && $data['product'] != null) {
			$story['once']['product_id'] = $data['product'];
		}
		if (isset($data['import_quantity']) && $data['import_quantity'] != null) {
			$story['once']['import_quantity'] = $data['import_quantity'];
			$story['once']['quantity'] = $data['import_quantity'];
		}
		$story['once']['created_at'] = date('Y-m-d H:i:s');
		$story['once']['updated_at'] = date('Y-m-d H:i:s');
		$this->db->insert('product_repository', $story['once']);
		if (isset($data['number_store'])) {
			for ($i = 1; $i < $data['number_store']; $i++) {
				if (isset($data['repository']) && $data['repository'] != null) {
					$story[$i]['repository_id'] = $data['repository'];
				}
				if (isset($data['import_date']) && $data['import_date'] != null) {
					$story[$i]['import_date'] = date("Y-m-d H:i:s", strtotime($data['import_date']));
				}
				if (isset($data['product'.$i.'']) && $data['product'.$i.''] != null) {
					$story[$i]['product_id'] = $data['product'.$i.''];
				}
				if (isset($data['import_quantity'.$i.'']) && $data['import_quantity'.$i.''] != null) {
					$story[$i]['import_quantity'] = $data['import_quantity'.$i.''];
					$story[$i]['quantity'] = $data['import_quantity'.$i.''];
				}
				$story[$i]['created_at'] = date('Y-m-d H:i:s');
				$story[$i]['updated_at'] = date('Y-m-d H:i:s');
				$this->db->insert('product_repository', $story[$i]);
			}
		}
		return '1';
	}
}
