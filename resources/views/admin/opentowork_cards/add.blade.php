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
		<li class="active">Add Product</li>
	</ul>
</div>
<script>
	window.product_mark_model = "{{ old('model') !==null ? old('model') : '' }}";
	window.product_mark_model_motorization = "{{ old('motorization') !==null ? old('motorization') : '' }}";
	window.product_mark_model_motorization_power = "{{ old('power') !==null ? old('power') : '' }}";

</script>
<!-- END Breadcrumb -->
<div class="box-content">
	{!! Form::open(['url' => '/auto-turbo-admin/products/' , 'method' => 'POST', 'route' => ['products.store']]) !!}
	<div action="#" class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Title</label>
			<div class="col-sm-9 col-lg-10 controls">
				<input type="text" placeholder="Product Title" name="title" value="{{ old('title') !== null ? old('title') : '' }}" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Title2</label>
			<div class="col-sm-9 col-lg-10 controls">
				<input type="text" placeholder="Product Title2" name="title2" value="{{ old('title2') !== null ? old('title2') : '' }}" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Group</label>
			<div class="col-sm-9 col-lg-10 controls">
				<select name="group" class="form-control">
					<option value="">Select a Group</option>
					@foreach($prod_groups as $group)
						<option {{ old('group') !== null && old('group') == $group->id ? 'selected' : '' }} value="{{ $group->id }}">{{ $group->name }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Category</label>
			<div class="col-sm-9 col-lg-10 controls">
				<select name="category" class="form-control">
					<option value="">Select a category</option>
					@foreach($categories as $cat)
						<option {{ old('category') !== null && old('category') == $cat->id ? 'selected' : '' }} value="{{ $cat->id }}">{{ $cat->name }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Mark</label>
			<div class="col-sm-9 col-lg-10 controls">
				<select name="mark" dependence="mark" class="dynamic_mark_model_motorization_power form-control">
					<option value="">Select a Mark</option>
					@foreach($marks as $mark)
						<option {{ old('mark') !== null && old('mark') == $mark->id ? 'selected' : '' }} value="{{ $mark->id }}">{{ $mark->name }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Model</label>
			<div class="col-sm-9 col-lg-10 controls">
				<select name="model" dependence="model" class="dynamic_mark_model_motorization_power form-control">
					<option value="">Select a Model</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Matorization</label>
			<div class="col-sm-9 col-lg-10 controls">
				<select name="motorization" dependence="motorization" class="dynamic_mark_model_motorization_power form-control">
					<option value="">Select a Matorization</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Power</label>
			<div class="col-sm-9 col-lg-10 controls">
				<select name="power" dependence="power" class="dynamic_mark_model_motorization_power form-control">
					<option value="">Select a Power</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Description</label>
			<div class="col-sm-9 col-lg-10 controls">
				<textarea class="form-control" id="description" name="description">{{ old('description') !== null ? old('description') : '' }}</textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label"></label>
			<div class="col-sm-9 col-lg-10 controls">
				<button type="submit" class="btn btn-primary">Create Product</button>
			</div>
		</div>
		<script src="//cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
		<script>
			CKEDITOR.replace( 'description', {
				//filebrowserUploadUrl: "{{route('products_image_upload', ['_token' => csrf_token() ])}}",
				filebrowserUploadMethod: 'form'
			});
		</script>
		
		
		
	</div>
	{!! Form::close() !!}
</div>

@endsection
