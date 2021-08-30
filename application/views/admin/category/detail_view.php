<h3>Chi tiết danh mục</h3>
<form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
	<div class="form-group">
		<label class="control-label col-lg-2" for="name">Tên danh mục:</label>
		<div class="col-lg-4">
			<p style="padding-top: 7px"><?php echo $result['name'] ?></p>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-lg-2" for="description">Mô tả:</label>
		<div class="col-lg-10">
			<p class="read"
			   style="padding-top: 7px"><?php echo !empty($result['description']) ? nl2br($result['description']) : 'Chưa có dữ liệu' ?></p>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-lg-2" for="image">Ảnh danh mục:</label>
		<div class="col-lg-3">
			<?php if (!empty($result['image'])): ?>
				<img src="<?php echo base_url('uploads/category_image/' . $result['image']) ?>"
					 style="width: 100px; height: 100px;padding-top: 7px">
			<?php else: ?>
				<p style="padding-top: 7px">Chưa có dữ liệu</p>
			<?php endif; ?>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-lg-2" for="parent_id">Thuộc danh mục:</label>
		<div class="col-lg-3">
			<p style="padding-top: 7px"><?php echo isset($parent) ? $parent : 'Danh mục gốc' ?></p>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-lg-2" for="parent_id">Danh mục con:</label>
		<div class="col-lg-3">
			<ul style="padding-top: 7px;padding-left: 15px">
				<?php if (isset($children)):
					foreach ($children as $data):?>
						<li><?php echo $data['name'] ?></li>
					<?php endforeach; ?>
				<?php else: ?>
					<li>Không có danh mục con</li>
				<?php endif; ?>
			</ul>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-lg-2">Hiển thị:</label>
		<div class="col-lg-3">
			<p style="padding-top: 7px"><?php echo $result['status'] == 1 ? 'Có' : 'Không' ?></p>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-6">
			<div class="row">
				<div class="col-lg-4">
					<a href="<?php echo base_url('admin/category/index') ?>" class="btn btn-primary"
					   style="background: rebeccapurple">Quay lại</a>
				</div>
				<div class="col-lg-4">
					<a href="<?php echo base_url('admin/category/edit/' . $result['id']) ?>" class="btn btn-success">Cập nhật</a>
				</div>
				<div class="col-lg-4">
					<a href="<?php echo base_url('admin/category/delete/' . $result['id']) ?>"
					   title="Nhấn để xóa" class="btn btn-danger"
					   onclick="return confirm('Bạn muốn xóa danh mục <?php echo $result['name']; ?> này không?')"
					   >Xoá</a>
				</div>
			</div>
		</div>
	</div>
</form>
</div>
<style>
	.read {
		border-radius: 5px;
		overflow: auto;
		width: auto;
		height: auto;
		max-height: 170px;
	}
</style>

