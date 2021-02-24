@extends('layouts.front')
@section('content')
<!-- Content -->
	
	<!-- Breadcrumb row END -->
<div class="space_lab_main_content page-content bg-white">
	<div class="breadcrumb-row">
		<div class="container">
			<ul class="list-inline">
				<li><a href="{{ URL::to('/') }}">Home</a></li>
				<li class="active">Recover password</li>
			</ul>
		</div>
	</div>
    <!-- contact area -->
	<div class="section-full content-inner">
		<!-- Product -->
		<div class="container">	
	
	
	<div class="shop-form">
		<div class="row">
			<div class="col-md-12 col-lg-6 m-b30">
				{!! Form::open(['url' => '/user/recover_password_post/'.$token, 'method' => 'POST']) !!}
					
					<div class="form-group {{ ((count($errors->get('password')) > 0) ? 'has-error' : '') }}">
						<label class="turbo_form_label">New password <span class="red">*</span></label>
						<input type="password" autocomplete="off" name="password" class="form-control" placeholder="New password" value="">
					</div>
					<div class="form-group {{ ((count($errors->get('password_confirmation')) > 0) ? 'has-error' : '') }}">
						<label class="turbo_form_label">Verify Password <span class="red">*</span></label>
						<input type="password" autocomplete="off" class="form-control" name="password_confirmation" placeholder="Verify Password" value="">
					</div>
					
					<div class="form-group">
						<input type="hidden" name="from_page" value="login" />
						<button type="submit" class="btn btn-primary">Recover Password</button>
				
					</div>
				{!! Form::close() !!}
			</div>
			
		</div>
	</div>
	</div>
	</div>
	</div>
	

@include('forgot_password')	
@endsection