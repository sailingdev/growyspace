<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Growyspace  - Admin</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

	<!--base css styles-->
	<link rel="stylesheet" href="{{ URL::to('/') }}/admin/assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="{{ URL::to('/') }}/admin/assets/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{ URL::to('/') }}/admin/assets/magnific-popup/magnific-popup.css">
	<link rel="stylesheet" href="{{ URL::to('/') }}/admin/assets/dropzone/dropzone.css">
	<link rel="stylesheet" href="{{ URL::to('/') }}/admin/assets/treeview/jquery.treeview.css">
	<link rel="stylesheet" type="text/css" href="{{ URL::to('/') }}/admin/assets/chosen-bootstrap/chosen.min.css" />
	<!--page specific css styles-->
	<!--page specific css styles-->
	<link rel="stylesheet" href="{{ URL::to('/') }}/admin/assets/jquery-ui/jquery-ui.min.css">
	<!--flaty css styles-->
	<link rel="stylesheet" href="{{ URL::to('/') }}/admin/css/flaty.css?{{ time() }}">
	<link rel="stylesheet" href="{{ URL::to('/') }}/admin/css/flaty-responsive.css">

	<script>window.base_url = '{{ URL::to("/growyspace-admin/") }}/';</script>
	</head>
	<body>

	<!-- BEGIN Theme Setting -->
	<div id="theme-setting">
		<a href="#"><i class="fa fa-gears fa fa-2x"></i></a>
		<ul>
			<li>
				<span>Skin</span>
				<ul class="colors" data-target="body" data-prefix="skin-">
					<li class="active"><a class="blue" href="#"></a></li>
					<li><a class="red" href="#"></a></li>
					<li><a class="green" href="#"></a></li>
					<li><a class="orange" href="#"></a></li>
					<li><a class="yellow" href="#"></a></li>
					<li><a class="pink" href="#"></a></li>
					<li><a class="magenta" href="#"></a></li>
					<li><a class="gray" href="#"></a></li>
					<li><a class="black" href="#"></a></li>
				</ul>
			</li>
			<li>
			<span>Navbar</span>
			<ul class="colors" data-target="#navbar" data-prefix="navbar-">
			<li class="active"><a class="blue" href="#"></a></li>
			<li><a class="red" href="#"></a></li>
			<li><a class="green" href="#"></a></li>
			<li><a class="orange" href="#"></a></li>
			<li><a class="yellow" href="#"></a></li>
			<li><a class="pink" href="#"></a></li>
			<li><a class="magenta" href="#"></a></li>
			<li><a class="gray" href="#"></a></li>
			<li><a class="black" href="#"></a></li>
			</ul>
			</li>
			<li>
			<span>Sidebar</span>
			<ul class="colors" data-target="#main-container" data-prefix="sidebar-">
			<li class="active"><a class="blue" href="#"></a></li>
			<li><a class="red" href="#"></a></li>
			<li><a class="green" href="#"></a></li>
			<li><a class="orange" href="#"></a></li>
			<li><a class="yellow" href="#"></a></li>
			<li><a class="pink" href="#"></a></li>
			<li><a class="magenta" href="#"></a></li>
			<li><a class="gray" href="#"></a></li>
			<li><a class="black" href="#"></a></li>
			</ul>
			</li>
			<li>
			<span></span>
			<a data-target="navbar" href="#"><i class="fa fa-square-o"></i> Fixed Navbar</a>
			<a class="hidden-inline-xs" data-target="sidebar" href="#"><i class="fa fa-square-o"></i> Fixed Sidebar</a>
			</li>
		</ul>
	</div>
	<!-- END Theme Setting -->

	<!-- BEGIN Navbar -->
	<div id="navbar" class="navbar">
	<button type="button" class="navbar-toggle navbar-btn collapsed" data-toggle="collapse" data-target="#sidebar">
	<span class="fa fa-bars"></span>
	</button>
	<a class="navbar-brand" href="#">
	<small>
	<i class="fa fa-desktop"></i>
	Space Lab Admin
	</small>
	</a>

	<!-- BEGIN Navbar Buttons -->
	<ul class="nav flaty-nav pull-right">


	<!-- BEGIN Button User -->
	<li class="user-profile">
	<a data-toggle="dropdown" href="#" class="user-menu dropdown-toggle">
	<img class="nav-user-photo" src="{{ URL::to('/') }}/admin/img/demo/avatar/avatar1.jpg" alt="Penny's Photo" />
	<span class="hhh" id="user_info">
	Penny
	</span>
	<i class="fa fa-caret-down"></i>
	</a>

	<!-- BEGIN User Dropdown -->
	<ul class="dropdown-menu dropdown-navbar" id="user_menu">
	<li class="nav-header">
	<i class="fa fa-clock-o"></i>
	Logined From 20:45
	</li>

	<li>
	<a href="#">
	<i class="fa fa-cog"></i>
	Account Settings
	</a>
	</li>

	<li>
	<a href="#">
	<i class="fa fa-user"></i>
	Edit Profile
	</a>
	</li>

	<li>
	<a href="#">
	<i class="fa fa-question"></i>
	Help
	</a>
	</li>

	<li class="divider visible-xs"></li>

	<li class="visible-xs">
	<a href="#">
	<i class="fa fa-tasks"></i>
	Tasks
	<span class="badge badge-warning">4</span>
	</a>
	</li>
	<li class="visible-xs">
	<a href="#">
	<i class="fa fa-bell"></i>
	Notifications
	<span class="badge badge-important">8</span>
	</a>
	</li>
	<li class="visible-xs">
	<a href="#">
	<i class="fa fa-envelope"></i>
	Messages
	<span class="badge badge-success">5</span>
	</a>
	</li>

	<li class="divider"></li>

	<li>
	<a href="{{ URL::to('/growyspace-admin/logout') }}">
	<i class="fa fa-off"></i>
	Logout
	</a>
	</li>
	</ul>
	<!-- BEGIN User Dropdown -->
	</li>
	<!-- END Button User -->
	</ul>
<!-- END Navbar Buttons -->
</div>
<!-- END Navbar -->
