@include('commons.admin_header')
<!-- BEGIN Container -->
<div class="container" id="main-container">
	@include('commons.admin_left_menu')
	<div id="main-content">
		@yield('content')
		
		<footer>
			<p>{{ date('Y') }} Growspace.</p>
		</footer>

		<a id="btn-scrollup" class="btn btn-circle btn-lg" href="#"><i class="fa fa-chevron-up"></i></a>
	</div>
</div>
<!-- END Container -->
@include('commons.admin_footer')




