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
<li class="active">Professional cards</li>
</ul>
</div>
<!-- END Breadcrumb -->

<!-- BEGIN Main Content -->
<div class="row">
<div class="col-md-12">
<div class="box">
<div class="box-title">
	<h3><i class="fa fa-table"></i> Professional cards</h3>
	<div class="box-tool">

	</div>
</div>

<div class="box-content">
	
	<br/><br/>
	<div class="clearfix"></div>
	<div class="table-responsive" style="border:0">
		<table class="opentowork_cards table" id="opentowork_cards">
			<thead>
				<tr>
					
					<th>ID</th>
					<th>Owner Name</th>
					<th>Title</th>
					<th>Email</th>
					<th>Roles</th>
					<!-- <th>Hours</th> -->
					<th>Country</th>
					<th>City</th>
					<th>Description</th>
					
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				
			</tbody>
		</table>
	</div>
</div>
</div>
</div>
</div>
<!-- END Main Content -->
<style>
    .chip-custom{
        background: #332960;
        border-radius: 6px;
        height: 40px;
        font-weight: 500;
        font-size: 13px;
        line-height: 18px;
        display: flex;
        align-items: center;
        text-align: center;
        letter-spacing: -0.015em;
        color: #FFFFFF;
        padding:10px;
	}
	.pb-2{
		padding-bottom:1rem;
	}
</style>
@endsection
