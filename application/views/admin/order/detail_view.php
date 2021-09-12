<h3>Chi tiết đơn hàng: <?php echo $order['code'] ?></h3>
<form action="" method="POST" novalidate>
	<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
			<table class="table table-bordered">
				<thead>
				<th class="text-center">Tên sản phẩm</th>
				<th class="text-center">Số lượng</th>
				<th class="text-center">Đơn giá</th>
				<th class="text-center">Tổng tiền</th>
				</thead>
				<tbody id="container">
				<?php if (count($product) > 0): ?>
					<?php foreach ($product as $data): ?>
						<tr>
							<td><?php echo $data['name'] ?></td>
							<td class="text-center"><?php echo $data['quantity'] ?></td>
							<td class="text-center"><?php echo $data['unit_price'] ?></td>
							<td class="text-center"><?php echo $data['total_price'] ?></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>

	<div class="row">
		<div class="form-group col-lg-6">
			<label class="col-lg-4" for="address">Tổng giá trị đơn hàng:</label>
			<div class="col-lg-8">
				<?php $str_reverse = strrev($order['total_bill']);
				$total_trim = ceil(strlen($order['total_bill']) / 3);
				$str_final = '';
				for ($i = 0; $i < $total_trim; $i++) {
					$str_trim = substr($str_reverse, ($i) * 3, 3);
					if ($i < $total_trim - 1) {
						$str_final .= $str_trim . '.';
					} else {
						$str_final .= $str_trim;
					}
				}
				$order['total_bill'] = strrev($str_final);
				echo $order['total_bill'] . ' VNĐ';
				?>
			</div>
		</div>
		<?php if ($order['discount'] > 0): ?>
			<div class="form-group col-lg-6">
				<label class="col-lg-4" for="address">Tổng tiền thanh toán:</label>
				<div class="col-lg-8">
					<?php $str_reverse = strrev($order['total_pay']);
					$total_trim = ceil(strlen($order['total_pay']) / 3);
					$str_final = '';
					for ($i = 0; $i < $total_trim; $i++) {
						$str_trim = substr($str_reverse, ($i) * 3, 3);
						if ($i < $total_trim - 1) {
							$str_final .= $str_trim . '.';
						} else {
							$str_final .= $str_trim;
						}
					}
					$order['total_pay'] = strrev($str_final);
					echo $order['total_pay'] . ' VNĐ';
					?>
				</div>
			</div>
		<?php endif; ?>
	</div>

	<div class="row">
		<div class="form-group col-lg-6">
			<label class="col-lg-4" for="customer">Khách hàng(*):</label>
			<div class="col-lg-8">
				<?php echo $order['fullname'] ?>
			</div>
		</div>

		<div class="form-group col-lg-6">
			<label class="col-lg-4" for="repository_id">Chọn kho hàng(*):</label>
			<div class="col-lg-8">
				<?php echo $order['name'] ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="form-group col-lg-6">
			<label class="col-lg-4" for="address">Địa chỉ khách hàng(*):</label>
			<div class="col-lg-8">
				<?php echo $order['address'] ?>
			</div>
		</div>
		<div class="form-group col-lg-6">
			<label class="col-lg-4" for="voucher_id">Mã giảm giá sản phẩm:</label>
			<div class="col-lg-8">
				<?php echo $voucher['name'] ? $voucher['name'] : 'Không có mã giảm giá' ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="form-group col-lg-6">
			<label class="col-lg-4" for="address">Phương thức thanh toán(*):</label>
			<div class="col-lg-8">
				<?php
				echo $order['payment_method'] == 1 ? 'VN Pay' : 'Ship COD';
				?>
			</div>
		</div>
		<div class="form-group col-lg-6">
			<label class="col-lg-4" for="address">Trạng thái thanh toán(*):</label>
			<div class="col-lg-8">
				<?php echo $order['payment_status'] == -1 ? 'Chưa thanh toán' : 'Đã thanh toán' ?>
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-6">
			<div class="row">
				<div class="col-lg-4">
					<a href="<?php echo base_url('admin/order/index') ?>" class="btn btn-primary"
					   style="background: rebeccapurple">Quay lại</a>
				</div>
				<div class="col-lg-4">
					<a type="submit"
					   class="btn btn-success"
					   href="<?php echo base_url('admin/order/edit/' . $order['id']) ?>">Cập nhật</a>
				</div>
				<div class="col-lg-4">
					<a type="submit"
					   class="btn btn-danger"
					   href="<?php echo base_url('admin/order/delete/' . $order['id']) ?>">Xoá</a>
				</div>
			</div>
		</div>
	</div>
</form>
</div>

