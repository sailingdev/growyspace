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
		<li class="active">Ajouter un pneu</li>
	</ul>
</div>
<script>
	window.product_mark_model = "{{ old('model') !==null ? old('model') : '' }}";
	window.product_mark_model_motorization = "{{ old('motorization') !==null ? old('motorization') : '' }}";
	window.product_mark_model_motorization_power = "{{ old('power') !==null ? old('power') : '' }}";

</script>
<!-- END Breadcrumb -->
<div class="box-content">
	{!! Form::open(['url' => '/auto-turbo-admin/tires/' , 'method' => 'POST', 'route' => ['tires.store']]) !!}
	<div action="#" class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Title</label>
			<div class="col-sm-9 col-lg-10 controls">
				<input type="text" placeholder="Product Title" name="title" value="{{ old('title') !== null ? old('title') : '' }}" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Prix</label>
			<div class="col-sm-9 col-lg-10 controls">
				<input type="text" placeholder="Prix" name="price" value="{{ old('price') !== null ? old('price') : '' }}" class="float_only form-control">
			</div>
		</div>
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
			<label class="col-sm-3 col-lg-2 control-label">Saison</label>
			<div class="col-sm-9 col-lg-10 controls">
				<label><input type="radio" {{ old('tire_season') !== null && old('tire_season') == 1 ? 'checked' : '' }} name="tire_season" value="1" /> Pneu été / 4 saisons</label>
				<label><input type="radio" {{ old('tire_season') !== null && old('tire_season') == 2 ? 'checked' : '' }} name="tire_season" value="2" /> Pneu hiver</label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Options</label>
			<div class="col-sm-9 col-lg-10 controls">
				<label><input type="checkbox" {{ old('runflat') !== null ? 'checked' : '' }} name="runflat" value="1" /> Runflat </label>
				<label><input type="checkbox" {{ old('reinforced') !== null ? 'checked' : '' }} name="reinforced" value="1" /> Renforcé</label>
			
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
				<button type="submit" class="btn btn-primary">Créer un pneu</button>
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
