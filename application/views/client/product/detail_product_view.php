<?php include('application/views/errors/error_message_view.php'); ?>
<div class="row pop">
	<?php if (isset($detail_product) && $detail_product): ?>
		<?php foreach ($detail_product as $product_detail): ?>
			<div class="col-lg-12">
				<ul class="breadcrumb">
					<li>
						<a href="#"><?php echo $product_detail['category_name']; ?></a>
						<meta property="position" content="1">
					</li>
					<li>
						<a href="#"><?php echo $product_detail['category_name']; ?><?php if ($product_detail['brand_name'] == 'Apple') echo 'iPhone (Apple)';
							else echo $product_detail['brand_name']; ?></a>
						<meta property="position" content="2">
					</li>
				</ul>
			</div>
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-6">
						<h4 style="display: inline-block"><?php echo $product_detail['category_name'] . ' ' . $product_detail['product_name']; ?></h4>
						<div class="detail-rate" style="display: inline-block">
							<?php if (isset($sub_stars)): ?>
								<p>
									<?php for ($i = 0; $i < round($sub_stars); $i++): ?>
										<i class="fa fa-star"></i>
									<?php endfor; ?>
									<?php for ($i = 0; $i < (5 - round($sub_stars)); $i++): ?>
										<i class="fa fa-star-o" style="color: #ff7033"></i>
									<?php endfor; ?>
								</p>
							<?php endif; ?>
							<p class="detail-rate-total"><?php echo isset($product_review) ? count($product_review) : '0'; ?>
								<span>đánh giá</span></p>
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
										<?php for ($i = 1; $i <= count($product_image); $i++): ?>
											<li data-target="#myCarousel" data-slide-to="<?php echo $i; ?>"></li>
										<?php endfor; ?>
									<?php endif; ?>
								</ol>
								<!-- Wrapper for slides -->
								<div class="carousel-inner" role="listbox">
									<div class="item active">
										<img src="<?php echo base_url('uploads/product_image/' . $product_detail['path']); ?>"
											 alt="Chania"
											 style="width: auto;height: 434px; max-width: 651px;">
									</div>
									<?php if (isset($product_image) && $product_image): ?>
										<?php foreach ($product_image as $result_image): ?>
											<div class="item">
												<img src="<?php echo base_url('uploads/product_image/' . $result_image['path']) ?>"
													 alt="Chania"
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
									<?php if (isset($child_product) && $child_product): ?>
										<?php foreach ($child_product as $result_child): ?>
											<div class="text-center product-child active-product">
												<input type="hidden" value="<?php echo $result_child['product_id']; ?>">
												<div class="product-child-v2" id="img-child-product">
													<a name="child_product">
														<img class="img-child"
															 src="<?php echo base_url('uploads/product_image/' . $result_child['path']); ?>">
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
							<p class="content-max"
							   id="div-description"><?php if ($product_detail['product_description'] != ''):
									echo $product_detail['product_description']; ?>
								<?php else: ?>
							<p class="content-max"><?php echo 'Chưa có mô tả cho sản phẩm này'; ?></p>
							<?php endif; ?>
							<div class="col-lg-12 more-detail" id="description">
								<span>Xem thêm <i class="fa fa-caret-down"></i></span>
							</div>
						</div>
						<div class="col-lg-12 back-white alert-login"
							 style="border: 1px solid #cccccc; border-radius: 10px">
							<h4>Đánh
								giá <?php echo $product_detail['category_name'] . ' ' . $product_detail['product_name']; ?></h4>
							<div class="detail-rate" style="display: inline-block">
								<?php if (isset($sub_stars)): ?>
									<p>
										<b style="font-size: 20px;color: #ff7033"><?php echo isset($sub_stars) ? $sub_stars : '0' ?></b>
										<?php for ($i = 0; $i < round($sub_stars); $i++): ?>
											<i class="fa fa-star"></i>
										<?php endfor; ?>
										<?php for ($i = 0; $i < (5 - round($sub_stars)); $i++): ?>
											<i class="fa fa-star-o" style="color: #ff7033"></i>
										<?php endfor; ?>
									</p>
								<?php endif; ?>
								<span><?php echo isset($product_review) ? count($product_review) : '0'; ?> đánh giá</span>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<p style="height:1px; background-color: #cccccc;"></p>
								</div>
							</div>
							<?php $max_show = 0;
							if (isset($product_review) && $product_review): ?>
								<?php foreach ($product_review as $result_review): $max_show++; ?>
									<?php if ($max_show == 5) break; ?>
									<div class="row">
										<div class="col-lg-12">
											<img src="<?php if (isset($result_review['avatar']) && $result_review['avatar'])
												echo base_url('uploads/avatar_image/' . $result_review['avatar']);
											else echo base_url('public/images/avatar-png.jpg') ?>" id="avatar_header"
												 style="border-color: grey">
											<strong><?php echo $result_review['fullname']; ?></strong>
										</div>
										<div class="col-lg-12">
											<div class="detail-rate" style="display: inline-block">
												<p>
													<?php for ($i = 0; $i < $result_review['stars']; $i++): ?>
														<i class="fa fa-star"></i>
													<?php endfor; ?>
													<?php for ($i = 0; $i < (5 - $result_review['stars']); $i++): ?>
														<i class="fa fa-star-o" style="color: #ff7033"></i>
													<?php endfor; ?>
												</p>
											</div>
										</div>
										<div class="col-lg-12 content-product">
											<p><?php echo $result_review['content']; ?></p>
										</div>
										<?php if (count($result_review['path']) > 0): ?>
											<?php foreach ($result_review['path'] as $img): ?>
												<img src="<?php echo base_url('uploads/review_image/' . $img['path']) ?>"
													 alt="<?php echo $img['path'] ?>" height="125px"
													 width="125px" class="review_image"
													 style="margin-left: 7px; margin-bottom: 7px; border-radius: 10px"
												>
											<?php endforeach; ?>
										<?php endif; ?>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<p style="height:1px; background-color: #cccccc;"></p>
										</div>
									</div>
								<?php endforeach; ?>
							<?php endif; ?>
							<div class="row product-v2-heading text-center">
								<div class="col-lg-12">
									<button class="btn btn-all-review">Xem tất cả đánh giá</button>
									<button class="btn btn-add-review" id="review-btn">Viết đánh giá</button>
								</div>
							</div>
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
							<div class="col-lg-12"><strong
										class="stock_product"><?php if ($product_detail['product_status'] == 0)
										echo 'CÒN HÀNG'; else echo 'HẾT HÀNG'; ?></strong></div>
							<div class="col-lg-12">
								<a id="check_store">Xem cửa hàng có hàng</a>
							</div>
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
								<h4>Cấu
									hình <?php echo $product_detail['category_name'] . ' ' . $product_detail['product_name'] ?></h4>
							</div>
							<div class="col-lg-12">
								<?php if (isset($attribute_product) && $attribute_product): ?>
									<?php $i = -1;
									foreach ($attribute_product as $attribute): $i++; ?>
										<?php if ($i == 9) {
											break;
										} ?>
										<div class="col-lg-4">
											<p><?php echo $attribute['name']; ?>:</p>
										</div>
										<div class="col-lg-8">
											<p><?php echo $attribute['value']; ?></p>
										</div>
									<?php endforeach; ?>
									<div id="more-setting" style="display: none">
										<?php $j = -1;
										foreach ($attribute_product as $attribute): $j++; ?>
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
								<?php else: ?>
									<div class="col-lg-12">
										<p>Chưa có thông tin cấu hình cho sản phẩm này</p>
									</div>
								<?php endif; ?>
								<div class="col-lg-12 more-detail" id="more-detail">
									<span>Xem thêm cấu hình chi tiết <i class="fa fa-caret-down"></i></span>
								</div>
							</div>
							<div class="col-lg-12">
								<h4>Sản phẩm liên quan</h4>
							</div>
							<div class="col-lg-12">
								<div class="listproduct-connect">
									<?php if (isset($product_connect) && $product_connect): ?>
										<?php foreach ($product_connect as $result_phone): ?>
											<div class="item">
												<a href="<?php echo base_url('client/product/detail/' . $result_phone['product_id']) ?>">
													<div class="item-label"></div>
													<div class="item-img">
														<img class="img-product"
															 src="<?php echo base_url('uploads/product_image/' . $result_phone['path'] . '') ?>"
															 style="width: 197px;height: auto">
														<h3><?php echo $result_phone['name']; ?></h3>
														<strong class="price"><?php echo convertPrice($result_phone['price']); ?>
															₫</strong>
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
					<span><?php echo $product_detail['category_name'] . ' ' . $product_detail['product_name']; ?></span>
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
						<?php if (isset($child_product) && $child_product): ?>
							<?php foreach ($child_product as $result_child): ?>
								<div class="item-popup text-center">
									<div>
										<img src="<?php echo base_url('uploads/product_image/' . $result_child['path']); ?>"
											 style="width: 50px;height: auto">
									</div>
									<div><input type="radio" value="<?php echo $result_child['product_id']; ?>"
												name="product_id" data-error="#error"></div>
									<strong><?php echo $result_child['color']; ?></strong>
								</div>
							<?php endforeach; ?>
						<?php else: ?>
							<div class="item-popup text-center">
								<div>
									<img src="<?php echo base_url('uploads/product_image/' . $product_detail['path']); ?>"
										 style="width: 50px;height: auto">
								</div>
								<div><input type="radio" value="<?php echo $product_detail['product_id']; ?>"
											name="product_id" data-error="#error"></div>
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
					<span><?php echo $product_detail['category_name'] . ' ' . $product_detail['product_name']; ?></span>
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
						<?php if (isset($child_product) && $child_product): ?>
							<?php foreach ($child_product as $result_child): ?>
								<div class="item-popup text-center">
									<div>
										<img src="<?php echo base_url('uploads/product_image/' . $result_child['path']); ?>"
											 style="width: 50px;height: auto">
									</div>
									<div><input type="radio" value="<?php echo $result_child['product_id']; ?>"
												name="product_id" data-error="#error_add"></div>
									<strong><?php echo $result_child['color']; ?></strong>
								</div>
							<?php endforeach; ?>
						<?php else: ?>
							<div class="item-popup text-center">
								<div>
									<img src="<?php echo base_url('uploads/product_image/' . $product_detail['path']); ?>"
										 style="width: 50px;height: auto">
								</div>
								<div><input type="radio" value="<?php echo $product_detail['product_id']; ?>"
											name="product_id" data-error="#error_add"></div>
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
<div class="popup-review">
	<form method="POST" id="review-form" enctype="multipart/form-data">
		<div class="row" style="margin-top: 10px">
			<div class="col-lg-12">
				<div class="col-lg-10">
					<strong>Đánh giá</strong>
				</div>
				<div class="col-lg-2"><i class="fa fa-remove close-btn"></i></div>
			</div>
			<div class="col-lg-12 product-v2-heading">
				<div class="col-lg-12">
					<p style="height:1px; background-color: #cccccc;"></p>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="col-lg-12">
					<textarea class="form-control text-rate" placeholder="Mời bạn chia sẻ một số cảm nhận"
							  name="content"><?php echo set_value('content') ?></textarea>
					<span style="color: red"><?php echo form_error('content') ?></span>
				</div>
				<div class="col-lg-12 product-v2-heading">
					<input type="file" id="img-review" name="img-review[]" style="display: none" multiple>
					<label for="img-review" class="file-btn-rate"><i class="fa fa-camera"></i> Gửi hình chụp thực
						tế</label>
					<span style="color: red"><?php echo form_error('img-review') ?></span>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-lg-6">
							<span>Bạn cảm thấy sản phẩm này như thế nào?(Chọn sao nhé)</span>
						</div>
						<div class="col-lg-6 text-center">
							<div class="star-widget" style="display: inline-block;">
								<input type="radio" name="rate" id="rate-5" value="5"
										<?php echo set_value('rate') == 5 ? 'checked' : '' ?>>
								<label for="rate-5" class="fa fa-star"></label>
								<input type="radio" name="rate" id="rate-4" value="4"
										<?php echo set_value('rate') == 4 ? 'checked' : '' ?>>
								<label for="rate-4" class="fa fa-star"></label>
								<input type="radio" name="rate" id="rate-3" value="3"
										<?php echo set_value('rate') == 3 ? 'checked' : '' ?>>
								<label for="rate-3" class="fa fa-star"></label>
								<input type="radio" name="rate" id="rate-2" value="2"
										<?php echo set_value('rate') == 2 ? 'checked' : '' ?>>
								<label for="rate-2" class="fa fa-star"></label>
								<input type="radio" name="rate" id="rate-1" value="1"
										<?php echo set_value('rate') == 1 ? 'checked' : '' ?>>
								<label for="rate-1" class="fa fa-star"></label>
							</div>
							<span style="color: red"><?php echo form_error('rate') ?></span>
						</div>
					</div>
				</div>
			</div>
			<?php if (!isset($_SESSION['login'])): ?>
				<div class="col-lg-12">
					<div class="col-lg-4">
						<input type="text" id="fullname" name="fullname" class="form-control form-border"
							   placeholder="Họ và tên" value="<?php echo set_value('fullname') ?>">
						<span style="color: red"><?php echo form_error('fullname') ?></span>
					</div>
					<div class="col-lg-4">
						<input type="text" id="mobile" name="mobile" class="form-control form-border"
							   placeholder="Số điện thoại" value="<?php echo set_value('mobile') ?>">
						<span style="color: red"><?php echo form_error('mobile') ?></span>
					</div>
					<div class="col-lg-4">
						<input type="text" id="email" name="email" class="form-control form-border"
							   placeholder="Email" value="<?php echo set_value('email') ?>">
						<span style="color: red"><?php echo form_error('email') ?></span>
					</div>
				</div>
			<?php endif; ?>
			<div class="col-lg-12" style="margin-bottom: 10px">
				<div class="col-lg-12">
					<button type="submit" id="review" name="review" class="btn btn-add more-detail">Gửi đánh giá ngay
					</button>
				</div>
			</div>
		</div>
	</form>
</div>
<div class="popup-check">
	<form id="check_store_form">
		<div class="row" style="margin-top: 10px">
			<div class="col-lg-12">
				<div class="col-lg-10">
					<strong>Xem siêu thị có hàng</strong>
				</div>
				<div class="col-lg-2"><i class="fa fa-remove close-btn"></i></div>
			</div>
			<div class="col-lg-12 product-v2-heading">
				<div class="col-lg-12">
					<p style="height:1px; background-color: #cccccc;"></p>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="col-lg-10">
					<strong>Chọn màu cần kiểm tra:</strong>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="col-lg-12">
					<div class="listproduct" style="grid-template-columns: repeat(7,minmax(0,1fr));">
						<?php if (isset($child_product) && $child_product): ?>
							<?php foreach ($child_product as $result_child): ?>
								<div class="item-popup text-center">
									<div>
										<img src="<?php echo base_url('uploads/product_image/' . $result_child['path']); ?>"
											 style="width: 50px;height: auto">
									</div>
									<div><input type="radio" value="<?php echo $result_child['product_id']; ?>"
												name="product_id" data-error="#error_check"></div>
									<strong><?php echo $result_child['color']; ?></strong>
								</div>
							<?php endforeach; ?>
						<?php else: ?>
							<div class="item-popup text-center">
								<div>
									<img src="<?php echo base_url('uploads/product_image/' . $product_detail['path']); ?>"
										 style="width: 50px;height: auto">
								</div>
								<div><input type="radio" value="<?php echo $product_detail['product_id']; ?>"
											name="product_id" data-error="#error"></div>
								<strong>Mặc định</strong>
							</div>
						<?php endif; ?>
					</div>
					<div class="div_error">
						<div id="error_check"></div>
					</div>
				</div>
			</div>
			<div class="col-lg-12" style="margin-top: 10px;">
				<div class="col-lg-6">
					<select class="form-control form-border" name="province" id="province">
						<option value="-1">- Tỉnh/TP -</option>
						<?php if (isset($province) && $province): ?>
							<?php foreach ($province as $result_province): ?>
								<option value="<?php echo $result_province['id']; ?>"><?php echo $result_province['name']; ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>
				<div class="col-lg-6">
					<select class="form-control form-border" name="district" id="district">
						<option value="-1">- Quận/Huyện -</option>
					</select>
				</div>
			</div>
			<div class="col-lg-12 product-v2-heading">
				<div class="col-lg-12">
					<p style="height:1px; background-color: #cccccc;"></p>
				</div>
			</div>
			<div class="col-lg-12" style="margin-bottom: 10px;">
				<div class="col-lg-12" id="ajax_check_stock"></div>
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

	document.querySelector('#review-btn').addEventListener('click', function () {
		document.querySelector('.popup-review').classList.add('active-popup-add');
		document.querySelector('.pop').classList.add('background-popup');
	});
	document.querySelector('.popup-review .close-btn').addEventListener('click', function () {
		document.querySelector('.popup-review').classList.remove('active-popup-add');
		document.querySelector('.pop').classList.remove('background-popup');
	});

	document.querySelector('#check_store').addEventListener('click', function () {
		document.querySelector('.popup-check').classList.add('active-popup-add');
		document.querySelector('.pop').classList.add('background-popup');
	});
	document.querySelector('.popup-check .close-btn').addEventListener('click', function () {
		document.querySelector('.popup-check').classList.remove('active-popup-add');
		document.querySelector('.pop').classList.remove('background-popup');
	});
	document.querySelector('#description').addEventListener('click', function () {
		if (document.querySelector('#div-description').className == 'content-max') {
			document.querySelector('#div-description').classList.remove('content-max');
			document.querySelector('#description').children[0].children[0].classList.remove('fa-caret-down');
			document.querySelector('#description').children[0].children[0].classList.add('fa-caret-up');
		} else {
			document.querySelector('#div-description').classList.add('content-max');
			document.querySelector('#description').children[0].children[0].classList.remove('fa-caret-up');
			document.querySelector('#description').children[0].children[0].classList.add('fa-caret-down');
		}
	});
	document.querySelector('#more-detail').addEventListener('click', function () {
		if (document.querySelector('#more-setting').style.display == 'none') {
			document.querySelector('#more-setting').style.display = 'block';
			document.querySelector('#more-detail').children[0].children[0].classList.remove('fa-caret-down');
			document.querySelector('#more-detail').children[0].children[0].classList.add('fa-caret-up');
		} else {
			document.querySelector('#more-setting').style.display = 'none';
			document.querySelector('#more-detail').children[0].children[0].classList.remove('fa-caret-up');
			document.querySelector('#more-detail').children[0].children[0].classList.add('fa-caret-down');
		}
	});

	var product_id = document.getElementsByName('product_id');
	for (i = 0; i < product_id.length; i++) {
		var input = product_id[i];
		input.addEventListener('click', function () {
			var params = [];
			params['product_id'] = this.value;
			params['province'] = document.getElementById('province').value;
			params['district'] = document.getElementById('district').value;
			callAjaxAddress(params, window.ajax_url.ajax_stock_store);
		})
	}
	;

	document.getElementById('district').addEventListener('change', function () {
		var params = [];
		params['product_id'] = $('input[name="product_id"]:checked').val();
		params['province'] = document.getElementById('province').value;
		params['district'] = document.getElementById('district').value;
		callAjaxAddress(params, window.ajax_url.ajax_stock_store);
	});

	$(document).ready(function () {
		$("#buy-form").validate({
			rules: {
				product_id: "required",
				quantity: {
					min: 1,
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
			errorPlacement: function (error, element) {
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
					min: 1,
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
			errorPlacement: function (error, element) {
				var placement = $(element).data('error');
				if (placement) {
					$(placement).append(error)
				} else {
					error.insertAfter(element);
				}
			}
		});
		$("#check_store_form").validate({
			rules: {
				product_id: "required",
				province: "min",
				district: "min",
			},
			messages: {
				product_id: '<h5 style="color: red; height: 0px;">Vui lòng chọn màu sản phẩm!</h5>',
				province: '<h5 style="color: red; height: 0px;">Vui lòng chọn Tỉnh/TP!</h5>',
				district: '<h5 style="color: red; height: 0px;">Vui lòng chọn Quận/Huyện!</h5>',
			},
			errorPlacement: function (error, element) {
				var placement = $(element).data('error');
				if (placement) {
					$(placement).append(error)
				} else {
					error.insertAfter(element);
				}
			}
		});
		filterAddress('province', window.ajax_url.district_list);
	});

	function filterAddress(id, url_ajax) {
		$('#' + id).change(function () {
			document.getElementById('district').value = -1;
			var id_address = $('#' + id).val();
			getDistrictStockStoreByProvince(id_address, url_ajax);
			var params = [];
			params['product_id'] = $('input[name="product_id"]:checked').val();
			params['province'] = id_address;
			params['district'] = document.getElementById('district').value;
			callAjaxAddress(params, window.ajax_url.ajax_stock_store);
		});
	}

	function callAjaxAddress(params, url_ajax) {
		$.ajax({
			url: url_ajax,
			type: 'POST',
			dataType: 'html',
			data: {
				product_id: params['product_id'],
				province: params['province'],
				district: params['district'],
			}
		}).done(function (result) {
			$('#ajax_check_stock').html(result);
		})
		$(document).ajaxError(function () {
		});
	}

	function getDistrictStockStoreByProvince(id_address, url_ajax) {
		$.ajax({
			url: url_ajax,
			type: 'POST',
			dataType: 'html',
			data: {
				id_address: id_address
			}
		}).done(function (result) {
			$('#district').html(result);
		})
		$(document).ajaxError(function () {
		});
	}

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
