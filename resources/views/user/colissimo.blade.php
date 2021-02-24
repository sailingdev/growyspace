@extends('layouts.front')
@section('content')
<!-- Content -->
<div class="page-content bg-white show_colissimo_widget">
  	<!-- Breadcrumb row -->
	<div class="breadcrumb-row">
		<div class="container">
			<ul class="list-inline">
				<li><a href="{{ URL::to('/') }}">Accueil</a></li>
				<li><a href="{{ URL::to('/') }}/user/my_account">My Account</a></li>
				<li>Colllisimo</li>
			</ul>
		</div>
	</div>
	<div class="page-content bg-white">
		<!-- contact area -->
		<div class="section-full content-inner">
			<!-- Product -->
			<div style="overflow:hidden;" class="container">	
				<div id="widget-container" ></div>
				<input type="hidden" id="pudoWidgetErrorCode">
			</div>
		</div>
	</div>
	
	
</div>	
@endsection