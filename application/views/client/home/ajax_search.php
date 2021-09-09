<?php if (isset($result_search) && $result_search): ?>
	<div class="col-lg-12">
		<div class="col-lg-10">
			<strong>Sản phẩm gợi ý</strong>
		</div>
		<div class="col-lg-2"><i class="fa fa-remove close-btn"></i></div>
	</div>
	<?php foreach ($result_search as $result_product): ?>
		<div class="col-lg-12">
			<div class="col-lg-12">
				<p style="height:1px; background-color: #cccccc;"></p>
			</div>
		</div>
		<a href="<?php echo base_url('client/product/detail/'.$result_product['product_id']); ?>" style="color: black">
			<div class="col-lg-12 product-v2-heading">
				<div class="col-lg-3">
					<img src="<?php echo base_url('uploads/product_image/' . $result_product['path']) ?>"
						 style="height:auto; width:60px; max-height: 60px;">
				</div>
				<div class="col-lg-9" style="margin-left: -30px; width:(100% + 30px);">
					<div class="col-lg-12">
						<span><?php echo $result_product['name'].' '.$result_product['product_name']; ?></span>
					</div>
					<div class="col-lg-12">
						<strong><?php echo convertPrice($result_product['price']); ?>đ</strong>
					</div>
				</div>
			</div>
		</a>
	<?php endforeach; ?>
<?php else: ?>
	<div class="col-lg-12 text-center" style="margin-bottom: 10px">
		<div class="col-lg-12">
			<strong>Không tìm thấy sản phẩm phù hợp</strong>
		</div>
	</div>
<?php endif; ?>
