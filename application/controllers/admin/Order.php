<?php


class Order extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'admin/order_model'
		));
	}

	public function index()
	{
		$data['title_page'] = 'QL Đơn hàng';
		$data['load_page'] = 'admin/order/list_view';
		$this->load->view('layouts/be_master_view', $data);
	}

	public function ajax_list()
	{
		$params['keyword'] = $this->input->post('keyword');
		$params['payment_status'] = $this->input->post('payment_status');
		$params['order_date'] = $this->input->post('order_date');
		$params['page_index'] = $this->input->post('page_index');
		$params['page_size'] = 10;
		if ($params['page_index'] < 1) {
			$params['page_index'] = 1;
		}
		$data['from'] = $params['from'] = ($params['page_index'] - 1) * $params['page_size'];
		$total_record = $this->order_model->order_list($params, true);

		$data['result_order'] = $this->order_model->order_list($params, false);
		$data['pagination_link'] = paginate_ajax($total_record, $params['page_index'], $params['page_size']);
		$this->load->view('admin/order/ajax_list_view', $data);
	}

	public function add()
	{
		$errors = array();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if ($_POST['customer_id'] == -1) {
				$errors['customer_id'] = 'Khách hàng chưa được chọn';
			} else {
				if ($_POST['address'] == -1) {
					$errors['address'] = 'Địa chỉ khách hàng chưa được chọn';
				}
			}
			if (isset($_POST['product_id'])) {
				if (count($_POST['product_id']) > 0) {
					foreach ($_POST['product_id'] as $value) {
						if ($value == -1) {
							$errors['product_id'] = 'Sản phẩm chưa được chọn';
						}
					}
					foreach (array_count_values($_POST['product_id']) as $value) {
						if ($value > 1) {
							$errors['product_id'] = 'Các sản phẩm không được trùng nhau';
						}
					}

					if ($_POST['voucher_id'] != -1) {
						if (!$this->order_model->query(
							'v.name, v.id',
							TBL_VOUCHERS . ' AS v',
							"join customer_voucher AS c ON c.voucher_id = v.id" .
							" WHERE c.customer_id = " . $_POST['customer_id'] .
							" AND (('" . date('Y-m-d H:i:s') . "' BETWEEN v.effective_date AND v.expiration_date) " .
							" OR ('" . date('Y-m-d H:i:s') . "' >= v.effective_date AND v. expiration_date IS NULL))"
						)) {
							$errors['voucher_id'] = 'Voucher giảm giá đã hết hạn sử dụng';
						} else {
							$voucher = $this->order_model->query(
								'`condition`',
								TBL_VOUCHERS,
								'WHERE id = ' . $_POST['voucher_id']
							)[0];
							if ($voucher['condition']) {
								$count = count($_POST['product_id']);
								$total_bill = 0;
								for ($i = 0; $i < $count; $i++) {
									if ($_POST['product_id'][$i] != -1 && $_POST['quantity'][$i] > 0) {
										$unit_price = $this->order_model->query(
											'price',
											TBL_PRODUCTS,
											'WHERE id = ' . $_POST['product_id'][$i]
										)[0]['price'];
										$total_bill += $unit_price * $_POST['quantity'][$i];
									}
								}
								if ($total_bill < $voucher['condition']) {
									$errors['voucher_id'] = 'Đơn hàng của bạn chưa đủ để áp dụng mã giảm giá này';
								}
							}
						}
					}
				}
			} else {
				$errors['product_id'] = 'Cần có ít nhất 1 sản phẩm để tạo đơn hàng';
			}
			if (empty($_POST['payment_status'])) {
				$errors['payment_status'] = 'Trạng thái thanh toán chưa được chọn';
			}
			if (empty($_POST['payment_method'])) {
				$errors['payment_method'] = 'Phương thức thanh toán chưa được chọn';
			}
			if ($_POST['repository_id'] == -1) {
				$errors['repository_id'] = 'Kho hàng chưa được chọn';
			}
		}

		if (isFormValidated($errors) && $_SERVER['REQUEST_METHOD'] == 'POST') {
			$order = array();
			$order['customer_id'] = $_POST['customer_id'];
			$order['address_id'] = $_POST['address'];
			$order['repository_id'] = $_POST['repository_id'];
			$order['payment_method'] = $_POST['payment_method'];
			$order['payment_status'] = $_POST['payment_status'];
			if ($order_id = $this->order_model->insert_order($order)) {
				$this->session->set_flashdata('success', 'Thêm đơn hàng thành công!');
			} else {
				$this->session->set_flashdata('error', 'Thêm đơn hàng thất bại!');
			}
			if (isset($_POST['product_id']) && count($_POST['product_id']) > 0) {
				$money = array(
					'discount' => 0,
					'total_bill' => 0,
					'total_pay' => 0
				);
				$count = count($_POST['product_id']);
				$product = array();
				$product['order_id'] = $order_id;
				for ($i = 0; $i < $count; $i++) {
					$product['quantity'] = $_POST['quantity'][$i];
					$product['product_id'] = $_POST['product_id'][$i];
					$product['unit_price'] = $this->order_model->query(
						'price',
						TBL_PRODUCTS,
						'WHERE id = ' . $_POST['product_id'][$i]
					)[0]['price'];
					$product['total_price'] = $product['unit_price'] * $product['quantity'];
					$this->order_model->insert_order_product($product);
					$money['total_bill'] += $product['total_price'];
				}
				if (isset($_POST['voucher_id']) && $_POST['voucher_id'] != -1) {
					if ($this->order_model->insert_order_voucher($order_id, $_POST['voucher_id'])) {
						$voucher = $this->order_model->query(
							'discount,discount_type',
							TBL_VOUCHERS,
							'WHERE id = ' . $_POST['voucher_id']
						)[0];
						if ($voucher['discount_type'] == 1) {
							$money['discount'] = round($money['total_bill'] * ($voucher['discount'] / 100));
						} elseif ($voucher['discount_type'] == 0) {
							$money['discount'] = round($voucher['discount']);
						}
					}
				}
				if ($money['discount'] > 0 && $money['total_bill'] > 0) {
					$money['total_pay'] = $money['total_bill'] - $money['discount'];
				} else {
					$money['total_pay'] = $money['total_bill'];
				}
				$this->order_model->update_money($money, $order_id);
			}

			redirect('admin/order/index');
		} else {
			$data['title_page'] = 'QL Đơn hàng';
			$data['load_page'] = 'admin/order/add_view';
			$data['errors'] = $errors;
			$data['customer'] = $this->order_model->query(
				'id,fullname',
				TBL_CUSTOMERS,
				'WHERE status = 1'
			);
			$data['product'] = $this->order_model->query(
				'id,name,price',
				TBL_PRODUCTS,
				'WHERE `delete` = 0'
			);
			$data['repository'] = $this->order_model->query(
				'id,name',
				TBL_REPOSITORIES
			);
			$this->load->view('layouts/be_master_view', $data);
		}
	}

	public function edit($id)
	{
		$errors = array();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if ($_POST['customer_id'] == -1) {
				$errors['customer_id'] = 'Khách hàng chưa được chọn';
			} else {
				if ($_POST['address'] == -1) {
					$errors['address'] = 'Địa chỉ khách hàng chưa được chọn';
				}
			}
			if (isset($_POST['product_id'])) {
				if (count($_POST['product_id']) > 0) {
					foreach ($_POST['product_id'] as $value) {
						if ($value == -1) {
							$errors['product_id'] = 'Sản phẩm chưa được chọn';
						}
					}
					foreach (array_count_values($_POST['product_id']) as $value) {
						if ($value > 1) {
							$errors['product_id'] = 'Các sản phẩm không được trùng nhau';
						}
					}

					if ($_POST['voucher_id'] != -1) {
						if (!$this->order_model->query(
							'v.name, v.id',
							TBL_VOUCHERS . ' AS v',
							"join customer_voucher AS c ON c.voucher_id = v.id" .
							" WHERE c.customer_id = " . $_POST['customer_id'] .
							" AND (('" . date('Y-m-d H:i:s') . "' BETWEEN v.effective_date AND v.expiration_date) " .
							" OR ('" . date('Y-m-d H:i:s') . "' >= v.effective_date AND v. expiration_date IS NULL))"
						)) {
							$errors['voucher_id'] = 'Voucher giảm giá đã hết hạn sử dụng';
						} else {
							$voucher = $this->order_model->query(
								'`condition`',
								TBL_VOUCHERS,
								'WHERE id = ' . $_POST['voucher_id']
							)[0];
							if ($voucher['condition']) {
								$count = count($_POST['product_id']);
								$total_bill = 0;
								for ($i = 0; $i < $count; $i++) {
									if ($_POST['product_id'][$i] != -1 && $_POST['quantity'][$i] > 0) {
										$unit_price = $this->order_model->query(
											'price',
											TBL_PRODUCTS,
											'WHERE id = ' . $_POST['product_id'][$i]
										)[0]['price'];
										$total_bill += $unit_price * $_POST['quantity'][$i];
									}
								}
								if ($total_bill < $voucher['condition']) {
									$errors['voucher_id'] = 'Đơn hàng của bạn chưa đủ để áp dụng mã giảm giá này';
								}
							}
						}
					}
				}
			} else {
				$errors['product_id'] = 'Cần có ít nhất 1 sản phẩm để tạo đơn hàng';
			}
			if (empty($_POST['payment_status'])) {
				$errors['payment_status'] = 'Trạng thái thanh toán chưa được chọn';
			}
			if (empty($_POST['payment_method'])) {
				$errors['payment_method'] = 'Phương thức thanh toán chưa được chọn';
			}
			if ($_POST['repository_id'] == -1) {
				$errors['repository_id'] = 'Kho hàng chưa được chọn';
			}
		}

		if (isFormValidated($errors) && $_SERVER['REQUEST_METHOD'] == 'POST') {
			$order = array();
			$order['id'] = $_POST['id'];
			$order['customer_id'] = $_POST['customer_id'];
			$order['address_id'] = $_POST['address'];
			$order['repository_id'] = $_POST['repository_id'];
			$order['payment_method'] = $_POST['payment_method'];
			$order['payment_status'] = $_POST['payment_status'];
			if ($this->order_model->edit($order)) {
				$this->session->set_flashdata('success', 'Cập nhật đơn hàng:'. $_POST['code'].' thành công!');
			} else {
				$this->session->set_flashdata('error', 'Cập nhật đơn hàng:'. $_POST['code'].' thất bại!');
			}
			if (isset($_POST['product_id']) && count($_POST['product_id']) > 0) {
				if ($this->order_model->delete_product($_POST['id'])) {
					$money = array(
						'discount' => 0,
						'total_bill' => 0,
						'total_pay' => 0
					);
					$count = count($_POST['product_id']);
					$product = array();
					$product['order_id'] = $_POST['id'];
					for ($i = 0; $i < $count; $i++) {
						$product['quantity'] = $_POST['quantity'][$i];
						$product['product_id'] = $_POST['product_id'][$i];
						$product['unit_price'] = $this->order_model->query(
							'price',
							TBL_PRODUCTS,
							'WHERE id = ' . $_POST['product_id'][$i]
						)[0]['price'];
						$product['total_price'] = $product['unit_price'] * $product['quantity'];
						$this->order_model->insert_order_product($product);
						$money['total_bill'] += $product['total_price'];
					}
					if (isset($_POST['voucher_id']) && $_POST['voucher_id'] != -1) {
						if ($this->order_model->delete_voucher($_POST['id'])) {
							if ($this->order_model->insert_order_voucher($_POST['id'], $_POST['voucher_id'])) {
								$voucher = $this->order_model->query(
									'discount,discount_type',
									TBL_VOUCHERS,
									'WHERE id = ' . $_POST['voucher_id']
								)[0];
								if ($voucher['discount_type'] == 1) {
									$money['discount'] = round($money['total_bill'] * ($voucher['discount'] / 100));
								} elseif ($voucher['discount_type'] == 0) {
									$money['discount'] = round($voucher['discount']);
								}
							}
						}
					}
					if ($money['discount'] > 0 && $money['total_bill'] > 0) {
						$money['total_pay'] = $money['total_bill'] - $money['discount'];
					} else {
						$money['total_pay'] = $money['total_bill'];
					}
					$this->order_model->update_money($money, $_POST['id']);
				}
			}
			redirect('admin/order/index');
		} elseif (count($this->order_model->query('code', TBL_ORDERS, 'WHERE id =' . $id)) != 0) {
			$data['title_page'] = 'QL Đơn hàng';
			$data['load_page'] = 'admin/order/edit_view';
			$data['errors'] = $errors;
			$data['customer'] = $this->order_model->query(
				'id,fullname',
				TBL_CUSTOMERS,
				'WHERE status = 1'
			);
			$data['product'] = $this->order_model->query(
				'id,name,price',
				TBL_PRODUCTS,
				'WHERE `delete` = 0'
			);
			$data['repository'] = $this->order_model->query(
				'id,name',
				TBL_REPOSITORIES
			);
			$data['order'] = $this->order_model->query(
				'*',
				TBL_ORDERS,
				'WHERE id =' . $id
			)[0];
			$data['order_product'] = $this->order_model->query(
				'*',
				TBL_ORDER_PRODUCT,
				'WHERE order_id =' . $id
			);
			$this->load->view('layouts/be_master_view', $data);
		} else {
			$this->session->set_flashdata('error', 'Không tìm thấy đơn hàng');
			redirect('admin/order/index');
		}
	}

	public function detail($id) {
		if (count($this->order_model->query('*',TBL_ORDERS,'WHERE `delete` = 0 AND id='.$id)) > 0) {
			$data['title_page'] = 'QL Đơn hàng';
			$data['load_page'] = 'admin/order/detail_view';
			$data['order'] = $this->order_model->detail($id)[0];
			$data['product'] = $this->order_model->get_order_product($id);
			$data['voucher'] = $this->order_model->voucher($id);
			if (count($data['voucher']) > 0) {$data['voucher'] = $data['voucher'][0];}
			$this->load->view('layouts/be_master_view', $data);
		} else {
			$this->session->set_flashdata('error', 'Không tìm thấy đơn hàng!');
			redirect('admin/order/index');
		}

	}

	public function delete($id)
	{
		if ($this->order_model->delete($id)) {
			$this->session->set_flashdata('success', 'Xoá đơn hàng thành công!');
		} else {
			$this->session->set_flashdata('error', 'Xoá đơn hàng thất bại!');
		}
		redirect('admin/order/index');
	}

	public function get_price()
	{
		$data['price'] = $this->order_model->query(
			'price',
			TBL_PRODUCTS,
			'WHERE id = ' . $_GET['product_id']
		)[0]['price'];
		$this->load->view('admin/order/get_price', $data);
	}

	public function get_address()
	{
		$data['address'] = $this->order_model->query(
			'a.address, a.id , w.full_location',
			TBL_ADDRESSES . ' AS a',
			'JOIN wards as w ON w.id = a.ward_id' .
			' WHERE customer_id = ' . $_GET['customer_id']
		);
		$this->load->view('admin/order/get_address', $data);
	}

	public function get_voucher()
	{
		$data['voucher'] = $this->order_model->query(
			'v.name, v.id',
			TBL_VOUCHERS . ' AS v',
			"join customer_voucher AS c ON c.voucher_id = v.id" .
			" WHERE c.customer_id = " . $_GET['customer_id'] .
			" AND (('" . date('Y-m-d H:i:s') . "' BETWEEN v.effective_date AND v.expiration_date) " .
			" OR ('" . date('Y-m-d H:i:s') . "' >= v.effective_date AND v. expiration_date IS NULL))"
		);
		$this->load->view('admin/order/get_voucher', $data);
	}
}
