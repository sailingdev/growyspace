<?php $__env->startSection('content'); ?> 
<div class="row m-0 bg-gray">

    <div class="col-md-12 head_logo_area mt-5">

        <div class="head_logo">		
            <img src='/assets/images/Icon-news.svg' alt='profile' class="pull-left" style="width:30px;"><h3 class="pull-left" >News</h3>
        </div>
        <div class="pull-left ml-3">
            <a onclick="window.history.back();" class="cusor_pointer display_image1"><img src="/assets/images/Frame 6.svg" alt="Back" ></a>
        </div>
    
    </div>

    <div class="col-md-10 mx-auto" >
        <div class="row m-0 p-0 ">
            <div class="w-100">
                <?php if(count($news) > 0): ?>
                    <div class="row w-100 m-0" style="background: #fff;">
                        <div class="w-75 p-3 pull-left ellipsis" style="color:#000;font-size:1.625rem;font-weight:bold"><?php echo e($news[0]->title); ?></div>
                        <div class="w-25 p-3 pull-left text-right ellipsis" style="color:#1C3041;font-size:1.25rem;"><?php echo e(date("D j, M, Y", strtotime($news[0]->created_at))); ?></div>

                        <div class="w-100" style="box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);">
                            <p class="pl-3"><?php echo e($news[0]->subtitle); ?><a href="<?php echo e(URL::to('/')); ?>/news/<?php echo e($news[0]->id); ?>" class="pl-2" style="color:#3170AF !important">read more</a></p> 
                        
                        </div>
                        

                        <div class="row w-100  m-0 p-3 pt-5">
                        <?php if($refined[0]['firstImg']): ?>
                            <img src="<?php echo e($refined[0]['firstImg']); ?>" class="news_img">
                            <div class="mt-2">
                                <?php echo $refined[0]['firstStr']; ?> <a href="<?php echo e(URL::to('/')); ?>/news/<?php echo e($news[0]->id); ?>" class="pl-2" style="color:#3170AF !important">read more</a>

                            </div>
                        <?php else: ?>
                            <?php echo $refined[0]['firstStr']; ?><a href="<?php echo e(URL::to('/')); ?>/news/<?php echo e($news[0]->id); ?>" class="pl-2" style="color:#3170AF !important">read more</a>
                        <?php endif; ?>                        
                        </div>                       
                    </div>

                    <div class="row mt-4">
                    <?php $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($key > 0): ?>
                        <div class="col-md-4 pull-left mt-4">
                            <div class="row w-100 m-0" style="background: #fff;">
                            <div class="w-100 p-3 pull-left ellipsis" style="color:#000;font-size:1.625rem;font-weight:bold"><?php echo e($news[$key]->title); ?></div>

                            <div class="w-100" style="box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);">
                                <p class="pl-3"><?php echo e(date("D j, M, Y", strtotime($news[$key]->created_at))); ?><a href="<?php echo e(URL::to('/')); ?>/news/<?php echo e($news[$key]->id); ?>" class="pl-2" style="color:#3170AF !important">read more</a></p> 
                            
                            </div>
                            

                            <div class="row w-100  m-0 p-3 pt-3">
                            <?php if($refined[$key]['firstImg']): ?>
                                <img src="<?php echo e($refined[0]['firstImg']); ?>" class="news_img">
                                <div class="mt-2 ">
                                    <?php echo $refined[$key]['secondStr']; ?> <a href="<?php echo e(URL::to('/')); ?>/news/<?php echo e($news[$key]->id); ?>" class="pl-2" style="color:#3170AF !important">read more</a>

                                </div>
                            <?php else: ?>
                                <div class=""><?php echo $refined[$key]['thirdStr']; ?><a href="<?php echo e(URL::to('/')); ?>/news/<?php echo e($news[$key]->id); ?>" class="pl-2" style="color:#3170AF !important">read more</a></div>
                            <?php endif; ?>                        
                            </div>                       
                        </div>                            
                        </div>
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                   

                        
                    
                <?php else: ?>
                <p>No news</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="mt-5"></div>
        <p class="text-center">
            <a  onclick="window.history.back();" class="cusor_pointer"><img src='/assets/images/back_arrow_round.svg' alt='Back' ></a>
        </p>
    </div>
    
		
  
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\XAMPP7.4\htdocs\growyspace 2.0\resources\views/news_card.blade.php ENDPATH**/ ?>