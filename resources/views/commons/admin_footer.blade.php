
<input type="hidden" class="_token" value="{!! csrf_token() !!}" />
<!--basic scripts-->
<script src="{{ URL::to('/') }}/admin/assets/jquery/jquery-2.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>



<script src="{{ URL::to('/') }}/admin/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="{{ URL::to('/') }}/admin/assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="{{ URL::to('/') }}/admin/assets/jquery-cookie/jquery.cookie.js"></script>
<script src="{{ URL::to('/') }}/admin/assets/magnific-popup/jquery.magnific-popup.js"></script>

<!--page specific plugin scripts-->
<script src="{{ URL::to('/') }}/admin/assets/flot/jquery.flot.js"></script>
<script src="{{ URL::to('/') }}/admin/assets/flot/jquery.flot.resize.js"></script>
<script src="{{ URL::to('/') }}/admin/assets/flot/jquery.flot.pie.js"></script>
<script src="{{ URL::to('/') }}/admin/assets/flot/jquery.flot.stack.js"></script>
<script src="{{ URL::to('/') }}/admin/assets/flot/jquery.flot.crosshair.js"></script>
<script src="{{ URL::to('/') }}/admin/assets/flot/jquery.flot.tooltip.min.js"></script>
<script src="{{ URL::to('/') }}/admin/assets/sparkline/jquery.sparkline.min.js"></script>
<script src="{{ URL::to('/') }}/admin/assets/dropzone/dropzone.js"></script>
<script src="{{ URL::to('/') }}/admin/assets/notify/notify.js"></script>
<script src="{{ URL::to('/') }}/admin/assets/treeview/jquery.treeview.js"></script>

<script src="{{ URL::to('/') }}/admin/assets/jquery-knob/jquery.knob.js"></script>

<script type="text/javascript" src="{{ URL::to('/') }}/admin/assets/chosen-bootstrap/chosen.jquery.min.js"></script>

<!--page specific plugin scripts-->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.js"></script>
<!--flaty scripts-->
<script src="{{ URL::to('/') }}/admin/js/flaty.js"></script>
<script src="{{ URL::to('/') }}/admin/js/flaty-demo-codes.js"></script>
<script src="{{ URL::to('/') }}/admin/js/main.js?time={{ time() }}"></script>
<script src="{{ URL::to('/') }}/admin/js/dropzone_init.js"></script>



@if (count($errors) > 0)
	<script type="text/javascript">
		@foreach ($errors->all() as $key =>  $error)
			$.notify("{{ $error }}", "error");
		@endforeach
	</script>
@endif

@if(session('message')) 
<script type="text/javascript">
	jQuery(window).load(function(){
		$.notify("{{ session('message') }}", "success");
	});
</script>
@endif

</body>


</html>