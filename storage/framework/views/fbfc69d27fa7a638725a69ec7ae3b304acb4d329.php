
<?php $__env->startSection('content'); ?>
	<!-- BEGIN Breadcrumb -->
<div id="breadcrumbs">
<ul class="breadcrumb">
<li>
<i class="fa fa-home"></i>
<a href="<?php echo e(URL::to('/growyspace-admin/dashboard/')); ?>">Home</a>
<span class="divider"><i class="fa fa-angle-right"></i></span>
</li>
<li class="active">Opportunity cards</li>
</ul>
</div>
<!-- END Breadcrumb -->

<!-- BEGIN Main Content -->
<div class="row">
<div class="col-md-12">
<div class="box">
<div class="box-title">
	<h3><i class="fa fa-table"></i> Opportunity cards</h3>
	<div class="box-tool">

	</div>
</div>

<div class="box-content">
	
	<br/><br/>
	<div class="clearfix"></div>
	<div class="table-responsive" style="border:0">
		<table class="opportunity_cards table" id="opportunity_cards">
			<thead>
				<tr>
					
					<th>ID</th>
					<th>Owner Name</th>
					<th>Title</th>
					<th>Company</th>
					<th>Salary</th>
					<th>Hours</th>
					<th>Country</th>
					<th>City</th>
					<th>Description</th>
					
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				
			</tbody>
		</table>
	</div>
</div>
</div>
</div>
</div>
<!-- END Main Content -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\XAMPP7.4\htdocs\growyspace 2.0\resources\views/admin/opportunity_cards/index.blade.php ENDPATH**/ ?>