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
<link rel="stylesheet" href="{{ URL::to('/') }}/admin/assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="{{ URL::to('/') }}/admin/assets/font-awesome/css/font-awesome.min.css">

<!--page specific css styles-->

<!--flaty css styles-->
<link rel="stylesheet" href="{{ URL::to('/') }}/admin/css/flaty.css?{{ time() }}">
<link rel="stylesheet" href="{{ URL::to('/') }}/admin/css/flaty-responsive.css">

<link rel="shortcut icon" href="{{ URL::to('/') }}/admin/img/favicon.html">
</head>
<body class="login-page">

<!-- BEGIN Main Content -->
<div class="login-wrapper">
<!-- BEGIN Login Form -->
<form id="form-login" action="{{ route('admin.login.submit') }}" method="POST">
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
	{{ csrf_field() }}
</form>
<!-- END Login Form -->


</div>
<!-- END Main Content -->


<!--basic scripts-->
<script src="{{ URL::to('/') }}/admin/assets/jquery/jquery-2.1.1.min.js"></script>
<script src="{{ URL::to('/') }}/admin/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="{{ URL::to('/') }}/admin/assets/notify/notify.js"></script>
@if (count($errors) > 0)
	<script type="text/javascript">
		@foreach ($errors->all() as $key =>  $error)
			$.notify("{{ $error }}", "error");
		@endforeach
	</script>
@endif

</body>

</html>
