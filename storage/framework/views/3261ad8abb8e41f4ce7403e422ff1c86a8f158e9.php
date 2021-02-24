<?php if($opportunity_cards !== null && $opportunity_cards->count() > 0): ?>
	<?php $__currentLoopData = $opportunity_cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<div data-opt-id="<?php echo e($opc->id); ?>" class="search_user_block filter_oppbox">
		<div class="card mb-4">
			<div class="card-header pl-4 pr-4 color-oppportunity h-100">
				<div class="row m-0 p-0 opportunity_header">
					<p class="w-50 m-0 p-0 font-weight-bold">Opportunity</p>
					<p class="w-50 m-0 p-0 text-right font-weight-bold ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2"><?php echo e((isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : $opc->country_code).', '.$opc->city); ?></span></p>
					
				</div>
			</div>
			<div class="card-block p-4">
				<a href="/cards/<?php echo e($opc->id); ?>" class="text-decoration-none" style="color:unset">
					<div class="row m-0 p-0 ">
						<div class="w-100 profile_pitch">
							<h3 class="font-weight-bold"><?php echo e($opc->title); ?></h3>
							<p><?php echo e(strlen($opc->description) > 75 ? substr($opc->description,0,75).'...' : $opc->description); ?></p>
							
						</div>
					</div>
					<div class="row m-0 p-0 mb-4">
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

						<div>
							<a href="#" class="float-right text-decoration-none textcolor-blue pl-2 opt_align_mobile" style="color: #CA7073 !important" data-toggle="dropdown" >Delete from collection</a>  
										
							<div class="dropdown-menu dropdown-menu-right"  style="padding: 0px;">
								<p style="padding: 10px;">Are you sure you want to delete?</p>
								<div style="width: 90%;margin: 0 auto;padding-bottom: 10px;">
									<span class="delete_my_individual_collection cusor_pointer" style="color: #CA7073;" collection_id="<?php echo e($collection_id); ?>" item_type="opportunity" item_id="<?php echo e($opc->id); ?>">Delete</span> <span class="cusor_pointer" style="float: right;color: #219BC4;">Back</span>
								</div>	

							</div>
						</div>						
					<?php endif; ?>
						<a href="/cards/<?php echo e($opc->id); ?>"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2 opt_align_mobile"  style="color: #219BC4">Read more</a>

						<div>
							<a href="#"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2 opt_align_mobile" data-toggle="dropdown"  style="color: #219BC4">Send my open-to-work</a>
							<div class="dropdown-menu dropdown-menu-right"  style="padding: 0px;">
								<?php if(count($opt_list) > 0): ?> 
									<ul style="margin: 0px;padding: 0px;">
										<?php $__currentLoopData = $opt_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<li class="list-unstyled send_opentowork"><a onclick="gotoChatWithOPT(<?php echo e($opc->user_id); ?>, <?php echo e($item->id); ?>)" class="cusor_pointer"><?php echo e($item->title); ?> - <?php echo e(json_decode($item->fields,true)[0]); ?></a></li>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											<li class="list-unstyled send_opentowork"><a href="<?php echo e(URL::to('/')); ?>/opentowork/<?php echo e($opc->id); ?>/refer">Create New one</a></li>
									</ul>
								<?php else: ?>
									<li class="list-unstyled send_opentowork"><a href="<?php echo e(URL::to('/')); ?>/opentowork/<?php echo e($opc->id); ?>/refer">Create New one</a></li>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php if($opentowork_cards !== null && $opentowork_cards->count() > 0): ?>
	<?php $__currentLoopData = $opentowork_cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<div data-opt-id="<?php echo e($opc->id); ?>" class="search_user_block filter_oppbox">
		<div class="card mb-4">
			<div class="card-header pl-4 pr-4 color-opentowork h-100">
				<div class="row m-0 p-0 opportunity_header">
					<p class="w-50 m-0 p-0 font-weight-bold">Open-to-work</p>
					<p class="w-50 m-0 p-0 text-right font-weight-bold ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2"><?php echo e((isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : $opc->country_code).', '.$opc->city); ?></span></p>
					
				</div>
			</div>
			<div class="card-block p-4">
				<a href="/opentowork/<?php echo e($opc->id); ?>" class="text-decoration-none" style="color:unset">
					<div class="row m-0 p-0 ">
						<div class="w-100 profile_pitch">
							<h3 class="font-weight-bold"><?php echo e(strlen($opc->title) > 75 ? substr($opc->title,0,75).'...' : $opc->title); ?></h3>
						</div>
					</div>
					<div class="row m-0 p-0 mb-4">
						<div class="w-100 profile_pitch">
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

						<div>
							<a href="#" class="float-right text-decoration-none textcolor-blue pl-2 opt_align_mobile" style="color: #CA7073 !important" data-toggle="dropdown" >Delete from collection</a>  
										
							<div class="dropdown-menu dropdown-menu-right"  style="padding: 0px;">
								<p style="padding: 10px;">Are you sure you want to delete?</p>
								<div style="width: 90%;margin: 0 auto;padding-bottom: 10px;">
									<span class="delete_my_individual_collection cusor_pointer" style="color: #CA7073 !important;" collection_id="<?php echo e($collection_id); ?>" item_type="opentowork" item_id="<?php echo e($opc->id); ?>">Delete</span> <span class="cusor_pointer" style="float: right;color: #219BC4;">Back</span>
								</div>	

							</div>
						</div>						
					<?php endif; ?>
						<a href="/opentowork/<?php echo e($opc->id); ?>"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2 opt_align_mobile"  style="color: #219BC4 !important">Read more</a>

						<div>
						
							<a href="#" class=" float-right  text-decoration-none textcolor-blue pr-2 pl-2 opt_align_mobile" data-toggle="dropdown">Send my opportunity</a>    
													
							<div class="dropdown-menu dropdown-menu-right"  style="padding: 0px;">
							<?php if(count($opc_list) > 0): ?> 
								<ul style="margin: 0px;padding: 0px;">
									<?php $__currentLoopData = $opc_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<li class="list-unstyled send_opentowork"><a class="cusor_pointer" onclick="gotoChatWithCard(<?php echo e($opc->user_id); ?>, <?php echo e($item->id); ?>)" ><?php echo e($item->title); ?> - <?php echo e(json_decode($item->fields,true)[0]); ?></a></li>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<li class="list-unstyled send_opentowork"><a href="<?php echo e(URL::to('/')); ?>/cards/<?php echo e($opc->id); ?>/refer">Create New one</a></li>
								</ul>
							<?php else: ?>
								<li class="list-unstyled send_opentowork"><a href="<?php echo e(URL::to('/')); ?>/cards/<?php echo e($opc->id); ?>/refer">Create New one</a></li>
							<?php endif; ?>
							</div>
						</div>
																
					
						
					</div>
				</div>
			</div>
		</div>						
	</div>	
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php if($users !== null && $users->count() > 0): ?> 
	<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<div data-opt-id="<?php echo e($u->id); ?>" class="search_user_block filter_oppbox">
		<div class="card mb-4">
			<div class="card-header pl-4 pr-4 color-user h-100">
				<div class="row m-0 p-0 opportunity_header">
					<p class="w-50 m-0 p-0 font-weight-bold">User</p>
					<p class="w-50 m-0 p-0 text-right font-weight-bold ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2"><?php echo e(isset($countries[$u->country_code]) ? $countries[$u->country_code] : $u->country_code); ?>, <?php echo e($u->city); ?></span></p>
					
				</div>
			</div>
			<div class="card-block p-4">
					<a href="<?php echo e(URL::to('/')); ?>/user/<?php echo e($u->id); ?>/view" style="color: unset;">
						<div class="row m-0 p-0 profile_picture">
							<div class="profile_img">
						<?php if(is_file(base_path() . '/public/uploads/profile/'.$u->id.'/'.$u->profile_image_cropped)): ?>
							<img src="<?php echo e(URL::to('/')); ?>/<?php echo e('uploads/profile/'.$u->id.'/'.$u->profile_image_cropped); ?>" class="img-fluid pull-left" >
						<?php else: ?>
							
							<img  src="<?php echo e(URL::to('/')); ?>/assets/images/noprofileIMG.png" class="img-fluid pull-left" />
						<?php endif; ?>
							</div>
							<div class="w-75 profile_name pull-left">

								<h3 class="font-weight-bold"><?php echo e($u->full_name); ?></h3>
								<h3 ><?php echo e($u->profession); ?></h3>
								
							</div>
						</div>
					</a>
					<div class="row m-0 p-0 ">
						<div class="w-100 m-0 p-0">						
							<?php if(!$third_person): ?>	

							<div>
								<a href="#" class="float-right text-decoration-none textcolor-blue pl-2 opt_align_mobile" style="color: #CA7073 !important" data-toggle="dropdown" >Delete from collection</a>  
											
								<div class="dropdown-menu dropdown-menu-right"  style="padding: 0px;">
									<p style="padding: 10px;">Are you sure you want to delete?</p>
									<div style="width: 90%;margin: 0 auto;padding-bottom: 10px;">
										<span class="delete_my_individual_collection cusor_pointer" style="color: #CA7073;" collection_id="<?php echo e($collection_id); ?>" item_type="user" item_id="<?php echo e($u->id); ?>">Delete</span> <span class="cusor_pointer" style="float: right;color: #219BC4 !important">Back</span>
									</div>	

								</div>
							</div>						
							<?php endif; ?>


											
							<a href="/messages/<?php echo e($u->id); ?>" class="text-decoration-none textcolor-blue float-right pl-2 pr-2 opt_align_mobile">Send a message</a>
						
							<a href="<?php echo e(URL::to('/')); ?>/user/<?php echo e($u->id); ?>/view"  class="float-right text-decoration-none textcolor-blue pr-2 opt_align_mobile" >Go to profile</a> 
						</div>
					</div>


			</div>

		</div>						
	</div>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php if($users->count() == 0 && $opportunity_cards->count() == 0  && $opentowork_cards->count() == 0): ?> 
	<div class="alert alert-secondary m-0 p-0 p-4 " role="alert" style="background:#fff;">
	Go to <a href="/search" class="color_a">Explore</a> to add items to this collection. 
		<!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button> -->
	</div>
<?php endif; ?><?php /**PATH F:\XAMPP7.4\htdocs\growyspace 2.0\resources\views/collections/items.blade.php ENDPATH**/ ?>