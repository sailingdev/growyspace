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
<li><a href="{{ URL::to('/auto-turbo-admin/orders') }}">Orders</a>
<span class="divider"><i class="fa fa-angle-right"></i></span>
</li>
<li class="active">{{ $order->user->bill_first_name.' '.$order->user->bill_last_name }}</li> 
</ul>
</div>
<!-- END Breadcrumb -->

<!-- BEGIN Main Content -->
<div class="row">
<div class="col-md-12">
<div class="box">
<div class="box-content">
<div class="invoice">
	<div class="row">
		<div class="col-md-6">
			<h2><strong>STATUS:</strong> <span class="{!! $order->status == 'finished' ? 'green' : '' !!} {!! $order->status == 'cancelled' ? 'red' : '' !!}">{!! $order->status == 'finished' ? '<i class="fa fa-check green"></i>' : '' !!} {{ $order->status }}</span> <button class="btn btn-primary edit_order_status_btn">Edit Status</button></h2>  
			@if($order->status == 'cancelled')
			<p><strong>Cancel  Order Text:</strong> {{ $order->cancel_order_text }}</p>
			@endif
			<div class="{{ $order->status == 'finished' || $order->status == 'cancelled' ? 'hidden' : '' }} order_statuses_block">
				@if($order->status != 'finished')
					<button order_id="{{ $order->id }}" status="finished" style="margin-bottom:10px;" class="btn btn-primary finish_order">Finish order as arrived</button><br/>
				@endif
				
				@if($order->status != 'cancelled')
					<div class="cancel_order_text_block hidden">
						<textarea class="cancel_order_text" placeholder="Cancel order text"></textarea>
					</div>
					<button order_id="{{ $order->id }}" status="cancelled" style="margin-bottom:10px;" class="btn btn-danger finish_order">Cancell Order</button><br/>
				@endif
			</div>
		</div>
		<div class="col-md-6 invoice-info">
			<p class="font-size-17"><strong>Invoice</strong> {{ $order->transaction_id }}</p>
			<p>{{ $order->created_at }}</p>
		</div>
	</div>

<hr class="margin-0" />

<div class="row">
	<div class="col-md-6 company-info">
		@if($order->is_professional == 1)
			<strong>Company:</strong> {{ $order->company }}<br/>
			<strong>Intra VAT Number:</strong> {{ $order->intra_VAT_number }}<br/>
			<strong>RCS Number:</strong> {{ $order->RCS_number }}
		
		@endif
	
		@if(trim($order->colissimo_address) != '')
			<p><strong>Colissimo Address:</strong> {{ $order->colissimo_address }}</p>
		@endif
		
		<h4>Shipping Address</h4>
		<p><strong>Recipient name:</strong> {{ $order->shipping_address_recipient_name }}</p>
		<p> {!! $order->shipping_address_address.' <br/>'.$order->shipping_address_city.' '.$order->shipping_address_state.' '.$order->shipping_address_zip.' '.$order->shipping_address_country_id !!}</p>
		<p><i class="fa fa-phone"></i> {{ $order->shipping_address_phone }}</p>
	</div>

</div>

<br/><br/>

<div class="table-responsive">
	<table class="table table-striped table-bordered">
		<thead class="text-left">
			<tr>
				<th>Product ID</th>
				<th>Product</th>
				<th>Product name</th>
				<th>Unit Price</th>
				<th>Quantity</th>
				<th>Total</th>
			
			</tr>
		</thead>
		<tbody>
			@foreach($orders_products as $cart_prod) 
			<tr class="" cart_row_id="{{ $cart_prod->id }}">
				<td>{{ $cart_prod->product_id }}</td>
				<td class="product-item-img">
					@if(is_file(base_path() . '/public/uploads/orders/'.$order->id.'/'.$cart_prod->product_image_url))
						<img style="width:100px;"  src="{{ URL::to('/') }}/uploads/orders/{{ $order->id }}/{{ $cart_prod->product_image_url }}" alt="">
					@else
						<img style="width:100px;" src="{{ URL::to('/') }}/assets/images/product/thumb/item1.jpg" alt="">
					@endif
				</td>
				<td class="product-item-name">
					<a href="{{ URL::to('/') }}/product/{{ urlencode(str_replace(['/',' '],['-','-'],$cart_prod->product_title)) }}/{{ $cart_prod->product_id }}.htm">{{ $cart_prod->product_title }}</a>
					<div class="shopping_cart_prod_ref">
					<span style="display:inline-flex;width:50px;">Ref.</span> 
					<span style="display:inline-flex;width:150px;">
						<select class="chosen ref_item form-control" name="ref_item_dropdown">
							<option value="">Sélectionnez un référent</option>
							@foreach($ref_items as $ref_item)
								<option {{ $cart_prod->ref_item == $ref_item->name ? 'selected' : '' }} value="{{ $ref_item->name }}">{{ $ref_item->name }}</option>
							@endforeach
						</select>
					</span>
					<span style="display:inline-flex;width:150px;">
						<button cart_row_id="{{ $cart_prod->id }}" class="btn btn-sm btn-primary update_ref">Update ref</button></div>
					</span>
					<div><label style="margin-bottom:0"><input type="checkbox" readonly class="include_exchange" value="1" {{ $cart_prod->include_exchange == 1 ? 'checked' : '' }} /> Echange immédiat (réception de l'ancien turbo sous 15 jours)</label></div>
					<div><label style="margin-bottom:0"><input type="checkbox" readonly class="include_seal" value="1" {{ $cart_prod->include_seal == 1 ? 'checked' : '' }} /> Kit de joints neufs</label></div>
				
				</td>
				<td class="product-item-price">
				{{ $cart_prod->product_price }} €
				<div style="height:30px;">&nbsp;</div>
				<div>{{ $cart_prod->price2 }} €</div>
				<div> 15 €</div>
				</td>
				<td class="product-item-quantity">
					<div class="quantity btn-quantity max-w80">
						{{ $cart_prod->quantity }}
					</div>
				</td>
				<td class="product-item-totle">{{ $cart_prod->total_price }} €</td>
				
			</tr>
			@endforeach
		</tbody>
	</table>
</div>

<div class="row">
	<div class="col-md-6">
	@if(trim($order->info_text) != '')
		<p>Extra information</p>
		<ul>
			<li>{{ $order->info_text }}</li>
		</ul>
	@endif
	</div>
	<div class="col-md-6 invoice-amount">
		<p><strong>Subtotal:</strong> <span>{{ $order->subtotal }}</span></p>
		<p><strong>Shipping:</strong> <span>{{ $order->shipping_price }} €</span></p>
		<p><strong>Shipping Name:</strong> <span>{{ $shipping_method }}</span></p>
		@if($order->coupon_price > 0)
			<p><strong>Coupon Price:</strong> <span>{{ $order->coupon_price }} €</span></p>
			<p><strong>Coupon Code:</strong> <span>{{ $order->coupon_code }}</span></p>
			<p><strong>Coupon Percentage:</strong> <span>{{ $order->coupon_percentage }}</span></p>
		@endif
		<p><strong>Total:</strong> <span class="green font-size-17"><strong>{{ $order->order_total_price }} €</strong></span></p>
	</div>
</div>

</div>
</div>
</div>
</div>
</div>
<!-- END Main Content -->

@endsection
