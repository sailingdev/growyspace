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
		<li>
			
			<a href="{{ URL::to('/auto-turbo-admin/marks/') }}">Marks</a>
			<span class="divider"><i class="fa fa-angle-right"></i></span>
		</li>
		<li>
			
			{{ $mark->name }}
			<span class="divider"><i class="fa fa-angle-right"></i></span>
		</li>
		<li class="active">Edit</li>
	</ul>
</div>
<!-- END Breadcrumb -->
<div class="box-content">
	{!! Form::open(['url' => '/auto-turbo-admin/marks/'.$mark->id , 'method' => 'PUT', 'route' => ['marks.update']]) !!}
	<div class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Mark</label>
			<div class="col-sm-9 col-lg-10 controls">
				<input type="text" placeholder="Mark Name" name="name" value="{{ old('name') !== null ? old('name') : $mark->name }}" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label"></label>
			<div class="col-sm-9 col-lg-10 controls">
				<button type="submit" class="btn btn-primary">Update Mark</button>
			</div>
		</div>
		
	</div>
	{!! Form::close() !!}
</div>
<div class="row">
	<div class="col-md-12">
		<div class="box box-green">
			<div class="box-title">
				<h3><i class="fa fa-table"></i> {{ $mark->name }}'s Models</h3>
				<div class="box-tool">
					<button mark_id = "{{ $mark->id }}" class="btn btn-primary add_new_model_btn btn-sm">Add New Model</button>
				</div>
			</div>
			<div class="box-content">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Model Name</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($mark->models as $model)
						<tr>
							<td>{{ $model->name }}</td>
							<td>
								<button mark_id="{{ $mark->id }}" model_id="{{ $model->id }}" model_name="{{ $model->name }}" class="btn btn-primary btn-sm edit_mark_model_btn ">Edit</button>
								<button mark_id="{{ $mark->id }}" model_id="{{ $model->id }}" class="btn btn-primary btn-sm manage_mark_model_tree_btn">Manage Model tree</button>
								<button mark_id="{{ $mark->id }}" model_id="{{ $model->id }}" class="btn btn-danger btn-sm">Manage Model tree</button>
								
							</td>
							
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@include('admin.popups.add_edit_mark_model')
@include('admin.popups.manage_mark_model_tree')
@endsection
