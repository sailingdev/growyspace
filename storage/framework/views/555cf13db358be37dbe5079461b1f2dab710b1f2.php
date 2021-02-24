<?php $__env->startSection('content'); ?>
	<div class="row m-0 bg-gray">
		<div class="col-md-12 head_logo_area_small mt-5">
		<?php if(!$third_person): ?>
			<div class="head_logo">		
			<img src='/assets/images/icon-profile 1.svg' alt='profile' class="pull-left" ><h3 class="pull-left" >My profile</h3>
			</div>
			<div class="pull-left ml-3">
				<a onclick="window.history.back();" class="cusor_pointer display_image1"><img src="/assets/images/Frame 6.svg" alt="Back" ></a>
			</div>
		<?php endif; ?>
		</div>

		<div class="col-md-8 mx-auto" >
			<!-- profile -->
			<div class="card mb-2">
			<?php if($third_person): ?>
			<a onclick="window.history.back();" class="left_back cusor_pointer display_image1"><img src="/assets/images/Frame 6.svg" alt="Back" ></a>
        	<a onclick="window.history.back();" class="left_back cusor_pointer display_image2"><img src="/assets/images/backformobile.svg" alt="Back" ></a>
			<?php endif; ?>
				<div class="card-header color-user" style="height: 54px;">
					<?php if($user->is_deleted == 1): ?>
						<div class="alert alert-danger fade in alert-dismissible show">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true" style="font-size:20px">×</span>
						</button>    <strong>Alert!</strong> This account has been cancelled, please contact Support
						</div>
					<?php endif; ?>
					
					<div class="row m-0 p-0 hide_mobile">
						<?php if($user->looking_for == 1): ?>
						<span class="m-0 text-right " style="padding: 14px 24px 14px 15px;position: absolute;right:0px; top:0px;height: 54px;background: #65C5BF;float:right;">
							<img src="/assets/images/Icon-opportunity seeker.svg" style="width:30px;"><span class="pl-2">Opportunity Seeker</span>
						</span>
						<?php elseif($user->looking_for == 2): ?>
						<span class="m-0 text-right " style="padding: 14px 24px 14px 15px;position: absolute;right:0px; top:0px;height: 54px;background: #3170AF;float:right;">
							<img src="/assets/images/Icon-talent seeker.svg" style="width:30px;"><span class="pl-2">Talent Seeker</span>
						</span>
						<?php endif; ?>
					</div>
					<!-- mobile -->
					<div class="row m-0 p-0  show_mobile">
						<?php if($user->looking_for == 1): ?>
						<p class="w-75 m-0 pl-1 pull-left text-left ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2"><?php echo e($user->city); ?>, <?php echo e($countries[$user->country_code]); ?></span></p>
						<p class="w-25 m-0 p-0 pull-left text-right">
							<img src="/assets/images/Icon-opportunity seeker.svg" style="width:30px;">
						</p>
						<?php elseif($user->looking_for == 2): ?>
						<p class="w-75 m-0 pl-1 pull-left text-left ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2"><?php echo e($user->city); ?>, <?php echo e($countries[$user->country_code]); ?></span></p>
						<p class="w-25 m-0 p-0 pull-left text-right">
							<img src="/assets/images/Icon-talent seeker.svg" style="width:30px;">
						</p>
						<?php endif; ?>
					</div>
					
				</div>
				<div class="card-block p-4">
						
						<div class="row m-0 p-0 profile_picture">
							<div class="profile_img">
						<?php if($profile_image_src !== false): ?>
							<img src='<?php echo e($profile_image_src); ?>' class="img-fluid pull-left" >
						<?php else: ?>
							<?php if($owner === true): ?>
								<img  src="<?php echo e(URL::to('/')); ?>/assets/images/noprofileIMG.png" class="img-fluid pull-left" />
							<?php else: ?>
								<img src="<?php echo e(URL::to('/')); ?>/assets/images/noprofileIMG.png" class="img-fluid pull-left" />
							<?php endif; ?>
						<?php endif; ?>
							</div>
							<div class="profile_name pull-left">

								<h3 class="font-weight-bold myname color-black1 ellipsis" onclick="toggleEllipsis(this)"><?php echo e($user->full_name); ?></h3>
								<h3 class="myprofessor color-black2 ellipsis" onclick="toggleEllipsis(this)"><?php echo e($user->profession); ?></h3>
								<p class="mylocation color-black1">
									<!-- <img src="/assets/images/location.png"> <?php echo e($user->city); ?>, <?php echo e($countries[$user->country_code]); ?></p> -->
									<span class="fa fa-map-marker"></span> <?php echo e($user->city); ?>, <?php echo e($countries[$user->country_code]); ?></p>
							</div>
						</div>
				
						<div class="row m-0 p-0 ">
							<div class="w-100 mt-3 profile_pitch">
								<h3 class="font-weight-bold mypresentation color-black1">Presentation letter</h3>
								<p class="mypictch color-black1 m-0"><?php echo e($user->my_pitch); ?></p>
							</div>
						</div>



						<div class="row m-0 p-0 mt-3">
							<div class="w-100 m-0 p-0">	
							<?php if(!$third_person): ?>						
								<a href="/user/<?php echo e($user->id); ?>/edit" class="textcolor-blue pull-right pl-2"><img src="/assets/images/Icon-edit.svg" alt="Edit" style="width:25px;"><span class="pl-2">Edit</span></a>
							<?php endif; ?>
								<a href="#" data-pk="<?php echo e($user->id); ?>" data-type="checklist" data-source="<?php echo e(URL::to('/')); ?>/ajax/get_user_collection_list/<?php echo e($user->id); ?>"  data-title="Select collections" class="user_collection editable editable-click text-decoration-none textcolor-blue pull-right pr-2 pl-2" data-placement="bottom"   data-original-title="" title="" style="color: #219BC4">Add to collection</a>
								<!-- <a href="/findmatch/<?php echo e($user->id); ?>" class="text-decoration-none textcolor-blue pull-right pr-2 pl-2" data-placement="bottom" style="color: #219BC4">Find matches</a> -->
							<?php if($third_person): ?>	
								<a href="/messages/<?php echo e($user->id); ?>" class="text-decoration-none textcolor-blue float-right pr-2">Send a message</a>
							<?php endif; ?>	
							</div>
						</div>
	

				</div>

			</div>
			<?php if(!$third_person): ?>
			<div class="row m-0 p-0 mt-5 display_button1" style="<?php echo e($user->matchmaking == 0 ? 'display:none;' : ''); ?>">
				<p class="w-65 m-0 p-0"></p>
				<p class="w-35 m-0 p-0 text-right">
				<a href="/findmatch/<?php echo e($user->id); ?>" class="btn button_create_opportunity" style="background:#219BC4">Matchmaking advanced</a>
				</p>
			</div>
			<div class="row m-0 p-0 mt-5 display_button2" style="<?php echo e($user->matchmaking == 0 ? 'display:none;' : ''); ?>">	
				<p class="w-100 m-0 p-0 text-right">
				<a href="/findmatch/<?php echo e($user->id); ?>" class="btn button_create_opportunity" style="background:#219BC4">Matchmaking advanced</a>
				</p>
			</div>	
			<?php endif; ?>		
			<!-- opportunity -->
			<?php $__currentLoopData = $opportunity_cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<div class="card mt-5 mb-2">
				<div class="card-header pl-4 pr-4 color-oppportunity h-100">
					<div class="row m-0 p-0 opportunity_header">
						<p class="w-50 m-0 p-0 font-weight-bold">Opportunity</p>
						<!-- <p class="w-65 m-0 p-0 text-right font-weight-bold"><img src="/assets/images/location2.png"><span class="pl-2"><?php echo e((isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : $opc->country_code).', '.$opc->city); ?></span></p> -->
						<p class="w-50 m-0 p-0 text-right font-weight-bold ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2"><?php echo e((isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : $opc->country_code).', '.$opc->city); ?></span></p>
						
					</div>
				</div>
				<div class="card-block p-4">
					<a href="/cards/<?php echo e($opc->id); ?>" class="text-decoration-none" style="color:unset">
						<div class="row m-0 p-0 ">
							<div class="w-100 profile_pitch">
								<h3 class="font-weight-bold ellipsis" onclick="toggleEllipsis(this)"><?php echo e($opc->title); ?></h3>
								<p class="ellipsis" onclick="toggleEllipsis(this)"><?php echo e(strlen(nl2br(strip_tags($opc->description))) > 75 ? substr(nl2br(strip_tags($opc->description)),0,75).'...' : nl2br(strip_tags($opc->description))); ?></p>
								
							</div>
						</div>

						<div class="row m-0 p-0 ">
							<div class="w-100 profile_pitch">
								<h3 class="font-weight-bold opt_roles_font">Requested skills</h3>
								<ul class="list-unstyled list-inline margin-0-auto mb-0 request_skills">
									<?php $__currentLoopData = json_decode($opc->fields,true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $oc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<li class="list-inline-item mr-0 pr-2 pb-2" style="margin:0px">
										<div class="chip bgcolor-purple mr-0 chip-custom"><?php echo e($oc); ?></div>
									</li>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
								</ul>
							</div>
						</div>	
					</a>
					<div class="row m-0 p-0 ">
						<div class="w-100 m-0 p-0">	
						<?php if(!$third_person): ?>		

							<a href="/cards/<?php echo e($opc->id); ?>/edit" class="textcolor-blue pull-right pl-2"><img src="/assets/images/Icon-edit.svg" alt="Edit" style="width:25px;"><span class="pl-2">Edit</span></a>
						<?php endif; ?>
							<a href="/cards/<?php echo e($opc->id); ?>"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2"  style="color: #219BC4">Read more</a>
							<?php if($third_person): ?>	
								
									<a href="#"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2" data-toggle="dropdown"  style="color: #219BC4">Send my open-to-work</a>
									<div class="dropdown-menu dropdown-menu-right"  style="padding: 0px;">
										<?php if(count($opentowork_card) > 0): ?> 
											<ul style="margin: 0px;padding: 0px;">
												<?php $__currentLoopData = $opentowork_card; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<li class="list-unstyled send_opentowork"><a href="<?php echo e(URL::to('/')); ?>/opentowork/<?php echo e($item->id); ?>"><?php echo e($item->title); ?></a></li>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													<li class="list-unstyled send_opentowork"><a href="<?php echo e(URL::to('/')); ?>/opentowork/<?php echo e($opc->id); ?>/refer">Create New one</a></li>
											</ul>
										<?php else: ?>
											<li class="list-unstyled send_opentowork"><a href="<?php echo e(URL::to('/')); ?>/opentowork/<?php echo e($opc->id); ?>/refer">Create New one</a></li>
										<?php endif; ?>
									</div>

									<a href="#" data-pk="<?php echo e($opc->id); ?>" data-type="checklist" data-source="<?php echo e(URL::to('/')); ?>/ajax/get_opc_collection_list/<?php echo e($opc->id); ?>"  data-title="Select collections" class="opportunity_collection editable editable-click  float-right  text-decoration-none textcolor-blue pr-2 pl-2" data-placement="bottom"   data-original-title="" title="">Add to collection</a>   
													
							<?php endif; ?>	
						</div>
					</div>
				</div>
			</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
			<!-- Add Opportunity -->
			<?php if(!$third_person && ($user->looking_for == 2 || $user->looking_for == 0)): ?>			
			<div class="row m-0 p-0 mt-5 display_button1">
				<p class="w-65 m-0 p-0"></p>
				<p class="w-35 m-0 p-0 text-right">
				<a href="/cards" class="btn button_create_opportunity">Create new Opportunity</a>
				</p>
			</div>
			<div class="row m-0 p-0 mt-5 display_button2">		
				<p class="w-100 m-0 p-0 text-right">
				<a href="/cards" class="btn button_create_opportunity">Create new Opportunity</a>
				</p>
			</div>
			<?php endif; ?>
			<!-- opentowork -->
			<?php if(count($opentowork_card) > 0): ?>
			<?php $__currentLoopData = $opentowork_card; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if($opc->refer): ?>
					<?php if(!$third_person): ?>
						<div class="card mt-5 mb-2">
						<div class="card-header pl-4 pr-4 color-opentowork h-100">
							<div class="row m-0 p-0 opportunity_header">
								<p class="w-50 m-0 p-0 font-weight-bold">Open-to-work</p>
								<!-- <p class="w-65 m-0 p-0 text-right font-weight-bold"><img src="/assets/images/location2.png"><span class="pl-2"><?php echo e((isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : $opc->country_code).', '.$opc->city); ?></span></p> -->
								<p class="w-50 m-0 p-0 text-right font-weight-bold ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2"><?php echo e((isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : $opc->country_code).', '.$opc->city); ?></span></p>
								
							</div>
						</div>
						<div class="card-block p-4">
							<a href="/opentowork/<?php echo e($opc->id); ?>" class="text-decoration-none" style="color:unset">
								<div class="row m-0 p-0 ">
									<div class="w-100 profile_pitch">
										<h3 class="font-weight-bold"><?php echo e($opc->title); ?></h3>
									</div>
								</div>

								<div class="row m-0 p-0 ">
									<div class="w-100 profile_pitch">
										<p></p>
										<h3 class="font-weight-bold opt_roles_font">Roles of interest</h3>
										<ul class="list-unstyled list-inline margin-0-auto mb-0 request_skills">
											<?php $__currentLoopData = json_decode($opc->roles,true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $oc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<li class="list-inline-item mr-0 pr-2 pb-2" style="margin:0px">
												<div class="chip bgcolor-purple mr-0 chip-custom"><?php echo e($oc); ?></div>
											</li>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
										</ul>
									</div>
								</div>	
							</a>
							<div class="row m-0 p-0 ">
								<div class="w-100 m-0 p-0">							
								<?php if(!$third_person): ?>		

									<a href="/opentowork/<?php echo e($opc->id); ?>/edit" class="textcolor-blue pull-right pl-2"><img src="/assets/images/Icon-edit.svg" alt="Edit" style="width:25px;"><span class="pl-2">Edit</span></a>
								<?php endif; ?>
									<a href="/opentowork/<?php echo e($opc->id); ?>"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2"  style="color: #219BC4">Read more</a>
								<?php if($third_person): ?>	
									
										<a href="#" class=" float-right  text-decoration-none textcolor-blue pr-2 pl-2" data-toggle="dropdown">Send my opportunity</a>    
																
										<div class="dropdown-menu dropdown-menu-right"  style="padding: 0px;">
										<?php if(count($opportunity_cards) > 0): ?> 
											<ul style="margin: 0px;padding: 0px;">
												<?php $__currentLoopData = $opportunity_cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<li class="list-unstyled send_opentowork"><a href="<?php echo e(URL::to('/')); ?>/cards/<?php echo e($item->id); ?>"><?php echo e($item->title); ?></a></li>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													<li class="list-unstyled send_opentowork"><a href="<?php echo e(URL::to('/')); ?>/cards/<?php echo e($opc->id); ?>/refer">Create New one</a></li>
											</ul>
										<?php else: ?>
											<li class="list-unstyled send_opentowork"><a href="<?php echo e(URL::to('/')); ?>/cards/<?php echo e($opc->id); ?>/refer">Create New one</a></li>
										<?php endif; ?>
										</div>

										<a href="#" data-pk="<?php echo e($opc->id); ?>" data-type="checklist" data-source="<?php echo e(URL::to('/')); ?>/ajax/get_opc_collection_list/<?php echo e($opc->id); ?>"  data-title="Select collections" class="opportunity_collection editable editable-click  float-right  text-decoration-none textcolor-blue pr-2 pl-2" data-placement="bottom"   data-original-title="" title="">Add to collection</a>   
														
								<?php endif; ?>
									
								</div>
							</div>
						</div>
					</div>
					<?php endif; ?>
				<?php else: ?>
				<div class="card mt-5 mb-2">
					<div class="card-header pl-4 pr-4 color-opentowork h-100">
						<div class="row m-0 p-0 opportunity_header">
							<p class="w-50 m-0 p-0 font-weight-bold">Open-to-work</p>
							<!-- <p class="w-65 m-0 p-0 text-right font-weight-bold"><img src="/assets/images/location2.png"><span class="pl-2"><?php echo e((isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : $opc->country_code).', '.$opc->city); ?></span></p> -->
							<p class="w-50 m-0 p-0 text-right font-weight-bold ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2"><?php echo e((isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : $opc->country_code).', '.$opc->city); ?></span></p>
							
						</div>
					</div>
					<div class="card-block p-4">
						<a href="/opentowork/<?php echo e($opc->id); ?>" class="text-decoration-none" style="color:unset">
							<div class="row m-0 p-0 ">
								<div class="w-100 profile_pitch">
									<h3 class="font-weight-bold"><?php echo e($opc->title); ?></h3>
								</div>
							</div>

							<div class="row m-0 p-0 ">
								<div class="w-100 profile_pitch">
									<p></p>
									<h3 class="font-weight-bold opt_roles_font">Roles of interest</h3>
									<ul class="list-unstyled list-inline margin-0-auto mb-0 request_skills">
										<?php $__currentLoopData = json_decode($opc->roles,true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $oc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<li class="list-inline-item mr-0 pr-2 pb-2" style="margin:0px">
											<div class="chip bgcolor-purple mr-0 chip-custom"><?php echo e($oc); ?></div>
										</li>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
									</ul>
								</div>
							</div>	
						</a>
						<div class="row m-0 p-0 ">
							<div class="w-100 m-0 p-0">							
							<?php if(!$third_person): ?>		

								<a href="/opentowork/<?php echo e($opc->id); ?>/edit" class="textcolor-blue pull-right pl-2"><img src="/assets/images/Icon-edit.svg" alt="Edit" style="width:25px;"><span class="pl-2">Edit</span></a>
							<?php endif; ?>
								<a href="/opentowork/<?php echo e($opc->id); ?>"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2"  style="color: #219BC4">Read more</a>
							<?php if($third_person): ?>	
								
									<a href="#" class=" float-right  text-decoration-none textcolor-blue pr-2 pl-2" data-toggle="dropdown">Send my opportunity</a>    
															
									<div class="dropdown-menu dropdown-menu-right"  style="padding: 0px;">
									<?php if(count($opportunity_cards) > 0): ?> 
										<ul style="margin: 0px;padding: 0px;">
											<?php $__currentLoopData = $opportunity_cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<li class="list-unstyled send_opentowork"><a href="<?php echo e(URL::to('/')); ?>/cards/<?php echo e($item->id); ?>"><?php echo e($item->title); ?></a></li>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
												<li class="list-unstyled send_opentowork"><a href="<?php echo e(URL::to('/')); ?>/cards/<?php echo e($opc->id); ?>/refer">Create New one</a></li>
										</ul>
									<?php else: ?>
										<li class="list-unstyled send_opentowork"><a href="<?php echo e(URL::to('/')); ?>/cards/<?php echo e($opc->id); ?>/refer">Create New one</a></li>
									<?php endif; ?>
									</div>

									<a href="#" data-pk="<?php echo e($opc->id); ?>" data-type="checklist" data-source="<?php echo e(URL::to('/')); ?>/ajax/get_opc_collection_list/<?php echo e($opc->id); ?>"  data-title="Select collections" class="opportunity_collection editable editable-click  float-right  text-decoration-none textcolor-blue pr-2 pl-2" data-placement="bottom"   data-original-title="" title="">Add to collection</a>   
													
							<?php endif; ?>
								
							</div>
						</div>
					</div>
				</div>
				<?php endif; ?>	
				

			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
			<?php endif; ?>
			<!-- Add opentowork -->
			<?php if(!$third_person && ($user->looking_for == 1 || $user->looking_for == 0)): ?>		
			<div class="row m-0 p-0 mt-5 display_button1">
				<p class="w-65 m-0 p-0"></p>
				<p class="w-35 m-0 p-0 text-right">
				<a href="/opentowork" class="btn button_create_opportunity color-opentowork">Create new Open-to-work</a>
				</p>
			</div>	
			<div class="row m-0 p-0 mt-5 display_button2">
				<p class="w-100 m-0 p-0 text-right">
				<a href="/opentowork" class="btn button_create_opportunity color-opentowork">Create new Open-to-work</a>
				</p>
			</div>	
			<?php endif; ?>
			<div class="mt-5"></div>	
			<?php if($third_person): ?>
			<p class="text-center">
            	<a onclick="window.history.back();" ckass="cusor_pointer"><img src='/assets/images/back_arrow_round.svg' alt='Back' ></a>
			</p>
			<?php endif; ?>	
			<div class="alert alert-secondary m-0 p-0 p-4 mb-5" role="alert" style="background:#fff;border-radius:10px;">
			Still unsure on what to do? Go to the <a href="/oportunity_guide" style="color:#219BC4;">Opportunity seeker guide</a> if you are looking for job opportunities and go to the <a href="/opentowork_guide" style="color:#219BC4;">Talent seeker guide</a> if you are looking to recruit talents.
				<!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              	</button> -->
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\XAMPP7.4\htdocs\growyspace 2.0\resources\views/user/my_account.blade.php ENDPATH**/ ?>