<div class="row">
	<div class="col-lg-12">
		<h4 class="title-cart">THÔNG TIN TÀI KHOẢN</h4>
	</div>
	<form action="" class="form-horizontal" method="POST">
		<div class="col-lg-12">
		<div class="col-lg-12 back-white product-v2-heading">
			<div class="col-lg-3"></div>
			<div class="col-lg-6 form-group">
				<div class="row img-avatar">
					<img src="<?php echo base_url('public/images/avatar-png.jpg') ?>" id="img-avatar">
					<input type="file" id="file" name="file_avatar">
					<label for="file" id="btn-upload"><i class="fa fa-camera" id="icon-avatar"></i></label>
				</div>
			</div>
		</div>
		<div class="col-lg-12 back-white">
			<div class="col-lg-3"></div>
			<div class="col-lg-6 form-group">
				<div class="row">
					<div class="col-lg-4">
						<label class="control-label" for="fullname">Họ và tên:</label>
					</div>
					<div class="col-lg-8">
						<input type="text" class="form-control" id="fullname" name="fullname"
							   value="<?php echo set_value('fullname'); ?>">
						<?php echo form_error('fullname'); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12 back-white">
			<div class="col-lg-3"></div>
			<div class="col-lg-6 form-group">
				<div class="row">
					<div class="col-lg-4">
						<label class="control-label" for="mobile">Số điện thoại:</label>
					</div>
					<div class="col-lg-8">
						<input type="text" class="form-control" id="mobile" name="mobile"
							   value="<?php echo set_value('mobile'); ?>">
						<?php echo form_error('mobile'); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12 back-white">
			<div class="col-lg-3"></div>
			<div class="col-lg-6 form-group">
				<div class="row">
					<div class="col-lg-4">
						<label class="control-label" for="email">Email:</label>
					</div>
					<div class="col-lg-8">
						<input type="text" class="form-control" id="email" name="email"
							   value="<?php echo set_value('email'); ?>">
						<?php echo form_error('email'); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12 back-white">
			<div class="col-lg-3"></div>
			<div class="col-lg-6 form-group">
				<div class="row">
					<div class="col-lg-4">
						<label class="control-label" for="gender">Giới tính:</label>
					</div>
					<div class="col-lg-8">
						<div class="row">
							<div class="col-lg-6">
								<label class="radio-inline"><input type="radio" name="gender" value="1"
											<?php if (set_value('gender') == '1') {
												echo 'checked';
											} ?>>Nam</label>
							</div>
							<div class="col-lg-6">
								<label class="radio-inline"><input type="radio" name="gender" value="0"
											<?php if (set_value('gender') == '0') {
												echo 'checked';
											} ?>>Nữ</label>
							</div>
						</div>
						<?php echo form_error('gender'); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12 back-white">
			<div class="col-lg-3"></div>
			<div class="col-lg-6 form-group">
				<div class="row">
					<div class="col-lg-4">
						<label class="control-label" for="birthday">Ngày sinh:</label>
					</div>
					<div class="col-lg-8">
						<input type="date" class="form-control" id="birthday" name="birthday"
							   value="<?php echo set_value('birthday'); ?>">
						<?php echo form_error('birthday'); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12 back-white">
			<div class="col-lg-3"></div>
			<div class="col-lg-6 form-group">
				<div class="row">
					<div class="col-lg-4">
					</div>
					<div class="col-lg-8">
						<input type="checkbox" id="status" name="status" value="1"> Thay đổi mật khẩu
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12 product-v2-heading back-white">
			<div class="col-lg-3"></div>
			<div class="col-lg-6 form-group" style="text-align: center">
				<button class="btn btn-primary">Cập nhật</button>
			</div>
		</div>
		</div>
	</form>
</div>
<script>
	const imgDiv = document.querySelector('.img-avatar');
	const img = document.querySelector('#img-avatar');
	const file = document.querySelector('#file');
	const uploadBtn = document.querySelector('#btn-upload');

	file.addEventListener('change', function () {
		const choosedFile = this.files[0];

		if (choosedFile) {
			const reader = new FileReader();
			reader.addEventListener('load', function () {
				img.setAttribute('src', reader.result);
			});
			reader.readAsDataURL(choosedFile);
		}
	});
</script>
