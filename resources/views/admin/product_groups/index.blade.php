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
<li class="active">Product Groups</li>
</ul>
</div>
<!-- END Breadcrumb -->

<!-- BEGIN Main Content -->
<div class="row">
<div class="col-md-12">
<div class="box">
<div class="box-title">
<h3><i class="fa fa-table"></i> Product Groups</h3>
<div class="box-tool">

</div>
</div>
<div style="max-width:500px;" action="#" class="form-horizontal">
	<h1>Filters</h1>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">Item Name</label>
		<div class="col-sm-9 col-lg-10 controls">
			<input type="text" class="form-control item_name" value="" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">Has Image</label>
		<div class="col-sm-9 col-lg-10 controls">
			<select class="form-control has_image">
				<option value="">Select a Option</option>
				<option value="Yes">Yes</option>
				<option value="No">No</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label"></label>
		<div class="col-sm-9 col-lg-10 controls">
			<button class="btn btn-primary filter_product_groups">Filter</button>
			<button class="btn btn-danger reset_filter_product_groups">Reset</button>
		</div>
	</div>
</div>
<div class="box-content">
	
	<br/><br/>
	<div class="clearfix"></div>
	<div class="table-responsive" style="border:0">
		<p style="font-size:20px">Filtered Groups <span style="font-weight:bold;" class="grouos_count">0</span></p>
		<table class="product_groups_table table" id="product_groups_table">
			<thead>
				<tr>
					
					<th style="width:1%;">Group Id</th>
					<th style="width:10%;">Name</th>
					<th>Items</th>
					<th>Has Image</th>
					<th>Price</th>
					<th>Exchange price</th>
					<th>Rank</th>
					<th style="width:10%;">Actions</th>
					
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
@include('admin.popups.manage_product_group')
@endsection
