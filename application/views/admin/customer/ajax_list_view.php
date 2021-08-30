<table class="table table-bordered" id="tablecustomer">
	<thead>
	<tr>
		<th class="text-center">STT</th>
		<th class="text-center">Họ và tên</th>
		<th class="text-center">Email</th>
		<th class="text-center">Số điện thoại</th>
		<th class="text-center">Loại</th>
		<th class="text-center">Trạng thái</th>
		<th class="text-center">Xử lý</th>
	</tr>
	</thead>
	<tbody>
	<?php  if (count($result_customer) > 0 && is_array($result_customer)):
		foreach ($result_customer as $key => $customer_list): ?>
			<tr>
				<td class="text-center"><?php echo ($from + $key + 1); ?></td>
				<td><?php echo $customer_list['fullname']; ?></td>
				<td><?php echo $customer_list['email']; ?></td>
				<td><?php echo $customer_list['mobile']; ?></td>
				<td><?php if ($customer_list['type'] == 1) echo 'Người dùng hệ thống';
					else echo 'Khách vãng lai'?></td>
				<td><?php if ($customer_list['status'] == 0 ) echo 'Chưa kích hoạt';
					elseif ($customer_list['status'] == 1) echo 'Đã kích hoạt';
					else echo 'Tạm khóa';?></td>
				<td class="text-center " style="width: 110px;">
						<a href="<?php echo base_url('admin/customer/detail/'.$customer_list['id'].'') ?>"
						   title="Nhấn để xem chi tiết">
							<i class="fa fa-eye"></i>
						</a>&nbsp
						<a href="<?php echo base_url('admin/customer/edit/'.$customer_list['id'].'') ?>"
						   title="Nhấn để chỉnh sửa">
							<i class="fa fa-pencil-square"></i>
						</a>&nbsp
						<a href="<?php echo base_url('admin/customer/delete/'.$customer_list['id'].'') ?>"
						   title="Nhấn để xóa" style="color: red"
						   onclick="return confirm('Bạn muốn xóa người dùng <?php echo $customer_list['fullname']; ?> này không?')">
							<i class="fa fa-trash"></i>
						</a>&nbsp
				</td>
			</tr>
		<?php endforeach; ?>
	<?php elseif (count($result_customer) == 0): ?>
		<tr>
			<td colspan="7">Không có dữ liệu</td>
		</tr>
	<?php endif; ?>
	</tbody>
</table>
<div class="text-center" style="margin-bottom: 20px;">
	<?php echo $pagination_link; ?>
</div>
<?php die(); ?>
