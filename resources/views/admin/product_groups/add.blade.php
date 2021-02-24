@extends('layouts.admin')
@section('content')

	<!-- BEGIN Breadcrumb -->
<div id="breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="fa fa-home"></i>
			<a href="{{ URL::to('/auto-turbo-admin/dashboard/') }}">Home</a>
			<span class="divider"><i class="fa fa-angle-right"></i></span>
		</li>
		<li class="active">Add Product Group</li>
	</ul>
</div>
<!-- END Breadcrumb -->
<div class="row">
	<div class="col-md-12">
		<div class="box">
			
			<div class="box-content">
				{!! Form::open(['url' => '/auto-turbo-admin/product_groups/', 'method' => 'POST', 'route' => ['product_groups.store']]) !!}
				<div action="#" class="form-horizontal">
					<div class="form-group">
					    <label class="col-sm-3 col-lg-2 control-label">Group Name</label>
					    <div class="col-sm-9 col-lg-10 controls">
							<input type="text" placeholder="Group Name" name="group_name" value="" class="form-control">
					    </div>
					</div>
					<div class="form-group">
					    <label class="col-sm-3 col-lg-2 control-label">Price</label>
					    <div class="col-sm-9 col-lg-10 controls">
							<input type="text" placeholder="Group Price" name="group_price" value="" class="form-control">
					    </div>
					</div>
					<div class="form-group">
					    <label class="col-sm-3 col-lg-2 control-label">Exchange Price</label>
					    <div class="col-sm-9 col-lg-10 controls">
							<input type="text" placeholder="Exchange Price" name="group_price2" value="" class="form-control">
					    </div>
					</div>
					<h2 style="text-align:center;">Group Items</h2>
	
					<div style="border:1px dotted #000;padding:10px;margin:10px;" class="product_group_items_block">
						@if(old('group_item') !== null)
							@foreach(old('group_item') as $item)
						
								<div class="form-group product_group_item">
									<label class="col-sm-3 col-lg-2 control-label"></label>
									<div class="col-sm-9 col-lg-10 controls">
										<div class="input-group">
											<input style="width:400px;margin-right:10px;" name="group_item[]" type="text" value="{{ $item }}" placeholder="Group Item" class="form-control">
											<span class="pull-left input-group-btn">
												<button class="btn btn-danger delete_product_group_item" type="button">Delete</button>
											</span>
										</div>
									</div>
								</div>
							@endforeach
						@else
							
						@endif
								
					</div>
					<div class="form-group">
						<label class="col-sm-3 col-lg-2 control-label"></label>
						<div class="col-sm-9 col-lg-10 controls">
							<div class="input-group">
								
									<button class="btn btn-success add_product_group_item_btn" type="submit">Add Group Item</button>
							
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
						   <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
						</div>
					</div>
					
					
				</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
<div class="form-group product_group_item product_group_item_ hidden">
	<label class="col-sm-3 col-lg-2 control-label"></label>
	<div class="col-sm-9 col-lg-10 controls">
		<div class="input-group">
			<input style="width:400px;margin-right:10px;" name="group_item[]" type="text" placeholder="Group Item" class="form-control">
			<span class="pull-left input-group-btn">
				<button class="btn btn-danger delete_product_group_item" type="button">Delete</button>
			</span>
		</div>
	</div>
</div>
@endsection
