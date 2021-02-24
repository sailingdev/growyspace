<div id="login_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered justify-content-center " role="document">
            <div class="modal-content border-0 mx-3">
                <div class="modal-body p-0">
                    <div class="row justify-content-center">
                        <div class="col">
                            <div class="card">
                                <div class="card-header bg-white border-0 pb-3">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="flex-col-auto"></div>
                                        <div class="col-auto text-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span class="cross" aria-hidden="true">&times;</span> </button></div>
                                    </div>
                                </div>
                                <?php echo Form::open(['url' => '/user/loggin', 'method' => 'POST']); ?>

								
								<!-- <?php if(count($errors->get('wrong_login_details')) > 0): ?>
									<p class="inline_error"><?php echo e($errors->first('wrong_login_details')); ?></p>
								<?php endif; ?>                                 -->
                                <div class="card-block p-4">
                                    <div class="row m-0 p-0 ">	
                                        <div class="w-100 text-center">
                                            <h2>Login</h2>
                                        </div>
                                        <div class="w-100 mt-3 profile_pitch">

                                            <div class="form-group form-inline p-0 m-0 mt-2 <?php echo e(((count($errors->get('email')) > 0) ? 'has-error' : '')); ?>">
                                                <label class="col-md-3 justify-content-start p-0" for="role">Email:</label>
                                                <input class="form-control col-md-9 " type="text" autocomplete="off" name="email" class="form-control" placeholder="Email" value="">
                                                <?php if(count($errors->get('email')) > 0): ?>
                                                    <p class="inline_error"><?php echo e($errors->first('email')); ?></p>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="form-group form-inline p-0 m-0 mt-2 <?php echo e(((count($errors->get('password')) > 0) ? 'has-error' : '')); ?>">
                                                <label class="col-md-3 justify-content-start p-0" for="company">Password:</label>
                                                <input type="password" class="form-control col-md-9" name="password" placeholder="password" value="">
                                                <?php if(count($errors->get('password')) > 0): ?>
                                                    <p class="inline_error"><?php echo e($errors->first('password')); ?></p>
                                                <?php endif; ?>
                                            </div>                                           
       
                                                                                    
                                        </div>
                                    </div>

                                    <div class="row m-0 p-0 mt-4">
                                        <div class="w-100 m-0 p-0">	               
                                            <input type="hidden" name="from_page" value="login" />                                 
                                            <button type="submit" class="pull-right text-light" style="background: #219BC4;box-shadow: 0px 4px 4px #32275F;border-radius: 10px;padding: 7px 25px;">Login</button>                         
                                        </div>
                                        <div class="w-100 m-0 p-0 mt-4 text-right">	
                                            <a class="forgot_password_btn textcolor-blue cusor_pointer">Forgot password ?</a>
                                        </div>
                                    </div>
                                    <div class="row m-0 p-0 mt-4">
                                        <div class="w-100 m-0 p-0 text-center">	                               
                                            <p style="color:#1C3041;font-size:1.125rem; font-weight:bold;">Don’t have a Growyspace account yet?</p>
                                        </div>
                                        <div class="w-100 m-0 p-0 mt-4 mb-2 text-center">	
                                            <a data-toggle="modal" data-target="#signup_modal" data-dismiss="modal" class="btn text-center" style="background: #219BC4;color:#fff;box-shadow: 0px 4px 4px #32275F;border-radius: 10px;padding: 7px 25px;">Sign up</a> 
                                        </div>
                                    </div>
			                    </div>
                                <?php echo Form::close(); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

<?php echo $__env->make('forgot_password', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\XAMPP7.4\htdocs\growyspace 2.0\resources\views/popups/login.blade.php ENDPATH**/ ?>