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
				<li>Change Account Info</li>
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
					@if (session('success'))
						<div class="alert alert-success">
							{{ session('success') }}
						</div>
					@endif
				{!! Form::open(['url' => '/user/change_contact_info', 'method' => 'POST']) !!}
					<div class="form-group {{ ((count($errors->get('full_name')) > 0) ? 'has-error' : '') }}">
						<label class="">Full Name <span class="red">*</span></label>
						<input type="text" autocomplete="off" class="form-control" name="full_name" placeholder="Full Name" value="{{ old('full_name') !== null ? old('full_name') : $user->full_name }}">
						@if(count($errors->get('full_name')) > 0)
							<p class="inline_error">{{ $errors->first('full_name')}}</p>
						@endif
					</div>
					<div class="form-group {{ ((count($errors->get('email')) > 0) ? 'has-error' : '') }}">
						<label class="">Email <span class="red">*</span></label>
						<input type="text" autocomplete="off" name="email" class="form-control" placeholder="Email" value="{{ old('email') !== null ? old('email') : $user->email }}">
						@if(count($errors->get('email')) > 0)
							<p class="inline_error">{{ $errors->first('email')}}</p>
						@endif
					</div>
										
					<div class="form-group">
						<button type="submit" class="btn btn-primary">Update Account Info</button>
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