<div class="modal fade" id="myalert" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">

        <div class="modal-body">
        @if(session('registration_success')) 
          <p>{{ session('registration_success') }}</p>
        @endif
        @if(count($errors->get('wrong_login_details')) > 0)
			<p>{{ $errors->first('wrong_login_details')}}</p>
		@endif           
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>