<div class="row">
	<div class="col-lg-12">
		<h3>Danh sách người dùng</h3>
	</div>
	<div class="col-lg-12 text-center mb-1" style="position: absolute; top: 20px; right: 0px">
		<img src="<?php echo base_url('public/images/data-loading.gif') ?>" id="data-loading" style="display: none; width: 65px">
	</div>
	<div class="col-lg-12" style="margin-top: 20px;">
		<div class="row" style="margin-bottom: 5px">
			<!-- Tìm kiếm theo từ khóa -->
			<div class="col-lg-3">
				<input class="form-control" type="text" name="keyword" id="keyword" value=""
					   placeholder="Nhập để tìm kiếm">
			</div>
			<!-- Lọc theo phòng ban -->
			<div class="col-lg-3" style="margin-left: -15px">
				<select class="form-control" name="type" id="type">
					<option value="-1">- Loại -</option>
					<option value="0">Khách vãng lai</option>
					<option value="1">Người dùng hệ thống</option>
				</select>
			</div>
			<div class="col-lg-2" style="margin-left: -15px">
				<select class="form-control" name="status" id="status">
					<option value="-1">- Trạng thái -</option>
					<option value="0">Chưa kích hoạt</option>
					<option value="1">Kích hoạt</option>
					<option value="2">Đang khóa</option>
				</select>
			</div>
			<div class="col-lg-1">
				<a class="btn btn-primary" id="reset_search" style="margin-left: -15px;">Tải lại</a>
			</div>
			<!-- Thêm mới -->
			<div class="col-lg-2" style="float: right; text-align: right">
				<a href="<?php echo base_url('admin/customer/add'); ?>">
					<button class="btn btn-primary">Thêm mới</button>
				</a>
			</div>
		</div>
	</div>
	<div class="col-lg-12">
		<div id="div-ajax">
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function () {
			callAjax(1, window.ajax_url.customer_list);
			var oldTimeout = '';

			$('#keyword').keyup(function () {
				$('#data-loading').show();

				clearTimeout(oldTimeout);
				oldTimeout = setTimeout(function () {
					callAjax(1, window.ajax_url.customer_list);
				}, 250);
			});

			filterBySelectBox('type', window.ajax_url.customer_list);
			filterBySelectBox('status', window.ajax_url.customer_list);

			$('#reset_search').click(function () {
				$('#keyword').val('');
				$('#type').val(-1);
				$('#status').val(-1);
				callAjax(1, window.ajax_url.customer_list)
			});
		});

		function filterBySelectBox(id, url_ajax) {
			$('#' + id).change(function () {
				callAjax(1, window.ajax_url.customer_list);
			});
		}

		function changePage(page_index) {
			callAjax(page_index, window.ajax_url.customer_list);
		}

		function callAjax(page_index, url_ajax) {
			$('#data-loading').show();
			var keyword = $('#keyword').val();
			var type = $('#type').val();
			var status = $('#status').val();
			console.log(keyword);
			console.log(type);
			console.log(status);
			$.ajax({
				url: url_ajax,
				type: 'POST',
				dataType: 'html',
				data: {
					keyword: keyword,
					type: type,
					status: status,
					page_index: page_index
				}
			}).done(function (result) {
				$('#data-loading').hide();
				$('#div-ajax').html(result);
			})
			$(document).ajaxError(function () {
				$('#data-loading').hide();
			});
		}
	</script>
</div>
