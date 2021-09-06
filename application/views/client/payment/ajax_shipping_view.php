<?php if (isset($update_customer) && $update_customer): ?>
<?php foreach ($update_customer as $result): ?>
<div class="col-lg-12">
	<input type="hidden" name="address_id" value="<?php echo $result['address_id'] ?>">
	<div class="col-lg-3"></div>
	<div class="col-lg-6 form-group">
		<div class="row">
			<div class="col-lg-4">
				<label class="control-label" for="fullname">Họ và tên:</label>
			</div>
			<div class="col-lg-8">
				<input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $result['address_fullname']; ?>">
			</div>
		</div>
	</div>
</div>
<div class="col-lg-12">
	<div class="col-lg-3"></div>
	<div class="col-lg-6 form-group">
		<div class="row">
			<div class="col-lg-4">
				<label class="control-label" for="mobile">Số điện thoại:</label>
			</div>
			<div class="col-lg-8">
				<input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $result['address_mobile']; ?>">
			</div>
		</div>
	</div>
</div>
<div class="col-lg-12">
	<div class="col-lg-3"></div>
	<div class="col-lg-6 form-group">
		<div class="row">
			<div class="col-lg-4">
				<label class="control-label" for="mobile">Tỉnh/Thành phố:</label>
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
			</div>
		</div>
	</div>
</div>
<div class="col-lg-12">
	<div class="col-lg-3"></div>
	<div class="col-lg-6 form-group">
		<div class="row">
			<div class="col-lg-4">
				<label class="control-label" for="district">Quận/Huyện:</label>
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
			</div>
		</div>
	</div>
</div>
<div class="col-lg-12">
	<div class="col-lg-3"></div>
	<div class="col-lg-6 form-group">
		<div class="row">
			<div class="col-lg-4">
				<label class="control-label" for="ward">Xã/Phường/Thị trấn:</label>
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
			</div>
		</div>
	</div>
</div>
<div class="col-lg-12">
	<div class="col-lg-3"></div>
	<div class="col-lg-6 form-group">
		<div class="row">
			<div class="col-lg-4">
				<label class="control-label" for="address">Địa chỉ:</label>
			</div>
			<div class="col-lg-8">
				<input type="text" class="form-control" id="address" name="address" value="<?php echo $result['address'] ?>">
			</div>
		</div>
	</div>
</div>
<div class="col-lg-12">
	<div class="col-lg-3"></div>
	<div class="col-lg-6 form-group">
		<div class="row">
			<div class="col-lg-4">
				<label class="control-label" for="type_address">Loại địa chỉ:</label>
			</div>
			<div class="col-lg-8">
				<div class="row">
					<div class="col-lg-6">
						<label class="radio-inline"><input type="radio" name="type_address" value="0"
							<?php if($result['address_type'] == '0') {echo 'checked';}  ?>>Nhà riêng/Chung cư</label>
					</div>
					<div class="col-lg-6">
						<label class="radio-inline"><input type="radio" name="type_address" value="1"
							<?php if($result['address_type'] == '1') {echo 'checked';} ?>>Cơ quan/Công ty</label>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-lg-12">
	<div class="col-lg-3"></div>
	<div class="col-lg-6 form-group">
		<div class="row">
			<div class="col-lg-4">
			</div>
			<div class="col-lg-8">
				<span>(Chọn giao đến địa chỉ này tự động thêm thành địa chỉ mặc định)</span>
				<!--							<input type="checkbox" id="status" name="status" value="1"> Sử dụng làm địa chỉ mặc định-->
			</div>
		</div>
	</div>
</div>
<div class="col-lg-12 product-v2-heading">
	<div class="col-lg-3"></div>
	<div class="col-lg-6 form-group">
		<div class="row">
			<div class="col-lg-4">
			</div>
			<div class="col-lg-8">
				<a id="remove_address" class="btn" style="border-color: #cccccc; width: 49%">Hủy bỏ</a>
				<button type="submit" name="update" class="btn btn-primary position-right" style="width: 49%">Cập nhật</button>
			</div>
		</div>
	</div>
</div>
<?php endforeach; ?>
<?php endif; ?>
<script type="text/javascript">
	var remove_address = document.querySelector('#remove_address');
	remove_address.addEventListener('click', () => {
		form_address.classList.remove("active_form_address");
		form_address.classList.add("non_active_form_address");
	})
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
<?php die(); ?>
