<table class="table table-bordered" id="tableuser">
	<thead>
	<tr>
		<th class="text-center">STT</th>
		<th class="text-center">Tên sản phẩm</th>
		<th class="text-center">Thương hiệu</th>
		<td class="text-center">Danh mục</td>
		<th class="text-center">Đơn giá</th>
		<th class="text-center">Tình trạng</th>
		<th class="text-center">Đã bán</th>
		<th class="text-center">Xử lý</th>
	</tr>
	</thead>
	<tbody>
	<?php  if (count($result_product) > 0 && is_array($result_product)):
		foreach ($result_product as $key => $data): ?>
			<tr>
				<td class="text-center"><?php echo ($from + $key + 1); ?></td>
				<td><?php echo $data['name']; ?></td>
				<td><?php echo $data['brand']? $data['brand'] : 'Thương hiệu khác'; ?></td>
				<td><?php echo $data['category']? $data['category'] : 'Danh mục khác'; ?></td>
				<td style="text-align: right"><?php $str_reverse = strrev($data['price']);
					$total_trim = ceil(strlen($data['price'])/3);
					$str_final = '';
					for($i=0; $i < $total_trim; $i++) {
						$str_trim = substr($str_reverse, ($i)*3, 3);
						if($i < $total_trim - 1) {
							$str_final .= $str_trim . '.';
						}else{
							$str_final .= $str_trim;
						}
					}
					$data['price'] = strrev($str_final);
					echo $data['price'].' VNĐ';
					?>
				</td>
				<td><?php
					if (isset($data['status'])) {
						if($data['status'] == 0) {
							echo 'Hết hàng';
						} else {
							echo 'Còn hàng';
						}
					} else {
						echo 'Sản phẩm chưa có trong kho';
					}
					?>
				</td>
				<td style="text-align: right"><?php echo $data['sold']; ?></td>
				<td class="text-center " style="width: 110px;">
					<a href="<?php echo base_url('admin/category/detail/'.$data['id'].'') ?>"
					   title="Nhấn để xem chi tiết">
						<i class="fa fa-eye"></i>
					</a>&nbsp
					<a href="<?php echo base_url('admin/category/edit/'.$data['id'].'') ?>"
					   title="Nhấn để chỉnh sửa">
						<i class="fa fa-pencil-square"></i>
					</a>&nbsp
					<a href="<?php echo base_url('admin/category/delete/'.$data['id'].'') ?>"
					   title="Nhấn để xóa" style="color: red"
					   onclick="return confirm('Bạn muốn xóa người dùng <?php echo $data['name']; ?> này không?')">
						<i class="fa fa-trash"></i>
					</a>&nbsp
				</td>
			</tr>
		<?php endforeach; ?>
	<?php elseif (count($result_product) == 0): ?>
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
