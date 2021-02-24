
<input type="hidden" class="_token" value="<?php echo csrf_token(); ?>" />
<!--basic scripts-->
<script src="<?php echo e(URL::to('/')); ?>/admin/assets/jquery/jquery-2.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>



<script src="<?php echo e(URL::to('/')); ?>/admin/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo e(URL::to('/')); ?>/admin/assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo e(URL::to('/')); ?>/admin/assets/jquery-cookie/jquery.cookie.js"></script>
<script src="<?php echo e(URL::to('/')); ?>/admin/assets/magnific-popup/jquery.magnific-popup.js"></script>

<!--page specific plugin scripts-->
<script src="<?php echo e(URL::to('/')); ?>/admin/assets/flot/jquery.flot.js"></script>
<script src="<?php echo e(URL::to('/')); ?>/admin/assets/flot/jquery.flot.resize.js"></script>
<script src="<?php echo e(URL::to('/')); ?>/admin/assets/flot/jquery.flot.pie.js"></script>
<script src="<?php echo e(URL::to('/')); ?>/admin/assets/flot/jquery.flot.stack.js"></script>
<script src="<?php echo e(URL::to('/')); ?>/admin/assets/flot/jquery.flot.crosshair.js"></script>
<script src="<?php echo e(URL::to('/')); ?>/admin/assets/flot/jquery.flot.tooltip.min.js"></script>
<script src="<?php echo e(URL::to('/')); ?>/admin/assets/sparkline/jquery.sparkline.min.js"></script>
<script src="<?php echo e(URL::to('/')); ?>/admin/assets/dropzone/dropzone.js"></script>
<script src="<?php echo e(URL::to('/')); ?>/admin/assets/notify/notify.js"></script>
<script src="<?php echo e(URL::to('/')); ?>/admin/assets/treeview/jquery.treeview.js"></script>

<script src="<?php echo e(URL::to('/')); ?>/admin/assets/jquery-knob/jquery.knob.js"></script>

<script type="text/javascript" src="<?php echo e(URL::to('/')); ?>/admin/assets/chosen-bootstrap/chosen.jquery.min.js"></script>

<!--page specific plugin scripts-->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.js"></script>
<!--flaty scripts-->
<script src="<?php echo e(URL::to('/')); ?>/admin/js/flaty.js"></script>
<script src="<?php echo e(URL::to('/')); ?>/admin/js/flaty-demo-codes.js"></script>
<script src="<?php echo e(URL::to('/')); ?>/admin/js/main.js?time=<?php echo e(time()); ?>"></script>
<script src="<?php echo e(URL::to('/')); ?>/admin/js/dropzone_init.js"></script>



<?php if(count($errors) > 0): ?>
	<script type="text/javascript">
		<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>  $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			$.notify("<?php echo e($error); ?>", "error");
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</script>
<?php endif; ?>

<?php if(session('message')): ?> 
<script type="text/javascript">
	jQuery(window).load(function(){
		$.notify("<?php echo e(session('message')); ?>", "success");
	});
</script>
<?php endif; ?>

</body>


</html><?php /**PATH F:\XAMPP7.4\htdocs\growyspace 2.0\resources\views/commons/admin_footer.blade.php ENDPATH**/ ?>