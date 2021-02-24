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
<li class="active">Pages</li>
</ul>
</div>
<!-- END Breadcrumb -->

<!-- BEGIN Main Content -->
<div class="row">
<div class="col-md-12">
<div class="box">
<div class="box-title">
	<h3><i class="fa fa-table"></i> Pages</h3>
	<div class="box-tool">

	</div>
</div>

<div class="box-content">
	
	<br/><br/>
	<div class="clearfix"></div>
	<div class="table-responsive" style="border:0">
		
		<table class="pages_table table" id="pages_table">
			<thead>
				<tr>
					
					<th>ID</th>
					<th>Title</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($pages as $page)
					<tr>
					
						<td>{{ $page->id }}</td>
						<td>{{ $page->title }}</td>
						<td>
							<a class="btn btn-primary" href="{{ URL::to('/growyspace-admin/pages/') }}/{{ $page->id }}/edit"><i class="fa fa-edit"></i> Edit</a>
							
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
