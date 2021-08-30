<?php include ('application/views/errors/error_message_view.php');?>
<div class="register-form">
	<form class="register" method="POST">
		<h3>Đăng nhập</h3>
		<span></span>
		<p>
			Bạn chưa phải thành viên ?<a href="<?php echo base_url('client/home/register') ?>">Đăng ký ngay</a>
		</p>
		<div class="form-group">
			<label for="mobile">Email/Số điện thoại</label>
			<input name="mobile" type="text" class="form-control" id="mobile" value="<?php if(isset($_COOKIE['mobile']))
				echo $_COOKIE['mobile']; else echo set_value('mobile'); ?>">
			<?php echo form_error('mobile'); ?>
		</div>
		<div class="form-group">
			<label for="password">Mật khẩu</label>
			<input id="password" name="password" type="password" class="form-control" value="<?php if(isset($_COOKIE['password']))
				echo $_COOKIE['password']; else echo set_value('password'); ?>">
			<?php echo form_error('password'); ?>
		</div>
		<div class="form-group form-check">
			<div class="row">
				<div class="col-lg-1">
					<input id="remember" name="remember" type="checkbox" class="form-check-input">
				</div>
				<div class="col-lg-11" style=" padding-top: 15px;" }>
					<label for="remember">Ghi nhớ đăng nhập</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<button type="submit" name="submit" class="btn btn-primary">Đăng nhập</button>
		</div>
		<a href="#"><p>Quên mật khẩu?</p></a>
	</form>
</div>
