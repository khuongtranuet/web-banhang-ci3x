<table class="table table-bordered" id="tablerepository">
	<thead>
	<tr>
		<th class="text-center">STT</th>
		<th class="text-center">Tên sản phẩm</th>
		<th class="text-center">Danh mục sản phẩm</th>
		<th class="text-center">Số lượng</th>
		<th class="text-center">Xử lý</th>
	</tr>
	</thead>
	<tbody>
	<?php  if (count($detail_repository) > 0 && is_array($detail_repository)):
		foreach ($detail_repository as $key => $repository_list): ?>
			<tr>
				<td class="text-center"><?php echo ($from + $key + 1); ?></td>
				<td><?php echo $repository_list['name']; ?></td>
				<td><?php echo $repository_list['mobile']; ?></td>
				<td><?php echo $repository_list['address'].', '.$repository_list['full_location'] ?></td>
				<td class="text-center " style="width: 110px;">
					<a href="<?php echo base_url('admin/repository/detail/'.$repository_list['id'].'') ?>"
					   title="Nhấn để xem chi tiết">
						<i class="fa fa-eye"></i>
					</a>&nbsp
					<a href="<?php echo base_url('admin/repository/edit/'.$repository_list['id'].'') ?>"
					   title="Nhấn để chỉnh sửa">
						<i class="fa fa-pencil-square"></i>
					</a>&nbsp
					<a href="<?php echo base_url('admin/repository/delete/'.$repository_list['id'].'') ?>"
					   title="Nhấn để xóa" style="color: red"
					   onclick="return confirm('Bạn muốn xóa <?php echo $repository_list['name']; ?> này không?')">
						<i class="fa fa-trash"></i>
					</a>&nbsp
				</td>
			</tr>
		<?php endforeach; ?>
	<?php elseif (count($detail_repository) == 0): ?>
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
