<?php echo $__env->make('commons.admin_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- BEGIN Container -->
<div class="container" id="main-container">
	<?php echo $__env->make('commons.admin_left_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<div id="main-content">
		<?php echo $__env->yieldContent('content'); ?>
		
		<footer>
			<p><?php echo e(date('Y')); ?> Growspace.</p>
		</footer>

		<a id="btn-scrollup" class="btn btn-circle btn-lg" href="#"><i class="fa fa-chevron-up"></i></a>
	</div>
</div>
<!-- END Container -->
<?php echo $__env->make('commons.admin_footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>




<?php /**PATH F:\XAMPP7.4\htdocs\growyspace 2.0\resources\views/layouts/admin.blade.php ENDPATH**/ ?>