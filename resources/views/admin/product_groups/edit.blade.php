@extends('layouts.admin')
@section('content')
<script>window.product_group_id='{{ $product_group_id }}';</script>
	<!-- BEGIN Breadcrumb -->
<div id="breadcrumbs">
<ul class="breadcrumb">
<li>
	<i class="fa fa-home"></i>
	<a href="{{ URL::to('/auto-turbo-admin/dashboard/') }}">Home</a>
	<span class="divider"><i class="fa fa-angle-right"></i></span>
</li>
<li>
	<a href="{{ URL::to('/auto-turbo-admin/product_groups/') }}">Product Groups</a>
	<span class="divider"><i class="fa fa-angle-right"></i></span>
</li>
<li>{{ $pg->name }}</li>
<li class="active">Edit</li>
</ul>
</div>
<!-- END Breadcrumb -->
<div class="row">
	<div class="col-md-12">
		<div class="box">
			<div class="box-title">
				<h3><i class="fa fa-bars"></i> {{ $pg-> name }}</h3>
				<div class="box-tool">

				</div>
			</div>
			<div class="box-content">
				{!! Form::open(['url' => '/auto-turbo-admin/product_groups/' . $pg->id, 'method' => 'PUT', 'route' => ['product_groups.update']]) !!}
				<div action="#" class="form-horizontal">
					<div class="form-group">
					    <label class="col-sm-3 col-lg-2 control-label">Group Name</label>
					    <div class="col-sm-9 col-lg-10 controls">
							<input type="text" placeholder="Group Name" name="group_name" value="{{ $pg->name }}" class="form-control">
					    </div>
					</div>
					<div class="form-group">
					    <label class="col-sm-3 col-lg-2 control-label">Price</label>
					    <div class="col-sm-9 col-lg-10 controls">
							<input type="text" placeholder="Group Price" name="group_price" value="{{ $pg->price }}" class="form-control">
					    </div>
					</div>
					<div class="form-group">
					    <label class="col-sm-3 col-lg-2 control-label">Exchange Price</label>
					    <div class="col-sm-9 col-lg-10 controls">
							<input type="text" placeholder="Exchange Price" name="group_price2" value="{{ $pg->price2 }}" class="form-control">
					    </div>
					</div>
					<h2 style="text-align:center;">Group Items</h2>
	
					<div style="border:1px dotted #000;padding:10px;margin:10px;" class="product_group_items_block">
						@if(!empty($pg_items))
							@foreach($pg_items as $item)
						
								<div class="form-group product_group_item">
									<label class="col-sm-3 col-lg-2 control-label"></label>
									<div class="col-sm-9 col-lg-10 controls">
										<div class="input-group">
											<input style="width:400px;margin-right:10px;" name="group_item[]" type="text" value="{{ $item->name }}" placeholder="Group Item" class="form-control">
											<span class="pull-left input-group-btn">
												<button class="btn btn-danger delete_product_group_item" type="button">Delete</button>
											</span>
										</div>
									</div>
								</div>
							@endforeach
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
					<div  style="margin-top:60px;" class="form-group">
						<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
						   <h1 style="text-align:center;">Group Images</h1>
						</div>
					</div>
					
					<div class="form-group">
					   <label class="col-sm-3 col-lg-2 control-label">Group Images</label>
					   <div class="col-sm-9 col-lg-10 controls">
							<div class="container">
								<div class="dropzone dz-clickable" id="myDrop">
									<div class="dz-default dz-message" data-dz-message="">
										<span>Drop files here to upload</span>
									</div>
								</div>
								<input type="button" id="add_file" value="Upload file(s)" class="btn btn-primary mt-3">
							</div>
							<hr class="my-5">
							<div class="container">
								<div id="msg" class="mb-3"></div>
								<a href="javascript:void(0);" class="btn btn-outline-primary reorder" id="updateReorder">Reorder Imgaes</a>
								<div id="reorder-msg" class="alert alert-warning mt-3" style="display:none;">
									<i class="fa fa-3x fa-exclamation-triangle float-right"></i> 1. Drag photos to reorder.<br>2. Click 'Save Reordering' when finished.
								</div>
								<div style="display:block;overflow:hidden;" class="gallery">
									<ul class="nav nav-pills">
									
										@if(!empty($pg_images))
											@foreach($pg_images as $row)
												@if(is_file(base_path() . '/public/uploads/product_group_images/'.$product_group_id.'/'.$row->image_url))
												<li id="image_li_{{ $row->id }}" class="ui-sortable-handle mr-2 mt-2">
													<div style="position:relative;width:220px; height:240px;border: 1px dotted #ccc;margin:10px;">
														<a href="javascript:void(0);" class="img-link"><img src="{{ URL::to('/') }}/uploads/product_group_images/{{ $product_group_id }}/{{ $row->image_url }}" alt="" class="img-thumbnail" width="200" style="max-height:200px;" ></a>
														<span data-id="{{ $row->id }}" style="position:absolute;bottom:2px; left:2px;" class="btn btn-danger delete_group_image_btn">Delete</span>
													
													</div>
												</li>
												@endif
											@endforeach
										@endif
									</ul>
								</div>
							</div>					  
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
