<?php if (isset($result_order) && $result_order): ?>
<?php foreach ($result_order as $order_list): ?>
<div class="row product-v2-heading">
	<div class="col-lg-2 text-center">
		<a href="<?php echo base_url('client/order/detail/'.$order_list['id']) ?>"><?php echo $order_list['code']; ?></a>
	</div>
	<div class="col-lg-2 text-center">
		<p><?php echo date('d-m-Y', strtotime($order_list['order_date'])); ?></p>
	</div>
	<div class="col-lg-3">
		<p>Điện thoại iPhone 12 64GB</p>
	</div>
	<div class="col-lg-2 text-center">
		<p><?php echo convertPrice($order_list['total_bill']) ?>đ</p>
	</div>
	<div class="col-lg-2">
		<p><?php echo statusOrder($order_list['status']); ?></p>
	</div>
	<div class="col-lg-1 text-center">
		<a href="<?php echo base_url('client/order/detail/'.$order_list['id']) ?>" class="">Chi tiết</a>
	</div>
</div>
<?php endforeach; ?>
<?php endif; ?>
<div class="row text-center" style="margin-bottom: 20px;">
	<?php echo $pagination_link; ?>
</div>
