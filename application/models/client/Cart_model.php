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

	public function product_cart($id , $is_cart = false) {
		if($is_cart == true) {
			$this->db->select(' *');
			$this->db->from(TBL_CUSTOMER_PRODUCT);
			$this->db->join(TBL_PRODUCTS, TBL_CUSTOMER_PRODUCT . '.product_id = ' . TBL_PRODUCTS . '.id');
			$this->db->join(TBL_PRODUCT_IMAGES, TBL_PRODUCT_IMAGES . '.product_id = ' . TBL_PRODUCTS . '.id');
			$this->db->where(TBL_CUSTOMER_PRODUCT . '.customer_id = ' . $id);
			$this->db->where(TBL_PRODUCT_IMAGES . '.type = 1');
			$query = $this->db->get();
			return $query->result_array();
		}else{
			$this->db->select(' *');
			$this->db->from(TBL_ORDER_PRODUCT);
			$this->db->join(TBL_PRODUCTS, TBL_ORDER_PRODUCT . '.product_id = ' . TBL_PRODUCTS . '.id');
			$this->db->join(TBL_PRODUCT_IMAGES, TBL_PRODUCT_IMAGES . '.product_id = ' . TBL_PRODUCTS . '.id');
			$this->db->where(TBL_ORDER_PRODUCT . '.order_id = ' . $id);
			$this->db->where(TBL_PRODUCT_IMAGES . '.type = 1');
			$query = $this->db->get();
			return $query->result_array();
		}
	}

	public function update_product($data) {
		$product_id = isset($data['product_id']) ? $data['product_id'] : '';
		$quantity = isset($data['quantity']) ? $data['quantity'] : '';
		$customer_id = isset($data['customer_id']) ? $data['customer_id'] : '';
		$is_delete = isset($data['is_delete']) ? $data['is_delete'] : '';
		if (is_array($product_id) && $is_delete == true && $customer_id != '') {
			for($i = 0; $i < count($product_id); $i++) {
				$key = array_search($product_id[$i], $_SESSION['cart']);
				if ($key != '') {
					unset($_SESSION['cart'][$key]);
				}
				$this->db->where('customer_id', $customer_id);
				$this->db->where('product_id', $product_id[$i]);
				$result = $this->db->delete(TBL_CUSTOMER_PRODUCT);
			}
		}elseif (is_array($product_id) && is_array($quantity) && $customer_id != '') {
			$address_id = isset($data['address_id']) ? $data['address_id'] : '';
			if ($address_id != '') {
				$order_exist = $this->select('*', TBL_ORDERS, 'WHERE customer_id = '.$customer_id.' AND status = -2');
				if(count($order_exist) > 0) {
					$order_id = $order_exist[0]['id'];
					$this->db->where('order_id', $order_id);
					$this->db->delete(TBL_ORDER_PRODUCT);

					$this->db->set('address_id', $address_id);
					$this->db->where('id', $order_id);
					$this->db->update(TBL_ORDERS);
					for($i = 0; $i < count($product_id); $i++) {
						$product_detail = $this->select('*', TBL_PRODUCTS, ' WHERE id = '.$product_id[$i]);
						$order_product = array(
							'product_id' => $product_id[$i],
							'order_id' => $order_id,
							'quantity' => $quantity[$i],
							'unit_price' => $product_detail[0]['price'],
							'total_price' => $product_detail[0]['price']*$quantity[$i],
							'created_at' => date('Y-m-d H:i:s'),
							'updated_at' => date('Y-m-d H:i:s'),
						);
						$this->db->insert(TBL_ORDER_PRODUCT, $order_product);
					}
				}else{
					$code = ramdomOrderNumber();
					$order = array(
						'customer_id' => $customer_id,
						'address_id' => $address_id,
						'code' => $code,
						'status' => -2,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s'),
					);
					$this->db->insert(TBL_ORDERS, $order);
					$order_id = $this->db->insert_id();
					for($i = 0; $i < count($product_id); $i++) {
						$product_detail = $this->select('*', TBL_PRODUCTS, ' WHERE id = '.$product_id[$i]);
						$order_product = array(
							'product_id' => $product_id[$i],
							'order_id' => $order_id,
							'quantity' => $quantity[$i],
							'unit_price' => $product_detail[0]['price'],
							'total_price' => $product_detail[0]['price']*$quantity[$i],
							'created_at' => date('Y-m-d H:i:s'),
							'updated_at' => date('Y-m-d H:i:s'),
						);
						$this->db->insert(TBL_ORDER_PRODUCT, $order_product);
					}
				}
			}
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
				$key = array_search($product_id, $_SESSION['cart']);
				if ($key != '') {
					unset($_SESSION['cart'][$key]);
				}
				$result = $this->db->delete(TBL_CUSTOMER_PRODUCT);
			}
		}
		return '1';
	}

	public function delete_cart($data) {
		$product_id = isset($data['product_id']) ? $data['product_id'] : '';
		$customer_id = isset($data['customer_id']) ? $data['customer_id'] : '';
		if ($product_id != '' && $customer_id != '') {
			$key = array_search($product_id, $_SESSION['cart']);
			if ($key != '') {
				unset($_SESSION['cart'][$key]);
			}
			$this->db->where('customer_id', $customer_id);
			$this->db->where('product_id', $product_id);
			$result = $this->db->delete(TBL_CUSTOMER_PRODUCT);
			if (isset($result)) {
				return '1';
			}
		}
	}

	public function insert_cart($data) {
		$product_id = isset($data['product_id']) ? $data['product_id'] : '';
		$quantity = isset($data['quantity']) ? $data['quantity'] : '';
		$customer_id = isset($data['customer_id']) ? $data['customer_id'] : '';
		if ($product_id != '' && $quantity != '' && $customer_id != '' && !isset($data['address_id'])) {
			$check_exist = $this->select(' *', TBL_CUSTOMER_PRODUCT, ' WHERE product_id = '.$product_id.' AND customer_id ='.$customer_id);
			if (count($check_exist) > 0) {
				$product = array(
					'quantity' => ($check_exist[0]['quantity'] + $quantity),
					'updated_at' => date('Y-m-d H:i:s'),
				);
				$this->db->where('product_id', $product_id);
				$this->db->where('customer_id', $customer_id);
				$this->db->update(TBL_CUSTOMER_PRODUCT, $product);
			}else{
				$product = array(
					'customer_id' => $customer_id,
					'product_id' => $product_id,
					'quantity' => $quantity,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);
				$this->db->insert(TBL_CUSTOMER_PRODUCT, $product);
			}
		}else{
			$address_id = isset($data['address_id']) ? $data['address_id'] : '';
			if ($address_id != '') {
				$order_exist = $this->select('*', TBL_ORDERS, 'WHERE customer_id = '.$customer_id.' AND status = -2');
				if(count($order_exist) > 0) {
					$order_id = $order_exist[0]['id'];
					$this->db->where('order_id', $order_id);
					$this->db->delete(TBL_ORDER_PRODUCT);

					$this->db->set('address_id', $address_id);
					$this->db->where('id', $order_id);
					$this->db->update(TBL_ORDERS);

					$product_detail = $this->select('*', TBL_PRODUCTS, ' WHERE id = '.$product_id);
					$order_product = array(
						'product_id' => $product_id,
						'order_id' => $order_id,
						'quantity' => $quantity,
						'unit_price' => $product_detail[0]['price'],
						'total_price' => $product_detail[0]['price']*$quantity,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s'),
					);
					$this->db->insert(TBL_ORDER_PRODUCT, $order_product);
				}else{
					$code = ramdomOrderNumber();
					$order = array(
						'customer_id' => $customer_id,
						'address_id' => $address_id,
						'code' => $code,
						'status' => -2,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s'),
					);
					$this->db->insert(TBL_ORDERS, $order);
					$order_id = $this->db->insert_id();
					$product_detail = $this->select('*', TBL_PRODUCTS, ' WHERE id = '.$product_id);
					$order_product = array(
						'product_id' => $product_id,
						'order_id' => $order_id,
						'quantity' => $quantity,
						'unit_price' => $product_detail[0]['price'],
						'total_price' => $product_detail[0]['price']*$quantity,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s'),
					);
					$this->db->insert(TBL_ORDER_PRODUCT, $order_product);
				}
			}
		}
		return '1';
	}
}
