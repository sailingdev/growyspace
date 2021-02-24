
		<!-- end of container -->
		</div> 	

		<div class="col-md-12 m-0 p-0 bg-white">
			
			<div class="row footer_area">
				<div class="footer_img">
					<img class="img-fluid" src="<?php echo e(URL::to('/')); ?>/assets/images/Group 844.svg" style="width:110px;" alt="" >
					<h5 class="pt-3 font-weight-bold">Growyspace</h5>
				</div>
				<div class="footer_social">
					<ul class="list-unstyled footer_ul">
						<li><a href="/terms">Terms</a></li>
						<li><a href="/privacy">Privacy</a></li>
						<li><a href="/about">About us</a></li>
						<li><a href="/contact">Contact us</a></li>
					</ul>
					<a href="https://www.instagram.com/growyspaceofficial/"> <img class="img-fluid pr-1" src="<?php echo e(URL::to('/')); ?>/assets/images/instagram.svg" ></a>
					<a href="https://www.linkedin.com/company/growyspace/"> <img class="img-fluid pl-1" src="<?php echo e(URL::to('/')); ?>/assets/images/linkedin.svg" ></a>
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
		
		
		
		
		
		<script src="<?php echo e(URL::to('/')); ?>/assets/js/jquery.min.js"></script>
		
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script src="<?php echo e(URL::to('/')); ?>/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
		<script src="<?php echo e(URL::to('/')); ?>/assets/plugins/magnific-popup/jquery.magnific-popup.js"></script>
		<script src="<?php echo e(URL::to('/')); ?>/assets/plugins/croppie/croppie.js"></script>
		<script src="<?php echo e(URL::to('/')); ?>/assets/plugins/notify/bootstrap-notify.min.js"></script>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>



		<script src="<?php echo e(URL::to('/')); ?>/assets/bootstrap4-editable/js/bootstrap-editable.min.js"></script>


		<script src="<?php echo e(URL::to('/')); ?>/assets/js/main.js?<?php echo e(time()); ?>"></script>
		<input type="hidden" class="_token" value="<?php echo csrf_token(); ?>" /> 

<?php echo $__env->make('popups.login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('popups.signup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('popups.upgradeMembership', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>	

		<?php if(count($errors) > 0): ?> 
			<script type="text/javascript">
				<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>  $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					$.notify({
						// options
						message: '<?php echo e($error); ?>' 
					},{
						// settings
						type: 'danger',
						placement: {
							align: 'center'
						},
						delay:3500
					});
					
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</script>
		<?php endif; ?>
		<?php if(session('message')): ?> 
		<script type="text/javascript">
			$.notify({
				// options
				message: "<?php echo e(session('message')); ?>" 
			},{
				// settings
				type: 'success',
				placement: {
					align: 'center'
				},
				delay:3500
			});
		</script>
		<?php endif; ?>
		<?php if(session('membership_error')): ?> 
		<script type="text/javascript">
			$('#upgradeMembership').modal('show');
		</script>
		<?php endif; ?>
		<!-- <?php if(config('yourconfig.reminderEmail')): ?> 
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
		<?php endif; ?> -->





	</body>
</html>
<?php /**PATH F:\XAMPP7.4\htdocs\growyspace 2.0\resources\views/commons/front_footer.blade.php ENDPATH**/ ?>