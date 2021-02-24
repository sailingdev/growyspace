@extends('layouts.front')
@section('content')

<style>
#registerform {
	background:white;
	border-radius:10px;
	box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
}
#buttonSignup {
	background: #332960;
	border: none;
}
</style>
<!-- Content -->
<div style="background:#E1E3DD;" class="space_lab_main_content page-content bg-white">
  	<!-- Breadcrumb row -->
	<div style="background:#E1E3DD;" class="breadcrumb-row">
		<div class="container">
			<!-- <ul class="list-inline">
				<li><a href="{{ URL::to('/') }}">Home</a></li>
				<li>Registration</li>
			</ul> -->
		</div>
	</div>
	<!-- Breadcrumb row END -->
	<div class="page-content bg-white">
		<!-- contact area -->
		<div style="background:#E1E3DD;min-height:750px" class="section-full content-inner">
			<!-- Product -->
			
			<div id="registerform" class="container">	
				<div class="shop-form">
					<div class="row">
				
						<div class="col-md-12 col-lg-12 m-b30">
						<h2 style="color:#332960;margin-top:10px;">Register</h2>
						
							{!! Form::open(['url' => '/user/registration', 'method' => 'POST']) !!}
								
								<div class="form-group {{ ((count($errors->get('full_name')) > 0) ? 'has-error' : '') }}">
									<label class="">Full Name <span class="red">*</span></label>
									<input type="text" autocomplete="off" class="form-control" name="full_name" placeholder="Full Name" value="{{ old('full_name') !== null ? old('full_name') : '' }}">
									@if(count($errors->get('full_name')) > 0)
										<p class="inline_error">{{ $errors->first('full_name')}}</p>
									@endif
								</div>
								<div class="form-group {{ ((count($errors->get('email')) > 0) ? 'has-error' : '') }}">
									<label class="">Email <span class="red">*</span></label>
									<input type="text" autocomplete="off" name="email" class="form-control" placeholder="Email" value="{{ old('email') !== null ? old('email') : '' }}">
									@if(count($errors->get('email')) > 0)
										<p class="inline_error">{{ $errors->first('email')}}</p>
									@endif
								</div>
								<div class="form-group {{ ((count($errors->get('profession')) > 0) ? 'has-error' : '') }}">
									<label class="">Profession <span class="red">*</span></label>
									<input type="text" autocomplete="off" name="profession" class="form-control" placeholder="Profession" value="{{ old('profession') !== null ? old('profession') : '' }}">
									@if(count($errors->get('profession')) > 0)
										<p class="inline_error">{{ $errors->first('profession')}}</p>
									@endif
								</div>
								<br/>
								<h3>Location</h3>
								<div class="row">
									<div class="form-group col-lg-6 col-md-6 col-sm-6 {{ ((count($errors->get('country_code')) > 0) ? 'has-error' : '') }}">
										<label class="turbo_form_label">Country <span class="red">*</span></label>
										<select class="form-control" name="country_code">
											<option value="">Select a Country</option>
											@foreach($countries as $country_code => $coutry_name)
												<option 
													@if(old('country_code') !==null && old('country_code') == $country_code)
														selected
													@endif
												value="{{ $country_code }}">{{ $coutry_name }}</option>
											@endforeach
										</select>	
									</div>
									<div class="form-group col-lg-6 col-md-6 col-sm-6 {{ ((count($errors->get('city')) > 0) ? 'has-error' : '') }}">
										<label class="turbo_form_label">City <span class="red">*</span></label>
										<input type="text" autocomplete="off" class="form-control" name="city" placeholder="City" value="{{ old('city') !== null ? old('city') : '' }}">
									</div>
								</div>
								<div class="form-group {{ ((count($errors->get('password')) > 0) ? 'has-error' : '') }}">
									<label class="">Password <span class="red">*</span></label>
									<input type="password" autocomplete="off" name="password" class="form-control" placeholder="Password" value="">
									@if(count($errors->get('password')) > 0)
										<p class="inline_error">{{ $errors->first('password')}}</p>
									@endif
								</div>
								<div class="form-group {{ ((count($errors->get('password_confirmation')) > 0) ? 'has-error' : '') }}">
									<label class="">Confirm password <span class="red">*</span></label>
									<input type="password" autocomplete="off" class="form-control" name="password_confirmation" placeholder="Confirm password" value="">
									@if(count($errors->get('password_confirmation')) > 0)
										<p class="inline_error">{{ $errors->first('password_confirmation')}}</p>
									@endif
								</div>
								<div class="form-group">
									<button id="buttonSignup" type="submit" class="btn btn-primary">Sign Up</button>
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