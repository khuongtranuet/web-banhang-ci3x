<h3>Chi tiết sản phẩm</h3>
<form class="form-horizontal" action="" id="form" method="POST" enctype="multipart/form-data" novalidate>
	<div class="row">
		<div class="form-group col-lg-6">
			<label class="control-label col-lg-4" for="name">Tên sản phẩm(*):</label>
			<div class="col-lg-8" style="padding-top: 7px"><?php echo $product['name'] ?></div>
		</div>
		<?php if (!$product['parent_id']): ?>
			<div class="form-group col-lg-6">
				<label class="control-label col-lg-4" for="brand_id">Thương hiệu:</label>
				<div class="col-lg-8" style="padding-top: 7px">
					<?php echo $product['brand'] ? $product['brand'] : 'Thương hiệu khác' ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
	<div class="row">
		<div class="form-group col-lg-6">
			<label class="control-label col-lg-4" for="price">Giá sản phẩm(*):</label>
			<div class="col-lg-8" style="padding-top: 7px">
				<?php $str_reverse = strrev($product['price']);
				$total_trim = ceil(strlen($product['price']) / 3);
				$str_final = '';
				for ($i = 0; $i < $total_trim; $i++) {
					$str_trim = substr($str_reverse, ($i) * 3, 3);
					if ($i < $total_trim - 1) {
						$str_final .= $str_trim . '.';
					} else {
						$str_final .= $str_trim;
					}
				}
				$product['price'] = strrev($str_final);
				echo $product['price'] . ' VNĐ';
				?>
			</div>
		</div>
		<?php if (!$product['parent_id']): ?>
			<div class="form-group col-lg-6">
				<label class="control-label col-lg-4" for="category_id">Danh mục:</label>
				<div class="col-lg-8" style="padding-top: 7px">
					<?php echo $product['category'] ? $product['category'] : 'Danh mục khác' ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
	<?php if (!$product['parent_id']): ?>
		<div class="row">
			<div class="form-group">
				<label class="control-label col-lg-2" for="description">Mô tả:</label>
				<div class="col-lg-9">
					<div id="description" style="margin-top: 7px">
						<?php echo $product['description'] ? nl2br($product['description']) : 'Chưa có thông tin' ?>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<label class="control-label col-lg-2" for="attribute_id"></label>
				<div class="col-lg-9" id="container">
					<table class="table table-bordered">
						<thead>
						<th class="text-center">Thông số</th>
						<th class="text-center">Thông tin</th>
						</thead>
						<tbody>
						<?php if (count($attribute) > 0): ?>
							<?php foreach ($attribute as $data): ?>
								<tr>
									<td><?php echo $data['name'] ?></td>
									<td><?php echo $data['value'] ?></td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td colspan="2" class="text-center">Sản phẩm chưa có thông số</td>
							</tr>
						<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<div class="row">
		<div class="form-group">
			<label class="control-label col-lg-2" for="main_img">Ảnh chính:</label>
			<div class="col-lg-9" style="padding-top: 7px">
				<?php if (isset($main_img) && $main_img): ?>
					<img src="<?php echo base_url('uploads/product_image/' . $main_img) ?>" alt="Ảnh chính"
						 height="200" width="250" style="border-radius: 5px">
				<?php else: ?>
					<p>Không có ảnh</p>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php if (!$product['parent_id']): ?>
		<div class="row">
			<div class="form-group">
				<label class="control-label col-lg-2" for="img">Ảnh phụ:</label>
				<div class="col-lg-9">
					<div class="row" style="padding-top: 7px">
						<?php if (count($img) > 0): ?>
							<?php foreach ($img as $data): ?>
								<div class="col-lg-4" style="padding-top: 7px">
									<img src="<?php echo base_url('uploads/product_image/' . $data['path']) ?>"
										 alt="Ảnh phụ"
										 height="200" width="250" style="border-radius: 5px;">
								</div>
							<?php endforeach; ?>
						<?php else: ?>
							<div class="col-lg-4">Không có ảnh</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<label class="control-label col-lg-2" for="priority">Nổi bật:</label>
				<div class="col-lg-3" style="padding-top: 7px">
					<?php echo $product['priority'] == 1 ? 'Sản phẩm nổi bật' : 'Sản phẩm thường' ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<div class="row">
		<div class="form-group">
			<label class="control-label col-lg-2" for="color">Màu sắc:</label>
			<div class="col-lg-9" style="padding-top: 7px">
				<?php if (!$product['parent_id']): ?>
					<?php if (count($child) > 0): ?>
						<ul>
							<?php foreach ($child as $data): ?>
								<li>
									<a href="<?php echo base_url('admin/product/detail/' . $data['id']) ?>">
										<?php echo $data['name'] ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php else: ?>
						<p>Sản phẩm chưa có màu sắc khác</p>
					<?php endif; ?>
				<?php else: ?>
					<p><?php echo $product['color'] ?></p>
				<?php endif; ?>
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
					<a href="<?php echo base_url('admin/product/edit/' . $product['id']) ?>" class="btn btn-success">Cập
						nhật</a>
				</div>
				<div class="col-lg-4">
					<a href="<?php echo base_url('admin/product/delete/' . $product['id']) ?>" type="reset"
					   class="btn btn-danger">Xoá</a>
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
		border: 1px solid lightgray;
		min-height: 200px;
		width: 895px;
		max-height: 500px;
		overflow: scroll;
	}
</style>

