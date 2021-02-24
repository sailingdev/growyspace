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
<li class="active">Orders</li>
</ul>
</div>
<!-- END Breadcrumb -->

<!-- BEGIN Main Content -->
<div class="row">
<div class="col-md-12">
<div class="box">
<div class="box-title">
	<h3><i class="fa fa-table"></i> Orders</h3>
	<div class="box-tool">

	</div>
</div>
<div style="max-width:500px;display:none;" action="#" class="form-horizontal">
	<h1>Filters</h1>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">Some filter here</label>
		<div class="col-sm-9 col-lg-10 controls">
			<select name="group" class="form-control">
				<option value="">Select a Group</option>
				
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label"></label>
		<div class="col-sm-9 col-lg-10 controls">
			<button class="btn btn-primary filter_orders">Filter</button>
		</div>
	</div>
</div>

<div class="box-content">
	
	<br/><br/>
	<div class="clearfix"></div>
	<div class="table-responsive" style="border:0">
		<p style="font-size:20px">Filtered Orders <span style="font-weight:bold;" class="orders_count">0</span></p>
		<p style="font-size:20px">Not Finished Orders <span style="font-weight:bold;color:red;" class="">{{ $not_finished_orders_count }}</span></p>
		<table class="orders_table table" id="orders_table">
			<thead>
				<tr>
					<th>Order ID</th>
					<th>Client Name</th>
					<th>Transaction ID</th>
					<th>Shipping</th>
					<th>Shipping Price</th>
					<th>Subtotal</th>
					<th>Total Price</th>
					<th>Status</th>
					<th>Facture ID</th>
					<th>Order Date</th>
					<th>Payment Type</th>
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

@endsection
