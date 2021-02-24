@extends('layouts.front')
@section('content')
<!-- Content -->
<div class="space_lab_main_content page-content bg-white">
  
	<!-- Breadcrumb row -->
	<div class="breadcrumb-row">
		<div class="container">
			<ul class="list-inline">
				<li><a href="{{ URL::to('/') }}">Home</a></li>
				<li><a href="{{ URL::to('/') }}/user/my_account">My Account</a></li>
				<li>Change Password</li>
			</ul>
		</div>
	</div>
	<!-- Breadcrumb row END -->
<div class="page-content bg-white">
    <!-- contact area -->
	<div class="section-full content-inner">
		<!-- Product -->
		<div class="container">	
	
	
	<div class="shop-form">
		<div class="row">
			<div class="col-md-6 col-lg-6 m-b30">
				{!! Form::open(['url' => '/user/change_password', 'method' => 'POST']) !!}
					<h2>Change your account password</h2>
					<br/>
					 					
					@if(count($errors->get('current_password')) > 0)
						<div class="alert alert-danger">
                            {{ $errors->first('current_password') }}
                        </div>
					@endif
					@if(count($errors->get('new_password')) > 0)
						<div class="alert alert-danger">
                            {{ $errors->first('new_password') }}
                        </div>
					@endif
					
					
					@if (session('success'))
						<div class="alert alert-success">
							{{ session('success') }}
						</div>
					@endif
					<div class="form-group">
						<label class="turbo_form_label">Current Password <span class="red">*</span></label>
						<input type="password" class="form-control" name="current_password" placeholder="Current Password" value="">
					</div>
					<div class="form-group">
						<label class="turbo_form_label">New Password <span class="red">*</span></label>
						<input type="password" class="form-control" name="new_password" placeholder="New Password" value="">
					</div>
					<div class="form-group">
						<label class="turbo_form_label">Repeat Password <span class="red">*</span></label>
						<input type="password" class="form-control" name="new_password_confirmation" placeholder="Repeat Password" value="">
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary">Change Password</button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
	</div>
	</div>
	</div>
	
	
	
	
</div>	
@endsection