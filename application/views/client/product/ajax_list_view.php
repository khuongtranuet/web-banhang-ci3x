<div class="row" style="margin-top: -10px; margin-bottom: 5px;">
	<div class="col-lg-2" style="margin-top: 6px;">
		<strong><?php if (isset($total_record) && isset($cate)) echo $total_record.' '.$cate['name']; ?></strong>
	</div>
</div>
<div class="listproduct">
<?php if (isset($result_product) && $result_product): ?>
	<?php foreach ($result_product as $result_phone): ?>
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
<?php endif; ?>
</div>
<?php if (count($result_product) == 0): ?>
<div class="text-center">
	<strong>KHÔNG CÓ DỮ LIỆU</strong>
</div>
<?php endif; ?>
<div class="text-center" style="margin-bottom: 20px; margin-top: 20px;">
	<?php echo $pagination_link; ?>
</div>
<?php die(); ?>
