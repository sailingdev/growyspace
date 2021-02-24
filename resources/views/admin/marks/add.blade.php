@extends('layouts.admin')
@section('content')
	<!-- BEGIN Breadcrumb -->
<div id="breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="fa fa-home"></i>
			<a href="{{ URL::to('/auto-turbo-admin/dashboard/') }}">Home</a>
			<span class="divider"><i class="fa fa-angle-right"></i></span>
		</li>
		<li class="active">Add Mark</li>
	</ul>
</div>

<!-- END Breadcrumb -->
<div class="box-content">
	{!! Form::open(['url' => '/auto-turbo-admin/marks/' , 'method' => 'POST', 'route' => ['marks.store']]) !!}
	<div action="#" class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Name</label>
			<div class="col-sm-9 col-lg-10 controls">
				<input type="text" placeholder="Mark Name" name="name" value="{{ old('name') !== null ? old('name') : '' }}" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label"></label>
			<div class="col-sm-9 col-lg-10 controls">
				<button class="btn btn-primary">Submit</button>
			</div>
		</div>
	</div>
	{!! Form::close() !!}
</div>

@endsection
