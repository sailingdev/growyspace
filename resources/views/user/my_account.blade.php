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
						<p class="w-50 m-0 p-0 pt-1">Profile</p>
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
				<div class="w-100 m-0 p-3 toolbar">	
							@if($logged_in_user_id && !$third_person)						
								<a href="/user/{{ $user->id }}/edit" class="textcolor-blue pull-right "><img src="/assets/images/Icon-edit.svg" alt="Edit" style="width:25px;"><span class="pr-2">Edit</span></a>
								<a href="#" data-pk="{{ $user->id }}" data-type="checklist" data-source="{{ URL::to('/') }}/ajax/get_user_collection_list/{{$user->id}}"  data-title="Select collections" class="user_collection editable editable-click text-decoration-none textcolor-blue pull-left pr-2 pl-2" data-placement="bottom"   data-original-title="" title="" style="color: #219BC4">Add to collection</a>
							@endif
							@if($logged_in_user_id && $third_person)	
								<a href="#" data-pk="{{ $user->id }}" data-type="checklist" data-source="{{ URL::to('/') }}/ajax/get_user_collection_list/{{$user->id}}"  data-title="Select collections" class="user_collection editable editable-click text-decoration-none textcolor-blue pull-left pr-2 pl-2" data-placement="bottom"   data-original-title="" title="" style="color: #219BC4">Add to collection</a>
								<a href="/messages/{{ $user->id }}" class="text-decoration-none textcolor-blue float-right pr-2">Send a message</a>
							@elseif(!$logged_in_user_id && $third_person)	
								
								<a href="#" data-toggle="modal" data-target="#login_modal" class="user_collection  text-decoration-none textcolor-blue pull-left pr-2 pl-2" style="color: #219BC4">Add to collection</a>
								<a href="#" data-toggle="modal" data-target="#login_modal" class="text-decoration-none textcolor-blue float-right pr-2">Send a message</a>
							@endif	
								<a href="{{ URL::to('/') }}/exportProfile/{{ $user->id }}" class="editable editable-click  float-left  text-decoration-none textcolor-blue  pr-2 pl-2 cusor_pointer opt_align_mobile" >Download PDF</a> 

								<a href="#" id="profile_share" data-type="text" data-title="Copy this link to share" class="editable editable-click  float-left  text-decoration-none textcolor-blue  pr-2 pl-2 opt_align_mobile" data-placement="bottom" data-original-title="" title="" data-value="{{ URL::to('/') }}/user/{{ $user->id }}#">Share</a> 

				</div>
				<div class="card-block p-4 toolbar_card">
						
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

						<div class="row m-0 p-0 ">
							<div class="mt-3 w-100 profile_experience">
								<h3 class="font-weight-bold mypresentation color-black1">Experience</h3>
								@foreach($user_experiences as $ue)
								<div class="row m-0 p-0 mb-2 profile_company hide_mobile">
									<p class="w-50 m-0 p-0 font-weight-bold profile_exp_font color-black1 ellipsis" onclick="toggleEllipsis(this)">{{$ue->title}}</p>
									<p class="w-50 m-0 p-0 text-left profile_exp_font myexp_company color-black2 ellipsis" onclick="toggleEllipsis(this)">{{$ue->company}}</p>
									<p class="w-50 m-0 p-0 mt-2 myexp_location color-black2 ellipsis" onclick="toggleEllipsis(this)">
										<!-- <img src="/assets/images/location.png">&nbsp;{{ (isset($countries[$ue->country_code]) ? $countries[$ue->country_code] : '' ) .', '.$ue->city }}</p> -->
										<span class="fa fa-map-marker"></span>&nbsp;{{ (isset($countries[$ue->country_code]) ? $countries[$ue->country_code] : '' ) .', '.$ue->city }}</p>
									<p class="w-50 m-0 p-0 text-left mt-2 myexp_location color-black2 ellipsis" onclick="toggleEllipsis(this)">{{ date("F, Y", strtotime($ue->from_date)) }} - 
									@if($ue->currently_working == 1)
										Present
									@else	
										{{ date("F, Y", strtotime($ue->to_date)) }}
									@endif
									</p>
								</div>
								<!-- mobile -->
								<div class="row m-0 p-0 mb-2 profile_company show_mobile">
									<p class="w-100 m-0 p-0 font-weight-bold profile_exp_font color-black1 ellipsis" onclick="toggleEllipsis(this)">{{$ue->title}}</p>
									<p class="w-100 m-0 p-0 text-left profile_exp_font myexp_company color-black2 ellipsis" onclick="toggleEllipsis(this)">{{$ue->company}}</p>
									<p class="w-100 m-0 p-0 mt-2 myexp_location color-black2 ellipsis" onclick="toggleEllipsis(this)">
										<!-- <img src="/assets/images/location.png">&nbsp;{{ (isset($countries[$ue->country_code]) ? $countries[$ue->country_code] : '' ) .', '.$ue->city }}</p> -->
										<span class="fa fa-map-marker"></span>&nbsp;{{ (isset($countries[$ue->country_code]) ? $countries[$ue->country_code] : '' ) .', '.$ue->city }}</p>
									<p class="w-100 m-0 p-0 text-left mt-2 myexp_location color-black2 ellipsis" onclick="toggleEllipsis(this)">{{ date("F, Y", strtotime($ue->from_date)) }} - 
									@if($ue->currently_working == 1)
										Present
									@else	
										{{ date("F, Y", strtotime($ue->to_date)) }}
									@endif
									</p>
								</div>
								@endforeach
							</div>
                		</div>
						<div class="row m-0 p-0 ">
							<div class="mt-3 w-100 profile_experience">
								<h3 class="font-weight-bold mypresentation color-black1">Education</h3>
								@foreach($user_educations as $ue)
								<div class="row m-0 p-0 mb-2 profile_company hide_mobile">
									<p class="w-50 m-0 p-0 font-weight-bold profile_exp_font myexperience color-black1 ellipsis" onclick="toggleEllipsis(this)">{{$ue->title}}</p>
									<p class="w-50 m-0 p-0 text-left profile_exp_font myexp_company color-black2 ellipsis" onclick="toggleEllipsis(this)">{{$ue->school}}</p>
									<!-- <p class="w-50 m-0 p-0"><img src="/assets/images/location.png">&nbsp;{{ (isset($countries[$ue->country_code]) ? $countries[$ue->country_code] : '' ) .', '.$ue->city }}</p> -->
									<p class="w-50 m-0 p-0 mt-2 myexp_location color-black2 ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span>&nbsp;{{ (isset($countries[$ue->country_code]) ? $countries[$ue->country_code] : '' ) .', '.$ue->city }}</p>
									<p class="w-50 m-0 p-0 text-left mt-2 myexp_location color-black2 ellipsis" onclick="toggleEllipsis(this)">{{ $ue->from_year }} to {{ $ue && $ue->to_year !=null ?  $ue->to_year : 'Present'}}
									</p>
								</div>
								<!-- mobile -->
								<div class="row m-0 p-0 mb-2 profile_company show_mobile">
									<p class="w-100 m-0 p-0 font-weight-bold profile_exp_font myexperience color-black1">{{ $ue->title }}</p>
									<p class="w-100 m-0 p-0 text-left profile_exp_font myexp_company color-black2 ellipsis" onclick="toggleEllipsis(this)">{{ $ue->school  }}</p>
									<!-- <p class="w-50 m-0 p-0"><img src="/assets/images/location.png">&nbsp;{{ (isset($countries[$ue->country_code]) ? $countries[$ue->country_code] : '' ) .', '.$ue->city }}</p> -->
									<p class="w-100 m-0 p-0 mt-2 myexp_location color-black2 ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span>&nbsp;{{ (isset($countries[$ue->country_code]) ? $countries[$ue->country_code] : '' ) .', '.$ue->city }}</p>
									<p class="w-100 m-0 p-0 text-left mt-2 myexp_location color-black2 ellipsis" onclick="toggleEllipsis(this)">{{ $ue->from_year }} to {{ $ue && $ue->to_year != null ?  $ue->to_year : 'Present'}}
									</p>
								</div>
								@endforeach
							</div>
                		</div>
						<div class="row m-0 p-0 ">
							<div class="w-100 profile_pitch">
								<h3 class="font-weight-bold mypresentation">Roles of interest</h3>
								<ul class="list-unstyled list-inline margin-0-auto mb-0 request_skills">
									@foreach($opc_roles as $oc)
									<li class="list-inline-item mr-0 pr-2 pb-2" style="margin:0px">
										<div class="chip bgcolor-purple mr-0 chip-custom">{{$oc}}</div>
									</li>
									@endforeach	
								</ul>
							</div>
						</div>	
						<div class="row m-0 p-0 ">
							<div class="w-100 profile_pitch">
								<h3 class="font-weight-bold mypresentation">Technical skills</h3>
								<ul class="list-unstyled list-inline margin-0-auto mb-0 ">
								@foreach($opc_fields as $oc)
								<li class="list-inline-item mr-0 pr-2 pt-2">
									<div class="chip color-experience mr-0 custom_endorse">
										<p style="margin: 0px;">{{ $oc }}</p>
									
										<span >
											@if(in_array($logged_in_user_id, $opc_endorse[$oc]))
												@if($logged_in_user_id)
												<a href="#" data-type="checklist" data-source="{{ URL::to('/') }}/ajax/get_endorse_list/{{$user_id}}/{{$oc}}"  data-title="Endorsed User list" class="endorse_list editable editable-click" data-placement="bottom"   data-original-title="" title="" data-logined="{{$logged_in_user_id}}"><img src='/assets/images/Icon-endorsed.svg' alt='Endorse' style='width:30px;' /></a>
												@else
													<img src='/assets/images/Icon-endorsed.svg' alt='Endorse' style='width:30px;' />
												@endif
												@if(count($opc_endorse[$oc]))
												<span>X {{count($opc_endorse[$oc])}}</span>
												@endif
											<span class="opentowork_endorse float-right pl-4"  data-opt-skill="{{ $oc }}" data-opt-id="{{$user_id}}" data-user-id="{{ $user_id }}" data-logined="{{$logged_in_user_id}}" class="undo_icon">Undo</span>
											
											@else

												@if(count($opc_endorse[$oc]))
													@if($logged_in_user_id)
													<a href="#"  data-pk="{{ $user_id }}" data-type="checklist" data-source="{{ URL::to('/') }}/ajax/get_endorse_list/{{$user_id}}/{{$oc}}"  data-title="Endorsed User list" class="endorse_list editable editable-click" data-placement="bottom"   data-original-title="" title="" data-logined="{{$logged_in_user_id}}"><img src='/assets/images/Icon-endorsed.svg' alt='Endorse' style='width:30px;' /></a>   
													@else
														<img src='/assets/images/Icon-endorsed.svg' alt='Endorse' style='width:30px;' />
													@endif                                     
													<span>X {{count($opc_endorse[$oc])}}</span>
												@else
													<img src='/assets/images/Icon-endorsed-1.svg' alt='Endorse' style='width:30px;' />
												@endif
												<span class="opentowork_endorse float-right pl-4"  data-opt-skill="{{ $oc }}" data-user-id="{{ $user_id }}" data-opt-id="{{$user_id}}" data-logined="{{$logged_in_user_id}}" class="undo_icon">Endorse</span>
											@endif
										</span>
									</div>
								</li>
								@endforeach
								</ul>
							</div>
                		</div>	
					
				</div>

			</div>
			@if(!$third_person)
			<div class="matchmaking_p" >
				@if($user->looking_for != 0)			
				<a href="/findmatch/{{ $user->id }}" class="btn button_create_opportunity" style="background:#219BC4">Matchmaking advanced</a>
				@endif

				@if(($user->looking_for == 2 || $user->looking_for == 3) && $licence > 1)
				<a href="/cards" class="btn button_create_opportunity mt-3">Create new Opportunity</a>
				@endif
			</div>
			<!-- <div class="row m-0 p-0 mt-5 display_button1" style="{{ $user->matchmaking == 0 ? 'display:none;' : '' }}">
				<p class="matchmaking_p">
				<a href="/findmatch/{{ $user->id }}" class="btn button_create_opportunity" style="background:#219BC4">Matchmaking advanced</a>
				</p>
			</div> -->
			<div class="row m-0 p-0 mt-5 display_button2" style="{{ $user->matchmaking == 0 ? 'display:none;' : '' }}">	
				<p class="w-100 m-0 p-0 text-right">
				<a href="/findmatch/{{ $user->id }}" class="btn button_create_opportunity" style="background:#219BC4">Matchmaking advanced</a>
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
			</div>
		</div>
	</div>
@endsection