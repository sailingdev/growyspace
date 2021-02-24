
		<!-- end of container -->
		</div> 	

		<div class="col-md-12 m-0 p-0 bg-white">
			
			<div class="row footer_area">
				<div class="footer_img">
					<img class="img-fluid" src="{{ URL::to('/') }}/assets/images/Group 844.svg" style="width:110px;" alt="" >
					<h5 class="pt-3 font-weight-bold">Growyspace</h5>
				</div>
				<div class="footer_social">
					<ul class="list-unstyled footer_ul">
						<li><a href="/terms">Terms</a></li>
						<li><a href="/privacy">Privacy</a></li>
						<li><a href="/about">About us</a></li>
						<li><a href="/contact">Contact us</a></li>
					</ul>
					<a href="https://www.instagram.com/growyspaceofficial/"> <img class="img-fluid pr-1" src="{{ URL::to('/') }}/assets/images/instagram.svg" ></a>
					<a href="https://www.linkedin.com/company/growyspace/"> <img class="img-fluid pl-1" src="{{ URL::to('/') }}/assets/images/linkedin.svg" ></a>
				</div>
				
				<div class="footer_social ml-5">
					<ul class="list-unstyled footer_ul">
						<li><a href="/oportunity_guide">Opportunity seeker guide</a></li>
						<li><a href="/opentowork_guide">Talent seeker guide</a></li>
					</ul>
					
				</div>				
			</div>
			<div class="row m-0 bottomFooter">
				<p>Copyright © growyspace.com 2021</p>
			</div>
  		</div>
		
		
		
		
		
		<script src="{{ URL::to('/') }}/assets/js/jquery.min.js"></script>
		
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script src="{{ URL::to('/') }}/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
		<script src="{{ URL::to('/') }}/assets/plugins/magnific-popup/jquery.magnific-popup.js"></script>
		<script src="{{ URL::to('/') }}/assets/plugins/croppie/croppie.js"></script>
		<script src="{{ URL::to('/') }}/assets/plugins/notify/bootstrap-notify.min.js"></script>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>



		<script src="{{ URL::to('/') }}/assets/bootstrap4-editable/js/bootstrap-editable.min.js"></script>


		<script src="{{ URL::to('/') }}/assets/js/main.js?{{ time() }}"></script>
		<input type="hidden" class="_token" value="{!! csrf_token() !!}" /> 

@include('popups.login')
@include('popups.signup')
@include('popups.upgradeMembership')	

		@if (count($errors) > 0) 
			<script type="text/javascript">
				@foreach ($errors->all() as $key =>  $error)
					$.notify({
						// options
						message: '{{ $error }}' 
					},{
						// settings
						type: 'danger',
						placement: {
							align: 'center'
						},
						delay:3500
					});
					
				@endforeach
			</script>
		@endif
		@if(session('message')) 
		<script type="text/javascript">
			$.notify({
				// options
				message: "{{ session('message') }}" 
			},{
				// settings
				type: 'success',
				placement: {
					align: 'center'
				},
				delay:3500
			});
		</script>
		@endif
		@if(session('membership_error')) 
		<script type="text/javascript">
			$('#upgradeMembership').modal('show');
		</script>
		@endif
		<!-- @if(config('yourconfig.reminderEmail')) 
		<script type="text/javascript">

			$.ajax({
			type:'POST',
			url:base_url + 'ajax/send_reminder',
			dataType:'json',
			data:{
				_token: $('._token').val()
			},
			cache: false,
			success:function(data){
			}
		});
		</script>			
		@endif -->





	</body>
</html>
