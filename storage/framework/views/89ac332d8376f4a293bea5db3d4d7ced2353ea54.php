<?php $__env->startSection('content'); ?>
	<div class="row m-0 bg-gray">
		<div class="col-md-12 head_logo_area mt-5">
			<div class="head_logo">		
			<img src='/assets/images/redesign-collections 5.svg' alt='explore' class="pull-left" style="width:30px;"><h3 class="pull-left" >Collections</h3>
			</div>
			<div class="pull-left ml-3">
				<a onclick="window.history.back();" class="cusor_pointer display_image1"><img src="/assets/images/Frame 6.svg" alt="Back" ></a>
			</div>
		</div>

		<div class="col-md-10 mx-auto mt-4">

			<div class="row m-0 p-0">
				<div class="col-md-4 m-0 p-0 collection_list">
				<?php $__currentLoopData = $collections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $collection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				
					<div class="card text-black bg-white mb-3 explore_card collection_item_block" data-col-id="<?php echo e($collection->id); ?>" data-col-name="<?php echo e(base64_encode($collection->name)); ?>">
						<div class="card-body">
							<p class="card-title m-0 p-0 card-title font-weight-bold"><?php echo e($collection->name); ?></p>
							<?php if($collection->user_id == $user_id): ?>		
							<a href="<?php echo e(URL::to('/')); ?>/user/collection/<?php echo e($collection->id); ?>" data-col-id="<?php echo e($collection->id); ?>" data-col-name="<?php echo e(base64_encode($collection->name)); ?>" class="editIcon float-right edit_collection_link" style="position: absolute; right: 5%;top: 10%;"> <img src="/assets/images/Icon-edit.svg" style="width:30px;"></a>		
							<?php endif; ?>
						
							<div class="card-title m-0 p-0 card-title font-weight-bold mt-3 mb-1">Created by: <a href="<?php echo e(URL::to('/')); ?>/user/<?php echo e($collection->user_id); ?>/view" class="textcolor-blue pl-2" ><?php echo e($username); ?></a></div>

							<div class="w-100 m-0 p-0">													
								<a href="#" data-type="text"  data-title="Copy this link to share" class="editable editable-click  float-right  text-decoration-none textcolor-blue collection_share" data-placement="bottom" data-original-title="" title="" data-value="<?php echo e(URL::to('/')); ?>/collections/<?php echo e($collection->id); ?>#">Share</a>
							</div>
						</div>
					</div>
			
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<a href="<?php echo e(URL::to('/')); ?>/user/collection/" class="text-decoration-none text-dark bg-white">
						<div class="w-100 text-center font-weight-bold pt-2 pb-2 text-black bg-white explore_card mb-3">
								Create new collection
						</div>
					</a>

				</div>
				<!-- result-->
				<div class="explore_result col-md-8 m-0 p-0 pl-3 collection_items_block">

				</div>

			</div>
			<div class="mt-5"></div>		
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\XAMPP7.4\htdocs\growyspace 2.0\resources\views/collections/index.blade.php ENDPATH**/ ?>