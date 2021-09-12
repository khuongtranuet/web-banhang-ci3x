<?php if (isset($stock_store) && $stock_store): ?>
<div class="stock_list">
	<ul>
		<?php foreach ($stock_store as $result_store): ?>
			<li><?php echo $result_store['repository_name'] . ', ' . $result_store['address'] . ', ' . $result_store['full_location']; ?></li>
		<?php endforeach; ?>
	</ul>
</div>
<?php elseif(isset($stock_store) && is_array($stock_store)): ?>
	<strong>Hiện không có hàng tại khu vực này</strong>
<?php endif; ?>

