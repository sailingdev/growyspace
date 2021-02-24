@extends('layouts.admin')
@section('content')
	<!-- BEGIN Breadcrumb -->
<div id="breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="fa fa-home"></i>
			<a href="{{ URL::to('/growyspace-admin/dashboard/') }}">Home</a>
			<span class="divider"><i class="fa fa-angle-right"></i></span>
		</li>
		<li>
			
			<a href="{{ URL::to('/growyspace-admin/pages/') }}">Pages</a>
			<span class="divider"><i class="fa fa-angle-right"></i></span>
		</li>
		<li>
			
			{{ $page->title }}
			<span class="divider"><i class="fa fa-angle-right"></i></span>
		</li>
		<li class="active">Edit</li>
	</ul>
</div>

<!-- END Breadcrumb -->
<div class="box-content">
	{!! Form::open(['url' => '/growyspace-admin/pages/'.$page->id , 'method' => 'PUT', 'route' => ['pages.update']]) !!}
	<div class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Title</label>
			<div class="col-sm-9 col-lg-10 controls">
				<input type="text" placeholder="Product Title" name="title" value="{{ old('title') !== null ? old('title') : $page->title }}" class="form-control">
			</div>
		</div>
		@if($page->id == 4)
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Description2</label>
			<div class="col-sm-9 col-lg-10 controls">
				<textarea class="form-control" id="description2" name="description2">{{ old('description2') !== null ? old('description2') : $page->text2 }}</textarea>
			</div>
		</div>
		@endif
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Description</label>
			<div class="col-sm-9 col-lg-10 controls">
				<textarea class="form-control" id="description" name="description">{{ old('description') !== null ? old('description') : $page->text }}</textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label"></label>
			<div class="col-sm-9 col-lg-10 controls">
				<button type="submit" class="btn btn-primary">Update Page</button>
			</div>
		</div>
		<script src="//cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
		<script>
			CKEDITOR.replace( 'description', {
				//filebrowserUploadUrl: "",
				filebrowserUploadMethod: 'form'
			});
		</script>
		<script>
			CKEDITOR.replace( 'description2', {
				//filebrowserUploadUrl: "",
				filebrowserUploadMethod: 'form'
			});
		</script>
		
		
	</div>
	{!! Form::close() !!}
</div>

@endsection
