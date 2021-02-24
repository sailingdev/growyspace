<?php $__env->startSection('content'); ?>
	<!-- BEGIN Breadcrumb -->

<div id="breadcrumbs">
<ul class="breadcrumb">
<li>
<i class="fa fa-home"></i>
<a href="<?php echo e(URL::to('/auto-turbo-admin/dashboard/')); ?>">Dashboard</a>
<span class="divider"><i class="fa fa-angle-right"></i></span>
</li>
<li class="active">Users</li>
</ul>
</div>
<!-- END Breadcrumb -->

<!-- BEGIN Main Content -->
<div class="row">
<div class="col-md-12">
<div class="box">
<div class="box-title">
<h3><i class="fa fa-table"></i> Users</h3>
<div class="box-tool">

</div>
</div>
<div class="box-content">
	
	<br/><br/>
	<div class="clearfix"></div>
	<div class="table-responsive" style="border:0">
		<table class="clients_table table table-bordered" id="clients_table">
			<thead>
				<tr>
					
					<th>ID</th>
					<th>Email</th>
					<th>Full Name</th>
					<th>Is activated</th>
					<th>Licence</th>
					<th>VIP Features</th>
					<th>Unsubscribe</th>
					<th>Status</th>
					
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr>
						<td><?php echo e($client->id); ?></td>
						<td><?php echo e($client->email); ?></td>
						<td><?php echo e($client->full_name); ?></td>
						<td><?php echo e($client->verified == 1 ? 'Yes' : 'No'); ?></td>
						<!-- <td contentEditable='true' class='edit_license editMode' id='license_<?php echo e($client->id); ?>'><?php echo e($client->licence); ?></td> -->
						<td> 
                            <div class='edit_license' > <?php echo e($client->licence); ?></div> 
                            <input type='text' class='txtedit' value='<?php echo e($client->licence); ?>' style="border: 1px solid;" id='license_<?php echo e($client->id); ?>' >
                        </td>
						<td> 
							<div class="form-check">
							<input class="form-check-input" type="checkbox" onclick="updateMatchmaking(<?php echo e($client->id); ?>)" data-user=<?php echo e($client->id); ?> value="<?php echo e($client->matchmaking); ?>" id="matchmaking_<?php echo e($client->id); ?>" class="matchmaking" <?php echo e($client->matchmaking == 1 ? 'checked' : ''); ?>>
								<label class="form-check-label" for="matchmaking_<?php echo e($client->id); ?>">
									Matchmaking
								</label>
							</div>                           
                        </td>
						<td><?php echo e($client->unsubscribe == 1 ? 'Yes' : 'No'); ?></td>
						<td><?php echo e($client->is_deleted == 1 ? 'Suspended' : 'Active'); ?></td>
						
						<td>
							<?php if($client->is_deleted == 1): ?>
								<form action="<?php echo e(URL::to('/growyspace-admin/clients/'.$client->id)); ?>" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
									<input type="hidden" name="_method" value="DELETE">
									<input type="hidden" name="action" value="recover">
									<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
									<button type="submit" class="btn btn-primary btn-sm"> Recover account</button>
								</form>
							<?php else: ?>
								<form action="<?php echo e(URL::to('/growyspace-admin/clients/'.$client->id)); ?>" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
									<input type="hidden" name="_method" value="DELETE">
									<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
									<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Suspend account </button>
								</form>
							<?php endif; ?>
							
							<form action="<?php echo e(URL::to('/growyspace-admin/clients/'.$client->id)); ?>" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
								<input type="hidden" name="_method" value="DELETE">
								<input type="hidden" name="action" value="delete_permanent">
								<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
								<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Delete Permanent </button>
							</form>
							
							<?php if($client->verified == 0): ?>
								<form action="<?php echo e(URL::to('/growyspace-admin/activate_client/'.$client->id)); ?>" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
									<input type="hidden" name="_method" value="POST">
									<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
									<button type="submit" class="btn btn-primary btn-sm">Activate User </button>
								</form>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</tbody>
		</table>
	</div>
</div>
</div>
</div>
</div>
<style>

.edit_license{
    width: auto;
    height: 25px;
}
.editMode{
    border: 1px solid black !important;

}
.txtedit{
    display: none;
    width: 99%;
    height: 30px;
}

</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\XAMPP7.4\htdocs\growyspace 2.0\resources\views/admin/clients/index.blade.php ENDPATH**/ ?>