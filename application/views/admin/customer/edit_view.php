<?php include ('application/views/errors/error_message_view.php');?>
<div class="row">
	<div class="col-lg-12">
		<h3>Chỉnh sửa thông tin người dùng</h3>
	</div>
	<div class="col-lg-12 col-sm-12 text-center mb-1" style="position: absolute; top: 110px; right: 0px;">
		<img src="<?php echo base_url('public/images/data-loading.gif') ?>" id="data-loading" style="display: none; width: 65px">
	</div>
	<?php if (isset($customer) && $customer): ?>
	<?php foreach ($customer as $result): ?>
	<form action="" class="form-horizontal" method="POST">
		<div class="col-lg-12">
			<div class="col-lg-6 form-group">
				<div class="row">
					<div class="col-lg-4">
						<label class="control-label" for="fullname">Tên người dùng<span style="color: red;">(*)</span>:</label>
					</div>
					<div class="col-lg-8">
						<input type="text" class="form-control" id="fullname" name="fullname"
							   value="<?php $fullname = set_value('fullname');
							   		  if($fullname) {echo $fullname;} else {echo $result['fullname'];}?>">
						<?php echo form_error('fullname'); ?>
					</div>
				</div>
			</div>
			<div class="col-lg-6 form-group" style="margin-left: 10px;">
				<div class="row">
					<div class="col-lg-4">
						<label class="control-label" for="birthday">Ngày sinh:</label>
					</div>
					<div class="col-lg-8">
						<input type="date" class="form-control" id="birthday" name="birthday"
							   value="<?php $birthday = set_value('birthday');
							   if($birthday) {echo $birthday;} else {echo date("Y-m-d", strtotime($result['birthday']));}?>">
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="col-lg-6 form-group">
				<div class="row">
					<div class="col-lg-4">
						<label class="control-label" for="mobile">Số điện thoại<span style="color: red;">(*)</span>:</label>
					</div>
					<div class="col-lg-8">
						<input type="text" class="form-control" id="mobile" name="mobile"
							   value="<?php $mobile = set_value('mobile');
							   if($mobile) {echo $mobile;} else {echo $result['mobile'];}?>">
						<?php echo form_error('mobile'); ?>
					</div>
				</div>
			</div>
			<div class="col-lg-6 form-group" style="margin-left: 10px;">
				<div class="row">
					<div class="col-lg-4">
						<label class="control-label" for="email">Email<span style="color: red;">(*)</span>:</label>
					</div>
					<div class="col-lg-8">
						<input type="text" class="form-control" id="email" name="email"
							   value="<?php $email = set_value('email');
							   if($email) {echo $email;} else {echo $result['email'];}?>">
						<?php echo form_error('email'); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="col-lg-6 form-group">
				<div class="row">
					<div class="col-lg-4">
						<label class="control-label" for="gender">Giới tính:</label>
					</div>
					<div class="col-lg-8">
						<select class="form-control" name="gender" id="gender">
							<option value="-1">- Giới tính -</option>
							<option value="1" <?php $gender = set_value('gender');
								if($gender){ if(set_value('gender') == '1') {echo 'selected';}}
								else {if($result['gender'] == '1') {echo 'selected';} }?>>Nam</option>
							<option value="0" <?php	if($gender){ if(set_value('gender') == '0') {echo 'selected';}}
								else {if($result['gender'] == '0') {echo 'selected';} }?>>Nữ</option>
							<option value="2" <?php if($gender){ if(set_value('gender') == '2') {echo 'selected';}}
								else {if($result['gender'] == '2') {echo 'selected';} }?>>Khác</option>
						</select>
						<?php echo form_error('gender'); ?>
					</div>
				</div>
			</div>
			<div class="col-lg-6 form-group" style="margin-left: 10px;">
				<div class="row">
					<div class="col-lg-4">
						<label class="control-label" for="password">Mật khẩu<span style="color: red;">(*)</span>:</label>
					</div>
					<div class="col-lg-8">
						<input type="text" class="form-control" id="password" name="password"
							   value="<?php $password = set_value('password');
							   if($password) {echo $password;} else {echo $result['password'];}?>">
						<?php echo form_error('password'); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="col-lg-6 form-group">
				<div class="row">
					<div class="col-lg-4">
						<label class="control-label" for="status">Trạng thái<span style="color: red;">(*)</span>:</label>
					</div>
					<div class="col-lg-8">
						<select class="form-control" name="status" id="status">
							<option value="-1">- Trạng thái -</option>
							<option value="0" <?php $status = set_value('status');
								if($status){ if(set_value('status') == '0') {echo 'selected';}}
								else {if($result['status'] == '0') {echo 'selected';} }?>>Chưa kích hoạt</option>
							<option value="1" <?php	if($status){ if(set_value('status') == '1') {echo 'selected';}}
								else {if($result['status'] == '1') {echo 'selected';} }?>>Kích hoạt</option>
							<option value="2" <?php	if($status){ if(set_value('status') == '2') {echo 'selected';}}
								else {if($result['status'] == '2') {echo 'selected';} }?>>Tạm khóa</option>
						</select>
						<?php echo form_error('status'); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="col-lg-6 form-group">
				<div class="row">
					<div class="col-lg-4">
						<label class="control-label" for="province">Tỉnh/Thành phố<span style="color: red;">(*)</span>:</label>
					</div>
					<div class="col-lg-8">
						<select class="form-control" name="province" id="province">
							<option value="-1">- Tỉnh/TP -</option>
							<?php if(isset($province) && $province):?>
								<?php foreach ($province as $result_province):?>
									<option value="<?php echo $result_province['id']; ?>"
											<?php if($result['province_id'] == $result_province['id']) {echo 'selected';} ?>><?php echo $result_province['name']; ?></option>
								<?php endforeach; ?>
							<?php endif; ?>
						</select>
						<?php echo form_error('province'); ?>
					</div>
				</div>
			</div>
			<div class="col-lg-6 form-group" style="margin-left: 10px;">
				<div class="row">
					<div class="col-lg-4">
						<label class="control-label" for="district">Quận/Huyện<span style="color: red;">(*)</span>:</label>
					</div>
					<div class="col-lg-8" id="ajax_district">
						<select class="form-control" name="district" id="district">
							<option value="-1">- Quận/Huyện -</option>
							<?php if(isset($district) && $district): ?>
							<?php foreach ($district as $result_district):?>
									<option value="<?php echo $result_district['id']; ?>"
										<?php if($result['district_id'] == $result_district['id']) {echo 'selected';} ?>><?php echo $result_district['name']; ?></option>
							<?php endforeach; ?>
							<?php endif; ?>
						</select>
						<?php echo form_error('district'); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="col-lg-6 form-group">
				<div class="row">
					<div class="col-lg-4">
						<label class="control-label" for="ward">Xã/Phường/Thị trấn<span style="color: red;">(*)</span>:</label>
					</div>
					<div class="col-lg-8" id="ajax_ward">
						<select class="form-control" name="ward" id="ward">
							<option value="-1">- Xã/Phường/Thị trấn -</option>
							<?php if(isset($ward) && $ward): ?>
								<?php foreach ($ward as $result_ward):?>
									<option value="<?php echo $result_ward['id']; ?>"
											<?php if($result['ward_id'] == $result_ward['id']) {echo 'selected';} ?>><?php echo $result_ward['name']; ?></option>
								<?php endforeach; ?>
							<?php endif; ?>
						</select>
						<?php echo form_error('ward'); ?>
					</div>
				</div>
			</div>
			<div class="col-lg-6 form-group" style="margin-left: 10px;">
				<div class="row">
					<div class="col-lg-4">
						<label class="control-label" for="address">Địa chỉ<span style="color: red;">(*)</span>:</label>
					</div>
					<div class="col-lg-8">
						<input type="text" class="form-control" id="address" name="address"
							   value="<?php $address = set_value('address');
							   if($address) {echo $address;} else {echo $result['address'];}?>">
						<?php echo form_error('address'); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="col-lg-6 form-group">
				<div class="row">
					<div class="col-lg-4">
						<label class="control-label" for="type_address">Loại địa chỉ<span style="color: red;">(*)</span>:</label>
					</div>
					<div class="col-lg-8">
						<div class="row">
							<div class="col-lg-6">
								<label class="radio-inline"><input type="radio" name="type_address" value="0"
											<?php $type_address = set_value('type_address');
											if($type_address){ if(set_value('type_address') == '0') {echo 'checked';}}
											else {if($result['address_type'] == '0') {echo 'checked';} }?>>Nhà riêng/Chung cư</label>
							</div>
							<div class="col-lg-6">
								<label class="radio-inline"><input type="radio" name="type_address" value="1"
											<?php	if($type_address){ if(set_value('type_address') == '1') {echo 'checked';}}
											else {if($result['address_type'] == '1') {echo 'checked';} }?>>Cơ quan/Công ty</label>
							</div>
						</div>
						<?php echo form_error('type_address'); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="col-lg-6 form-group">
				<div class="row">
					<div class="col-lg-4">
						<label class="control-label" for="status_address">Cài đặt địa chỉ<span style="color: red;">(*)</span>:</label>
					</div>
					<div class="col-lg-8">
						<div class="row">
							<div class="col-lg-6">
								<label class="radio-inline"><input type="radio" name="status_address" value="1"
											<?php $status_address = set_value('status_address');
											if($status_address){ if(set_value('status_address') == '1') {echo 'checked';}}
											else {if($result['address_status'] == '1') {echo 'checked';} }?>>Địa chỉ mặc định</label>
							</div>
							<div class="col-lg-6">
								<label class="radio-inline"><input type="radio" name="status_address" value="0"
											<?php	if($status_address){ if(set_value('status_address') == '0') {echo 'checked';}}
											else {if($result['address_status'] == '0') {echo 'checked';} }?>>Địa chỉ phụ</label>
							</div>
						</div>
						<?php echo form_error('status_address'); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-4 col-sm-4 col-xs-4" style="text-align: left">
					<a id="back" class="btn btn-primary" href="<?php echo base_url('admin/customer/index') ?>">Quay lại</a>
				</div>
				<div class="col-lg-4 col-sm-4 col-xs-4" style="text-align: center;">
					<button class="btn btn-primary" type="submit" name="submit">Lưu</button>
				</div>
			</div>
		</div>
	</form>
	<?php endforeach; ?>
	<?php endif; ?>
	<script type="text/javascript">
		$(document).ready(function () {
			filterAddress('province', window.ajax_url.district_list);
			filterAddress('district', window.ajax_url.ward_list);
		});

		function filterAddress(id, url_ajax) {
			$('#' + id).change(function () {
				var id_address = $('#' + id).val();
				callAjax(id_address, url_ajax);
			});
		}

		function callAjax(id_address, url_ajax) {
			$.ajax({
				url: url_ajax,
				type: 'POST',
				dataType: 'html',
				data: {
					id_address: id_address
				}
			}).done(function (result) {
				if (url_ajax == window.ajax_url.district_list) {
					$('#district').html(result);
					var html = '';
					html += '<option value="-1">- Xã/Phường/Thị trấn -</option>';
					$('#ward').html(html);
				}
				if (url_ajax == window.ajax_url.ward_list) {
					$('#ward').html(result);
				}
			})
			$(document).ajaxError(function () {
			});
		}
	</script>
</div>
<style>
	.form-control {
		border-color: #9d9d9d;
	}
</style>

