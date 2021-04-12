@extends('layouts.front')
@section('content')
	<div class="row m-0 bg-gray">
		<div class="col-md-12 head_logo_area_small mt-5">
		@if(!$third_person)
			<div class="head_logo">		
			<img src='/assets/images/icon-profile 1.svg' alt='profile' class="pull-left" ><h3 class="pull-left" >My profile</h3>
			</div>
			<div class="pull-left ml-3">
				<a onclick="window.history.back();" class="cusor_pointer display_image1"><img src="/assets/images/Frame 6.svg" alt="Back" ></a>
			</div>
		@endif
		</div>

		<div class="col-md-8 mx-auto" >
			<!-- profile -->
			<div class="card mb-2">
			@if($third_person)
			<a onclick="window.history.back();" class="left_back cusor_pointer display_image1"><img src="/assets/images/Frame 6.svg" alt="Back" ></a>
        	<a onclick="window.history.back();" class="left_back cusor_pointer display_image2"><img src="/assets/images/backformobile.svg" alt="Back" ></a>
			@endif
				<div class="card-header color-user" style="height: 54px;">
					@if($user->is_deleted == 1)
						<div class="alert alert-danger fade in alert-dismissible show">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true" style="font-size:20px">×</span>
						</button>    <strong>Alert!</strong> This account has been cancelled, please contact Support
						</div>
					@endif
					
					<div class="row m-0 p-0 hide_mobile">
						@if($user->looking_for == 1)
						<span class="m-0 text-right " style="padding: 14px 24px 14px 15px;position: absolute;right:0px; top:0px;height: 54px;background: #65C5BF;float:right;border-radius: 0px 3px 0px 0px;">
							<img src="/assets/images/Icon-opportunity seeker.svg" style="width:30px;"><span class="pl-2">Opportunity Seeker</span>
						</span>
						@elseif($user->looking_for == 2)
						<span class="m-0 text-right " style="padding: 14px 24px 14px 15px;position: absolute;right:0px; top:0px;height: 54px;background: #3170AF;float:right;border-radius: 0px 3px 0px 0px;">
							<img src="/assets/images/Icon-talent seeker.svg" style="width:30px;"><span class="pl-2">Talent Seeker</span>
						</span>
						@elseif($user->looking_for == 3)
						<span class="m-0 text-right " style="padding: 14px 24px 14px 15px;position: absolute;right:0px; top:0px;height: 54px;background: #EAEAEA;float:right;color:#000000;border-bottom:1px solid #B7B1D8;border-radius: 0px 3px 0px 0px;">
							<img src="/assets/images/Icon-news.svg" style="width:30px;"><span class="pl-2">Sourcer Pro</span>
						</span>
						@endif
					</div>
					<!-- mobile -->
					<div class="row m-0 p-0  show_mobile">
						@if($user->looking_for == 1)
						<p class="w-75 m-0 pl-1 pull-left text-left ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2">{{$user->city}}, {{$countries[$user->country_code]}}</span></p>
						<p class="w-25 m-0 p-0 pull-left text-right">
							<img src="/assets/images/Icon-opportunity seeker.svg" style="width:30px;">
						</p>
						@elseif($user->looking_for == 2)
						<p class="w-75 m-0 pl-1 pull-left text-left ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2">{{$user->city}}, {{$countries[$user->country_code]}}</span></p>
						<p class="w-25 m-0 p-0 pull-left text-right">
							<img src="/assets/images/Icon-talent seeker.svg" style="width:30px;">
						</p>
						@elseif($user->looking_for == 3)
						<p class="w-75 m-0 pl-1 pull-left text-left ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2">{{$user->city}}, {{$countries[$user->country_code]}}</span></p>
						<p class="w-25 m-0 p-0 pull-left text-right">
							<img src="/assets/images/Icon-news.svg" style="width:30px;">
						</p>
						@endif
					</div>
					
				</div>
				<div class="card-block p-4">
						
						<div class="row m-0 p-0 profile_picture">
							<div class="profile_img">
						@if($profile_image_src !== false)
							<img src='{{$profile_image_src}}' class="img-fluid pull-left" >
						@else
							@if($owner === true)
								<img  src="{{ URL::to('/') }}/assets/images/noprofileIMG.png" class="img-fluid pull-left" />
							@else
								<img src="{{ URL::to('/') }}/assets/images/noprofileIMG.png" class="img-fluid pull-left" />
							@endif
						@endif
							</div>
							<div class="profile_name pull-left">

								<h3 class="font-weight-bold myname color-black1 ellipsis" onclick="toggleEllipsis(this)">{{ $user->full_name }}</h3>
								<h3 class="myprofessor color-black2 ellipsis" onclick="toggleEllipsis(this)">{{ $user->profession }}</h3>
								<p class="mylocation color-black1">
									<!-- <img src="/assets/images/location.png"> {{$user->city}}, {{$countries[$user->country_code]}}</p> -->
									<span class="fa fa-map-marker"></span> {{$user->city}}, {{$countries[$user->country_code]}}</p>
							</div>
						</div>
				
						<div class="row m-0 p-0 ">
							<div class="w-100 mt-3 profile_pitch">
								<h3 class="font-weight-bold mypresentation color-black1">Presentation letter</h3>
								<p class="mypictch color-black1 m-0">{{ $user->my_pitch }}</p>
							</div>
						</div>



						<div class="row m-0 p-0 mt-3">
							<div class="w-100 m-0 p-0">	
							@if($logged_in_user_id && !$third_person)						
								<a href="/user/{{ $user->id }}/edit" class="textcolor-blue pull-right pl-2"><img src="/assets/images/Icon-edit.svg" alt="Edit" style="width:25px;"><span class="pl-2">Edit</span></a>
								<a href="#" data-pk="{{ $user->id }}" data-type="checklist" data-source="{{ URL::to('/') }}/ajax/get_user_collection_list/{{$user->id}}"  data-title="Select collections" class="user_collection editable editable-click text-decoration-none textcolor-blue pull-right pr-2 pl-2" data-placement="bottom"   data-original-title="" title="" style="color: #219BC4">Add to collection</a>
							@endif
							@if($logged_in_user_id && $third_person)	
								<a href="#" data-pk="{{ $user->id }}" data-type="checklist" data-source="{{ URL::to('/') }}/ajax/get_user_collection_list/{{$user->id}}"  data-title="Select collections" class="user_collection editable editable-click text-decoration-none textcolor-blue pull-right pr-2 pl-2" data-placement="bottom"   data-original-title="" title="" style="color: #219BC4">Add to collection</a>
								<a href="/messages/{{ $user->id }}" class="text-decoration-none textcolor-blue float-right pr-2">Send a message</a>
							@elseif(!$logged_in_user_id && $third_person)	
								
								<a href="#" data-toggle="modal" data-target="#login_modal" class="user_collection  text-decoration-none textcolor-blue pull-right pr-2 pl-2" style="color: #219BC4">Add to collection</a>
								<a href="#" data-toggle="modal" data-target="#login_modal" class="text-decoration-none textcolor-blue float-right pr-2">Send a message</a>
							@endif	
							</div>
						</div>
	

				</div>

			</div>
			@if(!$third_person)
			<div class="row m-0 p-0 mt-5 display_button1" style="{{ $user->matchmaking == 0 ? 'display:none;' : '' }}">
				<p class="w-65 m-0 p-0"></p>
				<p class="w-35 m-0 p-0 text-right">
				<a href="/findmatch/{{ $user->id }}" class="btn button_create_opportunity" style="background:#219BC4">Matchmaking advanced</a>
				</p>
			</div>
			<div class="row m-0 p-0 mt-5 display_button2" style="{{ $user->matchmaking == 0 ? 'display:none;' : '' }}">	
				<p class="w-100 m-0 p-0 text-right">
				<a href="/findmatch/{{ $user->id }}" class="btn button_create_opportunity" style="background:#219BC4">Matchmaking advanced</a>
				</p>
			</div>	
			@endif		
			<!-- opportunity -->
			@foreach($opportunity_cards as $opc)
			<div class="card mt-5 mb-2">
				<div class="card-header pl-4 pr-4 color-oppportunity h-100">
					<div class="row m-0 p-0 opportunity_header">
						<p class="w-50 m-0 p-0 font-weight-bold">Opportunity</p>
						<!-- <p class="w-65 m-0 p-0 text-right font-weight-bold"><img src="/assets/images/location2.png"><span class="pl-2">{{ (isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : $opc->country_code).', '.$opc->city }}</span></p> -->
						<p class="w-50 m-0 p-0 text-right location_font ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2">{{ (isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : $opc->country_code).', '.$opc->city }}</span></p>
						
					</div>
				</div>
				<div class="card-block p-4">
					<a href="/cards/{{ $opc->id }}" class="text-decoration-none" style="color:unset">
						<div class="row m-0 p-0 ">
							<div class="w-100 profile_pitch">
								<h3 class="font-weight-bold ellipsis" onclick="toggleEllipsis(this)">{{ $opc->title }}</h3>
								<p style="font-size: 15px;color:#1C3041;">{{ $opc->company }}</p>
								
							</div>
						</div>
						
						<div class="row m-0 p-0 ">
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
						@if(!$third_person)		

							<a href="/cards/{{ $opc->id }}/edit" class="textcolor-blue pull-right pl-2"><img src="/assets/images/Icon-edit.svg" alt="Edit" style="width:25px;"><span class="pl-2">Edit</span></a>
						@endif
							<a href="/cards/{{ $opc->id }}"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2"  style="color: #219BC4">Read more</a>
							@if($logged_in_user_id && $third_person)	
								
									<a href="#"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2" data-toggle="dropdown"  style="color: #219BC4">Send my professional card</a>
									<div class="dropdown-menu dropdown-menu-right"  style="padding: 0px;">
										@if(count($opentowork_card) > 0) 
											<ul style="margin: 0px;padding: 0px;">
												@foreach ($opentowork_card as $item)
													<li class="list-unstyled send_opentowork"><a href="{{ URL::to('/') }}/opentowork/{{ $item->id }}">{{$item->title}}</a></li>
												@endforeach
													<li class="list-unstyled send_opentowork"><a href="{{ URL::to('/') }}/opentowork/{{ $opc->id }}/refer">Create New one</a></li>
											</ul>
										@else
											<li class="list-unstyled send_opentowork"><a href="{{ URL::to('/') }}/opentowork/{{ $opc->id }}/refer">Create New one</a></li>
										@endif
									</div>

									<a href="#" data-pk="{{ $opc->id }}" data-type="checklist" data-source="{{ URL::to('/') }}/ajax/get_opc_collection_list/{{$opc->id}}"  data-title="Select collections" class="opportunity_collection editable editable-click  float-right  text-decoration-none textcolor-blue pr-2 pl-2" data-placement="bottom"   data-original-title="" title="">Add to collection</a>   
													
							@elseif(!$logged_in_user_id && $third_person)	

								<a href="#"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2" data-toggle="modal" data-target="#login_modal"  style="color: #219BC4">Send my professional card</a>
								<a href="#" data-toggle="modal" data-target="#login_modal" class="float-right  text-decoration-none textcolor-blue pr-2 pl-2" >Add to collection</a>
							@endif	
						</div>
					</div>
				</div>
			</div>
			@endforeach	
			<!-- Add Opportunity -->
			@if(!$third_person && ($user->looking_for == 2 || $user->looking_for == 0))			
			<div class="row m-0 p-0 mt-5 display_button1">
				<p class="w-65 m-0 p-0"></p>
				<p class="w-35 m-0 p-0 text-right">
				<a href="/cards" class="btn button_create_opportunity">Create new Opportunity</a>
				</p>
			</div>
			<div class="row m-0 p-0 mt-5 display_button2">		
				<p class="w-100 m-0 p-0 text-right">
				<a href="/cards" class="btn button_create_opportunity">Create new Opportunity</a>
				</p>
			</div>
			@endif
			<!-- opentowork -->
			@if(count($opentowork_card) > 0)
			@foreach($opentowork_card as $opc)
				@if($opc->refer)
					@if(!$third_person)
						<div class="card mt-5 mb-2">
						<div class="card-header pl-4 pr-4 color-opentowork h-100">
							<div class="row m-0 p-0 opportunity_header">
								<p class="w-50 m-0 p-0 font-weight-bold">Professional card</p>
								<!-- <p class="w-65 m-0 p-0 text-right font-weight-bold"><img src="/assets/images/location2.png"><span class="pl-2">{{ (isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : $opc->country_code).', '.$opc->city }}</span></p> -->
								<p class="w-50 m-0 p-0 text-right location_font ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2">{{ (isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : $opc->country_code).', '.$opc->city }}</span></p>
								
							</div>
						</div>
						<div class="card-block p-4">
							<a href="/opentowork/{{ $opc->id }}" class="text-decoration-none" style="color:unset">
								<div class="row m-0 p-0 ">
									<div class="w-100 profile_pitch">
										<h3 class="font-weight-bold">{{ $opc->title }}</h3>
									</div>
								</div>

								<div class="row m-0 p-0 ">
									<div class="w-100 profile_pitch">
										<p></p>
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

									<a href="/opentowork/{{ $opc->id }}/edit" class="textcolor-blue pull-right pl-2"><img src="/assets/images/Icon-edit.svg" alt="Edit" style="width:25px;"><span class="pl-2">Edit</span></a>
								@endif
									<a href="/opentowork/{{ $opc->id }}"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2"  style="color: #219BC4">Read more</a>
								@if($logged_in_user_id && $third_person)	
									
										<a href="#" class=" float-right  text-decoration-none textcolor-blue pr-2 pl-2" data-toggle="dropdown">Send my opportunity</a>    
																
										<div class="dropdown-menu dropdown-menu-right"  style="padding: 0px;">
										@if(count($opportunity_cards) > 0) 
											<ul style="margin: 0px;padding: 0px;">
												@foreach ($opportunity_cards as $item)
													<li class="list-unstyled send_opentowork"><a href="{{ URL::to('/') }}/cards/{{ $item->id }}">{{$item->title}}</a></li>
												@endforeach
													<li class="list-unstyled send_opentowork"><a href="{{ URL::to('/') }}/cards/{{ $opc->id }}/refer">Create New one</a></li>
											</ul>
										@else
											<li class="list-unstyled send_opentowork"><a href="{{ URL::to('/') }}/cards/{{ $opc->id }}/refer">Create New one</a></li>
										@endif
										</div>

										<a href="#" data-pk="{{ $opc->id }}" data-type="checklist" data-source="{{ URL::to('/') }}/ajax/get_opc_collection_list/{{$opc->id}}"  data-title="Select collections" class="opportunity_collection editable editable-click  float-right  text-decoration-none textcolor-blue pr-2 pl-2" data-placement="bottom"   data-original-title="" title="">Add to collection</a>   
														
								@elseif(!$logged_in_user_id && $third_person)	

									<a href="#" data-toggle="modal" data-target="#login_modal" class=" float-right  text-decoration-none textcolor-blue pr-2 pl-2" data-toggle="dropdown">Send my opportunity</a> 
									<a href="#" data-toggle="modal" data-target="#login_modal" class="user_collection  text-decoration-none textcolor-blue pull-right pr-2 pl-2" style="color: #219BC4">Add to collection</a>
								@endif
									
								</div>
							</div>
						</div>
					</div>
					@endif
				@else
				<div class="card mt-5 mb-2">
					<div class="card-header pl-4 pr-4 color-opentowork h-100">
						<div class="row m-0 p-0 opportunity_header">
							<p class="w-50 m-0 p-0 font-weight-bold">Professional card</p>
							<!-- <p class="w-65 m-0 p-0 text-right font-weight-bold"><img src="/assets/images/location2.png"><span class="pl-2">{{ (isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : $opc->country_code).', '.$opc->city }}</span></p> -->
							<p class="w-50 m-0 p-0 text-right location_font ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2">{{ (isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : $opc->country_code).', '.$opc->city }}</span></p>
							
						</div>
					</div>
					<div class="card-block p-4">
						<a href="/opentowork/{{ $opc->id }}" class="text-decoration-none" style="color:unset">
							<div class="row m-0 p-0 ">
								<div class="w-100 profile_pitch">
									<h3 class="font-weight-bold">{{ $opc->title }}</h3>
								</div>
							</div>

							<div class="row m-0 p-0 ">
								<div class="w-100 profile_pitch">
									<p></p>
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

								<a href="/opentowork/{{ $opc->id }}/edit" class="textcolor-blue pull-right pl-2"><img src="/assets/images/Icon-edit.svg" alt="Edit" style="width:25px;"><span class="pl-2">Edit</span></a>
							@endif
								<a href="/opentowork/{{ $opc->id }}"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2"  style="color: #219BC4">Read more</a>
							@if($logged_in_user_id && $third_person)	
								
									<a href="#" class=" float-right  text-decoration-none textcolor-blue pr-2 pl-2" data-toggle="dropdown">Send my opportunity</a>    
															
									<div class="dropdown-menu dropdown-menu-right"  style="padding: 0px;">
									@if(count($opportunity_cards) > 0) 
										<ul style="margin: 0px;padding: 0px;">
											@foreach ($opportunity_cards as $item)
												<li class="list-unstyled send_opentowork"><a href="{{ URL::to('/') }}/cards/{{ $item->id }}">{{$item->title}}</a></li>
											@endforeach
												<li class="list-unstyled send_opentowork"><a href="{{ URL::to('/') }}/cards/{{ $opc->id }}/refer">Create New one</a></li>
										</ul>
									@else
										<li class="list-unstyled send_opentowork"><a href="{{ URL::to('/') }}/cards/{{ $opc->id }}/refer">Create New one</a></li>
									@endif
									</div>

									<a href="#" data-pk="{{ $opc->id }}" data-type="checklist" data-source="{{ URL::to('/') }}/ajax/get_opc_collection_list/{{$opc->id}}"  data-title="Select collections" class="opportunity_collection editable editable-click  float-right  text-decoration-none textcolor-blue pr-2 pl-2" data-placement="bottom"   data-original-title="" title="">Add to collection</a>   
													
							@elseif(!$logged_in_user_id && $third_person)	

								<a href="#" data-toggle="modal" data-target="#login_modal" class=" float-right  text-decoration-none textcolor-blue pr-2 pl-2" data-toggle="dropdown">Send my opportunity</a> 
								<a href="#" data-toggle="modal" data-target="#login_modal" class="user_collection  text-decoration-none textcolor-blue pull-right pr-2 pl-2" style="color: #219BC4">Add to collection</a>
							@endif
								
							</div>
						</div>
					</div>
				</div>
				@endif	
				

			@endforeach	
			@endif
			<!-- Add opentowork -->
			@if(!$third_person && ($user->looking_for == 1 || $user->looking_for == 0))		
			<div class="row m-0 p-0 mt-5 display_button1">
				<p class="w-65 m-0 p-0"></p>
				<p class="w-35 m-0 p-0 text-right">
				<a href="/opentowork" class="btn button_create_opportunity color-opentowork">Create new professional card</a>
				</p>
			</div>	
			<div class="row m-0 p-0 mt-5 display_button2">
				<p class="w-100 m-0 p-0 text-right">
				<a href="/opentowork" class="btn button_create_opportunity color-opentowork">Create new professional card</a>
				</p>
			</div>	
			@endif
			<div class="mt-5"></div>	
			@if($third_person)
			<p class="text-center">
            	<a onclick="window.history.back();" ckass="cusor_pointer"><img src='/assets/images/back_arrow_round.svg' alt='Back' ></a>
			</p>
			@endif	
			<div class="alert alert-secondary m-0 p-0 p-4 mb-5" role="alert" style="background:#fff;border-radius:10px;">
			Still unsure on what to do? Go to the <a href="/oportunity_guide" style="color:#219BC4;">Opportunity seeker guide</a> if you are looking for job opportunities and go to the <a href="/opentowork_guide" style="color:#219BC4;">Talent seeker guide</a> if you are looking to recruit talents.
				<!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              	</button> -->
			</div>
		</div>
	</div>
@endsection