<option value="-1">Chọn địa chỉ</option>
<?php if (count($address) > 0): ?>
	<?php foreach ($address as $data): ?>
		<option value="<?php echo $data['id'] ?>"
			<?php echo (set_value('address') == $data['id']) ? 'selected' : '' ?>
		><?php echo $data['address'] . ' ' . $data['full_location'] ?></option>
	<?php endforeach; ?>
<?php
endif;
die();
?>
