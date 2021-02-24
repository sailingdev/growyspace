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
<li class="active">Pneus</li>
</ul>
</div>
<!-- END Breadcrumb -->

<!-- BEGIN Main Content -->
<div class="row">
<div class="col-md-12">
<div class="box">
<div class="box-title">
	<h3><i class="fa fa-table"></i> Pneus</h3>
	<div class="box-tool">

	</div>
</div>
<div style="max-width:500px;" action="#" class="form-horizontal">
	<h1>Filters</h1>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">Type de pneu</label>
		<div class="col-sm-9 col-lg-10 controls">
			<select name="type" class="form-control">
				<option value="">Sélectionnez une option</option>
				@foreach($tire_types as $k => $v )
					<option 
						@if(old('type') !== null && old('type') == $k)
							selected
						@endif
					value="{{ $k }}">{{ $v }}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">Marque</label>
		<div class="col-sm-9 col-lg-10 controls">
			<select name="tire_mark" class="form-control">
				<option value="">Sélectionnez une option</option>
				@foreach($tires_marks as $mark_cat => $tm)
					<optgroup label="{{ $mark_cat }}">
						@foreach($tm as $k => $v)
							<option 
							@if(old('tire_mark') !== null && old('tire_mark') == $v['id'])
								selected
							@endif
							value="{{ $v['id'] }}">{{ $v['name'] }}</option>
						@endforeach
					</optgroup>
				@endforeach
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">Largeur</label>
		<div class="col-sm-9 col-lg-10 controls">
			<select name="tire_width" class="form-control">
				<option value="">Sélectionnez une option</option>
				@foreach($tire_mark_widths as $mark_width_cat => $tmw)
					<optgroup label="{{ $mark_width_cat }}">
						@foreach($tmw as $k => $v)
							<option 
							@if(old('tire_width') !== null && old('tire_width') == $v['id'])
								selected
							@endif
							value="{{ $v['id'] }}">{{ $v['name'] }}</option>
						@endforeach
					</optgroup>
				@endforeach
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">Hauteur</label>
		<div class="col-sm-9 col-lg-10 controls">
			<select name="tire_height" class="form-control">
				<option value="">Sélectionnez une option</option>
				@foreach($tire_mark_width_heights as $mwh)
					<option 
						@if(old('tire_height') !== null && old('tire_height') == $mwh->id)
							selected
						@endif
					
					value="{{ $mwh->id }}">{{ $mwh->name }}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">Diamètre</label>
		<div class="col-sm-9 col-lg-10 controls">
			<select name="tire_diameter" class="form-control">
				<option value="">Sélectionnez une option</option>
				@foreach($tire_mark_width_height_diameters as $mwhd)
					<option 
						@if(old('tire_diameter') !== null && old('tire_diameter') == $mwhd->id)
							selected
						@endif
					value="{{ $mwhd->id }}">{{ $mwhd->name }}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">Charge</label>
		<div class="col-sm-9 col-lg-10 controls">
			<select name="tire_charge" class="form-control">
				<option value="">Sélectionnez une option</option>
				@foreach($tire_mark_width_height_diameter_charges as $mwhdc)
					<option 
						@if(old('tire_charge') !== null && old('tire_charge') == $mwhdc->id)
							selected
						@endif
					value="{{ $mwhdc->id }}">{{ $mwhdc->name }}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">Vitesse</label>
		<div class="col-sm-9 col-lg-10 controls">
			<select name="tire_speed" class="form-control">
				<option value="">Sélectionnez une option</option>
				@foreach($tire_mark_width_height_diameter_charge_speedes as $mwhdcs)
					<option 
						@if(old('tire_speed') !== null && old('tire_speed') == $mwhdcs->id)
							selected
						@endif
					
					value="{{ $mwhdcs->id }}">{{ $mwhdcs->name }}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label"></label>
		<div class="col-sm-9 col-lg-10 controls">
			<button class="btn btn-primary filter_tires">Filter</button>
			<button class="btn btn-danger reset_filter_tires">Reset</button>
			
		</div>
	</div>
</div>




<div class="box-content">
	
	<br/><br/>
	<div class="clearfix"></div>
	<div class="table-responsive" style="border:0">
		<p style="font-size:20px">Filtered Tires <span style="font-weight:bold;" class="tires_count">0</span></p>
		<table class="tires_table table" id="tires_table">
			<thead>
				<tr>
					
					<th>ID</th>
					<th>Title</th>
					<th>Type de pneu</th>
					<th>Marque</th>
					<th>Largeur</th>
					<th>Hauteur</th>
					<th>Diamètre</th>
					<th>Charge</th>
					<th>Vitesse</th>
					<th>Saison</th>
					<th>Runflat</th>
					<th>Renforcé</th>
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
