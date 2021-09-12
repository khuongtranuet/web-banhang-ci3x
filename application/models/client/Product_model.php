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

	public function product_list($params, $is_count) {
		$page_index = isset($params['page_index']) ? $params['page_index'] : 1;
		$page_size = isset($params['page_size']) ? $params['page_size'] : 20;
		$from = isset($params['from']) ? $params['from'] : 0;
		$keyword = isset($params['keyword']) ? $params['keyword'] : '';
		$brand = isset($params['brand']) ? $params['brand'] : -1;
		$sort = isset($params['sort']) ? $params['sort'] : -1;
		$cate_id = isset($params['cate_id']) ? $params['cate_id'] : -1;
		$price = isset($params['price']) ? $params['price'] : -1;
		$price_laptop = isset($params['price_laptop']) ? $params['price_laptop'] : -1;
		$price_accessory = isset($params['price_accessory']) ? $params['price_accessory'] : -1;
		$ram = isset($params['ram']) ? $params['ram'] : -1;
		$rom = isset($params['rom']) ? $params['rom'] : -1;
		$screen = isset($params['screen']) ? $params['screen'] : -1;
		$cpu = isset($params['cpu']) ? $params['cpu'] : -1;
		$card = isset($params['card']) ? $params['card'] : -1;
		$hard_drive = isset($params['hard_drive']) ? $params['hard_drive'] : -1;
		$screen_resolution = isset($params['screen_resolution']) ? $params['screen_resolution'] : -1;
		$frequency = isset($params['frequency']) ? $params['frequency'] : -1;
		$this->db->select(' *, '.TBL_PRODUCTS.'.id AS product_id, '.TBL_PRODUCTS.'.name AS product_name, '.TBL_PRODUCT_IMAGES.'.id AS product_images_id');
		$this->db->from(TBL_PRODUCTS);
		$this->db->join(TBL_PRODUCT_IMAGES, TBL_PRODUCT_IMAGES.'.product_id = '.TBL_PRODUCTS.'.id');
		if (isset($params['search']) && $params['search'] == true) {
			if ($keyword == '') {
				return '';
			}else{
				$this->db->join(TBL_BRANDS, TBL_BRANDS.'.id = '.TBL_PRODUCTS.'.brand_id');
				$this->db->join(TBL_CATEGORIES, TBL_CATEGORIES.'.id = '.TBL_PRODUCTS.'.category_id');
				$this->db->where("(".TBL_CATEGORIES.".name LIKE '%" . $keyword . "%' OR ".TBL_PRODUCTS.".name LIKE '%" . $keyword . "%' 
				 OR ".TBL_BRANDS.".name LIKE '%" . $keyword . "%')");
			}
		}
		$this->db->where(TBL_PRODUCTS.'.id > 0');
		if (!isset($params['search'])) {
			if ($keyword) {
				$this->db->where(TBL_PRODUCTS . ".name LIKE '%" . $keyword . "%'");
			}
		}
		if (isset($brand) && $brand != -1) {
			$this->db->where(TBL_PRODUCTS.'.brand_id = '.$brand);
		}
		if (isset($price) && $price != -1) {
			if ($price == '0') {
				$this->db->where(TBL_PRODUCTS.'.price >= 0');
				$this->db->where(TBL_PRODUCTS.'.price < 2000000');
			}elseif ($price == '1') {
				$this->db->where(TBL_PRODUCTS.'.price >= 2000000');
				$this->db->where(TBL_PRODUCTS.'.price <= 4000000');
			}elseif ($price == '2') {
				$this->db->where(TBL_PRODUCTS.'.price > 4000000');
				$this->db->where(TBL_PRODUCTS.'.price <= 7000000');
			}elseif ($price == '3') {
				$this->db->where(TBL_PRODUCTS.'.price > 7000000');
				$this->db->where(TBL_PRODUCTS.'.price <= 13000000');
			}elseif ($price == '4') {
				$this->db->where(TBL_PRODUCTS.'.price > 13000000');
				$this->db->where(TBL_PRODUCTS.'.price <= 20000000');
			}elseif ($price == '5') {
				$this->db->where(TBL_PRODUCTS.'.price > 20000000');
			}
		}
		if (isset($price_laptop) && $price_laptop != -1) {
			if ($price_laptop == '0') {
				$this->db->where(TBL_PRODUCTS.'.price >= 0');
				$this->db->where(TBL_PRODUCTS.'.price < 15000000');
			}elseif ($price_laptop == '1') {
				$this->db->where(TBL_PRODUCTS.'.price >= 15000000');
				$this->db->where(TBL_PRODUCTS.'.price <= 20000000');
			}elseif ($price_laptop == '2') {
				$this->db->where(TBL_PRODUCTS.'.price > 20000000');
				$this->db->where(TBL_PRODUCTS.'.price <= 25000000');
			}elseif ($price_laptop == '3') {
				$this->db->where(TBL_PRODUCTS.'.price > 25000000');
				$this->db->where(TBL_PRODUCTS.'.price <= 30000000');
			}elseif ($price_laptop == '4') {
				$this->db->where(TBL_PRODUCTS . '.price > 30000000');
			}
		}
		if (isset($price_accessory) && $price_accessory != -1) {
			if ($price_accessory == '0') {
				$this->db->where(TBL_PRODUCTS.'.price >= 0');
				$this->db->where(TBL_PRODUCTS.'.price < 200000');
			}elseif ($price_accessory == '1') {
				$this->db->where(TBL_PRODUCTS.'.price >= 200000');
				$this->db->where(TBL_PRODUCTS.'.price <= 500000');
			}elseif ($price_accessory == '2') {
				$this->db->where(TBL_PRODUCTS.'.price > 500000');
				$this->db->where(TBL_PRODUCTS.'.price <= 1000000');
			}elseif ($price_accessory == '3') {
				$this->db->where(TBL_PRODUCTS.'.price > 1000000');
				$this->db->where(TBL_PRODUCTS.'.price <= 2000000');
			}elseif ($price_accessory == '4') {
				$this->db->where(TBL_PRODUCTS . '.price > 2000000');
			}
		}
		$this->db->where(TBL_PRODUCT_IMAGES.".type = '1'");
		$this->db->where(TBL_PRODUCTS.".parent_id IS NULL");
		if (isset($cate_id) && $cate_id != -1) {
			$this->db->where(TBL_PRODUCTS.'.category_id = '.$cate_id);
		}
		if (isset($ram) && $ram != -1) {
			$this->db->where(TBL_PRODUCTS.".id IN ( SELECT ".TBL_PRODUCT_ATTRIBUTE.".product_id FROM ".TBL_PRODUCT_ATTRIBUTE."
			 JOIN ".TBL_ATTRIBUTES." ON ".TBL_ATTRIBUTES.".id = ".TBL_PRODUCT_ATTRIBUTE.".attribute_id WHERE ".TBL_ATTRIBUTES."
			 .name = 'RAM' AND value = '".$ram."' )");
		}
		if (isset($rom) && $rom != -1) {
			$this->db->where(TBL_PRODUCTS.".id IN ( SELECT ".TBL_PRODUCT_ATTRIBUTE.".product_id FROM ".TBL_PRODUCT_ATTRIBUTE."
			 JOIN ".TBL_ATTRIBUTES." ON ".TBL_ATTRIBUTES.".id = ".TBL_PRODUCT_ATTRIBUTE.".attribute_id WHERE ".TBL_ATTRIBUTES."
			 .name = 'Bộ nhớ trong' AND value = '".$rom."' )");
		}
		if (isset($screen) && $screen != -1) {
			$this->db->where(TBL_PRODUCTS.".id IN ( SELECT ".TBL_PRODUCT_ATTRIBUTE.".product_id FROM ".TBL_PRODUCT_ATTRIBUTE."
			 JOIN ".TBL_ATTRIBUTES." ON ".TBL_ATTRIBUTES.".id = ".TBL_PRODUCT_ATTRIBUTE.".attribute_id WHERE ".TBL_ATTRIBUTES."
			 .name = 'Màn hình' AND value LIKE '%".$screen."%' )");
		}
		if (isset($cpu) && $cpu != -1) {
			$this->db->where(TBL_PRODUCTS.".id IN ( SELECT ".TBL_PRODUCT_ATTRIBUTE.".product_id FROM ".TBL_PRODUCT_ATTRIBUTE."
			 JOIN ".TBL_ATTRIBUTES." ON ".TBL_ATTRIBUTES.".id = ".TBL_PRODUCT_ATTRIBUTE.".attribute_id WHERE ".TBL_ATTRIBUTES."
			 .name = 'CPU' AND value LIKE '%".$cpu."%' )");
		}
		if (isset($card) && $card != -1) {
			$this->db->where(TBL_PRODUCTS.".id IN ( SELECT ".TBL_PRODUCT_ATTRIBUTE.".product_id FROM ".TBL_PRODUCT_ATTRIBUTE."
			 JOIN ".TBL_ATTRIBUTES." ON ".TBL_ATTRIBUTES.".id = ".TBL_PRODUCT_ATTRIBUTE.".attribute_id WHERE ".TBL_ATTRIBUTES."
			 .name = 'Card màn hình' AND value LIKE '%".$card."%' )");
		}
		if (isset($hard_drive) && $hard_drive != -1) {
			$this->db->where(TBL_PRODUCTS.".id IN ( SELECT ".TBL_PRODUCT_ATTRIBUTE.".product_id FROM ".TBL_PRODUCT_ATTRIBUTE."
			 JOIN ".TBL_ATTRIBUTES." ON ".TBL_ATTRIBUTES.".id = ".TBL_PRODUCT_ATTRIBUTE.".attribute_id WHERE ".TBL_ATTRIBUTES."
			 .name = 'Ổ cứng' AND value LIKE '%".$hard_drive."%' )");
		}
		if (isset($screen_resolution) && $screen_resolution != -1) {
			$this->db->where(TBL_PRODUCTS.".id IN ( SELECT ".TBL_PRODUCT_ATTRIBUTE.".product_id FROM ".TBL_PRODUCT_ATTRIBUTE."
			 JOIN ".TBL_ATTRIBUTES." ON ".TBL_ATTRIBUTES.".id = ".TBL_PRODUCT_ATTRIBUTE.".attribute_id WHERE ".TBL_ATTRIBUTES."
			 .name = 'Màn hình' AND value LIKE '%".$screen_resolution."%' )");
		}
		if (isset($frequency) && $frequency != -1) {
			$this->db->where(TBL_PRODUCTS.".id IN ( SELECT ".TBL_PRODUCT_ATTRIBUTE.".product_id FROM ".TBL_PRODUCT_ATTRIBUTE."
			 JOIN ".TBL_ATTRIBUTES." ON ".TBL_ATTRIBUTES.".id = ".TBL_PRODUCT_ATTRIBUTE.".attribute_id WHERE ".TBL_ATTRIBUTES."
			 .name = 'Màn hình' AND value LIKE '%".$frequency."%' )");
		}
		if (isset($sort) && $sort != -1) {
			if ($sort == '0') {
				$this->db->order_by(TBL_PRODUCTS.'.sold', 'DESC');
			}elseif ($sort == '1') {
				$this->db->order_by(TBL_PRODUCTS.'.price', 'DESC');
			}else{
				$this->db->order_by(TBL_PRODUCTS.'.price', 'ASC');
			}
		}else{
			$this->db->order_by(TBL_PRODUCTS.'.id', 'DESC');
		}
		if ($is_count) {
			return $this->db->count_all_results();
		}
		$this->db->limit($page_size, $from);
		$query = $this->db->get();

		return $query->result_array();
	}

	public function stock_store($params) {
		$product_id = isset($params['product_id']) ? $params['product_id'] : '';
		$province = isset($params['province']) ? $params['province'] : -1;
		$district = isset($params['district']) ? $params['district'] : -1;
		$this->db->select('*, '.TBL_REPOSITORIES.'.name AS repository_name, ');
		$this->db->from(TBL_PRODUCT_REPOSITORY);
		$this->db->join(TBL_REPOSITORIES, TBL_REPOSITORIES.'.id = '.TBL_PRODUCT_REPOSITORY.'.repository_id');
		$this->db->join(TBL_WARDS, TBL_WARDS.'.id = '.TBL_REPOSITORIES.'.ward_id');
		if (isset($province) && $province != -1) {
			$this->db->where(TBL_REPOSITORIES.'.province_id = '.$province);
		}
		if (isset($district) && $district != -1) {
			$this->db->where(TBL_REPOSITORIES.'.district_id = '.$district);
		}
		if (isset($product_id) && $product_id) {
			$this->db->where(TBL_PRODUCT_REPOSITORY.'.product_id = '.$product_id);
		}
		$query = $this->db->get();
		if (isset($product_id) && $product_id && isset($province) && $province != -1) {
			return $query->result_array();
		}else{
			return '';
		}
	}

	public function product_review($id) {
		$this->db->select(' *');
		$this->db->from(TBL_PRODUCT_REVIEWS);
		$this->db->join(TBL_CUSTOMERS, TBL_CUSTOMERS.'.id = '.TBL_PRODUCT_REVIEWS.'.customer_id');
		$this->db->where(TBL_PRODUCT_REVIEWS.'.product_id = '.$id);
		$query = $this->db->get();
		return $query->result_array();
	}
}
