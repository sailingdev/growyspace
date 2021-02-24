<?php $__env->startSection('content'); ?>
<script>window.search_url = '<?php echo e($search_url); ?>';</script>
	<div class="row m-0 bg-gray">
		<div class="col-md-12 head_logo_area mt-5">
			<div class="head_logo">		
				<img src='/assets/images/icon-search-new.svg' alt='explore' class="pull-left" ><h3 class="pull-left" >Explore</h3>
			</div>
			<div class="pull-left ml-3">
				<a onclick="window.history.back();" class="cusor_pointer display_image1"><img src="/assets/images/Frame 6.svg" alt="Back" ></a>
			</div>			
		</div>

		<div class="col-md-10 mx-auto mt-5">
			<!-- search -->
			<div class="row m-0 p-0" id="search">
				<div class="col-md-7 form-group form-inline has-search m-0 p-0 search_filter_item_block_new">
					<span class="fa fa-search form-control-feedback"></span>
					<input type="text" name="search" class="form-control w-100 search_input" placeholder="Search for opportunitities, open-to-work cards or users" value="<?php echo e(isset($_GET['search']) ? $_GET['search'] : ''); ?>">
				</div>

				<div class="col-md-3 form-group form-inline p-0 m-0 has-location">
					<span class="fa fa-map-marker form-control-marker"></span>
					<select data-tags="true" data-placeholder="Type the country or city"  multiple class="opc_explore form-control w-100 search_city">
						<option value="<?php echo e($city !='' ? $city : ''); ?>" <?php echo e($city !='' ? 'selected' : ''); ?>><?php echo e($city !='' ? $city : ''); ?></option>
					</select>
				
				</div>				
				<div class="form-group form-inline col-md-2 m-0 p-0">
					<button type="submit" class="btn btn-block color-experience search search_btn padding-49">Search</button>
				</div>
			</div>

			<div class="row m-0 p-0 mt-4">
				<div class="col-md-4 m-0 p-0">
					<div class="card text-black bg-white mb-3 explore_card">
						<div class="card-body">
							<h5 class="card-title font-weight-bold">Filter</h5>

							<div class="form-check">
							<label class="form-check-label">
								<input type="radio" class="form-check-input" <?php echo e($type == 2 ? 'checked' : ''); ?> name="type"  value="2">Opportunities
							</label>
							</div>
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" class="form-check-input" <?php echo e($type == 3 ? 'checked' : ''); ?> name="type" value="3">Open-to-work
								</label>
							</div>
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" class="form-check-input" <?php echo e($type == 1 ? 'checked' : ''); ?> name="type" value="1">Users
								</label>
							</div>

						</div>
					</div>
				</div>

				<!-- result-->
				<div class="explore_result col-md-8 m-0 p-0 pl-3">
				<?php if($opportunity_cards !== null && $opportunity_cards->count() > 0): ?>
					<?php $__currentLoopData = $opportunity_cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div data-opt-id="<?php echo e($opc->id); ?>" class="search_user_block filter_oppbox">
						<div class="card mb-2">
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
									<?php if($user_id == $opc->user_id): ?>		

										<a href="/cards/<?php echo e($opc->id); ?>/edit" class="textcolor-blue pull-right pl-2 opt_align_mobile"><img src="/assets/images/Icon-edit.svg" alt="Edit" style="width:25px;"><span class="pl-2">Edit</span></a>
									<?php endif; ?>
									<?php if($user_id != $opc->user_id): ?>
										<a href="/cards/<?php echo e($opc->id); ?>"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2 opt_align_mobile"  style="color: #219BC4">Read more</a>
					
										
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

										<a href="#" data-pk="<?php echo e($opc->id); ?>" data-type="checklist" data-source="<?php echo e(URL::to('/')); ?>/ajax/get_opc_collection_list/<?php echo e($opc->id); ?>"  data-title="Select collections" class="opportunity_collection editable editable-click  float-right  text-decoration-none textcolor-blue pr-2 pl-2 opt_align_mobile" data-placement="bottom"   data-original-title="" title="">Add to collection</a>   
															
									<?php endif; ?>
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
						<div class="card mb-2">
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
									<?php if($user_id == $opc->user_id): ?>
										<a href="/opentowork/<?php echo e($opc->id); ?>/edit" class="textcolor-blue pull-right pl-2 opt_align_mobile"><img src="/assets/images/Icon-edit.svg" alt="Edit" style="width:25px;"><span class="pl-2">Edit</span></a>
									<?php endif; ?>
										<a href="/opentowork/<?php echo e($opc->id); ?>"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2 opt_align_mobile"  style="color: #219BC4">Read more</a>
										<?php if($user_id != $opc->user_id): ?>
										
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

											<a href="#" data-pk="<?php echo e($opc->id); ?>" data-type="checklist" data-source="<?php echo e(URL::to('/')); ?>/ajax/get_opentowork_collection_list/<?php echo e($opc->id); ?>"  data-title="Select collections" class="opentowork_collection editable editable-click  float-right  text-decoration-none textcolor-blue pr-2 pl-2 opt_align_mobile" data-placement="bottom"   data-original-title="" title="">Add to collection</a>   
															
									<?php endif; ?>
										
									</div>
								</div>
							</div>
						</div>						
					</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<?php endif; ?>

				<?php if($users !== null && $users->count() > 0): ?> 
					<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div data-user-id="<?php echo e($u->id); ?>" class="search_user_block filter_oppbox">
						<div class="card mb-2">
							<div class="card-header pl-4 pr-4 color-user h-100" style="height:54px !important">
								<div class="row m-0 p-0 opportunity_header hide_tablet">
									<?php if($u->looking_for == 1): ?>
										<span class="m-0 text-right " style="padding: 14px 24px 14px 15px;position: absolute;right:0px; top:0px;height: 54px;background: #65C5BF;float:right;">
											<img src="/assets/images/Icon-opportunity seeker.svg" style="width:30px;"><span class="pl-2">Opportunity Seeker</span>
										</span>
										<p class="p-0 font-weight-bold">User</p>
										<p class="pl-4 text-right font-weight-bold"><span class="fa fa-map-marker"></span><span class="pl-2"><?php echo e(isset($countries[$u->country_code]) ? $countries[$u->country_code] : $u->country_code); ?>, <?php echo e($u->city); ?></span></p>
									
									<?php elseif($u->looking_for == 2): ?>
										<span class="m-0 text-right " style="padding: 14px 24px 14px 15px;position: absolute;right:0px; top:0px;height: 54px;background: #3170AF;float:right;">
											<img src="/assets/images/Icon-talent seeker.svg" style="width:30px;"><span class="pl-2">Talent Seeker</span>
										</span>
										<p class="p-0 font-weight-bold">User</p>
										<p class="pl-4 text-right font-weight-bold"><span class="fa fa-map-marker"></span><span class="pl-2"><?php echo e(isset($countries[$u->country_code]) ? $countries[$u->country_code] : $u->country_code); ?>, <?php echo e($u->city); ?></span></p>
									<?php else: ?>

									<p class="w-35 m-0 p-0 font-weight-bold">User</p>
									<p class="w-65 m-0 p-0 text-right font-weight-bold"><span class="fa fa-map-marker"></span><span class="pl-2"><?php echo e(isset($countries[$u->country_code]) ? $countries[$u->country_code] : $u->country_code); ?>, <?php echo e($u->city); ?></span></p>
									<?php endif; ?>
								</div>
								<!-- mobile -->
								<div class="row m-0 p-0 opportunity_header show_tablet">
									<?php if($u->looking_for == 1): ?>
										<p class="w-25 m-0 p-0 font-weight-bold">User</p>
										<p class="w-50 m-0 p-0 text-right font-weight-bold ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2"><?php echo e(isset($countries[$u->country_code]) ? $countries[$u->country_code] : $u->country_code); ?>, <?php echo e($u->city); ?></span>
										</p>
										<p class="w-25 m-0 p-0 text-right ">
											<img src="/assets/images/Icon-opportunity seeker.svg" style="width:30px;">
										</p>
									
									<?php elseif($u->looking_for == 2): ?>
										<p class="w-25 m-0 p-0 font-weight-bold">User</p>
										<p class="w-50 m-0 p-0 text-right font-weight-bold ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2"><?php echo e(isset($countries[$u->country_code]) ? $countries[$u->country_code] : $u->country_code); ?>, <?php echo e($u->city); ?></span>
										</p>
										<p class="w-25 m-0 p-0 text-right ">
											<img src="/assets/images/Icon-talent seeker.svg" style="width:30px;">
										</p>

									<?php else: ?>

									<p class="w-35 m-0 p-0 font-weight-bold pull-left">User</p>
									<p class="w-65 m-0 p-0 text-right font-weight-bold pull-left ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2"><?php echo e(isset($countries[$u->country_code]) ? $countries[$u->country_code] : $u->country_code); ?>, <?php echo e($u->city); ?></span></p>
									<?php endif; ?>
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

											<h3 class="font-weight-bold ellipsis" onclick="toggleEllipsis(this)"><?php echo e($u->full_name); ?></h3>
											<h3 class="ellipsis" onclick="toggleEllipsis(this)"><?php echo e($u->profession); ?></h3>
											
										</div>
									</div>
								</a>
									<div class="row m-0 p-0 mt-3">
										<div class="w-100 m-0 p-0">						
										<?php if($user_id == $u->id): ?>				
											<a href="/user/<?php echo e($u->id); ?>/edit" class="textcolor-blue pull-right pl-2 opt_align_mobile"><img src="/assets/images/Icon-edit.svg" alt="Edit" style="width:25px;"><span class="pl-2">Edit</span></a>
										<?php endif; ?>
											
										<?php if($user_id != $u->id): ?>		
											<a href="<?php echo e(URL::to('/')); ?>/user/<?php echo e($u->id); ?>/view" class="text-decoration-none textcolor-blue float-right pl-2 opt_align_mobile">Go to profile</a>		
											<a href="/messages/<?php echo e($u->id); ?>" class="text-decoration-none textcolor-blue float-right pr-2 pl-2 opt_align_mobile">Send a message</a>
											
										<?php endif; ?>	
											<a href="#" data-pk="<?php echo e($u->id); ?>" data-type="checklist" data-source="<?php echo e(URL::to('/')); ?>/ajax/get_user_collection_list/<?php echo e($u->id); ?>"  data-title="Select collections" class="user_collection editable editable-click text-decoration-none textcolor-blue pull-right pr-2 pl-2 opt_align_mobile" data-placement="bottom"   data-original-title="" title="" style="color: #219BC4">Add to collection</a>
										</div>
									</div>
				

							</div>

						</div>						
					</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<?php endif; ?>
				<?php if($need_to_process_for_searching === true): ?>
					<?php if(
						($users == null || ($users !== null && $users->count() == 0 )  ) &&
						($opportunity_cards == null || ($opportunity_cards !== null && $opportunity_cards->count() == 0 )  ) 
						&& ($opentowork_cards == null || ($opentowork_cards !== null && $opentowork_cards->count() == 0 )  ) 
					): ?>
						<h2>No search result</h2>
					<?php endif; ?>
				<?php endif; ?>
				</div>
			</div>

			
			<div class="mt-5"></div>		
		</div>
	</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\XAMPP7.4\htdocs\growyspace 2.0\resources\views/search.blade.php ENDPATH**/ ?>