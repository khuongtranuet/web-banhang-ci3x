<?php
$controller = $this->router->fetch_class();
$action = $this->router->fetch_method();
//$this->load->model('client/home_model');
$this->db->select(' *');
$this->db->from(TBL_CATEGORIES);
$cate_list = $this->db->get()->result_array();
$cate_list = dataTree($cate_list);
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="<?php echo base_url('public/images/favicon.ico') ?>">

	<title>Quản lí website bán hàng</title>

	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="<?php echo base_url('public/dist/assets/vendor/bootstrap/css/bootstrap.min.css') ?>">
	<link rel="stylesheet"
		  href="<?php echo base_url('public/dist/assets/vendor/font-awesome/css/font-awesome.min.css') ?>">
	<link rel="stylesheet" href="<?php echo base_url('public/dist/assets/vendor/linearicons/style.css') ?>">
	<link rel="stylesheet" href="<?php echo base_url('public/dist/assets/vendor/chartist/css/chartist-custom.css') ?>">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="<?php echo base_url('public/dist/assets/css/main.css') ?>">
	<link rel="stylesheet" href="<?php echo base_url('public/dist/css/style.css') ?>">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">

	<!--	 IE10 viewport hack for Surface/desktop Windows 8 bug-->
	<link href="<?php echo base_url('public/assets/css/ie10-viewport-bug-workaround.css') ?>" rel="stylesheet">
	<!-- FontAwesome Styles-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- Custom Styles-->
	<link rel="stylesheet" href="<?php echo base_url('public/dist/assets/css/customize.css') ?>">
	<link href="<?php echo base_url('public/dist/css/customize.css') ?>" rel="stylesheet">
	<script src="<?php echo base_url('public/dist/js/jquery-3.6.0.js') ?>"></script>
<!--	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">-->
	<link rel="stylesheet"
		  href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
	<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
	<!--[if lt IE 9]>
	<script src="<?php echo base_url('public/assets/js/ie8-responsive-file-warning.js') ?>"></script><![endif]-->
	<script src="<?php echo base_url('public/assets/js/ie-emulation-modes-warning.js') ?>"></script>
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<script>
		window.ajax_url = {
			'cart_list': '<?php echo base_url("client/cart/ajax_list") ?>',
			'product_list': '<?php echo base_url("client/product/ajax_list") ?>',
			'ajax_stock_store': '<?php echo base_url("client/product/ajax_stock_store") ?>',
			'ajax_search': '<?php echo base_url("client/home/ajax_search") ?>',
            'district_list': '<?php echo base_url("admin/home/ajax_district") ?>',
            'ward_list': '<?php echo base_url("admin/home/ajax_ward") ?>',
            'address_list': '<?php echo base_url("client/payment/ajax_address") ?>',
            'account_address_list': '<?php echo base_url("client/account/ajax_address") ?>',
            'total_cart': '<?php echo base_url("client/cart/ajax_total_cart") ?>',
            'carousel_list': '<?php echo base_url("client/product/ajax_carousel") ?>',
            'order_list': '<?php echo base_url("client/order/ajax_list") ?>',
		}
	</script>
</head>

<body>
<!-- WRAPPER -->
<div class="App">
	<div style="background-color:#FFF200;">
		<div class="container">
			<div class="row">
				<img src="<?php echo base_url('public/images/header/banner.png') ?>">
			</div>
		</div>
	</div>
	<div style=" background-color: black; ">
		<div class="container">
			<div class="row" style=" height:45px;">
				<div class="col-lg-2">
					<a href="<?php echo base_url('client/home/index') ?>">
						<img class="logo_web" src="<?php echo base_url('public/images/header/logo.png') ?>">
					</a>
				</div>
				<div class="col-lg-2">
					<div class="row">
						<div class="col-lg-12 dropdown-category">
							<div class="dropdown-toggle btn" data-toggle="dropdown" role="button" aria-haspopup="true"
								 aria-expanded="false"
								 style="color:white; margin-top:0px; display: flex;">
								<div class="col-lg-3">
									<i class="fa fa-bars list_i"></i>
								</div>
								<div class="col-lg-9" style="margin-top:5px;">
									<span>Danh mục </span>
									<span class="caret"></span>
								</div>
							</div>
							<ul class="dropdown-menu" style="width: 200px">
								<?php if (isset($cate_list) && $cate_list): ?>
									<?php $j = 0; foreach ($cate_list as $result_cate): $j++; ?>
										<li>
											<a href="<?php echo base_url('client/product/pd_list/'.$result_cate['id']); ?>">
												<span><?php echo $result_cate['name']; ?></span>
												<?php if (isset($result_cate['child']) && $result_cate['child']): ?>
													<i class="fa fa-caret-right position-right" style="font-size: 20px"></i>
												<?php endif; ?>
											</a>
											<?php if (isset($result_cate['child']) && $result_cate['child']): ?>
												<ul class="dropdown-menu">
													<?php $i = 0; foreach ($result_cate['child'] as $result_child): $i++; ?>
														<li><a href="<?php echo base_url('client/product/pd_list/'.$result_child['id']); ?>">
																<?php echo $result_child['name']; ?></a></li>
														<?php if ($i != count($result_cate['child'])): ?>
															<li role="separator" class="divider"></li>
														<?php endif; ?>
													<?php endforeach; ?>
												</ul>
											<?php endif; ?>

										</li>
										<?php if ($j != count($cate_list)): ?>
											<li role="separator" class="divider"></li>
										<?php endif; ?>
									<?php endforeach; ?>
								<?php endif; ?>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="row" style="position: relative">
						<input type="search" name="key_search" id="key_search" class="form-control"
							   placeholder="Nhập để tìm kiếm"
							   style=" margin-top: 5px; border-radius:10px;">
						<div class="popup-search">
							<div class="row" style="margin-top: 10px" id="div-search">
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-2">
					<a href="<?php echo base_url('client/cart/detail') ?>">
						<div class="row btn" style=" color: white; ">
							<div class="col-lg-4" style="position: relative">
								<i class="fa fa-shopping-cart list_i"></i>
								<div class="quantity-cart-header">
									<span><?php if (isset($_SESSION['product_id']))
												echo isset($_SESSION['product_id']) ? count($_SESSION['product_id']) : '0';
										elseif(isset($_SESSION['cart'])) echo isset($_SESSION['cart']) ? (count($_SESSION['cart']) - 1) : '0';
										else echo '0';?></span>
								</div>
							</div>
							<div class="col-lg-8 title-cart-header">
								<span>Giỏ hàng</span>
							</div>
						</div>
					</a>
				</div>
				<div class="col-lg-2">
					<div class="row">
						<div class="col-lg-12">
							<div class="dropdown-toggle btn row" data-toggle="dropdown" role="button"
								 aria-haspopup="true"
								 aria-expanded="false"
								 style="color: white;margin-top: 0px;display: flex;margin-left: -30px;">
								<div class="col-lg-3">
<!--									<i class="fa fa-user-circle-o list_i"></i>-->
									<img src="<?php if (isset($_SESSION['avatar']) && $_SESSION['avatar'] != '')
										echo base_url('uploads/avatar_image/'.$_SESSION['avatar']);
									else echo base_url('public/images/avatar-png.jpg') ?>" id="avatar_header">
								</div>
								<div class="col-lg-9" style=" float: right; margin-top:5px; ">
									<span><?php if (isset($_SESSION['fullname'])) echo $_SESSION['fullname'];
										else echo 'Tài khoản'; ?> </span>
									<span class="caret"></span>
								</div>
							</div>
							<ul class="dropdown-menu">
								<?php if (isset($_SESSION['login'])): ?>
									<li>
										<a href="<?php echo base_url('client/account/edit') ?>">Thông tin tài khoản</a>
									</li>
								<?php endif; ?>
								<?php if (isset($_SESSION['login'])): ?>
									<li role="separator" class="divider"></li>
									<li>
										<a href="<?php echo base_url('client/order/history') ?>">Quản lý đơn hàng</a>
									</li>
								<?php endif; ?>
								<?php if (isset($_SESSION['login'])): ?>
									<li role="separator" class="divider"></li>
									<li>
										<a href="<?php echo base_url('client/account/address') ?>">Sổ địa chỉ</a>
									</li>
								<?php endif; ?>
								<?php if (!isset($_SESSION['login'])): ?>
									<li>
										<a href="<?php echo base_url('client/home/login') ?>">Đăng nhập</a>
									</li>
								<?php endif; ?>
								<?php if (!isset($_SESSION['login'])): ?>
									<li role="separator" class="divider"></li>
									<li>
										<a href="<?php echo base_url('client/account/register') ?>">Tạo tài khoản</a>
									</li>
								<?php endif; ?>
								<?php if (isset($_SESSION['login'])): ?>
								<li role="separator" class="divider"></li>
								<li>
									<a href="<?php echo base_url('client/account/logout') ?>"
									   onclick="confirm('Bạn có chắc chắn muốn thoát không?')">Thoát</a>
								</li>
								<?php endif; ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->
	<div class="container">
		<?php (isset($load_page) && $load_page) ? $this->load->view($load_page) : ''; ?>
	</div>
</div>
<!-- Javascript -->
<script src="<?php echo base_url('public/dist/assets/vendor/jquery/jquery.min.js') ?>"></script>
<script src="<?php echo base_url('public/dist/assets/vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('public/dist/assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js') ?>"></script>
<script src="<?php echo base_url('public/dist/assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js') ?>"></script>
<!--<script src="--><?php //echo base_url('public/dist/assets/vendor/chartist/js/chartist.min.js') ?><!--"></script>-->
<script src="<?php echo base_url('public/dist/assets/scripts/klorofil-common.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>-->
<script type="text/javascript">
	document.onclick = function (e) {
		if (e.target.id != 'key_search' && e.target.class != 'popup-search') {
			document.getElementById('div-search').parentElement.classList.remove('active-popup');
		}
		if (e.target.id == 'key_search' && $('#key_search').val() != '') {
			document.getElementById('div-search').parentElement.classList.add('active-popup');
		}
	};

	$(document).ready(function () {
		var oldTimeout = '';

		$('#key_search').keyup(function () {
			clearTimeout(oldTimeout);
			if($('#key_search').val() == '') {
				document.getElementById('div-search').parentElement.classList.remove('active-popup');
			}else{
				oldTimeout = setTimeout(function () {
					callAjaxSearch(1, window.ajax_url.ajax_search);
				}, 250);
			}
		});
	});
	function callAjaxSearch(page_index, url_ajax) {
		var keyword = $('#key_search').val();
		$.ajax({
			url: url_ajax,
			type: 'POST',
			dataType: 'html',
			data: {
				keyword: keyword,
			}
		}).done(function (result) {
			$('#div-search').html(result);
			document.getElementById('div-search').parentElement.classList.add('active-popup');
		})
		$(document).ajaxError(function () {
			$('#data-loading').hide();
		});
	}
</script>
</body>
</html>
