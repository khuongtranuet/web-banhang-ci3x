<div class="register-form">
	<form class="register">
		<h3>Tạo tài khoản</h3>
		<span></span>
		<a href="<?php echo base_url('client/home/login'); ?>">
		<p>Bạn đã có tài khoản?</p>
		</a>
		<div class="form-group">
			<label>Họ và tên</label>
			<input name="fullname" type="text" class="form-control">
		</div>

		<div class="form-group">
			<label>Số điện thoại</label>
			<input name="mobile" type="text" class="form-control">
		</div>
		<div class="form-group">
			<label>Email</label>
			<input name="email" type="text" class="form-control">
		</div>
		<div class="form-group">
			<label>Mật khẩu</label>
			<input name="password" type="password" class="form-control">
		</div>
		<div class="form-group">
			<label>Nhập lại mật khẩu</label>
			<input name="confirmPassword" type="password" class="form-control">
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Tạo tài khoản</button>
		</div>
	</form>
</div>
