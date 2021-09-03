<?php if (isset($product_list) && $product_list): ?>
<?php foreach ($product_list as $result_product): ?>
	<div class="row product-v2-heading">
		<div class="col-lg-5">
			<div class="row">
				<div class="col-lg-5">
					<input type="checkbox" id="product" name="product"
						   value="<?php echo $result_product['product_id']; ?>"
						   style="margin-top:3px; padding-top:3px;">
					<img src="<?php echo base_url('uploads/product_image/' . $result_product['path']) ?>"
						 style="height:78px; width:78px;">
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
			<?php $str_reverse = strrev($result_product['price']);
			$total_trim = ceil(strlen($result_product['price']) / 3);
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
			<strong><?php echo $price; ?>đ</strong>
		</div>
		<div class="col-lg-2">
			<button id="decrease" name="decrease" class="quatity-cart">-</button>
			<input type="text" id="quantity" name="quantity"
				   value="<?php echo $result_product['quantity']; ?>" class="quatity-cart">
			<button id="increase" name="increase" class="quatity-cart">+</button>
		</div>
		<div class="col-lg-2">
			<?php $str_reverse = strrev(($result_product['price'] * $result_product['quantity']));
			$total_trim = ceil(strlen(($result_product['price'] * $result_product['quantity'])) / 3);
			$str_final = '';
			for ($i = 0; $i < $total_trim; $i++) {
				$str_trim = substr($str_reverse, ($i) * 3, 3);
				if ($i < $total_trim - 1) {
					$str_final .= $str_trim . '.';
				} else {
					$str_final .= $str_trim;
				}
			}
			$price_total = strrev($str_final); ?>
			<strong style=" color:#ff424e;"><?php echo $price_total; ?>đ</strong>
		</div>
		<div class="col-lg-1">
			<a href="#">
				<i class="fa fa-trash-o"></i>
			</a>
		</div>
		<input type="hidden" id="customer_id" name="customer_id"
			   value="<?php echo $result_product['customer_id']; ?>">
	</div>
<?php endforeach; ?>
<?php endif; ?>
