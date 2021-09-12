<div class="col-lg-12">
	<span>Tạm tính</span>
	<?php if (isset($total)) {
		$str_reverse = strrev($total);
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
		$price = strrev($str_final);
	}?>
	<span class="position-right" id="tamtinh"><?php echo $price; ?>đ</span>
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
	<strong class="position-right" style="color:#ff424e;"><?php echo $price; ?>đ</strong>
</div>
