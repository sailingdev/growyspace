<a href="#update_profession_popup" class="open_update_profession_popup"></a>
<div class="spacelab_popup white-popup mfp-hide" id="update_profession_popup">
	
	<div class="popup_header">
		<h1 class="add_edit_opportunity_card_title">Update Profession</h1>
	</div>
	
		<div class="col-md-12">
			<div class="box-content">
			
				<div class="form-horizontal">
					<div class="profession_msg"></div>
					<br/>
					<div class="form-group">
						<label class="col-sm-3 col-lg-2 control-label"></label>
						<div class="col-sm-9 col-lg-12 controls">
							<div class="input-group">
								<input type="text" class="profession form-control" value="{{ Auth::guard('user')->user()->profession }}" />
							</div>
						</div>
					</div>
					
					
					<div class="form-group">
						<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
						   <button class="btn btn-primary update_profession">Update Profession</button>
						</div>
					</div>
									
					
				</div>
			</div>
		
		</div>
</div>
