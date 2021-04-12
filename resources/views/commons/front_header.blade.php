<!DOCTYPE html>
<html lang="en">
<head>
 
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	
   	<title>{{ isset($meta_title) ? $meta_title : 'Growyspace' }}</title>
	   @if(isset($opportunity_card_page) && $opportunity_card_page === true && $og_url)

		<meta property="og:url"           content="{{$og_url}}" />
		<meta property="og:type"          content="website" />
		<meta property="og:title"         content="{{ $og_title }}" />
		<meta property="og:description"   content="{{ $og_description }}" />
		<meta name="image" property="og:image" content="{{ $og_image}}">
		@else
		<meta name="image" property="og:image" content="{{ URL::to('/') }}/assets/images/logo.png">
		
		@endif
	
	
	
	<link rel="icon" href="{{ URL::to('/') }}/assets/images/Logo-no-text.png" type="image/x-icon" />
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- Bootstrap core CSS -->
    <link href="{{ URL::to('/') }}/assets/fontawesome/css/font-awesome.min.css" rel="stylesheet">
	<link href="{{ URL::to('/') }}/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="{{ URL::to('/') }}/assets/plugins/magnific-popup/magnific-popup.css" rel="stylesheet">
    <link href="{{ URL::to('/') }}/assets/plugins/croppie/croppie.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,100&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
	
	<link href="{{ URL::to('/') }}/assets/bootstrap4-editable/css/bootstrap-editable.css" rel="stylesheet"/>
	
	<link href="{{ URL::to('/') }}/assets/css/custom.css?{{ time() }}" rel="stylesheet">
	<script>window.base_url = '{{ URL::to('/') }}/';</script>
	<script>window.is_logged_in = '{{ Auth::guard("user")->check() ? 1 : 0 }}';</script>
	
</head>

<body class="bg-gray {{ (request()->is('/') || request()->is('contact') || request()->is('about') || request()->is('privacy') || request()->is('terms') || request()->is('oportunity_guide') || request()->is('opentowork_guide')) ? 'bg-white' : '' }}">
	<header class="sticky-top">
		<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm {{ Auth::guard('user')->check() ? 'navbar_custom2' : 'navbar_custom' }}">
		
			<a href="/user/my_account" class="navbar-brand p-0 m-0">
				<img src="/assets/images/Logo-Growyspace-Small.svg" class="img-fluid nav_img" alt="Growyspace">
			</a>
			<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse " id="navbarCollapse">
				
				@if(Auth::guard('user')->check())
				
				<div class="navbar-nav ml-auto hide_navbar_inmobile">
					<!--a href="blog" class="p-2 nav-item nav-link "><img src="/assets/images/Icon-news-small.svg" class="pull-left img-fluid" style="width:30px;"/><span class="pull-left p-1" >News</span></a-->

					<a href="{{ URL::to('/') }}/messages" class="p-2 nav-item nav-link {{ (request()->is('messages')) ? 'active' : '' }}">
					@if($not_read_messages_count > 0)
					<img src="/assets/images/Icon-message-new-message-1.svg" class="img-fluid pull-left" style="width:30px;" />
					@else
					<img src="/assets/images/Icon-message-new.svg" class="img-fluid pull-left" style="width:30px;" />
					@endif
					<span class="pull-left p-1" >Messages</span></a>
					<a href="{{ URL::to('/') }}/user/my-collection" class="p-2 nav-item nav-link {{ (request()->is('user/my-collection')) ? 'active' : '' }}"><img src="/assets/images/redesign-collections 5.svg" class="pull-left img-fluid" style="width:30px;"/><span class="pull-left p-1" >Collections</span></a>
					<a href="{{ URL::to('/') }}/search" class="p-2 nav-item nav-link {{ (request()->is('search')) ? 'active' : '' }}"><img src="/assets/images/icon-search-new.svg" class="pull-left img-fluid" style="width:30px;"/><span class="pull-left p-1">Explore</span></a>
					<a href="{{ URL::to('/') }}/user/my_account/settings" class="p-2 nav-item nav-link {{ (request()->is('user/my_account/settings')) ? 'active' : '' }}"><img src="/assets/images/icon-settings-new.svg" class="pull-left img-fluid" style="width:30px;"/><span class="pull-left p-1">Settings</span></a>
					@if(is_file(base_path() . '/public/uploads/profile/'.Auth::guard('user')->user()->id.'/'.Auth::guard('user')->user()->profile_image_cropped))
					
						<a href="{{ URL::to('/') }}/user/my_account" class="p-2 nav-item nav-link {{ (request()->is('user/my_account')) ? 'active' : '' }}"><img src="/uploads/profile/{{ Auth::guard('user')->user()->id }}/{{ Auth::guard('user')->user()->profile_image_cropped }}" class="pull-left img-fluid" style="width:30px;" /><span class="pull-left p-1">My profile</span></a>
					@else
						<a href="{{ URL::to('/') }}/user/my_account" class="p-2 nav-item nav-link {{ (request()->is('user/my_account')) ? 'active' : '' }}"><img src="/assets/images/icon-profile 1.svg" class="pull-left img-fluid" style="width:30px;" /><span class="pull-left p-1">My profile</span></a>
					@endif
					<a href="{{ URL::to('/') }}/user/logout" class="p-2 nav-item nav-link"><span class="pull-left p-1">Log out</span></a>
					</div>
				@else

					<div class="navbar-nav ml-auto p-2 hide_navbar_inmobile">
						<!--a href="/news" class="p-2 nav-item nav-link {{ (request()->is('news')) ? 'active' : '' }}"><img src="/assets/images/Icon-news-small.svg" class="pull-left img-fluid" style="width:30px;"/><span class="pull-left p-1" >News</span></a-->
						<a href="{{ URL::to('/') }}/search" class="p-2 nav-item nav-link {{ (request()->is('search')) ? 'active' : '' }}"><img src="/assets/images/icon-search-new.svg" class="pull-left img-fluid" style="width:30px;"/><span class="pull-left p-1">Explore</span></a>
						<a href="/user/register" class="p-2 nav-item nav-link" data-toggle="modal" data-target="#signup_modal">Sign up</a>
						<a href="/user/login" class="p-2 nav-item nav-link" data-toggle="modal" data-target="#login_modal">Login</a>
					</div>
				@endif
				</div>


				@if(Auth::guard('user')->check())
				<div class="navbar-nav ml-auto show_navbar_inmobile">
					<!--a href="/news" class="nav-item nav-link m-0 p-0 pr-3 pl-3 text-center {{ (request()->is('news')) ? 'active' : '' }}"><img src="/assets/images/Icon-news-small.svg" class="pt-2 img-fluid" style="width:30px;"/><p class="m-0 p-0 pt-1" >News</p></a-->

					<a href="{{ URL::to('/') }}/messages" class="nav-item nav-link m-0 p-0 pr-3 pl-3  text-center {{ (request()->is('messages')) ? 'active' : '' }}">
					@if($not_read_messages_count > 0)
					<img src="/assets/images/Icon-message-new-message-1.svg" class="img-fluid pt-2" style="width:30px;" />
					@else
					<img src="/assets/images/Icon-message-new.svg" class="img-fluid pt-2" style="width:30px;" />
					@endif
					<p class="m-0 p-0 pt-1" >Messages</p></a>
					<a href="{{ URL::to('/') }}/user/my-collection" class="nav-item nav-link m-0 p-0 pr-3 pl-3 text-center {{ (request()->is('user/my-collection')) ? 'active' : '' }}"><img src="/assets/images/redesign-collections 5.svg" class="pt-2 img-fluid" style="width:30px;"/><p class="m-0 p-0 pt-1" >Collections</p></a>
					<a href="{{ URL::to('/') }}/search" class="nav-item nav-link m-0 p-0 pr-3 pl-3 text-center {{ (request()->is('search')) ? 'active' : '' }}"><img src="/assets/images/icon-search-new.svg" class="pt-2 img-fluid" style="width:30px;"/><p class="m-0 p-0 pt-1">Explore</p></a>
					<a href="{{ URL::to('/') }}/user/my_account/settings" class="nav-item nav-link m-0 p-0 pr-3 pl-3 text-center {{ (request()->is('user/my_account/settings')) ? 'active' : '' }}"><img src="/assets/images/icon-settings-new-small.svg" class="img-fluid pt-2" style="width:30px;"/><p class="m-0 p-0 pt-1">Settings</p></a>
					@if(is_file(base_path() . '/public/uploads/profile/'.Auth::guard('user')->user()->id.'/'.Auth::guard('user')->user()->profile_image_cropped))
					
						<a href="{{ URL::to('/') }}/user/my_account" class="nav-item nav-link m-0 p-0 pr-3 pl-3 text-center {{ (request()->is('user/my_account')) ? 'active' : '' }}"><img src="/uploads/profile/{{ Auth::guard('user')->user()->id }}/{{ Auth::guard('user')->user()->profile_image_cropped }}" class="pt-2 img-fluid" style="width:30px;" /><p class="m-0 p-0 pt-1">My profile</p></a>
					@else
						<a href="{{ URL::to('/') }}/user/my_account" class="nav-item nav-link m-0 p-0 pr-3 pl-3 text-center {{ (request()->is('user/my_account')) ? 'active' : '' }}"><img src="/assets/images/icon-profile 1.svg" class="pt-2 img-fluid" style="width:30px;" /><p class="m-0 p-0 pt-1">My profile</p></a>
					@endif
					<a href="{{ URL::to('/') }}/user/logout" class="nav-item nav-link m-0 p-0 pr-3 pl-3 pt-3 text-center"><p class="m-0 p-0 pt-2">Log out</p></a>
					</div>
				@else

					<div class="navbar-nav ml-auto p-2 show_navbar_inmobile">
						<!--a href="/news" class="p-1 nav-item nav-link {{ (request()->is('news')) ? 'active' : '' }}" style="height:auto;"><img src="/assets/images/Icon-news-small.svg" class="pull-left img-fluid" style="width:30px;"/><span class="pull-left p-1" >News</span></a-->
						<a href="{{ URL::to('/') }}/search" class="nav-item nav-link m-0 p-0 pr-3 pl-3 text-center {{ (request()->is('search')) ? 'active' : '' }}"><img src="/assets/images/icon-search-new.svg" class="pt-2 img-fluid" style="width:25px;"/><small style="font-size: 85%;"><p class="m-0 p-0 pt-1">Explore</p></small></a>
						<a href="/user/register" class="nav-item nav-link m-0 p-0 pr-3 pl-3 pt-3 text-center" data-toggle="modal" data-target="#signup_modal">Sign up</a>
						<a href="/user/login" class="nav-item nav-link m-0 p-0 pr-3 pl-3 pt-3 text-center" data-toggle="modal" data-target="#login_modal">Login</a>
					</div>
				@endif
				</div>		
			</nav>
	</header>
	<div class="container p-0 m-0">

