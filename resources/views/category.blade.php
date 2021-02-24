@extends('layouts.front')
@section('content')
<!-- contact area -->
		<div class="breadcrumb-row">
            <div class="container">
                <ul class="list-inline">
                    <li><a href="{{ URL::to('/') }}">Accueil</a></li>
                    <li>{{ $category_name }}</li>
                </ul>
            </div>
        </div>	
<div class="section-full content-inner">
<script>
	window.page_id='{{ $page_id }}';
	window.category_url="{{ $category_url }}";
	window.product_mark_model="{{ $model_id }}";
	window.product_mark_model_motorization="{{ $motorization_id }}";
	window.product_mark_model_motorization_power="{{ $power_id }}";

</script>	
@include('advanced_filter')




	<!-- Product -->
	<div class="container category_products_block">
		
		<div class="row">
			@if(count($category_products) > 0)
				<h2 class="found_products_count">Found {{ $category_products->total() }} products</h2>
			
				@foreach ($category_products as $product)
				<div class="category_product_item col-lg-3 col-md-4 col-sm-6">
					<div class="item-box m-b10">
						<div class="sale">
							<span class="site-button button-sm">{{ $product->category_name }}</span>
						</div>
						<div class="item-img">
							@if(is_file(base_path() . '/public/uploads/product_group_images/'.$product->group_id.'/'.$product->main_image))
								<img src="{{ URL::to('/') }}/uploads/product_group_images/{{ $product->group_id }}/{{ $product->main_image }}" alt=""/>
							@else
								<img src="{{ URL::to('/') }}/assets/images/product/item1.jpg" alt=""/>
							@endif
							<div class="item-info-in">
								<ul>
									<li><a product_id = "{{ $product->product_id }}" class="add_to_cart_from_category" href="#"><i class="ti-shopping-cart"></i></a></li>
									<li><a href="{{ URL::to('/') }}/product/{{ urlencode(str_replace(['/',' '],['-','-'],$product->title)) }}/{{ $product->product_id }}.htm"><i class="ti-eye"></i></a></li>
									
								</ul>
							</div>
						</div>
						<div class="item-info text-center text-black p-a10">
							<h6 class="item-title"><a href="{{ URL::to('/') }}/product/{{ urlencode(str_replace(['/',' '],['-','-'],$product->title)) }}/{{ $product->product_id }}.htm">{{ $product->title }}</a></h6>
							
							<h4 class="item-price"> <span class="text-primary">{{ $product->group_price }} €</span></h4>
						</div>
					</div>
				</div>
				@endforeach
			@else
				<h2 class="no_products_found">No products found</h2>
			@endif
			<div class="pagination_block">
			{{ $category_products->appends(request()->input())->links() }}
			</div>
		</div>
	</div>
	<!-- Product END -->
</div>
@endsection