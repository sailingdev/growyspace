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
		<li>
			
			<a href="{{ URL::to('/auto-turbo-admin/cars/') }}">Cars</a>
			<span class="divider"><i class="fa fa-angle-right"></i></span>
		</li>
		<li>
			
			{{ $car->title }}
			<span class="divider"><i class="fa fa-angle-right"></i></span>
		</li>
		<li class="active">Edit</li>
	</ul>
</div>
<script>
	window.product_mark_model = "{{ old('model') !==null ? old('model') : $car->model_id }}";
	window.product_mark_model_motorization = "{{ old('motorization') !==null ? old('motorization') : $car->motorization_id }}";
	window.product_mark_model_motorization_power = "{{ old('power') !==null ? old('power') : $car->power_id }}";
	window.car_id = "{{ $car->id }}";
</script>
<!-- END Breadcrumb -->
<div class="box-content">
	{!! Form::open(['url' => '/auto-turbo-admin/cars/'.$car->id , 'method' => 'PUT', 'route' => ['cars.update']]) !!}
	<div class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Titre</label>
			<div class="col-sm-9 col-lg-10 controls">
				<input type="text" placeholder="Product Title" name="title" value="{{ old('title') !== null ? old('title') : $car->title }}" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Ajout de titre:</label>
			<div class="col-sm-9 col-lg-10 controls">
				<input type="text" placeholder="Ajout de titre" name="title2" value="{{ old('title2') !== null ? old('title2') : $car->title2 }}" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Prix</label>
			<div class="col-sm-9 col-lg-10 controls">
				<input type="text" placeholder="Prix" name="price" value="{{ old('price') !== null ? old('price') : $car->price }}" class="float_only form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Marque</label>
			<div class="col-sm-9 col-lg-10 controls">
				<select name="mark" dependence="mark" class="dynamic_mark_model_motorization_power form-control">
					<option value="">Select a Mark</option>
					@foreach($marks as $mark)
						<option 
							@if(old('mark') !== null && old('mark') == $mark->id)
								selected
							@elseif($car->mark_id == $mark->id)
								selected
							@endif

						value="{{ $mark->id }}">{{ $mark->name }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Model</label>
			<div class="col-sm-9 col-lg-10 controls">
				<select name="model" dependence="model" class="dynamic_mark_model_motorization_power form-control">
					<option value="">Select a Model</option>
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
						<option 
							@if(old('number_of_places') !== null && old('number_of_places') == $i)
								selected
							@elseif($car->number_of_places == $i)
								selected
							@endif
						value="{{ $i }}">{{ $i }}</option>
					@endfor
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Boîte de vitesse</label>
			<div class="col-sm-9 col-lg-10 controls">
				<select name="gearbox" class="form-control">
					<option value="">Select a Option</option>
					<option 
						@if(old('gearbox') !== null && old('gearbox') == 1)
							selected
						@elseif($car->gearbox == 1)
							selected
						@endif
					
					value="1">Manuelle</option>
					<option 
						@if(old('gearbox') !== null && old('gearbox') == 2)
							selected
						@elseif($car->gearbox == 2)
							selected
						@endif
					value="2">Automatique</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Année-modèle</label>
			<div class="col-sm-9 col-lg-10 controls">
				<input type="text" placeholder="Année-modèle" name="model_year" value="{{ old('model_year') !== null ? old('model_year') : $car->model_year }}" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Carburant</label>
			<div class="col-sm-9 col-lg-10 controls">
				<select name="fuel" class="form-control">
					<option value="">Engine Type</option>
					@foreach($fuels as $fuel_id => $fuel)
					<option  
						@if( old('fuel') !== null && old('fuel') == $fuel_id )
							selected
						@elseif($car->fuel == $fuel_id)
							selected
						@endif
						value="{{ $fuel_id }}">{{ $fuel }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Kilométrage</label>
			<div class="col-sm-9 col-lg-10 controls">
				<input type="text" placeholder="Kilométrage" name="mileage" value="{{ old('mileage') !== null ? old('mileage') : $car->mileage }}" class="float_only form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Description</label>
			<div class="col-sm-9 col-lg-10 controls">
				<textarea class="form-control" id="description" name="description">{{ old('description') !== null ? old('description') : $car->description }}</textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label"></label>
			<div class="col-sm-9 col-lg-10 controls">
				<button type="submit" class="btn btn-primary">Update Car</button>
			</div>
		</div>
		<div  style="margin-top:60px;" class="form-group">
			<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
			   <h1 style="text-align:center;">Car Images</h1>
			</div>
		</div>
		
		<div class="form-group">
		   <label class="col-sm-3 col-lg-2 control-label">Car Images</label>
		   <div class="col-sm-9 col-lg-10 controls">
				<div class="container">
					<div class="dropzone dz-clickable" id="myDrop">
						<div class="dz-default dz-message" data-dz-message="">
							<span>Drop files here to upload</span>
						</div>
					</div>
					<input type="button" id="add_file" value="Upload file(s)" class="btn btn-primary mt-3">
				</div>
				<hr class="my-5">
				<div class="container">
					<div id="msg" class="mb-3"></div>
					<a href="javascript:void(0);" class="btn btn-outline-primary reorder" id="updateReorder">Reorder Imgaes</a>
					<div id="reorder-msg" class="alert alert-warning mt-3" style="display:none;">
						<i class="fa fa-3x fa-exclamation-triangle float-right"></i> 1. Drag photos to reorder.<br>2. Click 'Save Reordering' when finished.
					</div>
					<div style="display:block;overflow:hidden;" class="gallery">
						<ul class="nav nav-pills">
						
							@if(!empty($car_images))
								@foreach($car_images as $row)
									@if(is_file(base_path() . '/public/uploads/car_images/'.$car_id.'/'.$row->image_url))
									<li id="image_li_{{ $row->id }}" class="ui-sortable-handle mr-2 mt-2">
										<div style="position:relative;width:220px; height:240px;border: 1px dotted #ccc;margin:10px;">
											<a href="javascript:void(0);" class="img-link"><img src="{{ URL::to('/') }}/uploads/car_images/{{ $car_id }}/{{ $row->image_url }}" alt="" class="img-thumbnail" width="200" style="max-height:200px;" ></a>
											<span data-id="{{ $row->id }}" style="position:absolute;bottom:2px; left:2px;" class="btn btn-danger delete_car_image_btn">Delete</span>
										
										</div>
									</li>
									@endif
								@endforeach
							@endif
						</ul>
					</div>
				</div>					  
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
