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
            <div class="card-header pl-4 pr-4 color-oppportunity h-100">
                <div class="row m-0 p-0 opportunity_header">
                    <p class="w-65 m-0 p-0 font-weight-bold">Opportunity</p>
                    <p class="w-35 m-0 p-0 text-right font-weight-bold">
                    @if(!$third_person)
                        <a href="{{ URL::to('/') }}/cards/{{$opc->id}}/edit" class="text-decoration-none text-white"> <img src="/assets/images/Icon-edit.svg" style="width:30px;"><span class="pl-2">Edit</span></a>
                    @endif
                    </p>
                    
                </div>
            </div>
            <div class="card-block p-4">
                <div class="row m-0 p-0 ">
                    <div class="w-100 profile_pitch ">
                        <h3 class="font-weight-bold " onclick="toggleEllipsis(this)">{{ $opc->title }}</h3>
                        <p class="" onclick="toggleEllipsis(this)">{{ $opc->company }}</p>
                        <!-- <p><img src="/assets/images/location.png" alt="Location" > <span class="pl-2">{{ $opc->city }}, {{ isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : '' }} </span></p> -->
                        <p class="m-0" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span> <span class="pl-2">{{ $opc->city }}, {{ isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : '' }} </span></p>
                        <p class="" onclick="toggleEllipsis(this)">{{ $remote }}</p>
                    </div>
                </div>
                @if($opc->salary_range)
                <div class="row m-0 p-0 ">
                    <div class="w-100 profile_pitch ">
                        <h3 class="font-weight-bold">Salary</h3>
                        <p class="" onclick="toggleEllipsis(this)">{{ $opc->salary_range }}</p>
                    </div>
                </div>	
                @endif
                <div class="row m-0 p-0 ">
                    <div class="w-100 profile_pitch ">
                        <h3 class="font-weight-bold">Technical skills</h3>
                        <ul class="list-unstyled list-inline margin-0-auto mb-0 request_skills">
                            @foreach($opc_fields as $oc)
                            <li class="list-inline-item mr-0 pr-2 pb-2" style="margin:0px">
                                <div class="chip bgcolor-purple mr-0 chip-custom">{{$oc}}</div>
                            </li>
                            @endforeach	
                        </ul>
                    </div>
                </div>	
                <div class="row m-0 p-0 ">
                    <div class="w-100 profile_pitch">
                        <h3 class="font-weight-bold">Description</h3>
                        <p>{!! nl2br(strip_tags($opc->description)) !!}</p>
                        
                    </div>
                </div>
                @if($opc->perks)
                <div class="row m-0 p-0 ">
                    <div class="w-100 profile_pitch">
                        <h3 class="font-weight-bold">Perks</h3>
                        <p>{!! nl2br(strip_tags($opc->perks)) !!}</p>
                        
                    </div>
                </div>
                @endif



                <div class="row m-0 p-0 ">
					@if($user_id)	
						<div class="w-100 m-0 p-0">	
							<a href="{{ URL::to('/') }}/user/{{ $opc->user_id }}/view" class="text-decoration-none textcolor-blue pull-right pl-2 opt_align_mobile">Go to user profile</a>
							<a href="#" data-pk="{{ $opc->id }}" data-type="checklist" data-source="{{ URL::to('/') }}/ajax/get_opc_collection_list/{{$opc->id}}"  data-title="Select collections" class="opportunity_collection editable editable-click  float-right  text-decoration-none textcolor-blue pr-2 pl-2 opt_align_mobile" data-placement="bottom"   data-original-title="" title="" data-send="auto">Add to collection</a>   

							<a href="#" id="opportunity_share" data-type="text" data-title="Copy this link to share" class="editable editable-click  float-right  text-decoration-none textcolor-blue  pr-2 pl-2 opt_align_mobile" data-placement="bottom" data-original-title="" title="" data-value="{{ URL::to('/') }}/cards/{{ $opc->id }}#">Share</a> 
                            <a href="{{ URL::to('/') }}/exportOPP/{{ $opc->id }}" class="editable editable-click  float-right  text-decoration-none textcolor-blue  pr-2 pl-2 cusor_pointer opt_align_mobile" >Download PDF</a>

						@if(!$third_person)		

							<!-- <a href="#" id="opportunity_findmatch" data-type="select" data-value="Not selected" data-title="Find Matches" class="editable editable-click  float-right  text-decoration-none textcolor-blue pr-2 pl-2" data-placement="bottom"  data-original-title="" title="" style="color: #E1E3DD;">Find Matches</a> -->
						@else
							<a href="#"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2 opt_align_mobile" data-toggle="dropdown"  style="color: #219BC4">Send my professional card</a>
							<div class="dropdown-menu dropdown-menu-right"  style="padding: 0px;">
								@if(count($opc_list) > 0) 
									<ul style="margin: 0px;padding: 0px;">
										@foreach ($opc_list as $item)
											<li class="list-unstyled send_opentowork"><a href="{{ URL::to('/') }}/messages/{{ $item->user_id }}">{{$item->title}} - {{json_decode($item->fields,true)[0]}}</a></li>
										@endforeach
											<li class="list-unstyled send_opentowork"><a href="{{ URL::to('/') }}/opentowork/{{ $opc->id }}/refer">Create New one</a></li>
									</ul>
								@else
									<li class="list-unstyled send_opentowork"><a href="{{ URL::to('/') }}/opentowork/{{ $opc->id }}/refer">Create New one</a></li>
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
                            <a href="/user/login"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2 opt_align_mobile"  style="color: #219BC4"  data-toggle="modal" data-target="#login_modal">Send my professional card</a>
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