<!-- BEGIN Sidebar -->
<div id="sidebar" class="navbar-collapse collapse">
	<!-- BEGIN Navlist -->
	<ul class="nav nav-list">
		<li class="active">
			<a href="{{ URL::to('/growyspace-admin/dashboard/') }}">
			<i class="fa fa-dashboard"></i>
			<span>Dashboard</span>
			</a>
		</li>
		<li class="">
			<a href="{{ URL::to('/growyspace-admin/opportunity_cards/') }}">
			<i class="fa fa-desktop"></i>
			<span>Opportunity cards</span>
			</a>
		</li>
		<li class="">
			<a href="{{ URL::to('/growyspace-admin/opentowork_cards/') }}">
			<i class="fa fa-tasks"></i>
			<span>Open-to-work cards</span>
			</a>
		</li>
		<li class="">
			<a href="{{ URL::to('/growyspace-admin/news/') }}">
			<i class="fa fa-book"></i>
			<span>News</span>
			</a>
		</li>
		<li class="hidden">
			<a href="#" class="dropdown-toggle">
				<i class="fa fa-desktop"></i>
				<span>Opportunity cards</span>
				<b class="arrow fa fa-angle-right"></b>
			</a>

			<!-- BEGIN Submenu -->
			<ul class="submenu">
				<li><a href="{{ URL::to('/growyspace-admin/products/') }}">All Products</a></li>
				<li><a href="{{ URL::to('/growyspace-admin/products/create') }}">Add Product</a></li>
			</ul>
			<!-- END Submenu -->
		</li>
		<li class="hidden">
			<a href="#" class="dropdown-toggle">
				<i class="fa fa-desktop"></i>
				<span>Product Groups</span>
				<b class="arrow fa fa-angle-right"></b>
			</a>

			<!-- BEGIN Submenu -->
			<ul class="submenu">
				<li><a href="{{ URL::to('/growyspace-admin/product_groups/') }}">All Product Groups</a></li>
				<li><a href="{{ URL::to('/growyspace-admin/product_groups/create') }}">Add Product Group</a></li>
			</ul>
			<!-- END Submenu -->
		</li>
		
		<li class="hidden">
			<a href="#" class="dropdown-toggle">
				<i class="fa fa-globe"></i>
				<span>Mark Tree</span>
				<b class="arrow fa fa-angle-right"></b>
			</a>

			<!-- BEGIN Submenu -->
			<ul class="submenu">
				<li><a href="{{ URL::to('/growyspace-admin/mark_tree') }}">Tree View</a></li>
				<li><a href="{{ URL::to('/growyspace-admin/marks/') }}">All Marks</a></li>
				<li><a href="{{ URL::to('/growyspace-admin/marks/create') }}">Add Mark</a></li>
			</ul>
			<!-- END Submenu -->
		</li>
		<li class="hidden">
			<a href="#" class="dropdown-toggle">
				<i class="glyphicon glyphicon-user"></i>
				<span>Users</span>
				<b class="arrow fa fa-angle-right"></b>
			</a>

			<!-- BEGIN Submenu -->
			<ul class="submenu">
				<li><a href="{{ URL::to('/growyspace-admin/users/') }}">All Users</a></li>
				<li><a href="{{ URL::to('/growyspace-admin/users/create') }}">Add User</a></li>
			</ul>
			<!-- END Submenu -->
		</li>
		<li class="hidden">
			<a href="{{ URL::to('/growyspace-admin/orders/') }}">
			<i class="fa fa-usd"></i>
			<span>Orders</span>
			</a>
		</li>
		<li class="">
			<a href="{{ URL::to('/growyspace-admin/clients/') }}">
			<i class="glyphicon glyphicon-user"></i>
			<span>Users</span>
			</a>
		</li>
		<li>
			<a href="#" class="dropdown-toggle">
				<i class="glyphicon glyphicon-user"></i>
				<span>Admin Users</span>
				<b class="arrow fa fa-angle-right"></b>
			</a>

			<!-- BEGIN Submenu -->
			<ul class="submenu">
				<li><a href="{{ URL::to('/growyspace-admin/users/') }}">All Users</a></li>
				<li><a href="{{ URL::to('/growyspace-admin/users/create') }}">Add User</a></li>
			</ul>
			<!-- END Submenu -->
		</li>
		<li class="hidden">
			<a href="#" class="dropdown-toggle">
				<i class="fa fa-car"></i>
				<span>Cars</span>
				<b class="arrow fa fa-angle-right"></b>
			</a>

			<!-- BEGIN Submenu -->
			<ul class="submenu">
				<li><a href="{{ URL::to('/growyspace-admin/cars/') }}">All Cars</a></li>
				<li><a href="{{ URL::to('/growyspace-admin/cars/create') }}">Add Car</a></li>
			</ul>
			<!-- END Submenu -->
		</li>
		
		
		<li class="">
			<a href="{{ URL::to('/growyspace-admin/pages/') }}">
			<i class="fa fa-circle-o"></i>
			<span>Pages</span>
			</a>
		</li>
		
		<li class="hidden">
			<a href="{{ URL::to('/growyspace-admin/settings/') }}">
			<i class="fa fa-circle-o"></i>
			<span>Settings</span>
			</a>
		</li>
	</ul>
	<!-- END Navlist -->

	<!-- BEGIN Sidebar Collapse Button -->
	<div id="sidebar-collapse" class="visible-lg">
		<i class="fa fa-angle-double-left"></i>
	</div>
	<!-- END Sidebar Collapse Button -->
</div>
<!-- END Sidebar -->