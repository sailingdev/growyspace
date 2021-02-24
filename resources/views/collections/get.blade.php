@extends('layouts.front')
@section('content')
	<div class="row m-0 bg-gray">
		<div class="col-md-12 head_logo_area mt-5">
			<div class="head_logo">		
			<img src='/assets/images/redesign-collections 5.svg' alt='explore' class="pull-left" style="width:30px;"><h3 class="pull-left" >Collections</h3>
			</div>
		</div>

		<div class="col-md-10 mx-auto mt-4">

			<div class="row m-0 p-0">
				<div class="col-md-4 m-0 p-0">
			
				
					<div class="card text-black bg-white mb-3 explore_card collection_item_block" data-col-id="{{ $collection->id }}" data-col-name="{{ base64_encode($collection->name) }}">
						<div class="card-body">
							<p class="card-title m-0 p-0 card-title font-weight-bold">{{ $collection && $collection->name  ? $collection->name : '' }}</p>
							@if($collection && $collection->user_id == $user_id)		
							<!-- <a href="{{ URL::to('/') }}/user/collection/{{ $collection->id }}" data-col-id="{{ $collection->id }}" data-col-name="{{ base64_encode($collection->name) }}" class="editIcon float-right edit_collection_link" style="position: absolute; right: 5%;top: 10%;"><img src="/assets/images/Icon-edit.svg" style="width:30px;"></a>		 -->
							@endif
						
							<p class="card-title m-0 p-0 card-title font-weight-bold mt-3 mb-1">Created by:<span class="textcolor-blue pl-2">{{ $user && $user->full_name  ? $user->full_name : '' }} </span></p>
							<div class="w-100 m-0 p-0">													
								<a href="#" data-type="text"  data-title="Copy this link to share" class="editable editable-click  float-right  text-decoration-none textcolor-blue collection_share" data-placement="bottom" data-original-title="" title="" data-value="{{ URL::to('/') }}/collections/{{ $collection->id }}#">Share</a>
							</div>
						</div>
					</div>
			
				
					<!-- <a href="{{ URL::to('/') }}/user/collection/" class="text-decoration-none text-dark bg-white">
						<div class="w-100 text-center font-weight-bold pt-2 pb-2 text-black bg-white explore_card mb-3">
								Create new collection
						</div>
					</a> -->

				</div>
				<!-- result-->
				<div class="explore_result col-md-8 m-0 p-0 pl-3 collection_items_block">
				@if($users->count() > 0)
					@foreach($users as $u)
					<div data-opt-id="{{ $u->id }}" class="search_user_block filter_oppbox">
						<div class="card mb-4">
							<div class="card-header pl-4 pr-4 color-user h-100">
								<div class="row m-0 p-0 opportunity_header">
									<p class="w-50 m-0 p-0 font-weight-bold">{{$collection_name}}</p>
									<p class="w-50 m-0 p-0 text-right font-weight-bold ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2">{{$u->city}}, {{$countries[$u->country_code]}}</span></p>
									
								</div>
							</div>
							<div class="card-block p-4">
									<a href="{{ URL::to('/') }}/user/{{$u->id}}/view" style="color: unset;">
										<div class="row m-0 p-0 profile_picture">
											<div class="profile_img">
										@if(is_file(base_path() . '/public/uploads/profile/'.$u->id.'/'.$u->profile_image_cropped))
											<img src="{{ URL::to('/') }}/{{ 'uploads/profile/'.$u->id.'/'.$u->profile_image_cropped }}" class="img-fluid pull-left" >
										@else
											
											<img  src="{{ URL::to('/') }}/assets/images/noprofileIMG.png" class="img-fluid pull-left" />
										@endif
											</div>
											<div class="w-75 profile_name pull-left">

												<h3 class="font-weight-bold">{{ $u->full_name }}</h3>
												<h3 >{{ $u->profession }}</h3>
												
											</div>
										</div>
									</a>
									<div class="row m-0 p-0 ">
										<div class="w-100 m-0 p-0">						
											@if(!$third_person)	

											<div>
												<a href="#" class="float-right text-decoration-none textcolor-blue pl-2 opt_align_mobile" style="color: #CA7073 !important" data-toggle="dropdown" >Delete from collection</a>  
															
												<div class="dropdown-menu dropdown-menu-right"  style="padding: 0px;">
													<p style="padding: 10px;">Are you sure you want to delete?</p>
													<div style="width: 90%;margin: 0 auto;padding-bottom: 10px;">
														<span class="delete_my_individual_collection cusor_pointer" style="color: #CA7073;" collection_id="{{$collection_id}}" item_type="user" item_id="{{$u->id}}">Delete</span> <span class="cusor_pointer" style="float: right;color: #219BC4 !important">Back</span>
													</div>	

												</div>
											</div>						
											@endif


															
											<a href="/messages/{{ $u->id }}" class="text-decoration-none textcolor-blue float-right pl-2 pr-2 opt_align_mobile">Send a message</a>
										
											<a href="{{ URL::to('/') }}/user/{{$u->id}}/view"  class="float-right text-decoration-none textcolor-blue pr-2 opt_align_mobile" >Go to profile</a> 
										</div>
									</div>


							</div>

						</div>						
					</div>
					@endforeach
				@endif
				@if($opportunity_cards !== null && $opportunity_cards->count() > 0)
					@foreach($opportunity_cards as $opc)
					<div data-opt-id="{{ $opc->id }}" class="search_user_block filter_oppbox">
						<div class="card mb-4">
							<div class="card-header pl-4 pr-4 color-oppportunity h-100">
								<div class="row m-0 p-0 opportunity_header">
									<p class="w-50 m-0 p-0 font-weight-bold">{{$collection_name}}</p>
									<p class="w-50 m-0 p-0 text-right font-weight-bold ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2">{{$opc->city}}, {{$countries[$opc->country_code]}}</span></p>
									
								</div>
							</div>
							<div class="card-block p-4">
								<a href="/cards/{{ $opc->id }}" class="text-decoration-none" style="color:unset">
									<div class="row m-0 p-0 ">
										<div class="w-100 profile_pitch">
											<h3 class="font-weight-bold">{{ strlen($opc->title) > 150 ? substr($opc->title,0,150).'...' : $opc->title }}</h3>
											<p>{{ strlen($opc->company) > 150 ? substr($opc->company,0,150).'...' : $opc->company }}</p>
											
										</div>
									</div>
									<div class="w-100 profile_pitch">
										<h3 class="font-weight-bold opt_roles_font">Requested skills</h3>
										<ul class="list-unstyled list-inline margin-0-auto mb-0 request_skills">
											@foreach(json_decode($opc->fields,true) as $oc)
											<li class="list-inline-item mr-0 pr-2 pb-2" style="margin:0px">
												<div class="chip bgcolor-purple mr-0 chip-custom">{{$oc}}</div>
											</li>
											@endforeach	
										</ul>
									</div>
								</a>
								<div class="row m-0 p-0 ">
									<div class="w-100 m-0 p-0">	
									@if(!$third_person)	

										<div>
											<a href="#" class="float-right text-decoration-none textcolor-blue pl-2 opt_align_mobile" style="color: #CA7073 !important" data-toggle="dropdown" >Delete from collection</a>  
														
											<div class="dropdown-menu dropdown-menu-right"  style="padding: 0px;">
												<p style="padding: 10px;">Are you sure you want to delete?</p>
												<div style="width: 90%;margin: 0 auto;padding-bottom: 10px;">
													<span class="delete_my_individual_collection cusor_pointer" style="color: #CA7073;" collection_id="{{$collection_id}}" item_type="opportunity" item_id="{{$opc->id}}">Delete</span> <span class="cusor_pointer" style="float: right;color: #219BC4;">Back</span>
												</div>	

											</div>
										</div>						
									@endif
										<a href="/cards/{{ $opc->id }}"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2 opt_align_mobile"  style="color: #219BC4">Read more</a>

										<div>
											<a href="#"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2 opt_align_mobile" data-toggle="dropdown"  style="color: #219BC4">Send my open-to-work</a>
											<div class="dropdown-menu dropdown-menu-right"  style="padding: 0px;">
												@if(count($opt_list) > 0) 
													<ul style="margin: 0px;padding: 0px;">
														@foreach ($opt_list as $item)
															<li class="list-unstyled send_opentowork"><a onclick="gotoChatWithOPT({{ $opc->user_id }}, {{$item->id}})" class="cusor_pointer">{{$item->title}} - {{json_decode($item->fields,true)[0]}}</a></li>
														@endforeach
															<li class="list-unstyled send_opentowork"><a href="{{ URL::to('/') }}/opentowork/{{ $opc->id }}/refer">Create New one</a></li>
													</ul>
												@else
													<li class="list-unstyled send_opentowork"><a href="{{ URL::to('/') }}/opentowork/{{ $opc->id }}/refer">Create New one</a></li>
												@endif
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					@endforeach
				@endif
				@if($opentowork_cards !== null && $opentowork_cards->count() > 0)
					@foreach($opentowork_cards as $opc)
					<div data-opt-id="{{ $opc->id }}" class="search_user_block filter_oppbox">
						<div class="card mb-4">
							<div class="card-header pl-4 pr-4 color-opentowork h-100">
								<div class="row m-0 p-0 opportunity_header">
									<p class="w-50 m-0 p-0 font-weight-bold">{{$collection_name}}</p>
									<p class="w-50 m-0 p-0 text-right font-weight-bold ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2">{{$opc->city}}, {{$countries[$opc->country_code]}}</span></p>
									
								</div>
							</div>
							<div class="card-block p-4">
								<a href="/opentowork/{{ $opc->id }}" class="text-decoration-none" style="color:unset">
									<div class="row m-0 p-0 ">
										<div class="w-100 profile_pitch">
											<h3 class="font-weight-bold">{{ strlen($opc->title) > 150 ? substr($opc->title,0,150).'...' : $opc->title }}</h3>
										</div>
									</div>
									<div class="row m-0 p-0 mb-4">
										<div class="w-100 profile_pitch">
											<h3 class="font-weight-bold opt_roles_font">Roles of interest</h3>
											<ul class="list-unstyled list-inline margin-0-auto mb-0 request_skills">
												@foreach(json_decode($opc->roles,true) as $oc)
												<li class="list-inline-item mr-0 pr-2 pb-2" style="margin:0px">
													<div class="chip bgcolor-purple mr-0 chip-custom">{{$oc}}</div>
												</li>
												@endforeach	
											</ul>
										</div>
									</div>	
								</a>

								<div class="row m-0 p-0 ">
									<div class="w-100 m-0 p-0">		
									@if(!$third_person)	

										<div>
											<a href="#" class="float-right text-decoration-none textcolor-blue pl-2 opt_align_mobile" style="color: #CA7073 !important" data-toggle="dropdown" >Delete from collection</a>  
														
											<div class="dropdown-menu dropdown-menu-right"  style="padding: 0px;">
												<p style="padding: 10px;">Are you sure you want to delete?</p>
												<div style="width: 90%;margin: 0 auto;padding-bottom: 10px;">
													<span class="delete_my_individual_collection cusor_pointer" style="color: #CA7073 !important;" collection_id="{{$collection_id}}" item_type="opentowork" item_id="{{$opc->id}}">Delete</span> <span class="cusor_pointer" style="float: right;color: #219BC4;">Back</span>
												</div>	

											</div>
										</div>						
									@endif
										<a href="/opentowork/{{ $opc->id }}"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2 opt_align_mobile"  style="color: #219BC4">Read more</a>

										<div>
										
											<a href="#" class=" float-right  text-decoration-none textcolor-blue pr-2 pl-2 opt_align_mobile" data-toggle="dropdown">Send my opportunity</a>    
																	
											<div class="dropdown-menu dropdown-menu-right"  style="padding: 0px;">
											@if(count($opc_list) > 0) 
												<ul style="margin: 0px;padding: 0px;">
													@foreach ($opc_list as $item)
														<li class="list-unstyled send_opentowork"><a class="cusor_pointer" onclick="gotoChatWithCard({{ $opc->user_id }}, {{$item->id}})" >{{$item->title}} - {{json_decode($item->fields,true)[0]}}</a></li>
													@endforeach
														<li class="list-unstyled send_opentowork"><a href="{{ URL::to('/') }}/cards/{{ $opc->id }}/refer">Create New one</a></li>
												</ul>
											@else
												<li class="list-unstyled send_opentowork"><a href="{{ URL::to('/') }}/cards/{{ $opc->id }}/refer">Create New one</a></li>
											@endif
											</div>
										</div>
																				
									
										
									</div>
								</div>
							</div>
						</div>						
					</div>	
					@endforeach
				@endif
				@if($users->count() == 0 && $opportunity_cards->count() == 0  && $opentowork_cards->count() == 0) 
					<h2>No items</h2>
				@endif
				</div>

			</div>
			<div class="mt-5"></div>		
		</div>
	</div>
@endsection