<a href="#add_edit_opportunity_card_popup" class="open_add_edit_opportunity_card_popup"></a>
<div class="spacelab_popup white-popup mfp-hide" id="add_edit_opportunity_card_popup">
	
	<div class="popup_header">
		<h1 class="add_edit_opportunity_card_title">Add Opportunity card</h1>
	</div>
	
		<div class="col-md-12">
			<div class="box-content">
			
				<div class="form-horizontal">
					<div class="opc_error_msg"></div>
					<br/>
					<div class="form-group">
						<label class="col-sm-3 col-lg-2 control-label">Fields</label>
						<div class="col-sm-9 col-lg-12 controls">
							<div class="input-group">
								<select style="width:100%;" multiple class="opc_fields form-control">
									
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 col-lg-2 control-label">Title</label>
						<div class="col-sm-9 col-lg-12 controls">
							<div class="input-group">
								<input type="text" class="opc_title form-control" maxlength="50" value="" />
								<p class="opc_title_note">Max length of 50 characters</p>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 col-lg-2 control-label">Company</label>
						<div class="col-sm-9 col-lg-12 controls">
							<div class="input-group">
								<input type="text" class="opc_company form-control" value="" />
							</div>
						</div>
					</div>
					<div class="form-group hidden">
						<label class="col-sm-3 col-lg-2 control-label">Company Logo</label>
						<div class="col-sm-9 col-lg-12 controls">
							<div class="input-group">
								<input type="file" class="opc_company_logo" name="opc_company_logo" value="" />
								<div class="opc_company_logo_block">
								
								</div>
							</div>
						</div>
					</div>
					<div style="overflow:hidden;" class="hidden form-group">
						
						<div style="float:left;width:49%;">
							<label class="col-sm-3 col-lg-2 control-label">Salary</label>
							<div class="col-sm-9 col-lg-12 controls">
								<div class="input-group">
									<input type="text" class="opc_salary form-control" value="" />
								</div>
							</div>
						</div>
						<div style="float:right;width:49%;">
							<label class="col-sm-3 col-lg-2 control-label">Hours/Week</label>
							<div class="col-sm-9 col-lg-12 controls">
								<div class="input-group">
									<input type="text" class="opc_hours form-control" value="" />
								</div>
							</div>
						</div>
					</div>
					<div style="overflow:hidden;" class="form-group">
						
						<div style="float:left;width:49%;">
							<label class="col-sm-3 col-lg-2 control-label">Country</label>
							<div class="col-sm-9 col-lg-12 controls">
								<div class="input-group">
									<select class="form-control opc_country_code" name="chosen">
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
									<input type="text" class="opc_city form-control" value="" />
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 col-lg-2 control-label">Description</label>
						<div class="col-sm-9 col-lg-12 controls">
							<div class="input-group">
								<textarea class="form-control opc_description"></textarea>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
						   <button class="btn btn-primary add_edit_opportunity_card">Add Opportunity Card</button>
						</div>
					</div>
					
					
					
					
				</div>
			</div>
		
		</div>
</div>
