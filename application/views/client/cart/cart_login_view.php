<div class="row">
	<div class="col-lg-12">
		<h4 class="title-cart">GIỎ HÀNG</h4>
	</div>
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-9">
				<div class="col-lg-12" style="background-color:white;">
					<div class="row product-v2-heading">
						<div class="col-lg-5">
							<input type="checkbox" id="allproduct" name="allproduct" value="-1"
								   style="margin-top:3px; padding-top:3px">
							<span> Tất cả (<?php if (isset($product_list)) {
									echo count($product_list);
								} ?> sản phẩm)</span>
						</div>
						<div class="col-lg-2">
							<span>Đơn giá</span>
						</div>
						<div class="col-lg-2">
							<span>Số lượng</span>
						</div>
						<div class="col-lg-2">
							<span>Thành tiền</span>
						</div>
						<div class="col-lg-1">
							<a href="#" id="delete_all">
								<i class="fa fa-trash-o"></i>
							</a>
						</div>
					</div>
					<div class="row">
						<p style="height:10px; background-color:#f5f5f5;"></p>
					</div>
					<?php $i=0; if (isset($product_list) && $product_list): ?>
						<?php foreach ($product_list as $result_product): $i++; ?>
						<div id="div-ajax">
							<div class="row product-v2-heading" style="height: 98px;">
								<div class="col-lg-5">
									<div class="row">
										<div class="col-lg-5">
											<input type="checkbox" name="product"
												   value="<?php echo $result_product['product_id']; ?>"
												   style="margin-top:3px; padding-top:3px;">
											<img src="<?php echo base_url('uploads/product_image/' . $result_product['path']) ?>"
												 style="height:auto; width:78px; max-height: 78px;">
										</div>
										<div class="col-lg-7" style="margin-left:-30px; width:(100% + 30px);">
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
									<strong><?php echo convertPrice($result_product['price']); ?>đ</strong>
								</div>
								<div class="col-lg-2">
									<button name="decrease" class="quatity-cart">-</button>
									<input type="text" name="quantity" disabled
										   value="<?php echo $result_product['quantity']; ?>" class="quatity-cart">
									<button name="increase" class="quatity-cart">+</button>
								</div>
								<div class="col-lg-2">
									<strong style=" color:#ff424e;"><?php echo convertPrice(($result_product['price'] * $result_product['quantity'])); ?>đ</strong>
								</div>
								<div class="col-lg-1">
									<a href="<?php echo base_url('client/cart/delete?cus_id='.$result_product['customer_id'].'&pd_id='.$result_product['product_id'])?>">
										<i class="fa fa-trash-o"></i>
									</a>
								</div>
								<input type="hidden" name="customer_id"
									   value="<?php echo $result_product['customer_id']; ?>">
							</div>
						</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="col-lg-12" style=" background-color:white;">
					<?php if (isset($customer_address) && $customer_address): ?>
					<?php foreach ($customer_address as $result_address): ?>
					<div class="row product-v2-heading">
						<div class="col-lg-12">
							<strong>Giao tới</strong>
							<a href="<?php echo base_url('client/payment/shipping') ?>" class="position-right">Thay đổi</a>
						</div>
						<div class="col-lg-12 product-v2-heading">
							<strong><?php echo $result_address['address_fullname']; ?></strong>
							<strong class="position-right"><?php echo $result_address['address_mobile']; ?></strong>
						</div>
						<div class="col-lg-12 product-v2-heading">
							<span><?php echo $result_address['address'].', '.$result_address['full_location']; ?></span>
						</div>
					</div>
					<?php endforeach; ?>
					<?php endif; ?>
					<div class="row">
						<p style=" height:10px; background-color:#f5f5f5;"></p>
					</div>
<!--					<div class="row product-v2-heading">-->
<!--						<div class="col-lg-12" style="text-align:center">-->
<!--							<a href="#">-->
<!--								<i class="fa fa-percent"></i>-->
<!--								<span> Dùng mã giảm giá </span>-->
<!--								<span class="caret"></span>-->
<!--							</a>-->
<!--						</div>-->
<!--					</div>-->
<!--					<div class="row">-->
<!--						<p style=" height:10px;background-color:#f5f5f5"></p>-->
<!--					</div>-->
					<div class="row product-v2-heading" id="ajax_total">
						<div class="col-lg-12">
							<span>Tạm tính</span>
							<span class="position-right" id="tamtinh">0đ</span>
						</div>
						<div class="col-lg-12">
							<span>Giảm giá</span>
							<span class="position-right">0đ</span>
						</div>
						<div class="col-lg-12">
							<span>VAT</span>
							<span class="position-right">0đ</span>
						</div>
						<div class="col-lg-12">
							<div class="row product-v2-heading">
								<p style="height:1px;background-color:#cccccc"></p>
							</div>
						</div>
						<div class="col-lg-12">
							<span>Tổng cộng</span>
							<strong class="position-right" style="color:#ff424e;">0đ</strong>
						</div>
					</div>
				</div>
				<button class="btn btn-primary button-cart" type="submit" name="submit" id="submit">Mua hàng</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var increase = document.getElementsByName('increase');
	var decrease = document.getElementsByName('decrease');
	var customer_id = document.querySelector('[name="customer_id"]').value;
	var product = document.getElementsByName('product');

	var product_id = [];
	var quantity = [];
	for (var i = 0; i < product.length; i++) {
		var button_product = product[i];
		button_product.addEventListener('click', function () {
			if(this.checked) {
				for(var j = 0; j < product.length; j++) {
					if(product_id[j] == undefined) {
						product_id[j] = this.value;
						quantity[j] = (this.parentElement.parentElement.parentElement.parentElement.children[2].children[1]).value;
					 	break;
					}
				}
			}else{
				for(var j = 0; j < product.length; j++) {
					if(product_id[j] == this.value) {
						product_id.splice(j, 1);
						quantity.splice(j, 1);
						break;
					}
				}
			}
			call(product_id, quantity, window.ajax_url.total_cart);
		});
	}
	var is_delete = '';
	for (var i = 0; i < increase.length; i++) {
		var button = increase[i];
		button.addEventListener('click', (event) => {
			var buttonClicked = event.target;
			var input = buttonClicked.parentElement.children[1];
			var inputValue = input.value;
			var newValue = parseInt(inputValue) + 1;
			input.value = newValue;
			// console.log((buttonClicked.parentElement.parentElement.children[0].children[0].children[0].children[0]).value);
			var params = [];
			params['product_id'] = (buttonClicked.parentElement.parentElement.children[0].children[0].children[0].children[0]).value;
			params['quantity'] = newValue;
			callAjax(window.ajax_url.cart_list, params);
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
				// console.log((buttonClicked.parentElement.parentElement.children[0].children[0].children[0].children[0]).value);
				var params = [];
				params['product_id'] = (buttonClicked.parentElement.parentElement.children[0].children[0].children[0].children[0]).value;
				params['quantity'] = newValue;
				callAjax(window.ajax_url.cart_list, params);
			} else {
				if(confirm('Bạn muốn xóa sản phẩm này?')){
					var params = [];
					params['product_id'] = (buttonClicked.parentElement.parentElement.children[0].children[0].children[0].children[0]).value;
					params['quantity'] = newValue;
					callAjax(window.ajax_url.cart_list, params);
				}else{
					input.value = 1;
					newValue = 1;
				}
			}

		})
	}
	$('#delete_all').click(function () {
		var product_id = [];
		if(confirm('Bạn muốn xóa sản phẩm đang chọn?')){
			$('input[name="product"]:checked').each(function(index) {
				product_id[index] = this.value;
			});
			if (product_id.length == 0) {
				alert('Vui lòng chọn sản phẩm để xóa');
			}else{
				is_delete = true;
				var params = [];
				params['product_id'] = product_id;
				params['quantity'] = '';
				params['is_delete'] = is_delete;
				callAjax(window.ajax_url.cart_list, params);
			}
		}
	});
	$('#allproduct').click(function () {
		if($('input[name="allproduct"]').is(':checked')) {
			$('input[name="product"]').each(function() {
				this.checked = true;
			});
		}else{
			$('input[name="product"]').each(function() {
				this.checked = false;
			});
		}
	});
	$('#submit').click(function () {
		var product_id = [];
		var quantity = [];
		$('input[name="product"]:checked').each(function(index) {
			product_id[index] = this.value;
			quantity[index] = (this.parentElement.parentElement.parentElement.parentElement.children[2].children[1]).value;
		});
		if(product_id.length == 0) {
			alert('Bạn vẫn chưa chọn sản phẩm nào để mua!');
		}else{
			var params = [];
			params['product_id'] = product_id;
			params['quantity'] = quantity;
			params['submit'] = 'submit';
			callAjax(window.ajax_url.cart_list, params);
		}
	});
	function callAjax(url_ajax, params) {
		$.ajax({
			url: url_ajax,
			type: 'POST',
			dataType: 'html',
			data: {
				product_id: params['product_id'],
				quantity: params['quantity'],
				customer_id: customer_id,
				is_delete: is_delete,
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
	function call(product_id, quantity, url_ajax) {
		$.ajax({
			url: url_ajax,
			type: 'POST',
			dataType: 'html',
			data: {
				product_id: product_id,
				quantity: quantity,
			}
		}).done(function (result) {
			$('#ajax_total').html(result);
		})
		$(document).ajaxError(function () {
		});
	}
</script>
