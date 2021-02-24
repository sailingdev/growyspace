<?php $__env->startSection('content'); ?>
	<div class="row m-0 bg-gray">
		<div class="col-md-12 head_logo_area mt-5">
			<div class="head_logo">		
			<img src='/assets/images/icon-profile 1.svg' alt='profile' class="pull-left" ><h3 class="pull-left" >My profile</h3>
			</div>
		</div>

		<div class="col-md-8 mx-auto" >
			<!-- profile -->
			<div class="card mb-2">
				<div class="card-header color-user">
					<?php if($user->is_deleted == 1): ?>
						<div class="alert alert-danger fade in alert-dismissible show">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true" style="font-size:20px">×</span>
						</button>    <strong>Alert!</strong> This account has been cancelled, please contact Support
						</div>
					<?php endif; ?>
				</div>
				<div class="card-block p-4">
						
						<div class="row m-0 p-0 profile_picture">
							<div class="mt-2 mb-2 w-100 profile_experience">
								<h3 class="font-weight-bold">About me</h3>
							</div>
							
							<div class="col-md-2 p-0 m-0 profile_img <?php echo e($profile_image_src !== false ? ''  : ''); ?>">
									<?php if($profile_image_src !== false): ?>
										<img src='<?php echo e($profile_image_src); ?>' class="profile_pic_wrapper img-fluid pull-left cusor_pointer" >
										<img  src="<?php echo e(URL::to('/')); ?>/assets/images/transparent_cricle.svg" class="changePicture img-fluid pull-left profile_pic_wrapper cusor_pointer" />
									<?php else: ?>
										<!-- <?php if($owner === true): ?>
											<img  src="<?php echo e(URL::to('/')); ?>/assets/images/change_profile.png" class="profile_pic_wrapper img-fluid pull-left" />
										<?php else: ?>
											<img src="<?php echo e(URL::to('/')); ?>/assets/images/icon-profile 1.svg" class="profile_pic_wrapper img-fluid pull-left" />
										<?php endif; ?> -->
										<img  src="<?php echo e(URL::to('/')); ?>/assets/images/change_profile.png " class="profile_pic_wrapper img-fluid pull-left cusor_pointer" />
										
									<?php endif; ?>
									
							</div>
							<div class="col-md-10 p-0 m-0 profile_name pull-left">
								<div class="form-group form-inline p-0 m-0 ml-3">
									<label class="col-md-3 p-0" for="name">Name:</label>
									<input class="form-control col-md-9" type="text" id="full_name"  value="<?php echo e($user && $user->full_name ? $user->full_name  : ''); ?>">
								</div>
								<div class="form-group form-inline p-0 m-0 ml-3 mt-2">
									<label class="col-md-3 p-0" for="profession">Title:</label>
									<input class="form-control col-md-9" type="text" id="profession"  value="<?php echo e($user && $user->profession ? $user->profession  : ''); ?>">
								</div>
								<div class="form-group form-inline p-0 m-0 ml-3 mt-2">
									<label class="col-md-3 p-0" for="profession">Location:</label>
									<select class="form-control col-md-5 mb-2 profile_country" name="chosen">
										<option value="">Select a Country</option>
										<?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country_code => $coutry_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($country_code); ?>" <?php echo e($user && $user->country_code === $country_code ? 'selected' : ''); ?>><?php echo e($coutry_name); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
									<div class="col-md-4 m-0 p-0 mb-2 profile_city has-location">
										<span class="fa fa-map-marker form-control-marker"></span>
										<input type="text" placeholder="city" class="opc_city form-control w-100 " value="<?php echo e($user && $user->city ? $user->city : ''); ?>" />
									</div>
								</div>
								
							</div>
						</div>
				
						<div class="row m-0 p-0 ">
							<div class="w-100 mt-3 profile_pitch">
								<h3 class="font-weight-bold">Profile badge:</h3>
								<div class="form-check form-check-inline <?php echo e(((count($errors->get('looking_for')) > 0) ? 'has-error' : '')); ?>">
									<input class="form-check-input" type="radio" name="pro_looking_for" id="inlineRadio1" value="1" <?php echo e($user->looking_for == 1 ? 'checked'  : ''); ?>>
									<label class="form-check-label" for="inlineRadio1">Opportunity seeker</label>
									<span class="pl-2"><img src="/assets/images/Icon-opportunity seeker.svg" style="width:30px;"></span>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="pro_looking_for" id="inlineRadio2" value="2" <?php echo e($user->looking_for == 2 ? 'checked'  : ''); ?>>
									<label class="form-check-label" for="inlineRadio2">Talent seeker</label>
									<span class="pl-2"><img src="/assets/images/Icon-talent seeker.svg" style="width:30px;"></span>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="pro_looking_for" id="inlineRadio3" value="0" <?php echo e($user->looking_for == 0 ? 'checked'  : ''); ?>>
									<label class="form-check-label" for="inlineRadio3">None</label>
								</div>		
							</div>
						</div>
						<div class="row m-0 p-0 ">
							<div class="w-100 mt-3 profile_pitch">
								<h3 class="font-weight-bold">Presentation letter:</h3>
								<textarea class="form-control profile_presentation"><?php echo e($user && $user->my_pitch ? nl2br($user->my_pitch)  : ''); ?></textarea>
							</div>
						</div>

						
						<!-- save -->
						<div class="row m-0 mt-5 p-0 ">
							<div class="w-100 m-0 p-0">	
								<a href="#" data-id="<?php echo e($user->id); ?>" class="text-decoration-none textcolor-blue pull-right  profile_save" style="color: #219BC4 !important">Save</a>
							</div>
						</div>									
				</div>

			</div>

			<div class="mt-5"></div>		
		</div>
	</div>
	<?php if($owner === true): ?> <?php echo $__env->make('popups.profile_image', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\XAMPP7.4\htdocs\growyspace 2.0\resources\views/user/edit_profile.blade.php ENDPATH**/ ?>