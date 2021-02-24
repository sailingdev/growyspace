<?php $__env->startSection('content'); ?>
<div class="row m-0 bg-gray">
	<div class="col-md-12 head_logo_area_small mt-5">
		<div class="head_logo">		
		<img src='/assets/images/icon-settings-new-small.svg' alt='Settings' class="pull-left" ><h3 class="pull-left" >Settings</h3>
		</div>
		<div class="pull-left ml-3">
			<a onclick="window.history.back();" class="cusor_pointer display_image1"><img src="/assets/images/Frame 6.svg" alt="Back" ></a>
		</div>
	</div>

    <div class="col-md-8 mx-auto" >
        <div class="card mb-2">
			<?php echo Form::open(['url' => '/user/change_password', 'method' => 'POST']); ?>

			<?php if(count($errors->get('current_password')) > 0): ?>
				<div class="alert alert-danger">
					<?php echo e($errors->first('current_password')); ?>

				</div>
			<?php endif; ?>
			<?php if(count($errors->get('new_password')) > 0): ?>
				<div class="alert alert-danger">
					<?php echo e($errors->first('new_password')); ?>

				</div>
			<?php endif; ?>
			
			
			<?php if(session('success')): ?>
				<div class="alert alert-success">
					<?php echo e(session('success')); ?>

				</div>
			<?php endif; ?>		
            <div class="card-block p-4">
                <div class="row m-0 p-0 mt-2">					
					<div class="w-100 mt-3 profile_pitch">
						<div class="mt-3 mb-3 w-100">
							<h3 class="font-weight-bold">Email</h3>
						</div>
                        <div class="form-group form-inline p-0 m-0 mt-2">
                            <label class="col-md-3 p-0" for="role">Email address:</label>
							<input class="form-control col-md-9 opc_title" type="text" autocomplete="off" name="email"   value="<?php echo e(old('email') !== null ? old('email') : $user->email); ?>">
							<?php if(count($errors->get('email')) > 0): ?>
								<p class="inline_error"><?php echo e($errors->first('email')); ?></p>
							<?php endif; ?>
						</div>
						<div class="mt-3 mb-3 w-100">
							<h3 class="font-weight-bold">Change your password</h3>
						</div>						
                        <div class="form-group form-inline p-0 m-0 mt-2">
                            <label class="col-md-3 p-0" for="company">Current password:</label>
                            <input type="password" class="form-control col-md-9" name="current_password"  value="">
						</div>                                           
                        <div class="form-group form-inline p-0 m-0 mt-2">
                            <label class="col-md-3 p-0" for="company">New password:</label>
                            <input type="password" class="form-control col-md-9" name="current_password"  value="">
						</div>                                           
                        <div class="form-group form-inline p-0 m-0 mt-2">
                            <label class="col-md-3 p-0" for="company">Repeat password:</label>
                            <input type="password" class="form-control col-md-9" name="current_password"  value="">
						</div>           
						<div class="mt-3 mb-3 w-100">
							<h3 class="font-weight-bold">Account</h3>
						</div>							                                
                        <div class="form-group form-inline p-0 m-0 mt-2">
                            <div class="col-md-3 p-0 m-0">
								<button type="button" id="deleteAccount" class="settingsButton btn-delete-color">Delete account</button>
							</div>
                            <div class="col-md-9 p-0 m-0">
							</div>
                            
						</div>    
						<div class="form-group form-inline p-0 m-0 mt-2">
                            <div class="col-md-3 p-0 m-0">
								<button type="button" id="activeNotification" data-title="<?php echo e($user->unsubscribe == 1 ? 'Activate Email Notification'  : 'Deactivate Email Notification'); ?>" class="settingsButton btn-noti_email-color"><?php echo e($user->unsubscribe == 1 ? 'Activate Email Notification'  : 'Deactivate Email Notification'); ?></button>
							</div>
                            <div class="col-md-9 p-0 m-0">
							</div>
                            
						</div>                                        
                        <div class="form-group form-inline p-0 m-0 mt-2">
                            <div class="col-md-3 p-0 m-0 mb-3">
								
								<button type="button" id="hideAccount" data-title="<?php echo e($user->is_hidden == 1 ? 'Unhide'  : 'Hide'); ?>" class="settingsButton btn-hide-color"><?php echo e($user->is_hidden == 1 ? 'Unhide account'  : 'Hide account'); ?></button>
							</div>
                            <div class="col-md-9 p-0 m-0">
								
								<div class="alert alert-secondary m-0 p-0 p-2 " role="alert">
								Hidden accounts won't appear in other users search results.
								</div>
								
							</div>
                            
						</div>  
                                           
                    </div>
                </div>

                <div class="row m-0 p-0 mt-4">
                    <div class="w-100 m-0 p-0">	
						<button type="submit"class="btn text-decoration-none textcolor-blue pull-right p-0">Save</button>                        
                    </div>
                </div>
			</div>
			<?php echo Form::close(); ?>

        </div>
    
        <div class="mt-5"></div>
        		
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\XAMPP7.4\htdocs\growyspace 2.0\resources\views/user/settings.blade.php ENDPATH**/ ?>