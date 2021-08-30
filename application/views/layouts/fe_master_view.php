<?php
$controller = $this->router->fetch_class();
$action = $this->router->fetch_method();
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
						<div class="col-lg-12">
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
							<ul class="dropdown-menu">
								<li>
									<a href="#">Đăng nhập</a>
								</li>
								<li role="separator" class="divider"></li>
								<li>
									<a href="#">Tạo tài khoản</a>
								</li>
								<li role="separator" class="divider"></li>
								<li>
									<a href="/#">Thoát</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="row">
						<input type="search" name="search" id="keyword" class="form-control"
							   placeholder="Nhập để tìm kiếm"
							   style=" margin-top: 5px; border-radius:10px;">
					</div>
				</div>
				<div class="col-lg-2">
					<a href="<?php echo base_url('client/home/cart') ?>">
						<div class="row btn" style=" color: white; ">
							<div class="col-lg-4">
								<i class="fa fa-shopping-cart list_i"></i>
							</div>
							<div class="col-lg-8" style=" margin-top:5px;">
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
									<i class="fa fa-user-circle-o list_i"></i>
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
										<a href="<?php echo base_url('client/home/register') ?>">Thông tin tài khoản</a>
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
										<a href="<?php echo base_url('client/home/register') ?>">Tạo tài khoản</a>
									</li>
								<?php endif; ?>
								<?php if (isset($_SESSION['login'])): ?>
								<li role="separator" class="divider"></li>
								<li>
									<a href="<?php echo base_url('client/home/logout') ?>"
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
</body>
</html>
