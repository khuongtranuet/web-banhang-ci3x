<table class="table table-bordered" id="tableuser">
	<thead>
	<tr>
		<th class="text-center">STT</th>
		<th class="text-center">Tên danh mục</th>
		<th class="text-center">Mô tả</th>
		<th class="text-center">Xử lý</th>
	</tr>
	</thead>
	<tbody>
	<?php  if (count($result_category) > 0 && is_array($result_category)):
		foreach ($result_category as $key => $category_list): ?>
			<tr>
				<td class="text-center"><?php echo ($from + $key + 1); ?></td>
				<td><?php echo $category_list['name']; ?></td>
				<td><?php echo $category_list['description']; ?></td>
				<td class="text-center " style="width: 110px;">
					<a href="<?php echo base_url('admin/category/detail/'.$category_list['id'].'') ?>"
					   title="Nhấn để xem chi tiết">
						<i class="fa fa-eye"></i>
					</a>&nbsp
					<a href="<?php echo base_url('admin/category/edit/'.$category_list['id'].'') ?>"
					   title="Nhấn để chỉnh sửa">
						<i class="fa fa-pencil-square"></i>
					</a>&nbsp
					<a href="<?php echo base_url('admin/category/delete/'.$category_list['id'].'') ?>"
					   title="Nhấn để xóa" style="color: red"
					   onclick="return confirm('Bạn muốn xóa danh mục <?php echo $category_list['name']; ?> này không?')">
						<i class="fa fa-trash"></i>
					</a>&nbsp
				</td>
			</tr>
		<?php endforeach; ?>
	<?php elseif (count($result_category) == 0): ?>
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
