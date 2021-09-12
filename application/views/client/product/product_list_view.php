<?php include ('application/views/errors/error_message_view.php');?>
<div class="row">
	<div class="col-lg-12">
		<ul class="breadcrumb">
			<li>
				<a href="<?php echo base_url('client/home/index') ?>">Trang chủ</a>
				<meta property="position" content="1">
			</li>
			<li>
				<input type="hidden" id="cate_id" value="<?php if (isset($cate)) echo $cate['id'] ?>">
				<a href="#"><?php if (isset($cate)) echo $cate['name'] ?></a>
				<meta property="position" content="2">
			</li>
		</ul>
	</div>
	<div class="col-lg-9" style="padding-top:20px">
		<div id="myCarousel" class="carousel slide" data-ride="carousel">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
				<li data-target="#myCarousel" data-slide-to="1"></li>
				<li data-target="#myCarousel" data-slide-to="2"></li>
				<li data-target="#myCarousel" data-slide-to="3"></li>
			</ol>
			<!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
				<div class="item active">
					<img src="<?php echo base_url('public/images/header/lcd-samsung-800-200-800x200.png') ?>" alt="Flower" width="460"
						 height="345">
				</div>
				<div class="item">
					<img src="<?php echo base_url('public/images/header/iphone-12-800-200-800x200.png') ?>" alt="Chania" width="460"
						 height="345">
				</div>
				<div class="item">
					<img src="<?php echo base_url('public/images/header/Oppo-A74-800-200-800x200.png') ?>" alt="Chania" width="460"
						 height="345">
				</div>
				<div class="item">
					<img src="<?php echo base_url('public/images/header/ipad-800-200-800x200-1.png') ?>" alt="Flower" width="460"
						 height="345">
				</div>
			</div>
			<!-- Left and right controls -->
			<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
	</div>
	<div class="col-lg-3" style="padding-top:20px">
		<div class="row preorder-hot">
			<img src="<?php echo base_url('public/images/header/Evogen11-390x97-2.png') ?>" alt="Anh iphone 11"
				 class="img-slider-detail"/>

			<img src="<?php echo base_url('public/images/header/sticky-micro-390x97.png') ?>" alt="Anh iphone"
				 class="img-slider-detail"/>
		</div>
	</div>
	<div class="col-lg-12 product-v2-heading">
		<div class="row">
			<div class="col-lg-2 col-sm-3 col-xs-12" style="margin-top: 5px">
				<select class="form-control filter-product" name="brand" id="brand">
					<option value="-1">- Thương hiệu -</option>
					<?php if (isset($brand) && $brand): ?>
					<?php foreach ($brand as $brand_list): ?>
					<option value="<?php echo $brand_list['id']; ?>"><?php echo $brand_list['name']; ?></option>
					<?php endforeach; ?>
					<?php endif; ?>
				</select>
			</div>
<!--			<div class="col-lg-2 col-sm-3 col-xs-12">-->
<!--				<select class="form-control selectpicker multi-select" multiple name="brand_multi" id="brand_multi"-->
<!--						style="width: 100%;">-->
<!--					--><?php //if (isset($brand) && $brand): ?>
<!--						--><?php //foreach ($brand as $brand_list): ?>
<!--							<option value="--><?php //echo $brand_list['id']; ?><!--">--><?php //echo $brand_list['name']; ?><!--</option>-->
<!--						--><?php //endforeach; ?>
<!--					--><?php //endif; ?>
<!--				</select>-->
<!--			</div>-->
			<?php if (in_array($id, ["1", "4", "5", "6", "18"])): ?>
			<div class="col-lg-2 col-sm-3 col-xs-12" style="margin-top: 5px">
				<select class="form-control filter-product" name="price" id="price">
					<option value="-1">- Giá -</option>
					<option value="0">Dưới 2 triệu</option>
					<option value="1">Từ 2 - 4 triệu</option>
					<option value="2">Từ 4 - 7 triệu</option>
					<option value="3">Từ 7 - 13 triệu</option>
					<option value="4">Từ 13 - 20 triệu</option>
					<option value="5">Trên 20 triệu</option>
				</select>
			</div>
			<?php endif; ?>
			<?php if (in_array($id, ["2"])): ?>
			<div class="col-lg-2 col-sm-3 col-xs-12" style="margin-top: 5px">
				<select class="form-control filter-product" name="price_laptop" id="price_laptop">
					<option value="-1">- Giá -</option>
					<option value="0">Dưới 15 triệu</option>
					<option value="1">Từ 15 - 20 triệu</option>
					<option value="2">Từ 20 - 25 triệu</option>
					<option value="3">Từ 25 - 30 triệu</option>
					<option value="4">Trên 30 triệu</option>
				</select>
			</div>
			<?php endif; ?>
			<?php if (in_array($id, ["3", "10", "11", "12", "15", "16"])): ?>
			<div class="col-lg-2 col-sm-3 col-xs-12" style="margin-top: 5px">
				<select class="form-control filter-product" name="price_accessory" id="price_accessory">
					<option value="-1">- Giá -</option>
					<option value="0">Dưới 200.000đ</option>
					<option value="1">Từ 200.000đ - 500.000đ</option>
					<option value="2">Từ 500.000đ - 1 triệu</option>
					<option value="3">Từ 1 - 2 triệu</option>
					<option value="4">Trên 2 triệu</option>
				</select>
			</div>
			<?php endif; ?>
			<?php if (in_array($id, ["1", "4"])): ?>
			<div class="col-lg-2 col-sm-3 col-xs-12" style="margin-top: 5px">
				<select class="form-control filter-product" name="ram" id="ram">
					<option value="-1">- RAM -</option>
					<option value="1 GB">1 GB</option>
					<option value="2 GB">2 GB</option>
					<option value="3 GB">3 GB</option>
					<option value="4 GB">4 GB</option>
					<option value="6 GB">6 GB</option>
					<option value="8 GB">8 GB</option>
					<option value="12 GB">12 GB</option>
				</select>
			</div>
			<?php endif; ?>
			<?php if (in_array($id, ["2"])): ?>
			<div class="col-lg-2 col-sm-3 col-xs-12" style="margin-top: 5px">
				<select class="form-control filter-product" name="ram" id="ram">
					<option value="-1">- RAM -</option>
					<option value="4 GB">4 GB</option>
					<option value="8 GB">8 GB</option>
					<option value="16 GB">16 GB</option>
					<option value="32 GB">32 GB</option>
				</select>
			</div>
			<?php endif; ?>
			<?php if (in_array($id, ["1", "4"])): ?>
			<div class="col-lg-2 col-sm-3 col-xs-12" style="margin-top: 5px">
				<select class="form-control filter-product" name="rom" id="rom">
					<option value="-1">- Bộ nhớ trong -</option>
					<option value="8 GB">8 GB</option>
					<option value="16 GB">16 GB</option>
					<option value="32 GB">32 GB</option>
					<option value="64 GB">64 GB</option>
					<option value="128 GB">128 GB</option>
					<option value="256 GB">256 GB</option>
					<option value="512 GB">512 GB</option>
				</select>
			</div>
			<?php endif; ?>
			<?php if (in_array($id, ["1", "5", "18"])): ?>
			<div class="col-lg-2 col-sm-3 col-xs-12" style="margin-top: 5px">
				<select class="form-control filter-product" name="screen" id="screen">
					<option value="-1">- Màn hình -</option>
					<option value="AMOLED">AMOLED</option>
					<option value="LCD">LCD</option>
					<option value="OLED">OLED</option>
				</select>
			</div>
			<?php endif; ?>
			<?php if (in_array($id, ["2"])): ?>
				<div class="col-lg-2 col-sm-3 col-xs-12" style="margin-top: 5px">
					<select class="form-control filter-product" name="screen" id="screen">
						<option value="-1">- Màn hình -</option>
						<option value='13.3"'>13.3 inch</option>
						<option value='14"'>14 inch</option>
						<option value='15.6"'>15.6 inch</option>
						<option value='17.3"'>17.3 inch</option>
					</select>
				</div>
				<div class="col-lg-2 col-sm-3 col-xs-12" style="margin-top: 5px">
					<select class="form-control filter-product" name="cpu" id="cpu">
						<option value="-1">- CPU -</option>
						<option value="i7">Intel Core i7</option>
						<option value="i5">Intel Core i5</option>
						<option value="i3">Intel Core i3</option>
						<option value="Pentinum">Intel Pentium</option>
						<option value="Celeron">Intel Celeron</option>
						<option value="Ryzen">AMD</option>
					</select>
				</div>
				<div class="col-lg-2 col-sm-3 col-xs-12" style="margin-top: 5px">
					<select class="form-control filter-product" name="card" id="card">
						<option value="-1">- Card đồ họa -</option>
						<option value="GTX">GeForce GTX</option>
						<option value="RTX">GeForce RTX</option>
						<option value="MX">GeForce MX</option>
					</select>
				</div>
				<div class="col-lg-2 col-sm-3 col-xs-12" style="margin-top: 5px">
					<select class="form-control filter-product" name="hard_drive" id="hard_drive">
						<option value="-1">- Ổ cứng -</option>
						<option value="SSD">SSD</option>
						<option value="HDD">HDD</option>
					</select>
				</div>
			<?php endif; ?>
			<?php if (in_array($id, ["18"])): ?>
				<div class="col-lg-2 col-sm-3 col-xs-12" style="margin-top: 5px">
					<select class="form-control filter-product" name="screen" id="screen">
						<option value="-1">- Kích cỡ màn hình -</option>
						<option value='23.8 inch"'>23.8 inch</option>
						<option value='24 inch'>24 inch</option>
						<option value='24.5 inch'>24.5 inch</option>
						<option value='27 inch'>27 inch</option>
						<option value='32 inch'>32 inch</option>
					</select>
				</div>
				<div class="col-lg-2 col-sm-3 col-xs-12" style="margin-top: 5px">
					<select class="form-control filter-product" name="frequency" id="frequency">
						<option value="-1">- Tần số quét -</option>
						<option value='60 Hz'>60 Hz</option>
						<option value='75 Hz'>75 Hz</option>
						<option value='144 Hz'>144 Hz</option>
						<option value='165 Hz'>165 Hz</option>
						<option value='240 Hz'>240 Hz</option>
					</select>
				</div>
			<?php endif; ?>
			<?php if (in_array($id, ["2", "18"])): ?>
			<div class="col-lg-2 col-sm-3 col-xs-12" style="margin-top: 5px">
				<select class="form-control filter-product" name="screen_resolution" id="screen_resolution">
					<option value="-1">- Độ phân giải -</option>
					<option value="4K">4K</option>
					<option value="2K">2K</option>
					<option value="Retina">Retina</option>
					<option value="Full HD">Full HD</option>
				</select>
			</div>
			<?php endif; ?>
		</div>
	</div>
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12" style="display: flex; flex-wrap: wrap;">
			<?php if (isset($brand) && $brand): ?>
			<?php foreach ($brand as $brand_image): ?>
				<button class="btn-brand" name="btn-brand" value="<?php echo $brand_image['id']; ?>">
					<img class="img-brand" src="<?php echo base_url('uploads/brand_image/'.$brand_image['brand_path']); ?>">
				</button>
			<?php endforeach; ?>
			<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="col-lg-12 product-v2-heading">
		<div class="row">
			<div class="col-lg-3 search-box">
				<input id="search-input" type="text" class="form-control" placeholder="Nhập để tìm kiếm...">
				<div class="search-btn">
					<i class="fa fa-search"></i>
				</div>
				<div class="cancel-btn">
					<i class="fa fa-times"></i>
				</div>
			</div>
			<div class="col-lg-2 col-sm-3 col-xs-12 position-right">
				<select class="form-control filter-product" name="sort" id="sort">
					<option value="-1">- Sắp xếp -</option>
					<option value="0">Nổi bật</option>
					<option value="1">Giá cao đến thấp</option>
					<option value="2">Giá thấp đến cao</option>
				</select>
			</div>
		</div>
	</div>
	<div class="col-lg-12" id="div-ajax">
	</div>
	<script type="text/javascript">
		var btn_brand = document.getElementsByName('btn-brand');
		var brand = document.getElementById('brand');

		var search_btn = document.querySelector('.search-btn');
		var cancel_btn = document.querySelector('.cancel-btn');
		var search_box = document.querySelector('.search-box');
		var search_input = document.querySelector('#search-input');
		search_btn.addEventListener('click', function () {
			search_box.classList.add("active-box");
			search_input.classList.add("active-box");
			search_btn.classList.add("active-box");
			cancel_btn.classList.add("active-box");
		});
		cancel_btn.addEventListener('click', function () {
			search_box.classList.remove("active-box");
			search_input.classList.remove("active-box");
			search_btn.classList.remove("active-box");
			cancel_btn.classList.remove("active-box");
		});
		for (var i = 0; i < btn_brand.length; i++) {
			var button = btn_brand[i];
			button.addEventListener('click', function () {
				brand.value = this.value;
				callAjax(1, window.ajax_url.product_list);
			});
		}

		$(document).ready(function () {
			callAjax(1, window.ajax_url.product_list);

			var oldTimeout = '';

			$('#search-input').keyup(function () {
				clearTimeout(oldTimeout);
				oldTimeout = setTimeout(function () {
					callAjax(1, window.ajax_url.product_list);
				}, 250);
			});
			filterBySelectBox('brand', window.ajax_url.product_list);
			filterBySelectBox('sort', window.ajax_url.product_list);
			filterBySelectBox('price', window.ajax_url.product_list);
			filterBySelectBox('price_laptop', window.ajax_url.product_list);
			filterBySelectBox('price_accessory', window.ajax_url.product_list);
			filterBySelectBox('ram', window.ajax_url.product_list);
			filterBySelectBox('rom', window.ajax_url.product_list);
			filterBySelectBox('screen', window.ajax_url.product_list);
			filterBySelectBox('cpu', window.ajax_url.product_list);
			filterBySelectBox('card', window.ajax_url.product_list);
			filterBySelectBox('hard_drive', window.ajax_url.product_list);
			filterBySelectBox('screen_resolution', window.ajax_url.product_list);
			filterBySelectBox('frequency', window.ajax_url.product_list);

			// $(".multi-select").select2({
			// 	placeholder: "- Thương hiệu -", //placeholder
			// 	tags: true,
			// 	tokenSeparators: ['/',',',';'," "],
			// });
		});

		function filterBySelectBox(id, url_ajax) {
			$('#' + id).change(function () {
				callAjax(1, window.ajax_url.product_list);
			});
		}

		function changePage(page_index) {
			callAjax(page_index, window.ajax_url.product_list);
		}

		function callAjax(page_index, url_ajax) {
			var keyword = $('#search-input').val();
			var brand = $('#brand').val();
			var sort = $('#sort').val();
			var cate_id = $('#cate_id').val();
			var price = $('#price').val();
			var price_laptop = $('#price_laptop').val();
			var price_accessory = $('#price_accessory').val();
			var ram = $('#ram').val();
			var rom = $('#rom').val();
			var screen = $('#screen').val();
			var cpu = $('#cpu').val();
			var card = $('#card').val();
			var hard_drive = $('#hard_drive').val();
			var screen_resolution = $('#screen_resolution').val();
			var frequency = $('#frequency').val();
			$.ajax({
				url: url_ajax,
				type: 'POST',
				dataType: 'html',
				data: {
					keyword: keyword,
					brand: brand,
					sort: sort,
					cate_id: cate_id,
					price: price,
					price_laptop: price_laptop,
					price_accessory: price_accessory,
					ram: ram,
					rom: rom,
					screen: screen,
					cpu: cpu,
					card: card,
					hard_drive: hard_drive,
					screen_resolution: screen_resolution,
					frequency: frequency,
					page_index: page_index
				}
			}).done(function (result) {
				$('#div-ajax').html(result);
			})
			$(document).ajaxError(function () {
				$('#data-loading').hide();
			});
		}
	</script>
</div>
