<h3>Thêm danh mục</h3>
<form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
	<div class="form-group">
		<label class="control-label col-lg-2" for="name">Tên danh mục(*):</label>
		<div class="col-lg-4">
			<input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name') ?>">
			<span class="errors"><?php echo form_error('name') ?></span>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-lg-2" for="description">Mô tả:</label>
		<div class="col-lg-10">
			<textarea id="description" name="description" cols="53"
					  rows="5"><?php echo set_value('description') ?></textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-lg-2" for="image">Ảnh danh mục:</label>
		<div class="col-lg-3">
			<input type="file" id="image" name="image" class="form-control">
			<span class="errors"><?php echo isset($error) ? $error : '' ?></span>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-lg-2" for="parent_id">Thuộc danh mục:</label>
		<div class="col-lg-3">
			<select class="form-control" id="parent_id" name="parent_id">
				<option value="-1 ">Danh mục gốc</option>
				<?php foreach ($category_id as $data): ?>
					<option value="<?php echo $data['id'] ?>"
							<?php
							if (set_value('parent_id') == $data['id']) {
								echo 'selected';
							}
							?>
					><?php echo $data['name'] ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-lg-2">Hiển thị:</label>
		<div class="col-lg-3">
			<div class="row">
				<div class="col-lg-6">
					<div class="radio">
						<label><input type="radio" value="1" name="status"
									<?php echo (set_value('status') == 1) ? 'checked' : ''; ?>>Có</label>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="radio">
						<label><input type="radio" value="-1" name="status"
									<?php echo (set_value('status') == -1) ? 'checked' : ''; ?>>Không</label>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-6">
			<div class="row">
				<div class="col-lg-6">
					<a href="<?php echo base_url('admin/category/index') ?>" class="btn btn-primary"
					   style="background: rebeccapurple">Quay lại</a>
				</div>
				<div class="col-lg-6">
					<button type="submit" class="btn btn-success">Thêm</button>
				</div>
			</div>
		</div>
	</div>
</form>
</div>
<style>
	.errors {
		color: red;
	}
</style>
