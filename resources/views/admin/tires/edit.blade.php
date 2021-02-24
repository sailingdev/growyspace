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
			
			<a href="{{ URL::to('/auto-turbo-admin/tires/') }}">Tires</a>
			<span class="divider"><i class="fa fa-angle-right"></i></span>
		</li>
		<li>
			
			{{ $tire->title }}
			<span class="divider"><i class="fa fa-angle-right"></i></span>
		</li>
		<li class="active">Edit</li>
	</ul>
</div>
<script>
	window.tire_id = "{{ $tire->id }}";
</script>
<!-- END Breadcrumb -->
<div class="box-content">
	{!! Form::open(['url' => '/auto-turbo-admin/tires/'.$tire->id , 'method' => 'PUT', 'route' => ['tires.update']]) !!}
	<div class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Titre</label>
			<div class="col-sm-9 col-lg-10 controls">
				<input type="text" placeholder="Titre" name="title" value="{{ old('title') !== null ? old('title') : $tire->title }}" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Prix</label>
			<div class="col-sm-9 col-lg-10 controls">
				<input type="text" placeholder="Prix" name="price" value="{{ old('price') !== null ? old('price') : $tire->price }}" class="float_only form-control">
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
							@elseif($tire->type == $k)
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
								@elseif($tire->tire_mark_id == $v['id'])
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
								@elseif($tire->tire_width_id == $v['id'])
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
							@elseif($tire->tire_height_id == $mwh->id)
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
							@elseif($tire->tire_diameter_id == $mwhd->id)
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
							@elseif($tire->tire_charge_id == $mwhdc->id)
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
							@elseif($tire->tire_speed_id == $mwhdcs->id)
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
				<label><input type="radio" 
					@if(old('tire_season') !== null && old('tire_season') == 1)
						checked
					@elseif($tire->tire_season_id == 1)
						checked
					@endif
				name="tire_season" value="1" /> Pneu été / 4 saisons</label>
				<label><input type="radio" 
					@if(old('tire_season') !== null && old('tire_season') == 2)
						checked
					@elseif($tire->tire_season_id == 2)
						checked
					@endif
				
				name="tire_season" value="2" /> Pneu hiver</label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Options</label>
			<div class="col-sm-9 col-lg-10 controls">
				<label><input type="checkbox" {{ old('runflat') !== null ? 'checked' : '' }} 
					@if(old('runflat') !== null && old('runflat') == 1)
						checked
					@elseif($tire->runflat == 1)
						checked
					@endif
				
				name="runflat" value="1" /> Runflat </label>
				<label><input type="checkbox" 
					@if(old('reinforced') !== null && old('reinforced') == 1)
						checked
					@elseif($tire->reinforced == 1)
						checked
					@endif

				name="reinforced" value="1" /> Renforcé</label>
			
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Description</label>
			<div class="col-sm-9 col-lg-10 controls">
				<textarea class="form-control" id="description" name="description">{{ old('description') !== null ? old('description') : $tire->description }}</textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label"></label>
			<div class="col-sm-9 col-lg-10 controls">
				<button type="submit" class="btn btn-primary">Créer un pneu</button>
			</div>
		</div>
		<div  style="margin-top:60px;" class="form-group">
			<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
			   <h1 style="text-align:center;">Group Images</h1>
			</div>
		</div>
		
		<div class="form-group">
		   <label class="col-sm-3 col-lg-2 control-label">Tire Images</label>
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
						
							@if(!empty($tire_images))
								@foreach($tire_images as $row)
							
									@if(is_file(base_path() . '/public/uploads/tire_images/'.$tire_id.'/'.$row->image_url))
									<li id="image_li_{{ $row->id }}" class="ui-sortable-handle mr-2 mt-2">
										<div style="position:relative;width:220px; height:240px;border: 1px dotted #ccc;margin:10px;">
											<a href="javascript:void(0);" class="img-link"><img src="{{ URL::to('/') }}/uploads/tire_images/{{ $tire_id }}/{{ $row->image_url }}" alt="" class="img-thumbnail" width="200" style="max-height:200px;" ></a>
											<span data-id="{{ $row->id }}" style="position:absolute;bottom:2px; left:2px;" class="btn btn-danger delete_tire_image_btn">Delete</span>
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
