<div class="row">
	<div class="col-lg-12">
		<h4 class="title-cart">CHI TIẾT ĐƠN HÀNG</h4>
	</div>
	<?php if (isset($order) && $order): ?>
	<?php foreach ($order as $result): ?>
	<div class="col-lg-12">
		<strong><?php echo '#'.$result['order_code'].' - '.statusOrder($result['order_status']) ?></strong>
		<span class="position-right">Ngày đặt: <?php echo date('H:i:s d-m-Y', strtotime($result['order_date'])); ?></span>
	</div>
	<div class="col-lg-12 product-v2-heading">
		<div class="row">
			<div class="col-lg-4">
				<span>Địa chỉ người nhận</span>
				<div class="col-lg-12 back-white product-v2-heading" style="min-height: 140px; border: 1px solid grey">
					<strong><?php echo $result['fullname']; ?></strong>
					<p>Địa chỉ: <?php echo $result['address'].', '.$result['full_location']; ?></p>
					<p>Điện thoại: <?php echo $result['mobile']; ?></p>
				</div>
			</div>
			<div class="col-lg-4">
				<span>Hình thức giao hàng</span>
				<div class="col-lg-12 back-white product-v2-heading" style="min-height: 140px;border: 1px solid grey">
					<strong>Giao hàng tiết kiệm</strong>
					<p>Phí vận chuyển: 35.000đ</p>
				</div>
			</div>
			<div class="col-lg-4">
				<span>Hình thức thanh toán</span>
				<div class="col-lg-12 back-white product-v2-heading" style="min-height: 140px;border: 1px solid grey">
					<p><?php if ($result['payment_method'] == 1) echo 'Thanh toán VNPay';
							else echo 'Thanh toán khi nhận hàng'; ?></p>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-12">
		<p style="height:10px; background-color:#f5f5f5;"></p>
	</div>
	<div class="col-lg-12">
		<div class="col-lg-12 back-white product-v2-heading" style="border: 1px solid grey">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-4">
						<strong>Sản phẩm</strong>
					</div>
					<div class="col-lg-2 text-center">
						<strong>Đơn giá</strong>
					</div>
					<div class="col-lg-2 text-center">
						<strong>Số lượng</strong>
					</div>
					<div class="col-lg-2 text-center">
						<strong>Giảm giá</strong>
					</div>
					<div class="col-lg-2 text-center">
						<strong>Tạm tính</strong>
					</div>
				</div>
			</div>
			<?php if (isset($order_product) && $order_product): ?>
			<?php foreach ($order_product as $result_product): ?>
			<div class="row product-v2-heading">
				<div class="col-lg-12" style="height: 78px;">
					<div class="col-lg-4">
						<div class="row">
							<div class="col-lg-5">
								<img src="<?php echo base_url('uploads/product_image/'.$result_product['path']) ?>"
									 style="height: auto; max-height:78px; width:78px;" alt="iphone 12">
							</div>
							<div class="col-lg-7" style="margin-left:-30px; width:(100% + 30px);">
								<div class="row">
									<span><?php echo $result_product['name']; ?></span>
									<p><?php if (isset($result_product['color']) && $result_product['color'] != '' )
										echo 'Màu '.$result_product['color']; ?></p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-2 text-center">
						<span><?php echo convertPrice($result_product['price']); ?>đ</span>
					</div>
					<div class="col-lg-2 text-center">
						<span><?php echo $result_product['quantity']; ?></span>
					</div>
					<div class="col-lg-2 text-center">
						<span>0đ</span>
					</div>
					<div class="col-lg-2 text-center">
						<span><?php echo convertPrice($result_product['price']*$result_product['quantity']); ?>đ</span>
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="row product-v2-heading">
					<p style="height:1px;background-color:#cccccc"></p>
				</div>
			</div>
			<?php endforeach; ?>
			<?php endif; ?>
			<div class="row product-v2-heading">
				<div class="col-lg-12">
					<div class="col-lg-4 position-right">
						<div class="col-lg-12">
							<span>Tạm tính</span>
							<strong class="position-right"><?php echo convertPrice($result['total_bill']); ?>đ</strong>
						</div>
						<div class="col-lg-12">
							<span>Giảm giá</span>
							<strong class="position-right">0đ</strong>
						</div>
						<div class="col-lg-12">
							<span>Phí vận chuyển</span>
							<strong class="position-right">35.000đ</strong>
						</div>
						<div class="col-lg-12">
							<span>Tổng cộng</span>
							<strong class="position-right" style="color: #ff424e"><?php echo convertPrice($result['total_bill'] + 35000); ?>đ</strong>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
	<?php endif; ?>
</div>
