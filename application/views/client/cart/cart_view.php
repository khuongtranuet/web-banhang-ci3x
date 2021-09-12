<?php include ('application/views/errors/error_message_view.php');?>
<div class="row">
	<div class="col-lg-12">
		<div class="cart">
			<div class="col-lg-12">
				<a href="<?php echo base_url('client/home/index') ?>" style="float:left">
					<i class="fa fa-chevron-left"></i> Mua thêm sản phẩm khác
				</a>
				<span class="position-right">Giỏ hàng của bạn</span>
			</div>
			<div class="col-lg-12" style="background-color:white">
				<div class="product-item">
					<div id="div-ajax">
						<?php $i = -1; $total_cost = 0;
							if (isset($product_list) && $product_list): ?>
						<?php foreach ($product_list as $result_product):
							$i++; $total_cost += ($result_product['price']*$quantity[$i]);?>
						<div class="row product-v2-heading" style="height: 98px;">
							<div class="col-lg-8">
								<div class="row">
									<a href="<?php echo base_url('client/product/detail/'.$result_product['product_parent'])?>">
										<div class="col-lg-4">
											<img src="<?php echo base_url('uploads/product_image/'.$result_product['path']); ?>"
												 style="height:auto; width:78px; max-height: 78px;">
										</div>
									</a>
									<div class="col-lg-8" style=" width:(100% + 30px);">
										<div class="row">
											<strong><?php echo $result_product['product_name']; ?></strong>
										</div>
										<div class="row">
											<a href="#">Màu: Đen <span class="caret"></span></a>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4 text-right">
								<div class="row">
									<div class="col-lg-12">
										<strong style=" color:#ff424e;"><?php echo convertPrice($result_product['price']); ?>đ</strong>
									</div>
								</div>
								<div class="row product-v2-heading">
									<div class="col-lg-12">
										<button name="decrease" class="quatity-cart">-</button>
										<input type="text" name="quantity" disabled
											   value="<?php echo $quantity[$i]; ?>" class="quatity-cart">
										<button name="increase" class="quatity-cart">+</button>
										<input type="hidden" value="<?php echo $result_product['product_id']; ?>">
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<a href="<?php echo base_url('client/cart/delete?product_id='.$result_product['product_id']); ?>"
										   onclick="if(!confirm('Bạn có muốn xóa sản phẩm này không?')) {return false;}">
											<i class="fa fa-trash-o"></i>
										</a>
									</div>
								</div>
							</div>
<!--							<input type="hidden" name="customer_id"-->
<!--								   value="1">-->
						</div>
						<div class="row">
							<p style="height:1px; background-color: #cccccc;"></p>
						</div>
						<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
				<div class="total-provisional row">
					<div class="col-lg-12">
						<span>Tạm tính (<?php echo count($product_list); ?> sản phẩm):</span>
						<span class="position-right" id="total_cost"><?php echo convertPrice($total_cost); ?>đ</span>
					</div>
				</div>
				<div class="row">
					<p style="height:1px; background-color: #cccccc;"></p>
				</div>
				<div class="row">
					<form method="POST" id="info-customer">
					<span class="col-lg-12">THÔNG TIN KHÁCH HÀNG:</span>
					<div class="col-lg-12">
						<div class="row setting-cart">
							<div class="col-lg-4">
								<div class="row">
									<div class="col-lg-6">
										<label class="radio-inline">
											<input type="radio" name="gender" value="1">Anh
										</label>
									</div>
									<div class="col-lg-6">
										<label class="radio-inline">
											<input type="radio" name="gender" value="0">Chị
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
												<?php if(isset($province) && $province):?>
													<?php foreach ($province as $result_province):?>
														<option value="<?php echo $result_province['id']; ?>"><?php echo $result_province['name']; ?></option>
													<?php endforeach; ?>
												<?php endif; ?>
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
												<option value="-1">- Xã/Phường/Thị trấn -</option>
											</select>
										</div>
										<div class="col-lg-6">
											<input type="text" id="address" name="address" class="form-control"
												   placeholder="Số nhà, tên đường">
										</div>
									</div>
<!--									<div class="row setting-cart">-->
<!--										<div class="col-lg-12">-->
<!--											<div class="col-lg-12 setting-cart"-->
<!--												 style="background-color:white; marginBottom:20px;">-->
<!--												<span>Giao trước 10h hôm nay (27/08)</span>-->
<!--												<span class="position-right">Chọn ngày giờ khác </span>-->
<!--											</div>-->
<!--										</div>-->
<!--									</div>-->
								</div>
							</div>
						</div>
					</div>
<!--					<div class="col-lg-12">-->
<!--						<input type="text" id="note" name="note" class="form-control" placeholder="Yêu cầu khác (không bắt buộc)">-->
<!--					</div>-->
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
						<strong class="position-right" style="color:#f30c28;"><?php echo convertPrice($total_cost); ?>đ</strong>
					</div>
					<div class="col-lg-12">
						<button type="submit" id="" name="submit" class="btn btn-primary button-cart">ĐẶT HÀNG</button>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var increase = document.getElementsByName('increase');
		var decrease = document.getElementsByName('decrease');

		for (var i = 0; i < increase.length; i++) {
			var button = increase[i];
			button.addEventListener('click', (event) => {
				var buttonClicked = event.target;
				var input = buttonClicked.parentElement.children[1];
				var inputValue = input.value;
				var newValue = parseInt(inputValue) + 1;
				input.value = newValue;
				console.log(buttonClicked.parentElement.children[3].value);
				var params = [];
				params['product_id'] = buttonClicked.parentElement.children[3].value;
				params['quantity'] = newValue;
				callAjaxProduct(window.ajax_url.cart_list, params);
			})
		}
		for (var i = 0; i < decrease.length; i++) {
			var button = decrease[i];
			button.addEventListener('click', (event) => {
				var buttonClicked = event.target;
				var input = buttonClicked.parentElement.children[1];
				var inputValue = input.value;
				var newValue = parseInt(inputValue) - 1;
				if (newValue > 0) {
					input.value = newValue;
					console.log(buttonClicked.parentElement.children[3].value);
					var params = [];
					params['product_id'] = buttonClicked.parentElement.children[3].value;
					params['quantity'] = newValue;
					callAjaxProduct(window.ajax_url.cart_list, params);
				} else {
					if(confirm('Bạn muốn xóa sản phẩm này?')){
						var params = [];
						params['product_id'] = buttonClicked.parentElement.children[3].value;
						params['quantity'] = newValue;
						callAjaxProduct(window.ajax_url.cart_list, params);
					}else{
						input.value = 1;
					}
				}

			})
		}
		$(document).ready(function () {
			filterAddress('province', window.ajax_url.district_list);
			filterAddress('district', window.ajax_url.ward_list);

			$("#info-customer").validate({
				rules: {
					fullname: "required",
					mobile: {
						required: true,
						maxlength: 15,
					},
					province: "min",
					district: "min",
					ward: "min",
					address: "required",
				},
				messages: {
					fullname: '<h5 style="color: red; height: 0px;">Vui lòng nhập họ và tên!</h5>',
					mobile: '<h5 style="color: red; height: 0px;">Vui lòng nhập số điện thoại!</h5>',
					province: '<h5 style="color: red; height: 0px;">Vui lòng chọn Tỉnh/TP!</h5>',
					district: '<h5 style="color: red; height: 0px;">Vui lòng chọn Quận/Huyện!</h5>',
					ward: '<h5 style="color: red; height: 0px;">Vui lòng chọn Xã/Phường!</h5>',
					address: '<h5 style="color: red; height: 0px;">Vui lòng nhập địa chỉ!</h5>',
				},
			});
		});

		function filterAddress(id, url_ajax) {
			$('#' + id).change(function () {
				var id_address = $('#' + id).val();
				callAjax(id_address, url_ajax);
			});
		}
		function callAjax(id_address, url_ajax) {
			$.ajax({
				url: url_ajax,
				type: 'POST',
				dataType: 'html',
				data: {
					id_address: id_address
				}
			}).done(function (result) {
				if (url_ajax == window.ajax_url.district_list) {
					$('#district').html(result);
					var html = '';
					html += '<option value="-1">- Xã/Phường/Thị trấn -</option>';
					$('#ward').html(html);
				}
				if (url_ajax == window.ajax_url.ward_list) {
					$('#ward').html(result);
				}
			})
			$(document).ajaxError(function () {
			});
		}
		function callAjaxProduct(url_ajax, params) {
			$.ajax({
				url: url_ajax,
				type: 'POST',
				dataType: 'html',
				data: {
					product_id: params['product_id'],
					quantity: params['quantity'],
				}
			}).done(function (result) {
				if (!params['submit']) {
					location.reload();
				}
				else{
					location.href = '/web-banhang-ci3x/client/payment/checkout';
				}
				// console.log(result);http://localhost:81
				// $('#div-ajax').html(result);
			})
			$(document).ajaxError(function () {
				$('#data-loading').hide();
			});
		}
	</script>
</div>
