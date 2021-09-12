<?php include ('application/views/errors/error_message_view.php');?>
<div class="register-form">
	<form class="register" method="POST">
		<h3>Tạo tài khoản</h3>
		<span></span>
		<a href="<?php echo base_url('client/home/login'); ?>">
		<p>Bạn đã có tài khoản?</p>
		</a>
		<div class="form-group">
			<label for="fullname">Họ và tên</label>
			<input id="fullname" name="fullname" type="text" class="form-control" value="<?php echo set_value('fullname'); ?>">
			<?php echo form_error('fullname'); ?>
		</div>

		<div class="form-group">
			<label for="mobile">Số điện thoại</label>
			<input id="mobile" name="mobile" type="text" class="form-control" value="<?php echo set_value('mobile'); ?>">
			<?php echo form_error('mobile'); ?>
		</div>
		<div class="form-group">
			<label for="email">Email</label>
			<input id="email" name="email" type="text" class="form-control" value="<?php echo set_value('email'); ?>">
			<?php echo form_error('email'); ?>
		</div>
		<div class="form-group">
			<label for="password">Mật khẩu</label>
			<input id="password" name="password" type="password" class="form-control" value="<?php echo set_value('password'); ?>">
			<?php echo form_error('password'); ?>
		</div>
		<div class="form-group">
			<label for="confirm_password">Nhập lại mật khẩu</label>
			<input id="confirm_password" name="confirm_password" type="password" class="form-control"
				   value="<?php echo set_value('confirm_password'); ?>">
			<?php echo form_error('confirm_password'); ?>
		</div>
		<div class="form-group">
			<button type="submit" name="submit" class="btn btn-primary">Tạo tài khoản</button>
		</div>
	</form>
</div>
