<?php $__env->startSection('content'); ?> 
<div class="row m-0 bg-gray">
    <div class="col-md-12">

    </div>

    <div class="col-md-8 mx-auto" >
        
        <!-- opportunity -->
        <div class="card mt-5 mb-2 bgcolor-e1e3dd">
        <?php if($user_id): ?>
        <a onclick="window.history.back();" class="left_back mb-1 cusor_pointer display_image1"><img src="/assets/images/Frame 6.svg" alt="Back" ></a>
        <a onclick="window.history.back();" class="left_back cusor_pointer display_image2"><img src="/assets/images/backformobile.svg" alt="Back" ></a>
        <?php endif; ?>
            <div class="card-header pl-4 pr-4 color-oppportunity h-100">
                <div class="row m-0 p-0 opportunity_header">
                    <p class="w-65 m-0 p-0 font-weight-bold">Opportunity</p>
                    <p class="w-35 m-0 p-0 text-right font-weight-bold">
                    <?php if(!$third_person): ?>
                        <a href="<?php echo e(URL::to('/')); ?>/cards/<?php echo e($opc->id); ?>/edit" class="text-decoration-none text-white"> <img src="/assets/images/Icon-edit.svg" style="width:30px;"><span class="pl-2">Edit</span></a>
                    <?php endif; ?>
                    </p>
                    
                </div>
            </div>
            <div class="card-block p-4">
                <div class="row m-0 p-0 ">
                    <div class="w-100 profile_pitch ">
                        <h3 class="font-weight-bold " onclick="toggleEllipsis(this)"><?php echo e($opc->title); ?></h3>
                        <p class="" onclick="toggleEllipsis(this)"><?php echo e($opc->company); ?></p>
                        <!-- <p><img src="/assets/images/location.png" alt="Location" > <span class="pl-2"><?php echo e($opc->city); ?>, <?php echo e(isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : ''); ?> </span></p> -->
                        <p class="" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span> <span class="pl-2"><?php echo e($opc->city); ?>, <?php echo e(isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : ''); ?> </span></p>
                    </div>
                </div>
                <div class="row m-0 p-0 ">
                    <div class="w-100 profile_pitch ">
                        <h3 class="font-weight-bold">Requested skills</h3>
                        <ul class="list-unstyled list-inline margin-0-auto mb-0 request_skills">
                            <?php $__currentLoopData = $opc_fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $oc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-inline-item mr-0 pr-2 pb-2" style="margin:0px">
                                <div class="chip bgcolor-purple mr-0 chip-custom"><?php echo e($oc); ?></div>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
                        </ul>
                    </div>
                </div>	
                <div class="row m-0 p-0 ">
                    <div class="w-100 profile_pitch">
                        <h3 class="font-weight-bold">Description</h3>
                        <p><?php echo nl2br(strip_tags($opc->description)); ?></p>
                        
                    </div>
                </div>



                <div class="row m-0 p-0 ">
					<?php if($user_id): ?>	
						<div class="w-100 m-0 p-0">	
							<a href="<?php echo e(URL::to('/')); ?>/user/<?php echo e($opc->user_id); ?>/view" class="text-decoration-none textcolor-blue pull-right pl-2 opt_align_mobile">Go to user profile</a>
							<a href="#" data-pk="<?php echo e($opc->id); ?>" data-type="checklist" data-source="<?php echo e(URL::to('/')); ?>/ajax/get_opc_collection_list/<?php echo e($opc->id); ?>"  data-title="Select collections" class="opportunity_collection editable editable-click  float-right  text-decoration-none textcolor-blue pr-2 pl-2 opt_align_mobile" data-placement="bottom"   data-original-title="" title="" data-send="auto">Add to collection</a>   

							<a href="#" id="opportunity_share" data-type="text" data-title="Copy this link to share" class="editable editable-click  float-right  text-decoration-none textcolor-blue  pr-2 pl-2 opt_align_mobile" data-placement="bottom" data-original-title="" title="" data-value="<?php echo e(URL::to('/')); ?>/cards/<?php echo e($opc->id); ?>#">Share</a> 

						<?php if(!$third_person): ?>		

							<!-- <a href="#" id="opportunity_findmatch" data-type="select" data-value="Not selected" data-title="Find Matches" class="editable editable-click  float-right  text-decoration-none textcolor-blue pr-2 pl-2" data-placement="bottom"  data-original-title="" title="" style="color: #E1E3DD;">Find Matches</a> -->
						<?php else: ?>
							<a href="#"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2 opt_align_mobile" data-toggle="dropdown"  style="color: #219BC4">Send my open-to-work</a>
							<div class="dropdown-menu dropdown-menu-right"  style="padding: 0px;">
								<?php if(count($opc_list) > 0): ?> 
									<ul style="margin: 0px;padding: 0px;">
										<?php $__currentLoopData = $opc_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<li class="list-unstyled send_opentowork"><a href="<?php echo e(URL::to('/')); ?>/messages/<?php echo e($item->user_id); ?>"><?php echo e($item->title); ?> - <?php echo e(json_decode($item->fields,true)[0]); ?></a></li>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											<li class="list-unstyled send_opentowork"><a href="<?php echo e(URL::to('/')); ?>/opentowork/<?php echo e($opc->id); ?>/refer">Create New one</a></li>
									</ul>
								<?php else: ?>
									<li class="list-unstyled send_opentowork"><a href="<?php echo e(URL::to('/')); ?>/opentowork/<?php echo e($opc->id); ?>/refer">Create New one</a></li>
								<?php endif; ?>
							</div>
						<?php endif; ?>
                    </div>
					<?php else: ?>
                  
                    <a href="/user/login"  class="w-100 text-decoration-none textcolor-blue pull-right pr-2 pl-2  opt_align_no_user_mobile"  style="color: #219BC4"  data-toggle="modal" data-target="#login_modal">Send my open-to-work</a>
                   
                    <?php endif; ?>
                </div>
            </div>
        </div>
    
        <div class="mt-5"></div>
        <p class="text-center">
        <?php if($user_id): ?>
            <a  onclick="window.history.back();" class="cusor_pointer"><img src='/assets/images/back_arrow_round.svg' alt='Back' ></a>
        <?php endif; ?>
        </p>		
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\XAMPP7.4\htdocs\growyspace 2.0\resources\views/opportunity_card.blade.php ENDPATH**/ ?>