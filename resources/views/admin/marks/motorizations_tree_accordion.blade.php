<h3>Motorizations <button class="btn btn-primary add_motorization_btn">Add Motorization</button></h3>
<div style="border:1px dotted #000;padding:10px;max-width:400px;margin:10px;" class="hidden form-horizontal add_motorization_block">
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">Motorization Name</label>
		<div class="col-sm-9 col-lg-10 controls">
			<input type="text" placeholder="Motorization Name" name="motorization_name" value="" class="motorization_name form-control">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label"></label>
		<div class="col-sm-9 col-lg-10 controls">
			<button class="btn btn-primary add_motorization">Add Motorization</button>
			<button class="btn btn-danger cancel_add_motorization">Cancel</button>
		</div>
	</div>
</div>


<div class="panel-group accordion" id="accordion2">
	@foreach($motorization_powers as $motorization_id => $motorization)
		<div class="panel panel-info">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a style="display:inline-block;" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse{{ $motorization_id }}"><i class="fa icon-chevron"></i>{{ $motorization->name }} </a> <button style="display:inline-block;float: right;margin-top: 4px;margin-right: 8px;" motorization_id="{{ $motorization_id }}" class="btn-sm btn btn-danger delete_mark_model_motorization">Delete</button>
				</h4>
			</div>
			<div id="collapse{{ $motorization_id }}" class="panel-collapse collapse" style="height: 0px;">
				<div style="border: 1px solid #ddd;overflow:hidden;" class="panel-body">
					<button class="btn btn-primary btn-sm add_power_btn">Add Power</button>
					<div style="border:1px dotted #000;padding:10px;max-width:400px;margin:10px;overflow:hidden;" class="hidden form-horizontal add_power_block">
						<div class="form-group">
							<label class="col-sm-3 col-lg-2 control-label">Power Name</label>
							<div class="col-sm-9 col-lg-10 controls">
								<input type="text" placeholder="Power Name" name="power_name" value="" class="power_name form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 col-lg-2 control-label"></label>
							<div class="col-sm-9 col-lg-10 controls">
								<button motorization_id="{{ $motorization_id }}" class="btn btn-primary add_power">Add Power</button>
								<button class="btn btn-danger cancel_add_power">Cancel</button>
							</div>
						</div>
					</div>
					
					@foreach($motorization->powers as $power)
						<div style="margin:4px;padding:10px" class="alert alert-success">
							<strong>{{ $power->name }}</strong> <button motorization_id="{{ $motorization_id }}" power_id="{{ $power->id }}" style="float:right;margin-top: -7px;" class="btn-sm btn btn-danger delete_mark_model_motorization_power">Delete</button> 
						</div>
					@endforeach
					 
				</div>
			</div>
		</div>
	@endforeach
	
</div>