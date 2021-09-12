<?php include ('application/views/errors/error_message_view.php');?>
<div class="row">
	<div class="col-lg-12">
		<h4 class="title-cart">THÔNG TIN TÀI KHOẢN</h4>
	</div>
	<?php if (isset($detail_customer) && $detail_customer): ?>
	<?php foreach ($detail_customer as $result_customer): ?>
	<form action="" class="form-horizontal" method="POST" enctype="multipart/form-data">
		<div class="col-lg-12">
			<div class="col-lg-12 back-white product-v2-heading">
				<div class="col-lg-3"></div>
				<div class="col-lg-6 form-group">
					<div class="row img-avatar">
						<img src="<?php if ($result_customer['avatar'] != '')
							echo base_url('uploads/avatar_image/'.$result_customer['avatar']);
							else echo base_url('public/images/avatar-png.jpg') ?>" id="img-avatar">
						<input type="file" id="file" name="file_avatar">
						<label for="file" id="btn-upload"><i class="fa fa-camera" id="icon-avatar"></i></label>
					</div>
				</div>
				<h5 class="col-lg-12" style="color: red; text-align: center"><?php echo isset($error) ? $error : '' ?></h5>
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
								   value="<?php $fullname = set_value('fullname');
								   if($fullname) {echo $fullname;} else {echo $result_customer['fullname'];}?>">
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
								   value="<?php $mobile = set_value('mobile');
								   if($mobile) {echo $mobile;} else {echo $result_customer['mobile'];}?>">
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
								   value="<?php $email = set_value('email');
								   if($email) {echo $email;} else {echo $result_customer['email'];}?>">
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
												<?php $gender = set_value('gender');
												if($gender){ if(set_value('gender') == '1') {echo 'checked';}}
												else {if($result_customer['gender'] == '1') {echo 'checked';} }?>>Nam</label>
								</div>
								<div class="col-lg-6">
									<label class="radio-inline"><input type="radio" name="gender" value="0"
												<?php	if($gender){ if(set_value('gender') == '0') {echo 'checked';}}
												else {if($result_customer['gender'] == '0') {echo 'checked';} }?>>Nữ</label>
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
								   value="<?php $birthday = set_value('birthday');
								   if($birthday) {echo $birthday;} else {echo date("Y-m-d", strtotime($result_customer['birthday']));}?>">
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
							<input type="checkbox" id="change_password" name="change_password" value="1"> Thay đổi mật
							khẩu
							<h5 style="color: red;"><?php echo isset($error_password) ? $error_password : '' ?></h5>
						</div>

					</div>
				</div>
			</div>
			<div id="form_password" style="display: none;">
				<div class="col-lg-12 back-white">
					<div class="col-lg-3"></div>
					<div class="col-lg-6 form-group">
						<div class="row">
							<div class="col-lg-4">
								<label class="control-label" for="password">Mật khẩu cũ:</label>
							</div>
							<div class="col-lg-8">
								<input type="password" class="form-control" id="password" name="password"
									   value="<?php echo set_value('password'); ?>">
								<?php echo form_error('password'); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-12 back-white">
					<div class="col-lg-3"></div>
					<div class="col-lg-6 form-group">
						<div class="row">
							<div class="col-lg-4">
								<label class="control-label" for="new_password">Mật khẩu mới:</label>
							</div>
							<div class="col-lg-8">
								<input type="password" class="form-control" id="new_password" name="new_password"
									   value="<?php echo set_value('new_password'); ?>">
								<?php echo form_error('new_password'); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-12 back-white">
					<div class="col-lg-3"></div>
					<div class="col-lg-6 form-group">
						<div class="row">
							<div class="col-lg-4">
								<label class="control-label" for="confirm_password">Nhập lại:</label>
							</div>
							<div class="col-lg-8">
								<input type="password" class="form-control" id="confirm_password" name="confirm_password"
									   value="<?php echo set_value('confirm_password'); ?>">
								<?php echo form_error('confirm_password'); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-12 product-v2-heading back-white">
				<div class="col-lg-3"></div>
				<div class="col-lg-6 form-group" style="text-align: center">
					<button type="submit" name="submit" class="btn btn-primary">Cập nhật</button>
				</div>
			</div>
		</div>
	</form>
	<?php endforeach; ?>
	<?php endif; ?>
</div>
<script>
	const imgDiv = document.querySelector('.img-avatar');
	const img = document.querySelector('#img-avatar');
	const file = document.querySelector('#file');
	const uploadBtn = document.querySelector('#btn-upload');

	var change_password = document.querySelector('#change_password');
	var form_password = document.querySelector('#form_password');

	change_password.addEventListener('click', function () {
		if (form_password.style.display == 'none') {
			form_password.style.display = 'block';
		}else{
			form_password.style.display = 'none';
		}
	});

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
