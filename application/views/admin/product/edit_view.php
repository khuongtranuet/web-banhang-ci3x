<h3>Cập nhật sản phẩm</h3>
<form class="form-horizontal" action="" id="form" method="POST" enctype="multipart/form-data" novalidate>
	<?php if ($product['parent_id']): ?>
		<input type="hidden" name="parent_id" value="<?php echo $product['parent_id'] ?>">
		<input type="hidden" name="father_name" value="<?php echo $father_name ?>">
		<input type="hidden" name="old_color" value="<?php echo $old_color ?>">
	<?php endif; ?>
	<input type="hidden" name="old_img" value="<?php echo isset($main_img) ? $main_img : '' ?>">
	<input type="hidden" name="old_name" value="<?php echo $product['name'] ?>">
	<input type="hidden" name="id" value="<?php echo $product['id'] ?>">
	<div class="row">
		<div class="form-group col-lg-6">
			<label class="control-label col-lg-4" for="name">Tên sản phẩm(*):</label>
			<div class="col-lg-8">
				<?php if (!$product['parent_id']): ?>
					<input type="text" class="form-control" id="name" name="name"
						   value="<?php echo $_SERVER['REQUEST_METHOD'] == 'POST' ? set_value('name') : $product['name'] ?>">
					<span class="errors"><?php echo form_error('name') ?></span>
				<?php else: ?>
					<p><?php echo $product['name'] ?></p>
				<?php endif; ?>
			</div>
		</div>
		<div class="form-group col-lg-6">
			<?php if (!$product['parent_id']): ?>
				<label class="control-label col-lg-4" for="brand_id">Thương hiệu:</label>
				<div class="col-lg-8">

					<select class="form-control" name="brand_id" id="brand_id">
						<option value="-1">Chọn thương hiệu</option>
						<?php if (isset($brand) && $brand): ?>
							<?php foreach ($brand as $data): ?>
								<option value="<?php echo $data['id'] ?>"
										<?php
										if ($_SERVER['REQUEST_METHOD'] == 'POST') {
											echo (set_value('brand_id') == $data['id']) ? 'selected' : '';
										} else {
											if ($product['brand_id']) {
												echo ($product['brand_id'] == $data['id']) ? 'selected' : '';
											}
										}
										?>
								><?php echo $data['name'] ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-lg-6">
			<label class="control-label col-lg-4" for="price">Giá sản phẩm(*):</label>
			<div class="col-lg-8">
				<input type="number" class="form-control" id="price" name="price"
					   value="<?php echo $_SERVER['REQUEST_METHOD'] == 'POST' ? set_value('price') : $product['price'] ?>">
				<span class="errors"><?php echo form_error('price') ?></span>
			</div>
		</div>
		<div class="form-group col-lg-6">
			<?php if (!$product['parent_id']): ?>
				<label class="control-label col-lg-4" for="category_id">Danh mục:</label>
				<div class="col-lg-8">
					<select class="form-control" name="category_id" id="category_id">
						<option value="-1">Chọn danh mục</option>
						<?php if (isset($category) && $category): ?>
							<?php foreach ($category as $data): ?>
								<option value="<?php echo $data['id'] ?>"
										<?php
										if ($_SERVER['REQUEST_METHOD'] == 'POST') {
											echo (set_value('category_id') == $data['id']) ? 'selected' : '';
										} else {
											if ($product['category_id']) {
												echo ($product['category_id'] == $data['id']) ? 'selected' : '';
											}
										}
										?>
								><?php echo $data['name'] ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<?php if (!$product['parent_id']): ?>
		<div class="row">
			<div class="form-group">
				<label class="control-label col-lg-2" for="description">Mô tả:</label>
				<div class="col-lg-9">
				<textarea id="description" name="description"
				><?php echo $_SERVER['REQUEST_METHOD'] == 'POST' ? set_value('description') : $product['description'] ?>
				</textarea>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<label class="control-label col-lg-2" for="attribute_id">Thông số:</label>
				<div class="col-lg-9" id="container">
					<div class="col-lg-12" style="text-align: center; padding-bottom: 7px">
						<a href="javascript:void(0)" class="btn btn-success" id="add">Thêm</a>
					</div>
					<div class="row">
						<div class="col-lg-5"><span
									class="errors"><?php echo form_error('attribute_id[]') ?></span>
						</div>
						<div class="col-lg-5"><span
									class="errors"><?php  echo form_error('value[]') ?></span>
						</div>
					</div>
					<?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
						<?php if (isset($_POST['attribute_id']) && isset($_POST['value'])): ?>
							<?php for ($i = 0; $i < count(set_value('attribute_id')); $i++): ?>
								<div class="row" style="padding-top:7px">
									<div class="col-lg-5">
										<select class="form-control" name="attribute_id[]">
											<option value="-1">Chọn thông số</option>
											<?php if (isset($attribute) && $attribute): ?>
												<?php foreach ($attribute as $data): ?>
													<option value="<?php echo $data['id'] ?>"
															<?php
															if ($_SERVER['REQUEST_METHOD'] == 'POST') {
																echo (set_value('attribute_id')[$i] == $data['id']) ? 'selected' : '';
															}
															?>
													><?php echo $data['name'] ?></option>
												<?php endforeach; ?>
											<?php endif; ?>
										</select>
									</div>
									<div class="col-lg-5">
										<input type="text" name="value[]" class="form-control"
											   value="<?php echo ($_SERVER['REQUEST_METHOD'] == 'POST') ? set_value('value')[$i] : '' ?>">
									</div>
									<div class="col-lg-2">
										<a href="javascript:void(0)" class="btn btn-danger" id="delete">Xoá</a>
									</div>
								</div>
							<?php endfor; ?>
						<?php endif; ?>
					<?php elseif (count($old_attribute) > 0): ?>
						<?php for ($i = 0; $i < count($old_attribute); $i++): ?>
							<div class="row" style="padding-top:7px">
								<div class="col-lg-5">
									<select class="form-control" name="attribute_id[]">
										<option value="-1">Chọn thông số</option>
										<?php if (isset($attribute) && $attribute): ?>
											<?php foreach ($attribute as $data): ?>
												<option value="<?php echo $data['id'] ?>"
														<?php
														if ($old_attribute[$i]['attribute_id'] == $data['id']) {
															echo 'selected';
														}
														?>
												><?php echo $data['name'] ?></option>
											<?php endforeach; ?>
										<?php endif; ?>
									</select>
								</div>
								<div class="col-lg-5">
									<input type="text" name="value[]" class="form-control"
										   value="<?php echo $old_attribute[$i]['value'] ?>">
								</div>
								<div class="col-lg-2">
									<a href="javascript:void(0)" class="btn btn-danger" id="delete">Xoá</a>
								</div>
							</div>
						<?php endfor; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<div class="row">
		<div class="form-group">
			<label class="control-label col-lg-2" for="main_img">Ảnh chính:</label>
			<div class="col-lg-9">
				<div class="row">
					<div class="col-lg-5">
						<input class="form-control" type="file" id="main_img" name="main_img">
						<span class="errors"><?php echo form_error('main_img') ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php if (!$product['parent_id']): ?>
		<div class="row">
			<div class="form-group">
				<label class="control-label col-lg-2" for="img">Ảnh phụ:</label>
				<div class="col-lg-9">
					<div class="row">
						<div class="col-lg-5">
							<input class="form-control" type="file" name="img[]" id="img" multiple>
							<span class="errors"><?php echo form_error('img[]') ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group">
				<label class="control-label col-lg-2" for="priority">Nổi bật:</label>
				<div class="col-lg-3">
					<div class="row">
						<div class="col-lg-6">
							<div class="radio">
								<label><input type="radio" value="1" name="priority"
											<?php echo (set_value('priority') == 1) ? 'checked' : ''; ?>>Có</label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<div class="row">
		<div class="form-group">
			<label class="control-label col-lg-2" for="color">
				<?php echo !$product['parent_id'] ? 'Thêm màu sắc:' : 'Thay đổi màu sắc:'; ?>
			</label>
			<div class="col-lg-9">
				<div class="row">
					<div class="col-lg-5">
						<input class="form-control" type="text" id="status" name="color"
							   value="<?php echo $_SERVER['REQUEST_METHOD'] == 'POST' ? set_value('color') : $product['color'] ?>">
						<?php if (!$product['parent_id']): ?>
							<small style="color: silver">
								<ul>
									<li>Xanh,Đỏ,Tím,Space Gray</li>
									<li>Màu đầu tiên sẽ là màu mặc định</li>
								</ul>
							</small>
						<?php endif; ?>
						<span class="errors"><?php echo form_error('color') ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-6">
			<div class="row">
				<div class="col-lg-4">
					<a href="<?php echo base_url('admin/product/index') ?>" class="btn btn-primary"
					   style="background: rebeccapurple">Quay lại</a>
				</div>
				<div class="col-lg-4">
					<button type="submit" class="btn btn-success">Cập nhật</button>
				</div>
				<div class="col-lg-4">
					<button type="reset" class="btn btn-primary">Reset</button>
				</div>
			</div>
		</div>
	</div>
</form>
<style>
	.errors {
		color: red;
	}

	#description {
		border-radius: 5px;
		resize: vertical;
		border: 1px solid lightgray;
		min-height: 200px;
		width: 895px;
	}
</style>
<script>
	$('document').ready(function (e) {
		var html = '<div class="row" style="padding-top:7px;">' +
				'<div class="col-lg-5">' +
				'<select class="form-control" name="attribute_id[]">' +
				'<option value="-1">Chọn thông số</option>' +
				'<?php if (isset($attribute) && $attribute): ?>' +
				'<?php foreach($attribute as $data): ?>' +
				'<option value="<?php echo $data['id']?>"><?php echo $data['name'] ?></option>' +
				'<?php endforeach;?>' +
				'<?php endif; ?>' +
				'</select>' +
				'</div>' +
				'<div class="col-lg-5">' +
				'<input type="text" name="value[]" class="form-control">' +
				'</div>' +
				'<div class="col-lg-2">' +
				'<a href="javascript:void(0)" class="btn btn-danger" id="delete">Xoá</a>' +
				'</div>' +
				'</div>'

		$('#add').click(function (e) {
			$('#container').append(html);
		})

		$('#container').on('click', '#delete', function (e) {
			$(this).parent().parent('div').remove();
		})
	})
</script>


