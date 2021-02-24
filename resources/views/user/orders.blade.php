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
				<li>Orders</li>
			</ul>
		</div>
	</div>
	<div class="page-content bg-white">
		<!-- contact area -->
		<div class="section-full content-inner">
			<!-- Product -->
			<div class="container">	
				<table class="orders_table table" id="orders_table">
					<thead>
						<tr>
							<th>Order ID</th>
							<th>Transaction ID</th>
							<th>Shipping</th>
							<th>Shipping Price</th>
							<th>Subtotal</th>
							<th>Total Price</th>
							<th>Status</th>
							<th>Date</th>
							<th>Facture ID</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($orders as $order)
							<tr>
								<td>{{ $order->id }}</td>
								<td>{{ $order->transaction_id }}</td>
								<td>{{ ( isset($order->shipping_method) && isset($order->shipping_method->name) ) ?  $order->shipping_method->name : '' }}</td>
								<td>{{ $order->shipping_price }}</td>
								<td>{{ $order->subtotal }}</td>
								<td>{{ $order->order_total_price }}</td>
								<td>{{ $order->status }}</td>
								<td>{{  date("d/m/Y", strtotime($order->created_at)) }}</td>
								<td>{{  trim($order->facture_id) == '' ? '----' : $order->facture_id }}</td>
								<td><a href="{{ URL::to('/') }}/user/my_account/orders/{{ $order->id }}/view" class="btn btn-primary" href="">View</a></td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	
</div>	
@endsection