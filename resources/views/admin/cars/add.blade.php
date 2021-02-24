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
		<li class="active">Add Car</li>
	</ul>
</div>
<script>
	window.product_mark_model = "{{ old('model') !==null ? old('model') : '' }}";
	window.product_mark_model_motorization = "{{ old('motorization') !==null ? old('motorization') : '' }}";
	window.product_mark_model_motorization_power = "{{ old('power') !==null ? old('power') : '' }}";
</script>
<!-- END Breadcrumb -->
<div class="box-content">
	{!! Form::open(['url' => '/auto-turbo-admin/cars/' , 'method' => 'POST', 'route' => ['cars.store']]) !!}
	<div action="#" class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Titre</label>
			<div class="col-sm-9 col-lg-10 controls">
				<input type="text" placeholder="Titre" name="title" value="{{ old('title') !== null ? old('title') : '' }}" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Ajout de titre:</label>
			<div class="col-sm-9 col-lg-10 controls">
				<input type="text" placeholder="Ajout de titre" name="title2" value="{{ old('title2') !== null ? old('title2') : '' }}" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Prix</label>
			<div class="col-sm-9 col-lg-10 controls">
				<input type="text" placeholder="Prix" name="price" value="{{ old('price') !== null ? old('price') : '' }}" class="float_only form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Marque</label>
			<div class="col-sm-9 col-lg-10 controls">
				<select name="mark" dependence="mark" class="dynamic_mark_model_motorization_power form-control">
					<option value="">Select a Marque</option>
					@foreach($marks as $mark)
						<option {{ old('mark') !== null && old('mark') == $mark->id ? 'selected' : '' }} value="{{ $mark->id }}">{{ $mark->name }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Modèle</label>
			<div class="col-sm-9 col-lg-10 controls">
				<select name="model" dependence="model" class="dynamic_mark_model_motorization_power form-control">
					<option value="">Select a Modèle</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Motorisation </label>
			<div class="col-sm-9 col-lg-10 controls">
				<select name="motorization" dependence="motorization" class="dynamic_mark_model_motorization_power form-control">
					<option value="">Sélectionnez une matorisation</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Power</label>
			<div class="col-sm-9 col-lg-10 controls">
				<select name="power" dependence="power" class="dynamic_mark_model_motorization_power form-control">
					<option value="">Select a Power</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Nombre de place(s) </label>
			<div class="col-sm-9 col-lg-10 controls">
				<select name="number_of_places"  class="form-control">
					<option value="">Sélectionnez une option</option>
					@for($i = 1;$i <=8;$i++)
						<option {{ old('number_of_places') !== '' && old('number_of_places') == $i ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
					@endfor
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Boîte de vitesse</label>
			<div class="col-sm-9 col-lg-10 controls">
				<select name="gearbox" class="form-control">
					<option value="">Select a Option</option>
					<option {{ old('gearbox') !== null && old('gearbox') == 1 ? 'selected' : '' }} value="1">Manuelle</option>
					<option {{ old('gearbox') !== null && old('gearbox') == 2 ? 'selected' : '' }} value="2">Automatique</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Année-modèle</label>
			<div class="col-sm-9 col-lg-10 controls">
				<input type="text" placeholder="Année-modèle" name="model_year" value="{{ old('model_year') !== null ? old('model_year') : '' }}" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Carburant</label>
			<div class="col-sm-9 col-lg-10 controls">
				<select name="fuel" class="form-control">
					<option value="">Engine Type</option>
					<option {{ old('fuel') !== null && old('fuel') == 1 ? 'selected' : '' }} value="1">Diesel</option>
					<option {{ old('fuel') !== null && old('fuel') == 2 ? 'selected' : '' }} value="2">petrol</option>
					<option {{ old('fuel') !== null && old('fuel') == 3 ? 'selected' : '' }} value="3">hybrid</option>
					<option {{ old('fuel') !== null && old('fuel') == 4 ? 'selected' : '' }} value="4">petrol/gas</option>
					<option {{ old('fuel') !== null && old('fuel') == 5 ? 'selected' : '' }} value="5">electric</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Kilométrage</label>
			<div class="col-sm-9 col-lg-10 controls">
				<input type="text" placeholder="Kilométrage" name="mileage" value="{{ old('mileage') !== null ? old('mileage') : '' }}" class="float_only form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Description</label>
			<div class="col-sm-9 col-lg-10 controls">
				<textarea class="form-control" id="description" name="description">{{ old('description') !== null ? old('description') : '' }}</textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label"></label>
			<div class="col-sm-9 col-lg-10 controls">
				<button type="submit" class="btn btn-primary">Create Car</button>
			</div>
		</div>
		<script src="//cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
		<script>
			CKEDITOR.replace( 'description', {
				//filebrowserUploadUrl: "{{route('products_image_upload', ['_token' => csrf_token() ])}}",
				filebrowserUploadMethod: 'form'
			});
		</script>
	</div>
	{!! Form::close() !!}
</div>

@endsection
