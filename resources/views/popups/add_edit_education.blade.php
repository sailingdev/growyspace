<a href="#add_edit_eductaion_popup" class="open_add_edit_education_popup"></a>
<div class="spacelab_popup white-popup mfp-hide" id="add_edit_eductaion_popup">
	
	<div class="popup_header">
		<h1 class="add_edit_education_title">Add Education</h1>
	</div>
	
		<div class="col-md-12">
			<div class="box-content">
				<div class="form-horizontal">
					<div class="education_msg"></div>
					<br/>
					<div class="form-group">
						<label class="col-sm-3 col-lg-2 control-label">School</label>
						<div class="col-sm-9 col-lg-12 controls">
							<div class="input-group">
								<input type="text" class="education_school form-control" placeholder="Ex: Northwestern University" value="" />
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 col-lg-2 control-label">Type of Title</label>
						<div class="col-sm-9 col-lg-12 controls">
							<div class="input-group">
								<input type="text" class="education_type_of_title form-control" placeholder="Ex: Bachelor degree" value="" />
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 col-lg-2 control-label">Title</label>
						<div class="col-sm-9 col-lg-12 controls">
							<div class="input-group">
								<input type="text" class="education_title form-control" placeholder="Ex: Businesss administration and management" value="" />
							</div>
						</div>
					</div>
					<div style="overflow:hidden;" class="form-group">
						
						<div style="float:left;width:49%;">
							<label class="col-sm-6 control-label">Dates Attended (Optional)</label>
							<div class="col-sm-9 col-lg-12 controls">
								<div class="input-group">
									<select  class="education_from_year form-control">
										<option value="">From</option>
										@for($i = 1975;$i <= date('Y');$i++)
											<option value="{{ $i }}">{{ $i }}</option>
										@endfor
									</select>
								</div>
							</div>
						</div>
						<div style="float:right;width:49%;">
							<label class="col-sm-3 col-lg-2 control-label">&nbsp;</label>
							<div class="col-sm-9 col-lg-12 controls">
								<div class="input-group">
									<select class="education_to_year form-control">
										<option value="">To (or expected graduation year)</option>
										@for($i = 1975;$i <= date('Y') + 7;$i++)
											<option value="{{ $i }}">{{ $i }}</option>
										@endfor
									</select>
								</div>
							</div>
						</div>
					</div>
					<div style="overflow:hidden;" class="form-group">
						
						<div style="float:left;width:49%;">
							<label class="col-sm-3 col-lg-2 control-label">Country</label>
							<div class="col-sm-9 col-lg-12 controls">
								<div class="input-group">
									<select class="form-control education_country_code" name="chosen">
										<option value="">Select a Country</option>
										@foreach($countries as $country_code => $coutry_name)
											<option value="{{ $country_code }}">{{ $coutry_name }}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div style="float:right;width:49%;">
							<label class="col-sm-3 col-lg-2 control-label">City</label>
							<div class="col-sm-9 col-lg-12 controls">
								<div class="input-group">
									<input type="text" class="education_city form-control" value="" />
								</div>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-6 control-label">Description (Optional)</label>
						<div class="col-sm-9 col-lg-12 controls">
							<div class="input-group">
								<textarea class="form-control education_description"></textarea>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
						   <button class="btn btn-primary add_edit_education">Add Education</button>
						</div>
					</div>
				</div>
			</div>
		
		</div>
</div>
