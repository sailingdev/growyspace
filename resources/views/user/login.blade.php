@extends('layouts.front')
@section('content')

<style>
	.container {
		background: white;
	}
	.row {
		background: white;
		border-radius: 10px;
		box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
	}
	#buttonLogin {
		background: #332960;
		border: none;
	}
</style>
<!-- Content -->
<div style="background:#E1E3DD;" class="space_lab_main_content page-content bg-white">
  	<!-- Breadcrumb row -->
	<div style="background:#E1E3DD;" class="breadcrumb-row">
		<div style="background:#E1E3DD;" class="container">
			<!-- <ul class="list-inline">
				<li><a href="{{ URL::to('/') }}">Home</a></li>
				<li class="active">Login</li>
			</ul> -->
		</div>
	</div>
	<!-- Breadcrumb row END -->
	<div style="min-height:500px;overflow:hidden;height:500px;" class="page-content bg-white">
		<!-- contact area -->
		<div style="background:#E1E3DD;height:500px;" class="section-full content-inner">
			<!-- Product -->
			<div style="background:#E1E3DD;" class="container">	
				<div class="shop-form">
					<div class="row">
						<div class="col-md-12 col-lg-12 m-b30">
							{!! Form::open(['url' => '/user/loggin', 'method' => 'POST']) !!}
								@if(session('registration_success')) 
									<div class="alert alert-success" role="alert">
										{{ session('registration_success') }}
									</div>
								@endif
								@if(count($errors->get('wrong_login_details')) > 0)
									<p class="inline_error">{{ $errors->first('wrong_login_details')}}</p>
								@endif

															
								<h2 style="color:#332960;margin-top:10px;">Log in</h2>
								
								<div class="form-group">
									<label class="turbo_form_label">Email <span class="red">*</span></label>
									<input type="text" class="form-control" name="email" placeholder="Email" value="">
									@if(count($errors->get('email')) > 0)
										<p class="inline_error">{{ $errors->first('email')}}</p>
									@endif
								</div>
								<div class="form-group">
									<label class="turbo_form_label">Password <span class="red">*</span></label>
									<input type="password" class="form-control" name="password" placeholder="Password" value="">
									@if(count($errors->get('password')) > 0)
										<p class="inline_error">{{ $errors->first('password')}}</p>
									@endif
								</div>
								
								<div class="form-group">
									<input type="hidden" name="from_page" value="login" />
									<button id="buttonLogin" type="submit" class="btn btn-primary">Login</button>
									<a style="color=#332960" class="forgot_password_btn">Forgot password ?</a>
								</div>
							{!! Form::close() !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@include('forgot_password')
@endsection