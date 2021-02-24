<a href="#add_edit_experience_popup" class="open_add_edit_experience_popup"></a>
<div class="spacelab_popup white-popup mfp-hide" id="add_edit_experience_popup">
	
	<div class="popup_header">
		<h1 class="add_edit_experience_title">Add Experience</h1>
	</div>
	
		<div class="col-md-12">
			<div class="box-content">
			
				<div class="form-horizontal">
					<div class="exp_msg"></div>
					<br/>
					<div class="form-group">
						<label class="col-sm-3 col-lg-2 control-label">Company</label>
						<div class="col-sm-9 col-lg-12 controls">
							<div class="input-group">
								<input type="text" class="exp_company form-control" value="" />
							</div>
						</div>
					</div>
					<div class="form-group hidden">
						<label class="col-sm-4 control-label">Company Logo(Optional)</label>
						<div class="col-sm-9 col-lg-12 controls">
							<div class="input-group">
								<input type="file" class="exp_company_logo" name="exp_company_logo" value="" />
								<div class="exp_company_logo_block">
								
								</div>
							</div>
						</div>
					</div>
					<div style="overflow:hidden;" class="form-group">
						
						<div style="float:left;width:49%;">
							<label class="col-sm-3 col-lg-2 control-label">Country</label>
							<div class="col-sm-9 col-lg-12 controls">
								<div class="input-group">
									<select class="form-control exp_country_code" name="chosen">
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
									<input type="text" class="exp_city form-control" value="" />
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 col-lg-2 control-label">Title</label>
						<div class="col-sm-9 col-lg-12 controls">
							<div class="input-group">
								<input type="text" class="exp_title form-control" value="" />
							</div>
						</div>
					</div>
					<div style="overflow:hidden;" class="form-group">
						
						<div style="float:left;width:49%;">
							<label class="col-sm-6 control-label"><strong>Period</strong></label>
							<div class="col-sm-9 col-lg-12 controls">
								<div class="input-group">
									<select  class="exp_from_month form-control">
										<option value="">Month</option>
										@foreach($months as $m_id => $m)
											<option value="{{ $m_id }}">{{ $m }}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div style="float:right;width:49%;">
							<label class="col-sm-3 col-lg-2 control-label">&nbsp;</label>
							<div class="col-sm-9 col-lg-12 controls">
								<div class="input-group">
									<select class="exp_from_year form-control">
										<option value="">Year</option>
										@for($i = 1975;$i <= date('Y') + 7;$i++)
											<option value="{{ $i }}">{{ $i }}</option>
										@endfor
									</select>
								</div>
							</div>
						</div>
					</div>
					<div style="overflow:hidden;" class="exp_end_year_month_block form-group">
						
						<div style="float:left;width:49%;">
							<label class="col-sm-6 control-label">through</label>
							<div class="col-sm-9 col-lg-12 controls">
								<div class="input-group">
									<select  class="exp_to_month form-control">
										<option value="">Month</option>
										@foreach($months as $m_id => $m)
											<option value="{{ $m_id }}">{{ $m }}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div style="float:right;width:49%;">
							<label class="col-sm-3 col-lg-2 control-label">&nbsp;</label>
							<div class="col-sm-9 col-lg-12 controls">
								<div class="input-group">
									<select class="exp_to_year form-control">
										<option value="">Year</option>
										@for($i = 1975;$i <= date('Y') + 7;$i++)
											<option value="{{ $i }}">{{ $i }}</option>
										@endfor
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group exp_present_label_block hidden">
						<label class="col-sm-3 col-lg-2 control-label">through</label>
						<div class="col-sm-9 col-lg-12 controls">
							<div class="input-group">
								Present
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 col-lg-2 control-label"></label>
						<div class="col-sm-9 col-lg-12 controls">
							<div class="input-group">
								<label>
									<input type="checkbox" class="exp_currently_working" value="1" />
									I currently work here
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 col-lg-2 control-label">Description(Optional)</label>
						<div class="col-sm-9 col-lg-12 controls">
							<div class="input-group">
								<textarea class="form-control exp_description"></textarea>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
						   <button class="btn btn-primary add_edit_experience">Add Experience</button>
						</div>
					</div>
					
					
					
					
				</div>
			</div>
		
		</div>
</div>
