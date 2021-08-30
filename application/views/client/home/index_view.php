<?php include ('application/views/errors/error_message_view.php');?>
<div class="row">
	<div class="col-lg-9" style="padding-top:20px">
		<div id="myCarousel" class="carousel slide" data-ride="carousel">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
				<li data-target="#myCarousel" data-slide-to="1"></li>
				<li data-target="#myCarousel" data-slide-to="2"></li>
				<li data-target="#myCarousel" data-slide-to="3"></li>
			</ol>
			<!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
				<div class="item active">
					<img src="<?php echo base_url('public/images/header/slide1.png') ?>" alt="Chania" width="460"
						 height="345">
				</div>
				<div class="item">
					<img src="<?php echo base_url('public/images/header/slider2.png') ?>" alt="Chania" width="460"
						 height="345">
				</div>
				<div class="item">
					<img src="<?php echo base_url('public/images/header/slider3.png') ?>" alt="Flower" width="460"
						 height="345">
				</div>
				<div class="item">
					<img src="<?php echo base_url('public/images/header/slider4.png') ?>" alt="Flower" width="460"
						 height="345">
				</div>
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
	<div class="col-lg-3" style="padding-top:20px">
		<div class="row preorder-hot">
			<img src="<?php echo base_url('public/images/header/anhvuong1.png') ?>" alt="Anh iphone 11"
				 class="img-slider"/>

			<img src="<?php echo base_url('public/images/header/anhvuong2.png') ?>" alt="Anh iphone"
				 class="img-slider"/>

			<img src="<?php echo base_url('public/images/header/anhvuong3.png') ?>" alt="Anh iphone 11"
				 class="img-slider"/>

			<img src="<?php echo base_url('public/images/header/anhvuong4.png') ?>" alt="Anh iphone"
				 class="img-slider"/>
		</div>
	</div>
	<div class="col-lg-12">
		<h3 style="font-weight: 600;display: inline-block;">ĐIỆN THOẠI NỔI BẬT NHẤT</h3>
		<a class="position-right all_product"><h3 style="font-size: 15px;">Xem tất cả điện thoại</h3></a>
	</div>
	<div class="col-lg-12">
		<div class="listproduct">
			<?php if (isset($product_list) && $product_list): ?>
			<?php foreach ($product_list as $result_phone): ?>
			<div class="item">
				<a href="<?php echo base_url('client/product/detail/'.$result_phone['id'])?>">
					<div class="item-label"></div>
					<div class="item-img">
						<img class="img-product" src="<?php echo base_url('uploads/product_image/'.$result_phone['path'].'') ?>"
							 style="width: 197px;height: auto">
						<h3><?php echo $result_phone['name']; ?></h3>
						<?php $str_reverse = strrev($result_phone['price']);
						$total_trim = ceil(strlen($result_phone['price'])/3);
						$str_final = '';
						for($i=0; $i < $total_trim; $i++) {
							$str_trim = substr($str_reverse, ($i)*3, 3);
							if($i < $total_trim - 1) {
								$str_final .= $str_trim . '.';
							}else{
								$str_final .= $str_trim;
							}
						}
						$result_phone['price'] = strrev($str_final); ?>
						<strong class="price"><?php echo $result_phone['price']; ?>₫</strong>
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
			<?php endif; ?>
		</div>
	</div>
	<div class="col-lg-12">
		<h3 style="font-weight: 600;display: inline-block;">LAPTOP, TABLE NỔI BẬT NHẤT</h3>
		<a class="position-right all_product"><h3 style="font-size: 15px;">Xem tất cả laptop, table</h3></a>
	</div>
	<div class="col-lg-12">
		<div class="listproduct">
			<?php if (isset($laptop_list) && $laptop_list): ?>
				<?php foreach ($laptop_list as $result_laptop): ?>
					<div class="item">
						<a href="<?php echo base_url('client/product/detail/'.$result_laptop['id'])?> ">
							<div class="item-label"></div>
							<div class="item-img">
								<img class="img-product" src="<?php echo base_url('uploads/product_image/'.$result_laptop['path'].'') ?>"
									 style="width: 197px;height: auto">
								<h3><?php echo $result_laptop['name']; ?></h3>
								<?php $str_reverse = strrev($result_laptop['price']);
								$total_trim = ceil(strlen($result_laptop['price'])/3);
								$str_final = '';
								for($i=0; $i < $total_trim; $i++) {
									$str_trim = substr($str_reverse, ($i)*3, 3);
									if($i < $total_trim - 1) {
										$str_final .= $str_trim . '.';
									}else{
										$str_final .= $str_trim;
									}
								}
								$result_laptop['price'] = strrev($str_final); ?>
								<strong class="price"><?php echo $result_laptop['price']; ?>₫</strong>
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
			<?php endif; ?>
		</div>
	</div>
	<div class="col-lg-12">
		<h3 style="font-weight: 600;display: inline-block;">PHỤ KIỆN NỔI BẬT NHẤT</h3>
		<a class="position-right all_product"><h3 style="font-size: 15px;">Xem tất cả phụ kiện</h3></a>
	</div>
</div>
