<?php
$controller = $this->router->fetch_class();
$action = $this->router->fetch_method();
?>
<!DOCTYPE html>
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
	<!-- Bootstrap Styles-->
	<link href="<?php echo base_url('public/dist/css/bootstrap.min.css') ?>" rel="stylesheet">
	<link href="assets/css/bootstrap.css" rel="stylesheet" />
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<link href="<?php echo base_url('public/assets/css/ie10-viewport-bug-workaround.css') ?>" rel="stylesheet">
	<!-- FontAwesome Styles-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="assets/css/font-awesome.css" rel="stylesheet" />
	<!-- Morris Chart Styles-->
	<link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
	<!-- Custom Styles-->
	<link href="<?php echo base_url('public/dist/css/custom-styles.css') ?>" rel="stylesheet" />
	<!-- Google Fonts-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
	<link rel="stylesheet" href="assets/js/Lightweight-Chart/cssCharts.css">
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
<div id="wrapper">
	<nav class="navbar navbar-default top-navbar" role="navigation">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo base_url('admin') ?>"><strong>QUẢN LÍ WEBSITE</strong></a>
			<div id="sideNav" href="">
				<i class="fa fa-bars icon"></i>
			</div>
		</div>
		<ul class="nav navbar-top-links navbar-right">
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
					<i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
				</a>
				<ul class="dropdown-menu dropdown-messages">
					<li>
						<a href="#">
							<div>
								<strong>John Doe</strong>
								<span class="pull-right text-muted">
                                        <em>Today</em>
                                    </span>
							</div>
							<div>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s...</div>
						</a>
					</li>
					<li class="divider"></li>
					<li>
						<a href="#">
							<div>
								<strong>John Smith</strong>
								<span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
							</div>
							<div>Lorem Ipsum has been the industry's standard dummy text ever since an kwilnw...</div>
						</a>
					</li>
					<li class="divider"></li>
					<li>
						<a href="#">
							<div>
								<strong>John Smith</strong>
								<span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
							</div>
							<div>Lorem Ipsum has been the industry's standard dummy text ever since the...</div>
						</a>
					</li>
					<li class="divider"></li>
					<li>
						<a class="text-center" href="#">
							<strong>Read All Messages</strong>
							<i class="fa fa-angle-right"></i>
						</a>
					</li>
				</ul>
				<!-- /.dropdown-messages -->
			</li>
			<!-- /.dropdown -->
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
					<i class="fa fa-tasks fa-fw"></i> <i class="fa fa-caret-down"></i>
				</a>
				<ul class="dropdown-menu dropdown-tasks">
					<li>
						<a href="#">
							<div>
								<p>
									<strong>Task 1</strong>
									<span class="pull-right text-muted">60% Complete</span>
								</p>
								<div class="progress progress-striped active">
									<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
										<span class="sr-only">60% Complete (success)</span>
									</div>
								</div>
							</div>
						</a>
					</li>
					<li class="divider"></li>
					<li>
						<a href="#">
							<div>
								<p>
									<strong>Task 2</strong>
									<span class="pull-right text-muted">28% Complete</span>
								</p>
								<div class="progress progress-striped active">
									<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="28" aria-valuemin="0" aria-valuemax="100" style="width: 28%">
										<span class="sr-only">28% Complete</span>
									</div>
								</div>
							</div>
						</a>
					</li>
					<li class="divider"></li>
					<li>
						<a href="#">
							<div>
								<p>
									<strong>Task 3</strong>
									<span class="pull-right text-muted">60% Complete</span>
								</p>
								<div class="progress progress-striped active">
									<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
										<span class="sr-only">60% Complete (warning)</span>
									</div>
								</div>
							</div>
						</a>
					</li>
					<li class="divider"></li>
					<li>
						<a href="#">
							<div>
								<p>
									<strong>Task 4</strong>
									<span class="pull-right text-muted">85% Complete</span>
								</p>
								<div class="progress progress-striped active">
									<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%">
										<span class="sr-only">85% Complete (danger)</span>
									</div>
								</div>
							</div>
						</a>
					</li>
					<li class="divider"></li>
					<li>
						<a class="text-center" href="#">
							<strong>See All Tasks</strong>
							<i class="fa fa-angle-right"></i>
						</a>
					</li>
				</ul>
				<!-- /.dropdown-tasks -->
			</li>
			<!-- /.dropdown -->
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
					<i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
				</a>
				<ul class="dropdown-menu dropdown-alerts">
					<li>
						<a href="#">
							<div>
								<i class="fa fa-comment fa-fw"></i> New Comment
								<span class="pull-right text-muted small">4 min</span>
							</div>
						</a>
					</li>
					<li class="divider"></li>
					<li>
						<a href="#">
							<div>
								<i class="fa fa-twitter fa-fw"></i> 3 New Followers
								<span class="pull-right text-muted small">12 min</span>
							</div>
						</a>
					</li>
					<li class="divider"></li>
					<li>
						<a href="#">
							<div>
								<i class="fa fa-envelope fa-fw"></i> Message Sent
								<span class="pull-right text-muted small">4 min</span>
							</div>
						</a>
					</li>
					<li class="divider"></li>
					<li>
						<a href="#">
							<div>
								<i class="fa fa-tasks fa-fw"></i> New Task
								<span class="pull-right text-muted small">4 min</span>
							</div>
						</a>
					</li>
					<li class="divider"></li>
					<li>
						<a href="#">
							<div>
								<i class="fa fa-upload fa-fw"></i> Server Rebooted
								<span class="pull-right text-muted small">4 min</span>
							</div>
						</a>
					</li>
					<li class="divider"></li>
					<li>
						<a class="text-center" href="#">
							<strong>See All Alerts</strong>
							<i class="fa fa-angle-right"></i>
						</a>
					</li>
				</ul>
				<!-- /.dropdown-alerts -->
			</li>
			<!-- /.dropdown -->
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
					<i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
				</a>
				<ul class="dropdown-menu dropdown-user">
					<li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
					</li>
					<li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
					</li>
					<li class="divider"></li>
					<li><a href="#"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
					</li>
				</ul>
				<!-- /.dropdown-user -->
			</li>
			<!-- /.dropdown -->
		</ul>
	</nav>
	<!--/. NAV TOP  -->
	<nav class="navbar-default navbar-side" role="navigation">
		<div class="sidebar-collapse">
			<ul class="nav" id="main-menu">
				<li>
					<a class="<?php echo (($controller == 'home') ? 'active-menu' : '') ?>" href="<?php echo base_url('admin') ?>">
						<i class="fa fa-home"></i>Trang chủ</a>
				</li>
				<li>
					<a class="<?php echo (in_array($controller, array('')) ? 'active-menu' : '') ?>" href="#">
						<i class="fa fa-th"></i>QL.Danh mục<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li>
							<a href="#">Mục 1</a>
						</li>
						<li>
							<a href="#">Mục 2</a>
						</li>
					</ul>
				</li>
				<li>
					<a class="<?php echo (in_array($controller, array('')) ? 'active-menu' : '') ?>" href="#">
						<i class="fa fa-dropbox"></i>QL.Sản phẩm<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li>
							<a href="#">Mục 1</a>
						</li>
						<li>
							<a href="#">Mục 2</a>
						</li>
					</ul>
				</li>
				<li>
					<a class="<?php echo (in_array($controller, array('')) ? 'active-menu' : '') ?>" href="#">
						<i class="fa fa-file-text"></i>QL.Đơn hàng<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li>
							<a href="#">Mục 1</a>
						</li>
						<li>
							<a href="#">Mục 2</a>
						</li>
					</ul>
				</li>
				<li>
					<a class="<?php echo (in_array($controller, array('')) ? 'active-menu' : '') ?>" href="#">
						<i class="fa fa-truck"></i>QL.Ship hàng<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li>
							<a href="#">Mục 1</a>
						</li>
						<li>
							<a href="#">Mục 2</a>
						</li>
					</ul>
				</li>
				<li>
					<a class="<?php echo (in_array($controller, array('')) ? 'active-menu' : '') ?>" href="#">
						<i class="fa fa-user"></i>QL.Khách hàng<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li>
							<a href="#">Mục 1</a>
						</li>
						<li>
							<a href="#">Mục 2</a>
						</li>
					</ul>
				</li>
				<li>
					<a class="<?php echo (in_array($controller, array('')) ? 'active-menu' : '') ?>" href="#">
						<i class="fa fa-files-o"></i>Thống kê<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li>
							<a href="#">Mục 1</a>
						</li>
						<li>
							<a href="#">Mục 2</a>
						</li>
					</ul>
				</li>
				<li>
					<a class="<?php echo (in_array($controller, array('')) ? 'active-menu' : '') ?>" href="#">
						<i class="fa fa-university"></i>QL.Kho hàng<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li>
							<a href="#">Mục 1</a>
						</li>
						<li>
							<a href="#">Mục 2</a>
						</li>
					</ul>
				</li>
				<li>
					<a class="<?php echo (in_array($controller, array('')) ? 'active-menu' : '') ?>" href="#">
						<i class="fa fa-percent"></i>QL.Giảm giá<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li>
							<a href="#">Mục 1</a>
						</li>
						<li>
							<a href="#">Mục 2</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="#"><i class="fa fa-sitemap"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li>
							<a href="#">Second Level Link</a>
						</li>
						<li>
							<a href="#">Second Level Link<span class="fa arrow"></span></a>
							<ul class="nav nav-third-level">
								<li>
									<a href="#">Third Level Link</a>
								</li>
								<li>
									<a href="#">Third Level Link</a>
								</li>
								<li>
									<a href="#">Third Level Link</a>
								</li>

							</ul>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
	<!-- /. NAV SIDE  -->
	<div id="page-wrapper" style="background-color: white;">
		<div class="container" style="padding-bottom: 30px; padding-top: 30px;">
			<?php (isset($load_page) && $load_page) ? $this->load->view($load_page) : ''; ?>
			<footer>
				<p>Thegioibanhang.com</p>
			</footer>
		</div>
		<!-- /. PAGE WRAPPER  -->
	</div>
	<!-- /. WRAPPER  -->
	<!-- JS Scripts-->
	<!-- jQuery Js -->
	<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="<?php echo base_url('public/assets/js/vendor/jquery.min.js') ?>"><\/script>')</script>
	<script src="<?php echo base_url('public/dist/js/bootstrap.min.js') ?>"></script>
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="<?php echo base_url('public/assets/js/ie10-viewport-bug-workaround.js') ?>"></script>
	<script src="assets/js/jquery-1.10.2.js"></script>
	<!-- Bootstrap Js -->
	<script src="assets/js/bootstrap.min.js"></script>
	<!-- Metis Menu Js -->
	<script src="<?php echo base_url('public/dist/js/jquery.metisMenu.js') ?>"></script>
	<!-- Morris Chart Js -->
	<script src="assets/js/morris/raphael-2.1.0.min.js"></script>
	<script src="assets/js/morris/morris.js"></script>
	<script src="assets/js/easypiechart.js"></script>
	<script src="assets/js/easypiechart-data.js"></script>
	<script src="assets/js/Lightweight-Chart/jquery.chart.js"></script>
	<!-- Custom Js -->
	<script src="<?php echo base_url('public/dist/js/custom-scripts.js') ?>"></script>
	<!-- Chart Js -->
	<script type="text/javascript" src="assets/js/Chart.min.js"></script>
	<script type="text/javascript" src="assets/js/chartjs.js"></script>
</body>
</html>
