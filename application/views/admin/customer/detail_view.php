<div class="row form-horizontal">
	<div class="col-lg-12">
		<h3>Thông tin khách hàng</h3>
	</div>
	<div class="col-lg-12 text-center mb-1" style="position: absolute; top: 110px; right: 0px">
		<img src="<?php echo base_url('public/images/data-loading.gif') ?>" id="data-loading" style="display: none; width: 65px">
	</div>
	<?php if (isset($customer) && $customer): ?>
	<?php foreach ($customer as $result): ?>
	<div class="col-lg-12">
		<div class="col-lg-6 form-group">
			<div class="row">
				<div class="col-lg-4">
					<label for="" >Họ và tên:</label>
				</div>
				<div class="col-lg-8">
					<p><?php echo $result['fullname'] ?></p>
				</div>
			</div>
		</div>
		<div class="col-lg-6 form-group">
			<div class="row">
				<div class="col-lg-4">
					<label for="">Địa chỉ email:</label>
				</div>
				<div class="col-lg-8">
					<p><?php echo $result['email'] ?></p>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-12">
		<div class="col-lg-6 form-group">
			<div class="row">
				<div class="col-lg-4">
					<label for="" >Số điện thoại:</label>
				</div>
				<div class="col-lg-8">
					<p><?php echo $result['mobile'] ?></p>
				</div>
			</div>
		</div>
		<div class="col-lg-6 form-group">
			<div class="row">
				<div class="col-lg-4">
					<label for="">Giới tính:</label>
				</div>
				<div class="col-lg-8">
					<p><?php if($result['gender'] == '1') echo 'Nam';
							 elseif($result['gender'] == '0') echo 'Nữ';
							 else echo 'Khác';?></p>
				</div>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
	<?php endif; ?>
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12 form-group">
				<div class="col-lg-12">
					<label for="">Địa chỉ:</label>
				</div>
				<?php if (isset($address) && $address): ?>
				<?php foreach ($address as $result): ?>
				<div class="col-lg-2">
				</div>
				<div class="col-lg-10">
					<p><?php echo '+ '.$result['address'].', '.$result['name'].', '.$result['district_name'].', '.$result['province_name'] ?>
						<?php if($result['address_status'] == '1') echo ' (Địa chỉ giao hàng mặc định)'; ?></p>
				</div>
				<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php if (isset($customer) && $customer): ?>
	<?php foreach ($customer as $result): ?>
	<div class="col-lg-12">
		<div class="col-lg-6 form-group">
			<div class="row">
				<div class="col-lg-4">
					<label for="">Loại tài khoản:</label>
				</div>
				<div class="col-lg-8">
					<p><?php if ($result['type'] == '1') echo 'Người dùng hệ thống';
							 elseif($result['type'] == '0') echo 'Khách vãng lai; '?></p>
				</div>
			</div>
		</div>
		<div class="col-lg-6 form-group">
			<div class="row">
				<div class="col-lg-4">
					<label for="">Trạng thái:</label>
				</div>
				<div class="col-lg-8">
					<p><?php if($result['status'] == '0') echo 'Chưa kích hoạt';
							 elseif($result['status'] == '1') echo 'Kích hoạt';
							 else echo 'Tạm khóa'; ?></p>
				</div>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
	<?php endif; ?>
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-4 col-sm-4 col-xs-4" style="text-align: left">
				<a id="back" class="btn btn-primary" href="<?php echo base_url('admin/customer/index') ?>">Quay lại</a>
			</div>
			<div class="col-lg-4 col-sm-4 col-xs-4" style="text-align: center;">
				<a id="update" class="btn btn-primary" href="<?php echo base_url('admin/customer/edit/'.$id.'') ?>">Chỉnh sửa</a>
			</div>
			<div class="col-lg-4 col-sm-4 col-xs-4" style="text-align: right;">
				<a id="delete" class="btn btn-primary" href="<?php echo base_url('admin/customer/delete/'.$id.'') ?>"
				   style="background: #d20e0ed4; border-color:#d20e0ed4;" onclick="return confirm('Bạn muốn xóa khách hàng này không?')">Xóa</a>
			</div>
		</div>
	</div>
</div>
