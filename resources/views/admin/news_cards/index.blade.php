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
<li class="active">News cards</li>
</ul>
</div>
<!-- END Breadcrumb -->

<!-- BEGIN Main Content -->
<div class="row">
<div class="col-md-12">
<div class="box">
<div class="box-title">
	<h3><i class="fa fa-table"></i> News cards</h3>
	<div class="box-tool">

	</div>
</div>

<div class="box-content">
<a href="/growyspace-admin/news/create" class="btn btn-primary">Add news</a>
	<br/><br/>
	<div class="clearfix"></div>
	<div class="table-responsive" style="border:0">
		
		<table class=" table" >
			<thead>
				<tr>
					<th class="col-md-1">ID</th>
					<th class="col-md-8 text-center">Title</th>					
					<th class="col-md-3 text-center">Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($news as $item)
					<tr>
						<td>{{ $item->id }}</td>
						<td class="text-center">{{ $item->title }}</td>
						
						<td class="text-center">

							<form action="{{ URL::to('/growyspace-admin/news/'.$item->id) }}/edit" method="GET" style="display: inline-block;">
								<button type="submit" class="btn btn-primary btn-sm">Edit </button>
							</form>							
							
							<form action="{{ URL::to('/growyspace-admin/news/'.$item->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
								<input type="hidden" name="_method" value="DELETE">
								<input type="hidden" name="_token" value="{{  csrf_token() }}">
								<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Delete  </button>
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
