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
<li class="active">Marks</li>
</ul>
</div>
<!-- END Breadcrumb -->

<!-- BEGIN Main Content -->
<div class="row">
<div class="col-md-12">
<div class="box">
<div class="box-title">
	<h3><i class="fa fa-table"></i> Marks</h3>
	<div class="box-tool">

	</div>
</div>

<div class="box-content">
	
	<br/><br/>
	<div class="clearfix"></div>
	<div class="table-responsive" style="border:0">
		<table class="marks_table table" id="marks_table">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($marks as $mark)
					<tr>
						<td>{{ $mark->id }}</td>
						<td>{{ $mark->name }}</td>
						<td>
							<a class="btn btn-primary" href="{{ URL::to('/auto-turbo-admin/marks/'.$mark->id.'/edit') }}">Edit</a>
							<form action="{{ URL::to('/auto-turbo-admin/marks/'.$mark->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
								<input type="hidden" name="_method" value="DELETE">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Delete </button>
							</form>
						
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
</div>
</div>
</div>
<!-- END Main Content -->

@endsection
