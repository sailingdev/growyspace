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
<li class="active">Cars</li>
</ul>
</div>
<!-- END Breadcrumb -->

<!-- BEGIN Main Content -->
<div class="row">
<div class="col-md-12">
<div class="box">
<div class="box-title">
	<h3><i class="fa fa-table"></i> Cars</h3>
	<div class="box-tool">

	</div>
</div>
<div style="max-width:500px;"  class="form-horizontal">
	<h1>Filters</h1>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">Prix</label>
		<div class="col-sm-9 col-lg-10 controls">
			<select style="width: 49%;float:left;" class="car_filter_min_price form-control">
				<option value="">Min</option>
				@for($i = $min_price; $i <= $max_price; $i = $i + 500)
					<option value="{{ $i }}">{{ $i }} €</option>
				@endfor
			</select>
			<select style="width: 49%;float:right;" class="car_filter_max_price form-control">
				<option value="">Max</option>
				@for($i = $min_price; $i <= $max_price; $i = $i + 500)
					<option value="{{ $i }}">{{ $i }} €</option>
				@endfor
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">Année-modèle</label>
		<div class="col-sm-9 col-lg-10 controls">
			<select style="width: 49%;float:left;" class="car_filter_min_year form-control">
				<option value="">Min</option>
				@for($i = $min_year; $i <= $max_year; $i = $i + 1)
					<option value="{{ $i }}">{{ $i }}</option>
				@endfor
			</select>
			<select style="width: 49%;float:right;" class="car_filter_max_year form-control">
				<option value="">Max</option>
				@for($i = $min_year; $i <= $max_year; $i = $i + 1)
					<option value="{{ $i }}">{{ $i }}</option>
				@endfor
			</select>
		
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">Carburant</label>
		<div class="col-sm-9 col-lg-10 controls">
			<select class="fuel_filter form-control">
				<option value="">Engine Type</option>
				<option value="1">Diesel</option>
				<option value="2">Essence</option>
				<option value="3">hybrid</option>
				<option value="4">Essence/gas</option>
				<option value="5">electric</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">Boîte de vitesse</label>
		<div class="col-sm-9 col-lg-10 controls">
			<select class="gearbox form-control">
				<option value="">Select a Option</option>
				<option value="1">Manuelle</option>
				<option value="2">Automatique</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">Kilométrage</label>
		<div class="col-sm-9 col-lg-10 controls">
			<select style="width: 49%;float:left;" class="car_filter_min_mileage form-control">
				<option value="">Min</option>
				@for($i = $min_mileage; $i <= $max_mileage; $i = $i + 10000)
					<option value="{{ $i }}">{{ $i }}</option>
				@endfor
			</select>
			<select style="width: 49%;float:right;" class="car_filter_max_mileage form-control">
				<option value="">Max</option>
				@for($i = $min_mileage; $i <= $max_mileage; $i = $i + 10000)
					<option value="{{ $i }}">{{ $i }}</option>
				@endfor
			</select>
		</div>
	</div>
	
	
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">Titre</label>
		<div class="col-sm-9 col-lg-10 controls">
			<input type="text" placeholder="Titre" name="title" value="" class="title_filter form-control">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label"></label>
		<div class="col-sm-9 col-lg-10 controls">
			<button class="btn btn-primary filter_cars">Filter</button>
			<button class="btn btn-danger reset_filter_cars">Reset</button>
		</div>
	</div>
	
</div>




<div class="box-content">
	
	<br/><br/>
	<div class="clearfix"></div>
	<div class="table-responsive" style="border:0">
		<p style="font-size:20px">Filtered Cars <span style="font-weight:bold;" class="cars_count">0</span></p>
		<table class="cars_table table" id="cars_table">
			<thead>
				<tr>
					<th>CID</th>
					<th>Title</th>
					<th>Price</th>
					<th>Mark</th>
					<th>Model</th>
					<th>Model Year</th>
					<th>gearbox</th>
					<th>mileage</th>
					<th>fuel</th>
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
