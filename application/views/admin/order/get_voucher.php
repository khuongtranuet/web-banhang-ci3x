<option value="-1">Chọn voucher</option>
<?php if (count($voucher) > 0): ?>
	<?php foreach ($voucher as $data): ?>
		<option value="<?php echo $data['id'] ?>"><?php echo $data['name'] ?></option>
	<?php endforeach; ?>
<?php
endif;
die();
?>
