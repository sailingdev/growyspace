<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>Auto-turbo Admin</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

<!--base css styles-->
<link rel="stylesheet" href="<?php echo e(URL::to('/')); ?>/admin/assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo e(URL::to('/')); ?>/admin/assets/font-awesome/css/font-awesome.min.css">

<!--page specific css styles-->

<!--flaty css styles-->
<link rel="stylesheet" href="<?php echo e(URL::to('/')); ?>/admin/css/flaty.css">
<link rel="stylesheet" href="<?php echo e(URL::to('/')); ?>/admin/css/flaty-responsive.css">

<link rel="shortcut icon" href="<?php echo e(URL::to('/')); ?>/admin/img/favicon.html">
</head>
<body class="login-page">

<!-- BEGIN Main Content -->
<div class="login-wrapper">
<!-- BEGIN Login Form -->
<form id="form-login" action="<?php echo e(route('admin.login.submit')); ?>" method="POST">
	<h3>Login to your account</h3>
	<hr/>
	<div class="form-group">
		<div class="controls">
			<input type="text" name="user_name" placeholder="username" class="form-control" />
		</div>
	</div>
	<div class="form-group">
		<div class="controls">
			<input type="password" name="password" placeholder="password" class="form-control" />
		</div>
	</div>
	<div class="form-group">
		<div class="controls">
			<label class="checkbox">
				<input type="checkbox" value="remember" /> Remember me
			</label>
		</div>
	</div>
	<div class="form-group">
	<div class="controls">
	<button type="submit" class="btn btn-primary form-control">Sign In</button>
	</div>
	</div>
	<hr/>
	<?php echo e(csrf_field()); ?>

</form>
<!-- END Login Form -->


</div>
<!-- END Main Content -->


<!--basic scripts-->
<script src="<?php echo e(URL::to('/')); ?>/admin/assets/jquery/jquery-2.1.1.min.js"></script>
<script src="<?php echo e(URL::to('/')); ?>/admin/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo e(URL::to('/')); ?>/admin/assets/notify/notify.js"></script>
<?php if(count($errors) > 0): ?>
	<script type="text/javascript">
		<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>  $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			$.notify("<?php echo e($error); ?>", "error");
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</script>
<?php endif; ?>

</body>

</html>
<?php /**PATH F:\XAMPP7.4\htdocs\growyspace 2.0\resources\views/admin/login.blade.php ENDPATH**/ ?>