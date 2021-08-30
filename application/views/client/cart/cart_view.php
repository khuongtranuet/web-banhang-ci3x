<div class="row">
	<div class="col-lg-12">
		<div class="cart">
			<div class="col-lg-12">
				<a href="<?php echo base_url('client/admin/index') ?>" style="float:left">
					<i class="fa fa-chevron-left"></i> Mua thêm sản phẩm khác
				</a>
				<span class="position-right">Giỏ hàng của bạn</span>
			</div>
			<div class="col-lg-12" style="background-color:white">
				<div class="product-item"></div>
				<div class="total-provisional row">
					<div class="col-lg-12">
						<span>Tạm tính (0 sản phẩm):</span>
						<span class="position-right">đ</span>
					</div>
				</div>
				<div class="row">
					<p style="height:1px; background-color: #cccccc;"></p>
				</div>
				<div class="row">
					<span class="col-lg-12">THÔNG TIN KHÁCH HÀNG:</span>
					<div class="col-lg-12">
						<div class="row setting-cart">
							<div class="col-lg-4">
								<div class="row">
									<div class="col-lg-6">
										<label class="radio-inline">
											<input type="radio" name="gender_customer" value="1">Anh
										</label>
									</div>
									<div class="col-lg-6">
										<label class="radio-inline">
											<input type="radio" name="gender_customer" value="0">Chị
										</label>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="row  cart-info">
							<div class="col-lg-6">
								<input type="text" id="fullname" name="fullname" class="form-control"
									   placeholder="Họ và tên">
							</div>
							<div class="col-lg-6">
								<input type="text" id="mobile" name="mobile" class="form-control"
									   placeholder="Số điện thoại">
							</div>
						</div>
					</div>
					<div class="col-lg-12 setting-cart">
						<div class="col-lg-12" style="background-color:#f6f6f6">
							<div class="row">
								<div class="col-lg-12 setting-cart">CHỌN ĐỊA CHỈ VÀ THỜI GIAN NHẬN HÀNG:</div>
								<div class="col-lg-12">
									<div class="row setting-cart">
										<div class="col-lg-6">
											<select class="form-control" name="province" id="province">
												<option value="-1">- Tỉnh/TP -</option>
											</select>
										</div>
										<div class="col-lg-6">
											<select class="form-control" name="district" id="district">
												<option value="-1">- Quận/Huyện -</option>
											</select>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<select class="form-control" name="ward" id="ward">
												<option value="-1">- Phường/Xã -</option>
											</select>
										</div>
										<div class="col-lg-6">
											<input type="text" id="address" name="address" class="form-control"
												   placeholder="Số nhà, tên đường">
										</div>
									</div>
									<div class="row setting-cart">
										<div class="col-lg-12">
											<div class="col-lg-12 setting-cart"
												 style="background-color:white; marginBottom:20px;">
												<span>Giao trước 10h hôm nay (27/08)</span>
												<span class="position-right">Chọn ngày giờ khác </span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-12">
						<input type="text" id="note" name="note" class="form-control" placeholder="Yêu cầu khác (không bắt buộc)">
					</div>
					<div class="col-lg-12 setting-cart">
						<div class="row">
							<p style="height:1px; background-color:#cccccc;"></p>
						</div>
						<div class="row">
							<div class="col-lg-5">
								<div class="col-lg-12 discount-cart">
									<i class="fa fa-percent"></i>
									<span> Dùng mã giảm giá </span>
									<span class="caret"></span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-12 setting-cart">
						<div class="row">
							<p style="height:1px; background-color:#cccccc;"></p>
						</div>
						<strong>Tổng tiền:</strong>
						<strong class="position-right" style="color:#f30c28;">đ</strong>
					</div>
					<div class="col-lg-12">
						<button class="btn btn-primary button-cart">ĐẶT HÀNG</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
