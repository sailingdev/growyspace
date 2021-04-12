@extends('layouts.front')
@section('content') 
<div class="row m-0 bg-gray">
    <div class="col-md-12">

    </div>

    <div class="col-md-8 mx-auto" >
        
        <!-- opportunity -->
        <div class="card mt-5 mb-2 bgcolor-e1e3dd">
            @if($user_id)
            <a onclick="window.history.back();" class="left_back mb-1 cusor_pointer display_image1"><img src="/assets/images/Frame 6.svg" alt="Back" ></a>
            <a onclick="window.history.back();" class="left_back cusor_pointer display_image2"><img src="/assets/images/backformobile.svg" alt="Back" ></a>
            @endif
            @if($opc && $opc->refer == 1 && !$third_person) 
            <div class="card-header pl-4 pr-4 color-opentowork h-100 hidden_opc">
                <div class="d-flex m-0 p-0 opportunity_header">
                    
                    <div class="hiddenState_opt_title">
                        <p class="m-0 p-0 font-weight-bold">Professional card</p>
                        
                    </div>
                    <div class="hiddenState_opt_icon d-flex m-0 p-0">
                        <img src="/assets/images/Icon-talent seeker-profile.png" class="pull-left hiddenState_opt_desktop" alt="">
                        <div class="pull-left m-0 p-0 hiddenState_opt_cont hiddenState_opt_desktop">
                        <p>This professional card is hidden and will only appear to the talent seekers you send it to.</p></div>
                        
                        <img src="/assets/images/Icon-talent seeker-profile-mobile.png" class="pull-left img-fluid hiddenState_opt_mobile" style="margin: 0 auto;" alt="">
                    </div>
                    <div class="hiddenState_opt_edit">
                        <p class="m-0 p-0 text-right font-weight-bold ">
                        @if(!$third_person)
                            <a href="{{ URL::to('/') }}/opentowork/{{$opc->id}}/edit" class="text-decoration-none text-white"> <img src="/assets/images/Icon-edit.svg" style="width:30px;"><span class="pl-2">Edit</span></a>
                        @endif
                        </p>
                    </div>
                    
                </div>
            </div>
            @else
            <div class="card-header pl-4 pr-4 color-opentowork h-100">
                <div class="row m-0 p-0 opportunity_header">
                    <p class="w-65 m-0 p-0 font-weight-bold">Professional card</p>
                    <p class="w-35 m-0 p-0 text-right font-weight-bold ">
                    @if(!$third_person)
                        <a href="{{ URL::to('/') }}/opentowork/{{$opc->id}}/edit" class="text-decoration-none text-white"> <img src="/assets/images/Icon-edit.svg" style="width:30px;"><span class="pl-2">Edit</span></a>
                    @endif
                    </p>
                    
                </div>
            </div>
            @endif

            <div class="card-block p-4">
                <div class="row m-0 p-0 ">
                    <div class="w-100 profile_pitch ">
                        <h3 class="font-weight-bold ellipsis" onclick="toggleEllipsis(this)">{{ $opc->title }}</h3>
                        <p class="" onclick="toggleEllipsis(this)">{{ $opc->email }}</p>
                        <p class="" onclick="toggleEllipsis(this)">{{ $opc->phone }}</p>
                        <!-- <p><img src="/assets/images/location.png" alt="Location" > <span class="pl-2">{{ $opc->city }}, {{ isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : '' }} </span></p> -->
                        <p class="" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span> <span class="pl-2">{{ $opc->city }}, {{ isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : '' }} </span></p>
                    </div>
                </div>

                <div class="row m-0 p-0 ">
                    <div class="w-100 profile_pitch">
                        <h3 class="font-weight-bold">Pictch</h3>
                       <p>{!! nl2br(strip_tags($opc->description)) !!}</p>
                        
                    </div>
                </div>
                <div class="row m-0 p-0 ">
                    <div class="mt-3 w-100 profile_experience">
                        <h3 class="font-weight-bold mypresentation color-black1">Experience</h3>
                        @foreach($user_experiences as $ue)
                        <div class="row m-0 p-0 mb-2 profile_company hide_mobile">
                            <p class="w-50 m-0 p-0 font-weight-bold profile_exp_font myexperience color-black1 ellipsis" onclick="toggleEllipsis(this)">{{$ue->title}}</p>
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
                            <p class="w-100 m-0 p-0 font-weight-bold profile_exp_font myexperience color-black1 ellipsis" onclick="toggleEllipsis(this)">{{$ue->title}}</p>
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
                        <h3 class="font-weight-bold">Roles of interest</h3>
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
                        <h3 class="font-weight-bold">Technical skills</h3>
                        <ul class="list-unstyled list-inline margin-0-auto mb-0 ">
                        @foreach($opc_fields as $oc)
                        <li class="list-inline-item mr-0 pr-2 pt-2">
                            <div class="chip color-experience mr-0 custom_endorse">
                                <p style="margin: 0px;">{{ $oc }}</p>
                              
                                <span >
                                    @if(in_array($logged_in_user_id, $opc_endorse[$oc]))
                                        @if($logged_in_user_id)
                                        <a href="#" data-type="checklist" data-source="{{ URL::to('/') }}/ajax/get_endorse_list/{{$opc->user_id}}/{{$oc}}"  data-title="Endorsed User list" class="endorse_list editable editable-click" data-placement="bottom"   data-original-title="" title="" data-logined="{{$logged_in_user_id}}"><img src='/assets/images/Icon-endorsed.svg' alt='Endorse' style='width:30px;' /></a>
                                        @else
                                            <img src='/assets/images/Icon-endorsed.svg' alt='Endorse' style='width:30px;' />
                                        @endif
                                        @if(count($opc_endorse[$oc]))
                                        <span>X {{count($opc_endorse[$oc])}}</span>
                                        @endif
                                    <span class="opentowork_endorse float-right pl-4"  data-opt-skill="{{ $oc }}" data-opt-id="{{$opc->id}}" data-user-id="{{ $opc->user_id }}" data-logined="{{$logged_in_user_id}}" class="undo_icon">Undo</span>
                                    
                                    @else

                                        @if(count($opc_endorse[$oc]))
                                            @if($logged_in_user_id)
                                             <a href="#"  data-pk="{{ $opc->user_id }}" data-type="checklist" data-source="{{ URL::to('/') }}/ajax/get_endorse_list/{{$opc->user_id}}/{{$oc}}"  data-title="Endorsed User list" class="endorse_list editable editable-click" data-placement="bottom"   data-original-title="" title="" data-logined="{{$logged_in_user_id}}"><img src='/assets/images/Icon-endorsed.svg' alt='Endorse' style='width:30px;' /></a>   
                                            @else
                                                <img src='/assets/images/Icon-endorsed.svg' alt='Endorse' style='width:30px;' />
                                            @endif                                     
                                            <span>X {{count($opc_endorse[$oc])}}</span>
                                        @else
                                            <img src='/assets/images/Icon-endorsed-1.svg' alt='Endorse' style='width:30px;' />
                                        @endif
                                        <span class="opentowork_endorse float-right pl-4"  data-opt-skill="{{ $oc }}" data-user-id="{{ $opc->user_id }}" data-opt-id="{{$opc->id}}" data-logined="{{$logged_in_user_id}}" class="undo_icon">Endorse</span>
                                    @endif
                                </span>
                            </div>
                        </li>
                        @endforeach
                        </ul>
                    </div>
                </div>	

                <div class="row m-0 p-0 mt-5">
					@if($user_id)	
						<div class="w-100 m-0 p-0">	
							<a href="{{ URL::to('/') }}/user/{{ $opc->user_id }}/view" class="text-decoration-none textcolor-blue pull-right pl-2 opt_align_mobile">Go to user profile</a>
							<a href="#" data-pk="{{ $opc->id }}" data-type="checklist" data-source="{{ URL::to('/') }}/ajax/get_opentowork_collection_list/{{$opc->id}}"  data-title="Select collections" class="opentowork_collection editable editable-click  float-right  text-decoration-none textcolor-blue pr-2 pl-2 opt_align_mobile" data-placement="bottom"   data-original-title="" title="">Add to collection</a>   


							<a href="#" id="opportunity_share" data-type="text" data-title="Copy this link to share" class="editable editable-click  float-right  text-decoration-none textcolor-blue  pr-2 pl-2 opt_align_mobile" data-placement="bottom" data-original-title="" title="" data-value="{{ URL::to('/') }}/opentowork/{{ $opc->id }}#">Share</a> 
							<!-- <a id="export_PDF" data-id="{{$opc->id}}" data-type="opw" class="editable editable-click  float-right  text-decoration-none textcolor-blue  pr-2 pl-2 cusor_pointer opt_align_mobile" >Download PDF</a>  -->
							<a href="{{ URL::to('/') }}/exportOPW/{{ $opc->id }}" class="editable editable-click  float-right  text-decoration-none textcolor-blue  pr-2 pl-2 cusor_pointer opt_align_mobile" >Download PDF</a> 

						@if(!$third_person)		

							<!-- <a href="#" id="opportunity_findmatch" data-type="select" data-value="Not selected" data-title="Find Matches" class="editable editable-click  float-right  text-decoration-none textcolor-blue pr-2 pl-2" data-placement="bottom"  data-original-title="" title="" style="color: #E1E3DD;">Find Matches</a> -->
						@else
							<a href="#"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2 opt_align_mobile" data-toggle="dropdown"  style="color: #219BC4">Send my opportunity</a>
							<div class="dropdown-menu dropdown-menu-right"  style="padding: 0px;">
								@if(count($opc_list) > 0) 
									<ul style="margin: 0px;padding: 0px;">
										@foreach ($opc_list as $item)
											<li class="list-unstyled send_opentowork"><a href="{{ URL::to('/') }}/messages/{{ $item->user_id }}">{{$item->title}} - {{json_decode($item->fields,true)[0]}}</a></li>
										@endforeach
											<li class="list-unstyled send_opentowork"><a href="{{ URL::to('/') }}/cards/{{ $opc->id }}/refer">Create New one</a></li>
									</ul>
								@else
									<li class="list-unstyled send_opentowork"><a href="{{ URL::to('/') }}/cards/{{ $opc->id }}/refer">Create New one</a></li>
								@endif
							</div>
						@endif
						</div>
					@else
                        <div class="w-100 m-0 p-0">	
							<a href="{{ URL::to('/') }}/user/{{ $opc->user_id }}/view" class="text-decoration-none textcolor-blue pull-right pl-2 opt_align_mobile">Go to user profile</a>
							<a href="#" class="opportunity_collection float-right  text-decoration-none textcolor-blue pr-2 pl-2 opt_align_mobile"  data-toggle="modal" data-target="#login_modal">Add to collection</a>   

							<a href="#" class="float-right  text-decoration-none textcolor-blue  pr-2 pl-2 opt_align_mobile"  data-toggle="modal" data-target="#login_modal">Share</a> 
                            <a href="#" class="float-right  text-decoration-none textcolor-blue  pr-2 pl-2 cusor_pointer opt_align_mobile"  data-toggle="modal" data-target="#login_modal" >Download PDF</a>
                            <a href="/user/login"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2 opt_align_mobile"  style="color: #219BC4"  data-toggle="modal" data-target="#login_modal">Send my opportunity</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    
        <div class="mt-5"></div>
        <p class="text-center">
        @if($user_id)
            <a  onclick="window.history.back();" class="cusor_pointer"><img src='/assets/images/back_arrow_round.svg' alt='Back' ></a>
        @endif
        </p>		
    </div>
</div>
@endsection