<div class="row">
	<div class="col-lg-12">
		<h4 class="title-cart">ĐƠN HÀNG VÀ THANH TOÁN</h4>
	</div>
	<div class="col-lg-12 product-v2-heading">
		<strong>Địa chỉ giao hàng</strong>
	</div>
	<div class="col-lg-12">
		<p>Chọn địa chỉ giao hàng có sẵn bên dưới</p>
	</div>
	<div class="col-lg-12">
		<div class="row">
			<?php if(isset($address_customer) && $address_customer): ?>
			<?php foreach ($address_customer as $result_address): ?>
			<div class="col-lg-6">
				<div class="col-lg-12" style="background-color:white;">
					<div class="row">
						<div class="col-lg-12 product-v2-heading">
							<strong><?php echo $result_address['fullname']; ?></strong>
							<?php if ($result_address['address_status'] == '1'): ?>
							<strong class="position-right" style="color: #009900">Mặc định</strong>
							<?php endif; ?>
						</div>
						<div class="col-lg-12">
							<span class="address_cus">Địa chỉ: <?php echo $result_address['address'].', '.$result_address['full_location'] ?></span>
							<p>Điện thoại: <?php echo $result_address['mobile'] ?></p>
						</div>
						<div class="col-lg-12 product-v2-heading">
							<a href="<?php echo base_url('client/payment/change?cus_id='.$result_address['customer_id'].'&id='.$result_address['address_id'])?>" class="btn btn-primary">Giao đến địa chỉ này</a>
							<button class="btn" style="border-color: #cccccc">Sửa</button>
							<?php if ($result_address['address_status'] != '1'): ?>
							<button class="btn" style="border-color: #cccccc">Xóa</button>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<div class="col-lg-12">
					<p style="height:10px; background-color:#f5f5f5;"></p>
				</div>
			</div>
			<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
	<div class="col-lg-12 product-v2-heading">
		<p>Bạn muốn giao hàng đến địa chỉ khác?<a id="add_address"> Thêm địa chỉ giao hàng mới</a></p>
	</div>
	<div id="form_address" class="non_active_form_address" style="display: block;">
		<form class="form-horizontal" method="POST" id="add_form">
			<div class="col-lg-12">
				<div class="col-lg-3"></div>
				<div class="col-lg-6 form-group">
					<div class="row">
						<div class="col-lg-4">
							<label class="control-label" for="fullname">Họ và tên:</label>
						</div>
						<div class="col-lg-8">
							<input type="text" class="form-control" id="fullname" name="fullname" value="">
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
							<input type="text" class="form-control" id="mobile" name="mobile" value="">
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
										<option value="<?php echo $result_province['id']; ?>"><?php echo $result_province['name']; ?></option>
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
							<input type="text" class="form-control" id="address" name="address" value="">
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
									<label class="radio-inline"><input type="radio" name="type_address" value="0" checked>Nhà riêng/Chung cư</label>
								</div>
								<div class="col-lg-6">
									<label class="radio-inline"><input type="radio" name="type_address" value="1">Cơ quan/Công ty</label>
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
							<input type="checkbox" id="status" name="status" value="1"> Sử dụng làm địa chỉ mặc định
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
							<button type="submit" name="submit" class="btn btn-primary position-right" style="width: 49%">Giao đến địa chỉ này</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<script type="text/javascript">
		var add_address = document.querySelector('#add_address');
		var form_address = document.querySelector('#form_address');
		var remove_address = document.querySelector('#remove_address');

		add_address.addEventListener('click', () => {
			form_address.classList.remove("non_active_form_address");
			form_address.classList.add("active_form_address");
		});
		remove_address.addEventListener('click', () => {
			form_address.classList.remove("active_form_address");
			form_address.classList.add("non_active_form_address");
			// form_address.style.display = 'none';
		})
		$(document).ready(function () {
			filterAddress('province', window.ajax_url.district_list);
			filterAddress('district', window.ajax_url.ward_list);
			$(".address_cus").each(function(i){
				var len=$(this).text().trim().length;
				if(len>78) {
					$(this).text($(this).text().substr(0,78)+'...');
				}
			});
			$("#add_form").validate({
				rules: {
					fullname: "required",
					mobile: "required",
					province: "min",
					district: "min",
					ward: "min",
					address: "required",
				},
				messages: {
					fullname: '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>',
					mobile: '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>',
					province: {min: '<h5 style="color: red; height: 0px;">Vui lòng chọn Tỉnh/TP!</h5>',},
					district: {min: '<h5 style="color: red; height: 0px;">Vui lòng chọn Quận/Huyện!</h5>',},
					ward: {min: '<h5 style="color: red; height: 0px;">Vui lòng chọn Xã/Phường!</h5>',},
					address: '<h5 style="color: red; height: 0px;">Trường này không được để trống!</h5>',
				}
			});
		});
		function filterAddress(id, url_ajax) {
			$('#' + id).change(function () {
				var id_address = $('#' + id).val();
				console.log($('#' + id).val());
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
				console.log(result);
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

