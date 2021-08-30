<?php if (isset($district)):?>
	<option value="-1">- Quận/Huyện -</option>
	<?php if (isset($district) && $district): ?>
	<?php foreach ($district as $result_district):?>
	<option value="<?php echo $result_district['id']; ?>"><?php echo $result_district['name']; ?></option>
	<?php endforeach; ?>
	<?php endif; ?>
<?php endif; ?>

<?php if (isset($ward)): ?>
	<option value="-1">- Xã/Phường/Thị trấn -</option>
	<?php if (isset($ward) && $ward): ?>
	<?php foreach ($ward as $result_ward):?>
	<option value="<?php echo $result_ward['id']; ?>"><?php echo $result_ward['name']; ?></option>
	<?php endforeach; ?>
	<?php endif; ?>
<?php endif; ?>
<?php die(); ?>
