<div class="row">
	<div class="col-lg-12">
		<h4 class="title-cart">ĐƠN HÀNG VÀ THANH TOÁN</h4>
	</div>
	<div class="col-lg-9 product-v2-heading">
		<strong>Đơn hàng</strong>
		<a href="<?php echo base_url('client/cart/detail'); ?>" class="position-right">Sửa đơn hàng</a>
	</div>
	<div class="col-lg-12">
		<form action="" method="POST">
			<div class="row">
				<div class="col-lg-9">
					<div class="col-lg-12" style="background-color:white;">
						<?php $total = 0;
						if (isset($product_list) && $product_list): ?>
							<?php foreach ($product_list as $result_product): ?>
								<div class="row product-v2-heading" style="height: 98px;">
									<div class="col-lg-8">
										<div class="row">
											<div class="col-lg-3">
												<img src="<?php echo base_url('uploads/product_image/' . $result_product['path']) ?>"
													 style="height:auto; width:78px; max-height: 78px;">
											</div>
											<div class="col-lg-9" style="margin-left:-30px; width:(100% + 30px);">
												<div class="row">
													<strong><?php echo $result_product['name']; ?></strong>
												</div>
												<div class="row">
													<a href="#">Màu: Đen <span class="caret"></span></a>
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-2">
										<strong>x<?php echo $result_product['quantity']; ?></strong>
									</div>
									<?php $total += $result_product['total_price'];
									$str_reverse = strrev($result_product['total_price']);
									$total_trim = ceil(strlen($result_product['total_price']) / 3);
									$str_final = '';
									for ($i = 0; $i < $total_trim; $i++) {
										$str_trim = substr($str_reverse, ($i) * 3, 3);
										if ($i < $total_trim - 1) {
											$str_final .= $str_trim . '.';
										} else {
											$str_final .= $str_trim;
										}
									}
									$price = strrev($str_final); ?>
									<div class="col-lg-2">
										<strong><?php echo $price; ?>đ</strong>
									</div>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
					<div class="row">
						<p style="height:10px; background-color:#f5f5f5;"></p>
					</div>
					<div class="row product-v2-heading">
						<div class="col-lg-12">
							<strong>Hình thức giao hàng</strong>
						</div>
					</div>
					<div class="col-lg-12" style="background-color:white;">
						<div class="row product-v2-heading">
							<div class="col-lg-12">
								<p>Giao hàng tiết kiệm</p>
							</div>
						</div>
					</div>
					<div class="row">
						<p style="height:10px; background-color:#f5f5f5;"></p>
					</div>
					<div class="row product-v2-heading">
						<div class="col-lg-12">
							<strong>Lựa chọn hình thức thanh toán</strong>
						</div>
					</div>
					<div class="col-lg-12" style="background-color:white;">
						<div class="row product-v2-heading">
							<div class="col-lg-12">
								<label class="radio-inline"><input type="radio" name="payment" value="0" checked>Thanh toán tiền
									mặt khi nhận hàng</label>
							</div>
							<div class="col-lg-12">
								<label class="radio-inline"><input type="radio" name="payment" value="1">Thanh toán bằng
									VNPay</label>
							</div>
							<div class="col-lg-12">
							<?php echo form_error('payment'); ?>
							</div>
						</div>
					</div>
					<button type="submit" name="submit" class="btn btn-primary btn-checkout" style="background-color: #fb6e2e">Đặt mua</button>
					<div class="row">
						<div class="col-lg-12">
							<p>(Xin vui lòng kiểm tra lại đơn hàng trước khi Đặt Mua)</p>
						</div>
					</div>
				</div>
				<div class="col-lg-3">
					<div class="col-lg-12" style=" background-color:white;">
						<?php if (isset($customer_address) && $customer_address): ?>
							<?php foreach ($customer_address as $result_address): ?>
								<div class="row product-v2-heading">
									<div class="col-lg-12">
										<strong>Địa chỉ giao hàng</strong>
										<a href="<?php if (isset($_SESSION['login'])) echo base_url('client/payment/shipping');
										else echo base_url('client/cart/detail'); ?>" class="position-right">Sửa</a>
									</div>
									<div class="col-lg-12 product-v2-heading">
										<strong><?php echo $result_address['address_fullname']; ?></strong>
									</div>
									<div class="col-lg-12 product-v2-heading">
										<span><?php echo $result_address['address'] . ', ' . $result_address['full_location']; ?></span>
										<p>Điện thoại: <?php echo $result_address['address_mobile']; ?></p>
									</div>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
						<div class="row">
							<p style=" height:10px; background-color:#f5f5f5;"></p>
						</div>
						<div class="row product-v2-heading">
							<div class="col-lg-12" style="text-align:center">
								<a href="#">
									<i class="fa fa-percent"></i>
									<span> Dùng mã giảm giá </span>
									<span class="caret"></span>
								</a>
							</div>
						</div>
						<div class="row">
							<p style=" height:10px;background-color:#f5f5f5"></p>
						</div>
						<div class="row product-v2-heading">
							<div class="col-lg-12">
								<span>Tạm tính</span>
								<?php $str_reverse = strrev($total);
								$total_trim = ceil(strlen($total) / 3);
								$str_final = '';
								for ($i = 0; $i < $total_trim; $i++) {
									$str_trim = substr($str_reverse, ($i) * 3, 3);
									if ($i < $total_trim - 1) {
										$str_final .= $str_trim . '.';
									} else {
										$str_final .= $str_trim;
									}
								}
								$temporary_price = strrev($str_final); ?>
								<span class="position-right"><?php echo $temporary_price; ?>đ</span>
							</div>
							<div class="col-lg-12">
								<span>Phí vận chuyển</span>
								<span class="position-right">35.000đ</span>
							</div>
							<div class="col-lg-12">
								<div class="row product-v2-heading">
									<p style="height:1px;background-color:#cccccc"></p>
								</div>
							</div>
							<div class="col-lg-12">
								<strong>Tổng cộng:</strong>
								<?php $str_reverse = strrev(($total + 35000));
								$total_trim = ceil(strlen(($total + 35000)) / 3);
								$str_final = '';
								for ($i = 0; $i < $total_trim; $i++) {
									$str_trim = substr($str_reverse, ($i) * 3, 3);
									if ($i < $total_trim - 1) {
										$str_final .= $str_trim . '.';
									} else {
										$str_final .= $str_trim;
									}
								}
								$final_price = strrev($str_final); ?>
								<strong class="position-right"
										style="color:#ff424e;font-size: 120%"><?php echo $final_price; ?>đ</strong>
							</div>
							<div class="col-lg-12">
								<i class="position-right">(Đã bao gồm VAT nếu có)</i>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
