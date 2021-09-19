<div class="row">
	<div class="col-lg-12">
		<h4 class="title-cart">ĐƠN HÀNG CỦA TÔI</h4>
	</div>
	<div class="col-lg-12">
		<div class="col-lg-12 back-white">
			<div class="row product-v2-heading">
				<div class="col-lg-2 text-center">
					<strong>Mã đơn</strong>
				</div>
				<div class="col-lg-2 text-center">
					<strong>Ngày mua</strong>
				</div>
				<div class="col-lg-3 text-center">
					<strong>Sản phẩm</strong>
				</div>
				<div class="col-lg-2 text-center">
					<strong>Tổng tiền</strong>
				</div>
				<div class="col-lg-2 text-center">
					<strong>Trạng thái</strong>
				</div>
				<div class="col-lg-1 text-center">
					<strong>Thao tác</strong>
				</div>
			</div>
			<div class="row">
				<p style="height:1px;background-color:#cccccc"></p>
			</div>
			<div id="div-ajax"></div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function () {
			callAjax(1, window.ajax_url.order_list);
		});

		function changePage(page_index) {
			callAjax(page_index, window.ajax_url.order_list);
		}

		function callAjax(page_index, url_ajax) {
			$('#data-loading').show();
			$.ajax({
				url: url_ajax,
				type: 'POST',
				dataType: 'html',
				data: {
					page_index: page_index,
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
