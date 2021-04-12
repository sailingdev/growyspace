@extends('layouts.front')
@section('content')
<script>window.search_url = '{{ $search_url }}';</script>
	<div class="row m-0 bg-gray">
		<div class="col-md-12 head_logo_area mt-5">
			<div class="head_logo">		
				<img src='/assets/images/icon-search-new.svg' alt='explore' class="pull-left" ><h3 class="pull-left" >Explore</h3>
			</div>
			<div class="pull-left ml-3">
				<a onclick="window.history.back();" class="cusor_pointer display_image1"><img src="/assets/images/Frame 6.svg" alt="Back" ></a>
			</div>			
		</div>

		<div class="col-md-10 mx-auto mt-5">
			<!-- search -->
			<div class="row m-0 p-0" id="search">
				<div class="col-md-7 form-group form-inline has-search m-0 p-0 search_filter_item_block_new">
					<span class="fa fa-search form-control-feedback"></span>
					<input type="text" name="search" class="form-control w-100 search_input" placeholder="Search for opportunitities, professional cards or users" value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}">
				</div>

				<div class="col-md-3 form-group form-inline p-0 m-0 has-location">
					<span class="fa fa-map-marker form-control-marker"></span>
					<select data-tags="true" data-placeholder="Type the country or city"  multiple class="opc_explore form-control w-100 search_city">
						<option value="{{ $city !='' ? $city : '' }}" {{ $city !='' ? 'selected' : '' }}>{{ $city !='' ? $city : '' }}</option>
					</select>
				
				</div>				
				<div class="form-group form-inline col-md-2 m-0 p-0">
					<button type="submit" class="btn btn-block color-experience search search_btn padding-49">Search</button>
				</div>
			</div>

			<div class="row m-0 p-0 mt-4">
				<div class="col-md-4 m-0 p-0">
					<div class="card text-black bg-white mb-3 explore_card">
						<div class="card-body">
							<h5 class="card-title font-weight-bold">Filter</h5>

							<div class="form-check">
							<label class="form-check-label">
								<input type="radio" class="form-check-input" {{ $type == 2 ? 'checked' : '' }} name="type"  value="2">Opportunities
							</label>
							</div>
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" class="form-check-input" {{ $type == 3 ? 'checked' : '' }} name="type" value="3">Professional cards
								</label>
							</div>
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" class="form-check-input" {{ $type == 1 ? 'checked' : '' }} name="type" value="1">Users
								</label>
							</div>

						</div>
					</div>
				</div>

				<!-- result-->
				<div class="explore_result col-md-8 m-0 p-0 pl-3">
				@if($opportunity_cards !== null && $opportunity_cards->count() > 0)
					@foreach($opportunity_cards as $opc)
					<div data-opt-id="{{ $opc->id }}" class="search_user_block filter_oppbox">
						<div class="card mb-2">
							<div class="card-header pl-4 pr-4 color-oppportunity h-100">
								<div class="row m-0 p-0 opportunity_header">
									<p class="w-50 m-0 p-0 font-weight-bold">Opportunity</p>
									<p class="w-50 m-0 p-0 text-right  ellipsis location_font" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2">{{ (isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : $opc->country_code).', '.$opc->city }}</span></p>

								</div>
							</div>
							<div class="card-block p-4">
							<a href="/cards/{{ $opc->id }}" class="text-decoration-none" style="color:unset">
								<div class="row m-0 p-0 ">
									<div class="w-100 profile_pitch">
										<h3 class="font-weight-bold">{{ $opc->title }}</h3>
										<p style="font-size: 15px;color:#1C3041;">{{ $opc->company }}</p>
										
									</div>
								</div>
									
								<div class="row m-0 p-0 mb-4">
									<div class="w-100 profile_pitch">
										<h3 class="font-weight-bold opt_roles_font">Technical skills</h3>
										<ul class="list-unstyled list-inline margin-0-auto mb-0 request_skills">
											@foreach(json_decode($opc->fields,true) as $oc)
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
									@if($user_id == $opc->user_id)		

										<a href="/cards/{{ $opc->id }}/edit" class="textcolor-blue pull-right pl-2 opt_align_mobile"><img src="/assets/images/Icon-edit.svg" alt="Edit" style="width:25px;"><span class="pl-2">Edit</span></a>
									@endif
									@if($user_id && $user_id != $opc->user_id)
										<a href="/cards/{{ $opc->id }}"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2 opt_align_mobile"  style="color: #219BC4">Read more</a>
					
										
										<a href="#"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2 opt_align_mobile" data-toggle="dropdown"  style="color: #219BC4">Send my professional card</a>
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

										<a href="#" data-pk="{{ $opc->id }}" data-type="checklist" data-source="{{ URL::to('/') }}/ajax/get_opc_collection_list/{{$opc->id}}"  data-title="Select collections" class="opportunity_collection editable editable-click  float-right  text-decoration-none textcolor-blue pr-2 pl-2 opt_align_mobile" data-placement="bottom"   data-original-title="" title="">Add to collection</a>   
															
									@elseif(!$user_id && $user_id != $opc->user_id)
										<a href="/cards/{{ $opc->id }}"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2 opt_align_mobile"  style="color: #219BC4" >Read more</a>
										<a href="/user/login"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2 opt_align_mobile" style="color: #219BC4" data-toggle="modal" data-target="#login_modal">Send my professional card</a>		
										<a href="/user/login" class="float-right  text-decoration-none textcolor-blue pr-2 pl-2 opt_align_mobile" data-toggle="modal" data-target="#login_modal">Add to collection</a> 							
									@endif
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
						<div class="card mb-2">
							<div class="card-header pl-4 pr-4 color-opentowork h-100">
								<div class="row m-0 p-0 opportunity_header">
									<p class="w-50 m-0 p-0 font-weight-bold">Professional cards</p>
									<p class="w-50 m-0 p-0 text-right location_font ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2">{{ (isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : $opc->country_code).', '.$opc->city }}</span></p>
									
								</div>
							</div>
							<div class="card-block p-4">
							<a href="/opentowork/{{ $opc->id }}" class="text-decoration-none" style="color:unset">
								<div class="row m-0 p-0 ">
									<div class="w-100 profile_pitch">
										<h3 class="font-weight-bold">{{ strlen($opc->title) > 75 ? substr($opc->title,0,75).'...' : $opc->title }}</h3>
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
									@if($user_id == $opc->user_id)
										<a href="/opentowork/{{ $opc->id }}/edit" class="textcolor-blue pull-right pl-2 opt_align_mobile"><img src="/assets/images/Icon-edit.svg" alt="Edit" style="width:25px;"><span class="pl-2">Edit</span></a>
									@endif
										<a href="/opentowork/{{ $opc->id }}"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2 opt_align_mobile"  style="color: #219BC4">Read more</a>
										@if($user_id && $user_id != $opc->user_id)
										
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

											<a href="#" data-pk="{{ $opc->id }}" data-type="checklist" data-source="{{ URL::to('/') }}/ajax/get_opentowork_collection_list/{{$opc->id}}"  data-title="Select collections" class="opentowork_collection editable editable-click  float-right  text-decoration-none textcolor-blue pr-2 pl-2 opt_align_mobile" data-placement="bottom"   data-original-title="" title="">Add to collection</a>   
															
									
										@elseif(!$user_id && $user_id != $opc->user_id)
											<a href="/user/login"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2 opt_align_mobile" style="color: #219BC4" data-toggle="modal" data-target="#login_modal">Send my opportunity</a>		
											<a href="/user/login" class="float-right  text-decoration-none textcolor-blue pr-2 pl-2 opt_align_mobile" data-toggle="modal" data-target="#login_modal">Add to collection</a> 
										@endif
										
									</div>
								</div>
							</div>
						</div>						
					</div>
					@endforeach
				@endif

				@if($users !== null && $users->count() > 0) 
					@foreach($users as $u)
					<div data-user-id="{{ $u->id }}" class="search_user_block filter_oppbox">
						<div class="card mb-2">
							<div class="card-header pl-4 pr-4 color-user h-100" style="height:54px !important">
								<div class="row m-0 p-0 opportunity_header hide_tablet">
									@if($u->looking_for == 1)
										<span class="m-0 text-right " style="padding: 14px 24px 14px 15px;position: absolute;right:0px; top:0px;height: 54px;background: #65C5BF;float:right;">
											<img src="/assets/images/Icon-opportunity seeker.svg" style="width:30px;"><span class="pl-2">Opportunity Seeker</span>
										</span>
										<p class="p-0 font-weight-bold">User</p>
										<p class="pl-4 text-right location_font"><span class="fa fa-map-marker"></span><span class="pl-2">{{ isset($countries[$u->country_code]) ? $countries[$u->country_code] : $u->country_code }}, {{ $u->city }}</span></p>
									
									@elseif($u->looking_for == 2)
										<span class="m-0 text-right " style="padding: 14px 24px 14px 15px;position: absolute;right:0px; top:0px;height: 54px;background: #3170AF;float:right;">
											<img src="/assets/images/Icon-talent seeker.svg" style="width:30px;"><span class="pl-2">Talent Seeker</span>
										</span>
										<p class="p-0 font-weight-bold">User</p>
										<p class="pl-4 text-right location_font"><span class="fa fa-map-marker"></span><span class="pl-2">{{ isset($countries[$u->country_code]) ? $countries[$u->country_code] : $u->country_code }}, {{ $u->city }}</span></p>
									@else

									<p class="w-35 m-0 p-0 font-weight-bold">User</p>
									<p class="w-65 m-0 p-0 text-right location_font"><span class="fa fa-map-marker"></span><span class="pl-2">{{ isset($countries[$u->country_code]) ? $countries[$u->country_code] : $u->country_code }}, {{ $u->city }}</span></p>
									@endif
								</div>
								<!-- mobile -->
								<div class="row m-0 p-0 opportunity_header show_tablet">
									@if($u->looking_for == 1)
										<p class="w-25 m-0 p-0 font-weight-bold">User</p>
										<p class="w-50 m-0 p-0 text-right location_font ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2">{{ isset($countries[$u->country_code]) ? $countries[$u->country_code] : $u->country_code }}, {{ $u->city }}</span>
										</p>
										<p class="w-25 m-0 p-0 text-right ">
											<img src="/assets/images/Icon-opportunity seeker.svg" style="width:30px;">
										</p>
									
									@elseif($u->looking_for == 2)
										<p class="w-25 m-0 p-0 font-weight-bold">User</p>
										<p class="w-50 m-0 p-0 text-right location_font ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2">{{ isset($countries[$u->country_code]) ? $countries[$u->country_code] : $u->country_code }}, {{ $u->city }}</span>
										</p>
										<p class="w-25 m-0 p-0 text-right ">
											<img src="/assets/images/Icon-talent seeker.svg" style="width:30px;">
										</p>

									@else

									<p class="w-35 m-0 p-0 font-weight-bold pull-left">User</p>
									<p class="w-65 m-0 p-0 text-right location_font pull-left ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2">{{ isset($countries[$u->country_code]) ? $countries[$u->country_code] : $u->country_code }}, {{ $u->city }}</span></p>
									@endif
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

											<h3 class="font-weight-bold ellipsis" onclick="toggleEllipsis(this)">{{ $u->full_name }}</h3>
											<h3 class="ellipsis" onclick="toggleEllipsis(this)">{{ $u->profession }}</h3>
											
										</div>
									</div>
								</a>
									<div class="row m-0 p-0 mt-3">
										<div class="w-100 m-0 p-0">						
										@if($user_id == $u->id)				
											<a href="/user/{{ $u->id }}/edit" class="textcolor-blue pull-right pl-2 opt_align_mobile"><img src="/assets/images/Icon-edit.svg" alt="Edit" style="width:25px;"><span class="pl-2">Edit</span></a>
										@endif
											
										@if($user_id && $user_id != $u->id)		
											<a href="{{ URL::to('/') }}/user/{{ $u->id }}/view" class="text-decoration-none textcolor-blue float-right pl-2 opt_align_mobile">Go to profile</a>		
											<a href="/messages/{{ $u->id }}" class="text-decoration-none textcolor-blue float-right pr-2 pl-2 opt_align_mobile">Send a message</a>
											<a href="#" data-pk="{{ $u->id }}" data-type="checklist" data-source="{{ URL::to('/') }}/ajax/get_user_collection_list/{{$u->id}}"  data-title="Select collections" class="user_collection editable editable-click text-decoration-none textcolor-blue pull-right pr-2 pl-2 opt_align_mobile" data-placement="bottom"   data-original-title="" title="" style="color: #219BC4">Add to collection</a>
										@elseif(!$user_id && $user_id != $u->id)	
											<a href="{{ URL::to('/') }}/user/{{ $u->id }}/view" class="text-decoration-none textcolor-blue float-right pl-2 opt_align_mobile">Go to profile</a>	
											<a href="/user/login"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2 opt_align_mobile" style="color: #219BC4" data-toggle="modal" data-target="#login_modal">Send a message</a>		
											<a href="/user/login" class="float-right  text-decoration-none textcolor-blue pr-2 pl-2 opt_align_mobile" data-toggle="modal" data-target="#login_modal">Add to collection</a>
										@endif	
										</div>
									</div>
				
									
							</div>

						</div>						
					</div>
					@endforeach
				@endif
				@if($need_to_process_for_searching === true)
					@if(
						($users == null || ($users !== null && $users->count() == 0 )  ) &&
						($opportunity_cards == null || ($opportunity_cards !== null && $opportunity_cards->count() == 0 )  ) 
						&& ($opentowork_cards == null || ($opentowork_cards !== null && $opentowork_cards->count() == 0 )  ) 
					)
						<h2>No search result</h2>
					@endif
				@endif
				</div>
			</div>

			
			<div class="mt-5"></div>		
		</div>
	</div>


@endsection