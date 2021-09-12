<table class="table table-bordered" id="tableuser">
	<thead>
	<tr>
		<th class="text-center">STT</th>
		<th class="text-center">Mã đơn hàng</th>
		<th class="text-center">Khách hàng</th>
		<th class="text-center">Tổng số tiền</th>
		<th class="text-center">Ngày đặt hàng</th>
		<th class="text-center">Trạng thái</th>
		<th class="text-center">Xử lý</th>
	</tr>
	</thead>
	<tbody>
	<?php  if (count($result_order) > 0 && is_array($result_order)):
		foreach ($result_order as $key => $data): ?>
			<tr>
				<td class="text-center"><?php echo ($from + $key + 1); ?></td>
				<td class="text-center"><?php echo $data['code']; ?></td>
				<td><?php echo $data['fullname'] ?></td>
				<td class="text-center"><?php $str_reverse = strrev($data['total_pay']);
					$total_trim = ceil(strlen($data['total_pay'])/3);
					$str_final = '';
					for($i=0; $i < $total_trim; $i++) {
						$str_trim = substr($str_reverse, ($i)*3, 3);
						if($i < $total_trim - 1) {
							$str_final .= $str_trim . '.';
						}else{
							$str_final .= $str_trim;
						}
					}
					$data['total_pay'] = strrev($str_final);
					echo $data['total_pay'].' VNĐ';
					?>
				</td>
				<td class="text-center"><?php echo $data['order_date'] ?></td>
				<td>
					<?php
						if ($data['payment_status'] == 1) {
							echo 'Đã thanh toán';
						} else {
							echo 'Chưa thanh toán';
						}
					?>
				</td>
				<td class="text-center " style="width: 110px;">
					<a href="<?php echo base_url('admin/order/detail/'.$data['id'].'') ?>"
					   title="Nhấn để xem chi tiết">
						<i class="fa fa-eye"></i>
					</a>&nbsp
					<a href="<?php echo base_url('admin/order/edit/'.$data['id'].'') ?>"
					   title="Nhấn để chỉnh sửa">
						<i class="fa fa-pencil-square"></i>
					</a>&nbsp
					<a href="<?php echo base_url('admin/order/delete/'.$data['id'].'') ?>"
					   title="Nhấn để xóa" style="color: red"
					   onclick="return confirm('Bạn muốn xóa đơn hàng <?php echo $data['code']; ?> này không?')">
						<i class="fa fa-trash"></i>
					</a>&nbsp
				</td>
			</tr>
		<?php endforeach; ?>
	<?php elseif (count($result_order) == 0): ?>
		<tr>
			<td colspan="7">Không có dữ liệu</td>
		</tr>
	<?php endif; ?>
	</tbody>
</table>
<div class="text-center" style="margin-bottom: 20px ">
	<?php echo $pagination_link; ?>
</div>
<?php die(); ?>
