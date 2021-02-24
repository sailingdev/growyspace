@extends('layouts.front')
@section('content')
<!-- Content -->
<div class="page-content bg-white">
  	<!-- Breadcrumb row -->
	<div class="breadcrumb-row">
		<div class="container">
			<ul class="list-inline">
				<li><a href="{{ URL::to('/') }}">Accueil</a></li>
				<li><a href="{{ URL::to('/') }}/user/my_account">My Account</a></li>
				<li><a href="{{ URL::to('/') }}/user/my_account/orders">Orders</a></li>
				<li>View Order</li>
			</ul>
		</div>
	</div>
	<!-- contact area -->
	<div class="section-full content-inner">
		<!-- Product -->
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-6 col-sm-6">
					<ul class="list-circle">
						<li><span style="font-size:30px;"><strong>STATUS:</strong> {{ $order->status }}</span></li>
						<li><span ><strong>Date:</strong> {{ date("d/m/Y", strtotime($order->created_at)) }}</span></li>
						<li><span ><strong>Facture ID:</strong> {{ trim($order->facture_id) == '' ? '---' : $order->facture_id }}</span></li>
						@if($order->is_professional == 1)
							<h4>Company Info</h4>
							<li><strong>Company:</strong> {{ $order->company }}</li>
							<li><strong>Intra VAT Number:</strong> {{ $order->intra_VAT_number }}</li>
							<li><strong>RCS Number:</strong> {{ $order->RCS_number }}</li>
						@endif
					
						<h4>Shipping Address</h4>
						<li><strong>Recipient name:</strong> {{ $order->shipping_address_recipient_name }}</li>
						<li> {!! $order->shipping_address_address.' '.$order->shipping_address_city.' '.$order->shipping_address_state.' '.$order->shipping_address_zip.' '.$order->shipping_address_country_id !!}</li>
						<li><i class="fa fa-phone"></i> {{ $order->shipping_address_phone }}</li>
						
					</ul>
				</div>
				<div class="col-lg-12 m-b30">
					<div class="table-responsive">
					<table class="table check-tbl">
						<thead class="text-left">
							<tr>
								<th>Product</th>
								<th>Product name</th>
								<th>Unit Price</th>
								<th>Quantity</th>
								<th>Total</th>
								
							</tr>
						</thead>
						<tbody>
							@foreach($order_products as $cart_key => $cart_prod) 
							<tr class="" cart_row_id="{{ $cart_prod->id }}">
								<td class="product-item-img">
									<input type="hidden" class="product_id" value="{{ $cart_prod->product_id }}" />
									@if(is_file(base_path() . '/public/uploads/orders/'.$order->id.'/'.$cart_prod->product_image_url))
										<img src="{{ URL::to('/') }}/uploads/orders/{{ $order->id }}/{{ $cart_prod->product_image_url }}" alt="">
									@else
										<img src="{{ URL::to('/') }}/assets/images/product/thumb/item1.jpg" alt="">
									@endif
								</td>
								<td class="product-item-name">
									<a href="{{ URL::to('/') }}/product/{{ urlencode(str_replace(['/',' '],['-','-'],$cart_prod->product_title)) }}/{{ $cart_prod->product_id }}.htm">{{ $cart_prod->product_title }}</a>
									<div class="shopping_cart_prod_ref">Ref. {{ $cart_prod->ref_item }}	</div>
									<div><label style="margin-bottom:0"><input disabled type="checkbox" value="1" {{ $cart_prod->include_exchange == 1 ? 'checked' : '' }} /> Echange immédiat (réception de l'ancien turbo sous 15 jours)</label></div>
									<div><label style="margin-bottom:0"><input disabled type="checkbox" value="1" {{ $cart_prod->include_seal == 1 ? 'checked' : '' }} /> Kit de joints neufs</label></div>
								
								</td>
								<td class="product-item-price">
								{{ $cart_prod->product_price }} €
								<div>&nbsp;</div>
								<div> {{ $cart_prod->price2 }} €</div>
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
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6 col-md-6">
					@if(trim($order->info_text) != '')
						<p>Extra information</p>
						<ul>
							<li>{{ $order->info_text }}</li>
						</ul>
					@endif
				</div>
				<div class="col-lg-6 col-md-6">
					<h5>Cart Subtotal</h5>
					<table class="table-bordered check-tbl">
						<tbody>
							<tr>
								<td>Order Subtotal</td>
								<td>{{ $order->subtotal }} €</td>
							</tr>
							<tr>
								<td>Shipping Price</td>
								<td>{{ $order->shipping_price }} €</td>
							</tr>
							<tr>
								<td>Shipping Method</td>
								<td>{{ $shipping_method }} €</td>
							</tr>
							@if($order->coupon_price > 0)
								<tr>
									<td>Coupon Price:</td>
									<td>{{ $order->coupon_price }} €</td>
								</tr>
								<tr>
									<td>Coupon Code:</td>
									<td>{{ $order->coupon_code }}</td>
								</tr>
								<tr>
									<td>Coupon Percentage:</td>
									<td>{{ $order->coupon_percentage }}</td>
								</tr>
							@endif
							<tr>
								<td>Total</td>
								<td><span style="font-size:25px;color:#EE3131;">{{ $order->order_total_price }} €</span></td>
							</tr>
						</tbody>
					</table>
					
				</div>
			</div>
	   </div>
		<!-- Product END -->
	</div>
</div>	
@endsection