<div data-opt-id="<?php echo e($opc->id); ?>" class="opp_card_block msg_block">
	<?php if(false && $opc->user_id == $user_id): ?>
	<div class="dropdown opp_card_actions_block">
		<button class="btn btn-light dropdown-toggle" type="button" id="opt<?php echo e($opc->id); ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<span class="sr-only"></span>
		</button>
		<div class="dropdown-menu dropdown-menu-right" aria-labelledby="opt<?php echo e($opc->id); ?>">
			<a class="dropdown-item" href="#"> Invite user to this card</a>
			<a data-opt-id="<?php echo e($opc->id); ?>" class="dropdown-item edit_opportunity_card_link" href=""> Edit</a>
			<a data-opt-id="<?php echo e($opc->id); ?>" class="dropdown-item delete_opportunity_card_link"> Delete</a>
		</div>
	</div>
	<?php endif; ?>
	<?php if($url == 'collections'): ?>
		<img src="/assets/images/redesign-collections 5.svg" alt="sunil" class="msg_collection_img">
		<div class="msg_collection_opp">
			<p class="m-0 p-0 ellipsis"><?php echo e($name); ?></p>
			<p class="m-0 p-0 ellipsis">Created by: <span><?php echo e($user); ?></span></p>
		</div>
		<a href="<?php echo e(URL::to('/')); ?>/<?php echo e($url); ?>/<?php echo e($opc->id); ?>" style="text-decoration: none;color: #58C0FA;font-weight: 500;font-size: 20px;float: right;padding-bottom: 15px;padding-right: 10px;padding-top: 5px;" >Go to Collection</a>

	<?php else: ?>
		<p style="font-size: 20px;font-weight: 600; margin: 0px;padding-top: 20px;padding-left: 14px;"><?php echo e($name); ?></p>
		<?php if($url == 'news'): ?>
			<p style="font-size: 18px;margin: 0px;padding-top: 18px;padding-left: 14px;" class="ellipsis"><?php echo e(strlen($opc->title) > 50 ? substr($opc->title,0,50).'...' : $opc->title); ?></p>
			<p class="location_icon ellipsis" style="margin:0px;font-size: 18px;padding-left: 14px;padding-top: 10px;"> <span class=""><?php echo e(isset($subtitle) ? $subtitle : ''); ?> </span></p>
			<a href="<?php echo e(URL::to('/')); ?>/<?php echo e($url); ?>/<?php echo e($opc->id); ?><?php echo e($url == 'user' ? '/view' : ''); ?>" style="text-decoration: none;color: #58C0FA;font-weight: 500;font-size: 20px;float: right;padding-bottom: 15px;padding-right: 10px;padding-top: 5px;">Go to <?php echo e($name); ?></a>
		<?php elseif($url == 'user'): ?>
			<p style="font-size: 18px;margin: 0px;padding-top: 18px;padding-left: 14px;" class="ellipsis"><?php echo e(strlen($opc->full_name) > 50 ? substr($opc->full_name,0,50).'...' : $opc->full_name); ?></p>

			<p class="location_icon ellipsis" style="margin:0px;font-size: 18px;padding-left: 14px;padding-top: 10px;"><img src="/assets/images/<?php echo e($msg_state == 'inbox' ? 'location.png' : 'location2.png'); ?>" alt="Location" > <span class=""><?php echo e($opc->city); ?>, <?php echo e(isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : ''); ?> </span></p>
			<a href="<?php echo e(URL::to('/')); ?>/<?php echo e($url); ?>/<?php echo e($opc->id); ?><?php echo e($url == 'user' ? '/view' : ''); ?>" style="text-decoration: none;color: #58C0FA;font-weight: 500;font-size: 20px;float: right;padding-bottom: 15px;padding-right: 10px;padding-top: 5px;">Go to <?php echo e($name); ?></a>

		<?php else: ?>
			<p style="font-size: 18px;margin: 0px;padding-top: 18px;padding-left: 14px;" class="ellipsis"><?php echo e(strlen($opc->title) > 50 ? substr($opc->title,0,50).'...' : $opc->title); ?></p>
			<p class="location_icon ellipsis" style="margin:0px;font-size: 18px;padding-left: 14px;padding-top: 10px;"><img src="/assets/images/<?php echo e($msg_state == 'inbox' ? 'location.png' : 'location2.png'); ?>" alt="Location" > <span class=""><?php echo e($opc->city); ?>, <?php echo e(isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : ''); ?> </span></p>

			<a href="<?php echo e(URL::to('/')); ?>/<?php echo e($url); ?>/<?php echo e($opc->id); ?><?php echo e($url == 'user' ? '/view' : ''); ?>" style="text-decoration: none;color: #58C0FA;font-weight: 500;font-size: 20px;float: right;padding-bottom: 15px;padding-right: 10px;padding-top: 5px;">Go to <?php echo e($name); ?></a>
			
		<?php endif; ?>
		
		
	<?php endif; ?>

<div class="clearfix"></div>
</div><?php /**PATH F:\XAMPP7.4\htdocs\growyspace 2.0\resources\views/opp_card_item.blade.php ENDPATH**/ ?>