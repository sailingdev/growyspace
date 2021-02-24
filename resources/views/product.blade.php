@extends('layouts.front')
@section('content')
  <!-- Content -->
    <div class="page-content bg-white">
      
        <!-- Breadcrumb row -->
        <div class="breadcrumb-row">
            <div class="container">
                <ul class="list-inline">
                    <li><a href="{{ URL::to('/') }}">Accueil</a></li>
                    <li>{{ $product->title }}</li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb row END -->
		<input type="hidden" class="product_id" value="{{ $product->id }}" />
        <!-- contact area -->
        <div class="section-full content-inner bg-white">
            <!-- Product details -->
            <div class="container woo-entry">
                <div class="row m-b30">
					<div class="col-lg-5 col-md-5">
						<div class="product-gallery on-show-slider"> 
							<div id="sync1" class="owl-carousel owl-theme owl-btn-center-lr m-b5 owl-btn-1 primary">
								@if(count($product->group->images) > 0)
									@foreach($product->group->images as $image)
										<div class="item">
											<div class="mfp-gallery">
												<div class="dlab-box">
													<div class="dlab-thum-bx dlab-img-overlay1 ">
														<img src="{{ URL::to('/') }}/uploads/product_group_images/{{ $product->group_id }}/{{ $image->image_url }}" alt="">
														<div class="overlay-bx">
															<div class="overlay-icon">
																<a class="mfp-link" title="{{ $product->title }}" href="{{ URL::to('/') }}/uploads/product_group_images/{{ $product->group_id }}/{{ $image->image_url }}">
																	<i class="ti-fullscreen"></i>
																</a>
														  </div>
														</div>
													</div>
												</div>
											</div>
										</div>
									@endforeach
								@else
									<div class="item">
										<div class="mfp-gallery">
											<div class="dlab-box">
												<div class="dlab-thum-bx dlab-img-overlay1 ">
													<img src="{{ URL::to('/') }}/assets/images/product/item1.jpg" alt="">
													<div class="overlay-bx">
														<div class="overlay-icon">
															<a class="mfp-link" title="{{ $product->title }}" href="{{ URL::to('/') }}/assets/images/product/item1.jpg">
																<i class="ti-fullscreen"></i>
															</a>
													  </div>
													</div>
												</div>
											</div>
										</div>
									</div>
								@endif
								
								
							</div>
							
							<div id="sync2" class="owl-carousel owl-theme owl-none">
								@if(count($product->group->images) > 0)
									@foreach($product->group->images as $image)
										<div class="item">
											<div class="dlab-media">
												<img src="{{ URL::to('/') }}/uploads/product_group_images/{{ $product->group_id }}/{{ $image->image_url }}" alt="">
											</div>
										</div>
									@endforeach
								@else
									<div class="item">
										<div class="dlab-media">
											<img src="{{ URL::to('/') }}/assets/images/product/item1.jpg" alt="">
										</div>
									</div>
								@endif
								
							</div>
						</div>
					</div>
					<div class="col-lg-7 col-md-7">
						<div class="sticky-top">
							<div class="cart">
								<div class="dlab-post-title ">
									<h2 class="post-title">{{ $product->title }}</h2>
									<p class="m-b10">{{ $product->title2 }}</p>
									<div class="dlab-divider bg-gray tb15"><i class="icon-dot c-square"></i></div>
								</div>
								<div class="shop-item-tage">
									<span>Category: </span> {{ $product->category->name }}
								</div>
								<br/>
								<div class="shop-item-tage">
									<span>Modèle: </span> {{ $product->mark->name }} / {{ $product->model->name }} / {{ $product->motorization->name }} / {{ $product->power->name }}
								</div>
								<br/>
								<div class="shop-item-tage">
									<span>Group: </span> {{ $product->group->name }}
								</div>
								<br/>
								<div class="shop-item-tage">
									<span>Référence : </span>
									<br/>
									
									@foreach($product->group->items as $item)
									<span class="ref_item_row">{{ $item->name }} </span><br/> 
									@endforeach
								</div>
															
								<div class="dlab-divider bg-gray tb15"><i class="icon-dot c-square"></i></div>
								<div class="row">
									<div class="m-b30 col-lg-6 col-md-6 col-sm-6">
										<h6>Kit de joints neufs :</h6>
										<div class="btn-group">
											<label class="">
												<input type="radio" name="seal" id="seal1" value="1" onchange="calculate_product_price()"  > Oui + 15 €
											</label>
											<label style="margin-left:30px" class="">
												<input type="radio" name="seal" id="seal1" value="2" onchange="calculate_product_price()"> Non
											</label>
											
										</div>
									</div>
									<div style="" class="product_exchange_price_info_block m-b30 col-lg-12 col-md-6 col-sm-6">
										<h6>Echange immédiat (réception de l'ancien turbo sous 15 jours)</h6>
										<br/>
										<p style="line-height:17px;">Par défaut, nous attendons la réception de votre ancien turbo avant l'envoi du nouveau turbo. Pour un échange immédiat, cliquez sur le bouton ci-contre pour ajouter la caution au panier, en plus du turbo.</p>
										
										<p class="product_exchange_price_block"><span data-price="{{ $product->group->price2 }}" class="product_exchange_price">{{ $product->group->price2 }} €</span> <input type="checkbox" class="product_exchange_price_on" value="1" /></p>										
										
									</div>
								</div>
								
								<div class="row">
									<div class="m-b30 col-lg-6 col-md-6 col-sm-6">
										<h6>Select quantity</h6>
										<div class="quantity btn-quantity style-1">
											<input id="product_qty" type="text" value="1" name="product_qty"/>
										</div>
									</div>
									<div class="m-b30 col-lg-6 col-md-6 col-sm-6 product_price_block">
										<h6>&nbsp;</h6>
										<span data-price="{{ $product->group->price }}" class="product_price">{{ $product->group->price }} €</span>
									</div>
								</div>
								<button class="site-button radius-no add_to_cart" onclick="add_to_cart()"><i class="ti-shopping-cart"></i> Add To Cart</button>
								
								<div class="row return_coupon_link_block">
									<div class="m-b30 col-lg-12 col-md-6 col-sm-6">
										<a style="display:none;" target="_blank" href="{{ URL::to('/') }}/uploads/Bon-de-retour-du-turbo-consigne.pdf.pdf">Télécharger le coupon de retour pour la consigne turbo</a>
									</div>
								</div>
							</div>
						</div>
					</div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="dlab-tabs product-description border-tp bg-tabs tabs-site-button">
                            <ul class="nav nav-tabs ">
                                <li class="nav-item"><a data-toggle="tab" class="nav-link active" href="#web-design-1">
									<i class="fa fa-globe"></i> Description</a></li>
                              
                            </ul>
                            <div class="tab-content">
                                <div id="web-design-1" class="tab-pane active">
									{!! $product->description !!}
                                </div>
                             
                            </div>
                        </div>
                    </div>
                </div>
				<div class="row">
					<div class="col-lg-12">
						<h5 class="m-b20">Related Products</h5>
						<div class="img-carousel-content owl-carousel owl-btn-center-lr owl-btn-1 primary">
							<div class="item">
								<div class="item-box">
									<div class="item-img">
										<img src="{{ URL::to('/') }}/assets/images/product/item1.jpg" alt="">
										<div class="item-info-in">
											<ul>
												<li><a href="#"><i class="ti-shopping-cart"></i></a></li>
												<li><a href="#"><i class="ti-eye"></i></a></li>
												<li><a href="#"><i class="ti-heart"></i></a></li>
											</ul>
										</div>
									</div>
									<div class="item-info text-center text-black p-a10">
										<h6 class="item-title text-uppercase font-weight-500"><a href="#">Product Title</a></h6>
										<ul class="item-review">
											<li><i class="fa fa-star"></i></li>
											<li><i class="fa fa-star"></i></li>
											<li><i class="fa fa-star"></i></li>
											<li><i class="fa fa-star-half-o"></i></li>
											<li><i class="fa fa-star-o"></i></li>
										</ul>
										<h4 class="item-price"><del>$232</del> <span class="text-primary">$192</span></h4>
									</div>
								</div>
							</div>
							<div class="item">
								<div class="item-box">
									<div class="item-img">
										<img src="{{ URL::to('/') }}/assets/images/product/item2.jpg" alt="">
										<div class="item-info-in">
											<ul>
												<li><a href="#"><i class="ti-shopping-cart"></i></a></li>
												<li><a href="#"><i class="ti-eye"></i></a></li>
												<li><a href="#"><i class="ti-heart"></i></a></li>
											</ul>
										</div>
									</div>
									<div class="item-info text-center text-black p-a10">
										<h6 class="item-title text-uppercase font-weight-500"><a href="#">Product Title</a></h6>
										<ul class="item-review">
											<li><i class="fa fa-star"></i></li>
											<li><i class="fa fa-star"></i></li>
											<li><i class="fa fa-star"></i></li>
											<li><i class="fa fa-star-half-o"></i></li>
											<li><i class="fa fa-star-o"></i></li>
										</ul>
										<h4 class="item-price"><del>$232</del> <span class="text-primary">$192</span></h4>
									</div>
								</div>
							</div>
							<div class="item">
								<div class="item-box">
									<div class="item-img">
										<img src="{{ URL::to('/') }}/assets/images/product/item3.jpg" alt="">
										<div class="item-info-in">
											<ul>
												<li><a href="#"><i class="ti-shopping-cart"></i></a></li>
												<li><a href="#"><i class="ti-eye"></i></a></li>
												<li><a href="#"><i class="ti-heart"></i></a></li>
											</ul>
										</div>
									</div>
									<div class="item-info text-center text-black p-a10">
										<h6 class="item-title text-uppercase font-weight-500"><a href="#">Product Title</a></h6>
										<ul class="item-review">
											<li><i class="fa fa-star"></i></li>
											<li><i class="fa fa-star"></i></li>
											<li><i class="fa fa-star"></i></li>
											<li><i class="fa fa-star-half-o"></i></li>
											<li><i class="fa fa-star-o"></i></li>
										</ul>
										<h4 class="item-price"><del>$232</del> <span class="text-primary">$192</span></h4>
									</div>
								</div>
							</div>
							<div class="item">
								<div class="item-box">
									<div class="item-img">
										<img src="{{ URL::to('/') }}/assets/images/product/item4.jpg" alt="">
										<div class="item-info-in">
											<ul>
												<li><a href="#"><i class="ti-shopping-cart"></i></a></li>
												<li><a href="#"><i class="ti-eye"></i></a></li>
												<li><a href="#"><i class="ti-heart"></i></a></li>
											</ul>
										</div>
									</div>
									<div class="item-info text-center text-black p-a10">
										<h6 class="item-title text-uppercase font-weight-500"><a href="#">Product Title</a></h6>
										<ul class="item-review">
											<li><i class="fa fa-star"></i></li>
											<li><i class="fa fa-star"></i></li>
											<li><i class="fa fa-star"></i></li>
											<li><i class="fa fa-star-half-o"></i></li>
											<li><i class="fa fa-star-o"></i></li>
										</ul>
										<h4 class="item-price"><del>$232</del> <span class="text-primary">$192</span></h4>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
            <!-- Product details -->
        </div>
        <!-- contact area  END -->
		<div class="section-full p-t50 p-b20 bg-gray">
			<div class="container">
				<div class="row">
					<div class="col-md-4 col-lg-4">
						<div class="icon-bx-wraper left m-b30">
							<div class="icon-md text-black radius"> 
								<a href="#" class="icon-cell text-black"><i class="fa fa-gift"></i></a> 
							</div>
							<div class="icon-content">
								<h5 class="dlab-tilte">Free shipping on orders $60+</h5>
								<p>Order more than 60$ and you will get free shippining Worldwide. More info.</p>
							</div>
						</div>
					</div>
					<div class="col-md-4 col-lg-4">
						<div class="icon-bx-wraper left m-b30">
							<div class="icon-md text-black radius"> 
								<a href="#" class="icon-cell text-black"><i class="fa fa-plane"></i></a> 
							</div>
							<div class="icon-content">
								<h5 class="dlab-tilte">Worldwide delivery</h5>
								<p>We deliver to the following countries: USA, Canada, Europe, Australia</p>
							</div>
						</div>
					</div>
					<div class="col-md-4 col-lg-4">
						<div class="icon-bx-wraper left m-b30">
							<div class="icon-md text-black radius"> 
								<a href="#" class="icon-cell text-black"><i class="fa fa-history"></i></a> 
							</div>
							<div class="icon-content">
								<h5 class="dlab-tilte">60 days money back guranty!</h5>
								<p>Not happy with our product, feel free to return it, we will refund 100% your money!</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
    <!-- Content END-->



@endsection