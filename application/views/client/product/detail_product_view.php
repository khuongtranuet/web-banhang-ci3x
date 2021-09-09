<?php include ('application/views/errors/error_message_view.php');?>
<div class="row pop">
	<?php if(isset($detail_product) && $detail_product): ?>
	<?php foreach ($detail_product as $product_detail): ?>
	<div class="col-lg-12">
		<ul class="breadcrumb">
			<li>
				<a href="#"><?php echo $product_detail['category_name'];?></a>
				<meta property="position" content="1">
			</li>
			<li>
				<a href="#"><?php echo $product_detail['category_name'];?> <?php if ($product_detail['brand_name'] == 'Apple') echo 'iPhone (Apple)';
					else echo $product_detail['brand_name']; ?></a>
				<meta property="position" content="2">
			</li>
		</ul>
	</div>
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-6">
				<h4 style="display: inline-block"><?php echo $product_detail['category_name'].' '.$product_detail['product_name'];?></h4>
				<div class="detail-rate" style="display: inline-block">
					<p>
						<i class="fa fa-star"></i>
						<i class="fa fa-star"></i>
						<i class="fa fa-star"></i>
						<i class="fa fa-star"></i>
						<i class="fa fa-star-o"></i>
					</p>
					<p class="detail-rate-total">68 <span>đánh giá</span></p>
					<p class="detail-rate-total"><i class="fa fa-plus-circle"></i> So sánh</p>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-12">
		<p style="height:1px; background-color: #cccccc;"></p>
	</div>
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-7">
				<div id="my_carousel">
					<div id="myCarousel" class="carousel slide" data-ride="carousel">
						<!-- Indicators -->
						<ol class="carousel-indicators">
							<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
							<?php if (isset($product_image) && $product_image): ?>
								<?php for($i = 1; $i <= count($product_image); $i++): ?>
									<li data-target="#myCarousel" data-slide-to="<?php echo $i; ?>"></li>
								<?php endfor; ?>
							<?php endif; ?>
						</ol>
						<!-- Wrapper for slides -->
						<div class="carousel-inner" role="listbox">
							<div class="item active">
								<img src="<?php echo base_url('uploads/product_image/'.$product_detail['path']); ?>" alt="Chania"
									 style="width: auto;height: 434px; max-width: 651px;">
							</div>
							<?php if (isset($product_image) && $product_image): ?>
								<?php foreach ($product_image as $result_image): ?>
									<div class="item">
										<img src="<?php echo base_url('uploads/product_image/'.$result_image['path']) ?>" alt="Chania"
											 style="width: auto;height: 434px; max-width: 651px;">
									</div>
								<?php endforeach; ?>
							<?php endif; ?>
						</div>
						<!-- Left and right controls -->
						<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
							<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
							<span class="sr-only">Previous</span>
						</a>
						<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
							<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
							<span class="sr-only">Next</span>
						</a>
					</div>
				</div>
				<div class="row" style="margin-top: 10px;">
					<div class="col-lg-12">
						<div class="text-center">
							<?php if(isset($child_product) && $child_product): ?>
							<?php foreach ($child_product as $result_child): ?>
								<div class="text-center product-child active-product">
									<input type="hidden" value="<?php echo $result_child['product_id']; ?>">
									<div class="product-child-v2" id="img-child-product">
										<a name="child_product">
											<img class="img-child" src="<?php echo base_url('uploads/product_image/'.$result_child['path']); ?>">
										</a>
									</div>
									<span style="color: black;"><?php echo $result_child['color']; ?></span>
								</div>
							<?php endforeach; ?>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<h4>Mô tả sản phẩm</h4>
				<div class="col-lg-12 content-product">
					<p class="content-max" id="div-description"><?php if ($product_detail['product_description'] != ''): echo $product_detail['product_description']; ?>
					<div class="col-lg-12 more-detail" id="description">
						<span>Xem thêm <i class="fa fa-caret-down"></i></span>
					</div>
					<?php else: ?>
					<p class="content-max"><?php echo 'Chưa có mô tả cho sản phẩm này'; ?></p>
					<?php endif; ?>
<!--						else echo 'Chưa có mô tả cho sản phẩm này';?></p>-->
				</div>

			</div>
			<div class="col-lg-5">
				<div class="row">
					<div class="col-lg-12">
						<a class="btn">64GB</a>
						<a class="btn active-product">128GB</a>
						<a class="btn">256GB</a>
					</div>
					<div class="col-lg-12">Giá sản phẩm</div>
					<div class="col-lg-12"><h4><?php echo convertPrice($product_detail['price']); ?>₫</h4></div>
					<div class="col-lg-12"><strong class="stock_product"><?php if($product_detail['product_status'] == 0)
							echo 'CÒN HÀNG'; else echo 'HẾT HÀNG'; ?></strong></div>
					<div class="col-lg-12">
						<p style="height:1px; background-color: #cccccc;"></p>
					</div>
					<div class="col-lg-12">
						<button id="buy_now" class="btn btn-buy">MUA NGAY</button>
					</div>
					<div class="col-lg-12">
						<button id="add-cart" class="btn btn-add">THÊM VÀO GIỎ HÀNG</button>
					</div>
					<div class="col-lg-12">
						<p class="p-center">Gọi đặt mua <a>1800.0000</a> (7h30 - 22h)</p>
					</div>
					<div class="col-lg-12">
						<h4>Cấu hình <?php echo $product_detail['category_name'].' '.$product_detail['product_name'] ?></h4>
					</div>
					<div class="col-lg-12">
						<?php if (isset($attribute_product) && $attribute_product): ?>
						<?php $i=-1; foreach ($attribute_product as $attribute): $i++; ?>
						<?php if ($i == 9) { break;} ?>
						<div class="col-lg-4">
							<p><?php echo $attribute['name']; ?>:</p>
						</div>
						<div class="col-lg-8">
							<p><?php echo $attribute['value']; ?></p>
						</div>
						<?php endforeach; ?>
						<div id="more-setting" style="display: none">
						<?php $j=-1; foreach ($attribute_product as $attribute): $j++; ?>
							<?php if ($j >= 9): ?>
							<div class="col-lg-4">
								<p><?php echo $attribute['name']; ?>:</p>
							</div>
							<div class="col-lg-8">
								<p><?php echo $attribute['value']; ?></p>
							</div>
							<?php endif; ?>
						<?php endforeach; ?>
						</div>
						<div class="col-lg-12 more-detail" id="more-detail">
							<span>Xem thêm cấu hình chi tiết <i class="fa fa-caret-down"></i></span>
						</div>
						<?php else: ?>
						<div class="col-lg-12">
							<p>Chưa có thông tin cấu hình cho sản phẩm này</p>
						</div>
						<?php endif; ?>
					</div>
					<div class="col-lg-12">
						<h4>Sản phẩm liên quan</h4>
					</div>
					<div class="col-lg-12">
						<div class="listproduct-connect">
							<?php if (isset($product_connect) && $product_connect): ?>
							<?php foreach ($product_connect as $result_phone): ?>
								<div class="item">
									<a href="<?php echo base_url('client/product/detail/'.$result_phone['product_id'])?>">
										<div class="item-label"></div>
										<div class="item-img">
											<img class="img-product" src="<?php echo base_url('uploads/product_image/'.$result_phone['path'].'') ?>"
												 style="width: 197px;height: auto">
											<h3><?php echo $result_phone['name']; ?></h3>
											<strong class="price"><?php echo convertPrice($result_phone['price']); ?>₫</strong>
											<p class="item-gift">Quà <b>400.000₫</b></p>
											<div class="item-rating">
												<p>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star-o"></i>
												</p>
												<p class="item-rating-total">134</p>
											</div>
										</div>
									</a>
								</div>
							<?php endforeach; ?>
							<?php else: ?>
								<div class="col-lg-12">
									<p>Chưa có sản phẩm liên quan</p>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
	<?php endif; ?>
</div>
<div class="popup">
	<form method="POST" id="buy-form">
	<div class="row" style="margin-top: 10px">
		<div class="col-lg-12">
			<div class="col-lg-10">
				<span><?php echo $product_detail['category_name'].' '.$product_detail['product_name']; ?></span>
			</div>
			<div class="col-lg-2"><i class="fa fa-remove close-btn"></i></div>
		</div>
		<div class="col-lg-12">
			<div class="col-lg-10">
				<span style="color: #ff424e"><?php echo convertPrice($product_detail['price']); ?>₫</span>
			</div>
		</div>
		<div class="col-lg-12 product-v2-heading">
			<div class="col-lg-12">
				<p style="height:1px; background-color: #cccccc;"></p>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="col-lg-10">
				<strong>Chọn màu:</strong>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="col-lg-12">
				<div class="listproduct">
					<?php if(isset($child_product) && $child_product): ?>
					<?php foreach ($child_product as $result_child): ?>
					<div class="item-popup text-center">
						<div>
						<img src="<?php echo base_url('uploads/product_image/'.$result_child['path']); ?>"
							 style="width: 50px;height: auto">
						</div>
						<div><input type="radio" value="<?php echo $result_child['product_id']; ?>" name="product_id" data-error="#error"></div>
						<strong><?php echo $result_child['color']; ?></strong>
					</div>
					<?php endforeach; ?>
					<?php else: ?>
						<div class="item-popup text-center">
							<div>
								<img src="<?php echo base_url('uploads/product_image/'.$product_detail['path']); ?>"
									 style="width: 50px;height: auto">
							</div>
							<div><input type="radio" value="<?php echo $product_detail['product_id']; ?>" name="product_id" data-error="#error"></div>
							<strong>Mặc định</strong>
						</div>
					<?php endif; ?>
				</div>
				<div class="div_error">
					<div id="error"></div>
				</div>
			</div>
		</div>
		<div class="col-lg-12" style="margin-top: 10px">
			<div class="col-lg-12">
				<strong>Nhập số lượng:</strong>
<!--				<button name="decrease" class="quatity-cart">-</button>-->
				<input type="text" name="quantity" value="1" class="quatity-cart" data-error="#error_quantity">
<!--				<button name="increase" class="quatity-cart">+</button>-->
				<div class="div_error">
					<div id="error_quantity"></div>
				</div>
			</div>
		</div>
		<div class="col-lg-12 product-v2-heading">
			<div class="col-lg-12">
				<p style="height:1px; background-color: #cccccc;"></p>
			</div>
		</div>

		<div class="col-lg-12" style="margin-bottom: 10px">
			<div class="col-lg-12">
				<button id="buy" name="buy" class="btn btn-buy">MUA NGAY</button>
			</div>
		</div>
	</div>
	</form>
</div>
<div class="popup-add">
	<form method="POST" id="add-form">
	<div class="row" style="margin-top: 10px">
		<div class="col-lg-12">
			<div class="col-lg-10">
				<span><?php echo $product_detail['category_name'].' '.$product_detail['product_name']; ?></span>
			</div>
			<div class="col-lg-2"><i class="fa fa-remove close-btn"></i></div>
		</div>
		<div class="col-lg-12">
			<div class="col-lg-10">
				<span style="color: #ff424e"><?php echo convertPrice($product_detail['price']); ?>₫</span>
			</div>
		</div>
		<div class="col-lg-12 product-v2-heading">
			<div class="col-lg-12">
				<p style="height:1px; background-color: #cccccc;"></p>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="col-lg-10">
				<strong>Chọn màu:</strong>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="col-lg-12">
				<div class="listproduct">
					<?php if(isset($child_product) && $child_product): ?>
						<?php foreach ($child_product as $result_child): ?>
							<div class="item-popup text-center">
								<div>
									<img src="<?php echo base_url('uploads/product_image/'.$result_child['path']); ?>"
										 style="width: 50px;height: auto">
								</div>
								<div><input type="radio" value="<?php echo $result_child['product_id']; ?>" name="product_id" data-error="#error_add"></div>
								<strong><?php echo $result_child['color']; ?></strong>
							</div>
						<?php endforeach; ?>
					<?php else: ?>
						<div class="item-popup text-center">
							<div>
								<img src="<?php echo base_url('uploads/product_image/'.$product_detail['path']); ?>"
									 style="width: 50px;height: auto">
							</div>
							<div><input type="radio" value="<?php echo $product_detail['product_id']; ?>" name="product_id" data-error="#error_add"></div>
							<strong>Mặc định</strong>
						</div>
					<?php endif; ?>
				</div>
				<div class="div_error">
					<div id="error_add"></div>
				</div>
			</div>
		</div>
		<div class="col-lg-12" style="margin-top: 10px">
			<div class="col-lg-12">
				<strong>Nhập số lượng:</strong>
<!--				<button name="decrease-add" class="quatity-cart">-</button>-->
				<input type="text" name="quantity" value="1" class="quatity-cart" data-error="#error_quantity_add">
<!--				<button name="increase-add" class="quatity-cart">+</button>-->
				<div class="div_error">
					<div id="error_quantity_add"></div>
				</div>
			</div>
		</div>
		<div class="col-lg-12 product-v2-heading">
			<div class="col-lg-12">
				<p style="height:1px; background-color: #cccccc;"></p>
			</div>
		</div>
		<div class="col-lg-12" style="margin-bottom: 10px">
			<div class="col-lg-12">
				<button type="submit" id="add" name="add" class="btn btn-add">THÊM VÀO GIỎ HÀNG</button>
			</div>
		</div>
	</div>
	</form>
</div>
<script type="text/javascript">
	var child_product = document.getElementsByName('child_product');
	for (var i = 0; i < child_product.length; i++) {
		var button = child_product[i];
		button.addEventListener('click', (event) => {
			for (var j = 0; j < child_product.length; j++) {
				var div_image = child_product[j];
				div_image.parentElement.classList.remove('active-product');
			}
			var buttonClicked = event.target;
			buttonClicked.parentElement.parentElement.classList.add('active-product');
			var child_id = buttonClicked.parentElement.parentElement.parentElement.children[0].value;
			// console.log(child_id);
			var params = [];
			params['product_id'] = child_id;
			callAjax(window.ajax_url.carousel_list, params);
		});
	}
	document.querySelector('#buy_now').addEventListener('click', function () {
		document.querySelector('[name="quantity"]').value = 1;
		document.querySelector('.popup').classList.add('active-popup');
		document.querySelector('.pop').classList.add('background-popup');
	});
	document.querySelector('.popup .close-btn').addEventListener('click', function () {
		document.querySelector('.popup').classList.remove('active-popup');
		document.querySelector('.pop').classList.remove('background-popup');
	});

	document.querySelector('#add-cart').addEventListener('click', function () {
		document.querySelector('[name="quantity"]').value = 1;
		document.querySelector('.popup-add').classList.add('active-popup-add');
		document.querySelector('.pop').classList.add('background-popup');
	});
	document.querySelector('.popup-add .close-btn').addEventListener('click', function () {
		document.querySelector('.popup-add').classList.remove('active-popup-add');
		document.querySelector('.pop').classList.remove('background-popup');
	});
	document.querySelector('#description').addEventListener('click',function () {
		if (document.querySelector('#div-description').className == 'content-max') {
			document.querySelector('#div-description').classList.remove('content-max');
			document.querySelector('#description').children[0].children[0].classList.remove('fa-caret-down');
			document.querySelector('#description').children[0].children[0].classList.add('fa-caret-up');
		}else{
			document.querySelector('#div-description').classList.add('content-max');
			document.querySelector('#description').children[0].children[0].classList.remove('fa-caret-up');
			document.querySelector('#description').children[0].children[0].classList.add('fa-caret-down');
		}
	});
	document.querySelector('#more-detail').addEventListener('click',function () {
		if (document.querySelector('#more-setting').style.display == 'none') {
			document.querySelector('#more-setting').style.display = 'block';
			document.querySelector('#more-detail').children[0].children[0].classList.remove('fa-caret-down');
			document.querySelector('#more-detail').children[0].children[0].classList.add('fa-caret-up');
		}else{
			document.querySelector('#more-setting').style.display = 'none';
			document.querySelector('#more-detail').children[0].children[0].classList.remove('fa-caret-up');
			document.querySelector('#more-detail').children[0].children[0].classList.add('fa-caret-down');
		}
	});
	$(document).ready(function () {
		$("#buy-form").validate({
			rules: {
				product_id: "required",
				quantity: {
					min : 1,
					required: true,
				}
			},
			messages: {
				product_id: '<h5 style="color: red; height: 0px;">Vui lòng chọn màu sản phẩm!</h5>',
				quantity: {
					min: '<h5 style="color: red; height: 0px;">Số lượng phải lớn hơn 0!</h5>',
					required: '<h5 style="color: red; height: 0px;">Vui lòng nhập số lượng sản phẩm!</h5>',
				},
			},
			errorPlacement: function(error, element) {
				var placement = $(element).data('error');
				if (placement) {
					$(placement).append(error)
				} else {
					error.insertAfter(element);
				}
			}
		});
		$("#add-form").validate({
			rules: {
				product_id: "required",
				quantity: {
					min : 1,
					required: true,
				}
			},
			messages: {
				product_id: '<h5 style="color: red; height: 0px;">Vui lòng chọn màu sản phẩm!</h5>',
				quantity: {
					min: '<h5 style="color: red; height: 0px;">Số lượng phải lớn hơn 0!</h5>',
					required: '<h5 style="color: red; height: 0px;">Vui lòng nhập số lượng sản phẩm!</h5>',
				},
			},
			errorPlacement: function(error, element) {
				var placement = $(element).data('error');
				if (placement) {
					$(placement).append(error)
				} else {
					error.insertAfter(element);
				}
			}
		});
	});
	function callAjax(url_ajax, params) {
		$.ajax({
			url: url_ajax,
			type: 'POST',
			dataType: 'html',
			data: {
				product_id: params['product_id'],
			}
		}).done(function (result) {
			$('#my_carousel').html(result);
		})
		$(document).ajaxError(function () {
		});
	}
</script>
