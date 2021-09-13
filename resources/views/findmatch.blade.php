@extends('layouts.front')
@section('content')
	<style>
	@media (min-width: 1100px) {
		.custom-control-label::before, 
		.custom-control-label::after {
		top: 0.4rem;
		width: 1.25rem;
		height: 1.25rem;
		}
	}
	@media (max-width: 1099px) {
		.custom-control-label::before, 
		.custom-control-label::after {
		top: 0.1vw;
		width: 1.25rem;
		height: 1.25rem;
		}
	}
	.custom-control-input:checked~.custom-control-label::before {
		color: #fff;
		border-color: #332960;
		background-color: #332960;
	}
	</style>
	<div class="row m-0 bg-gray">
		<div class="col-md-12 head_logo_area_small mt-5">
		@if(!$third_person)
			<div class="head_logo">		
			<img src='/assets/images/icon-profile 1.svg' alt='profile' class="pull-left" ><h3 class="pull-left" >Matchmaking</h3>
			</div>
			<div class="pull-left ml-3">
				<a onclick="window.history.back();" class="cusor_pointer display_image1"><img src="/assets/images/Frame 6.svg" alt="Back" ></a>
			</div>
		@endif
		</div>

		<div class="col-md-8 mx-auto" >
			<div class="row alert alert-secondary m-0 p-0 p-4 mt-4 pt-2 d-flex" role="alert" style="background:#fff;border-radius:10px;">
				<div class="matching_title1 pr-2 " style="margin: auto">
					Finding matches based on 
				</div>
				<div class="matching_option1 form-group form-inline p-0 mt-4  has-location">
					<select data-tags="true" data-user-id="{{$user_id}}" data-placeholder="select opportunity or professional card"  class="opc_explore form-control w-100 matching_filter">		
						<option value="">select opportunity or professional card</option>			
						@foreach($opportunity_cards as $oc => $val)
							<option value="opt_{{$val->id}}" {{ $type == "opt" && $card_id == $val->id ? 'selected' : '' }}>opportunity: {{$val->title}}</option>
						@endforeach
						@foreach($opentowork_card as $oc => $val)
							<option value="opw_{{$val->id}}" {{ $type == "opw" && $card_id == $val->id ? 'selected' : '' }}>professional card: {{$val->title}}</option>
						@endforeach					

					</select>
				</div>
				<div class="matching_title pr-2 pt-4" style="margin: auto">
					Send the card to all selected matches
				</div>
				<div class="matching_option row m-0 p-0 mt-5 pt-4">		
					<p class="w-100 m-0 p-0 text-right">
					<a href="#" class="btn button_create_opportunity" onclick="Send_to_all_matches({{$card_id}},'{{$type}}')" style="background:#219BC4">Send to all matches</a>
					</p>
				</div>
			</div>
			<!-- opportunity -->
			@foreach($opt_rlt as $opc)
			<div class="card mt-5 mb-2">
				<div class="card-header pl-4 pr-4 color-oppportunity h-100">
					<div class="row m-0 p-0 opportunity_header">
						<!-- <p class="w-50 m-0 p-0 font-weight-bold">Opportunity</p> -->
						<div class="custom-control custom-checkbox w-50">
								<input type="checkbox" class="custom-control-input" id="MatchingOPW_{{ $opc->user_id }}_{{ $opc->id }}" name="MatchingOPW" checked value="{{ $opc->user_id }}">
								<label class="custom-control-label" for="MatchingOPW_{{ $opc->user_id }}_{{ $opc->id }}"><p class="m-0 p-0 pl-2 font-weight-bold">Opportunity</p></label>					
						</div>
						<p class="w-50 m-0 p-0 text-right location_font ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2">{{ (isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : $opc->country_code).', '.$opc->city }}</span></p>
						
					</div>
				</div>
				<div class="card-block p-4">
					<a href="/cards/{{ $opc->id }}#" class="text-decoration-none" style="color:unset">
						<div class="row m-0 p-0 ">
							<div class="w-100 profile_pitch">
								<h3 class="font-weight-bold ellipsis" onclick="toggleEllipsis(this)">{{ $opc->title }}</h3>
								<p class="ellipsis" onclick="toggleEllipsis(this)">{{ $opc->company }}</p>
								
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
						@if($user_id == $opc->user_id)	

							<!-- <a href="/cards/{{ $opc->id }}/edit" class="textcolor-blue pull-right pl-2"><img src="/assets/images/Icon-edit.svg" alt="Edit" style="width:25px;"><span class="pl-2">Edit</span></a> -->
						@endif
							<a href="/cards/{{ $opc->id }}#"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2"  style="color: #219BC4">Read more</a>
							@if($third_person)	
								
									<a href="#" onclick="gotoChatWithOPT({{ $opc->user_id }},{{ $opc->id }})" class="text-decoration-none textcolor-blue pull-right pr-2 pl-2"  style="color: #219BC4">Send my interest</a>
									<!-- <div class="dropdown-menu dropdown-menu-right"  style="padding: 0px;">
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
									</div> -->

									<a href="#" data-pk="{{ $opc->id }}" data-type="checklist" data-source="{{ URL::to('/') }}/ajax/get_opc_collection_list/{{$opc->id}}"  data-title="Select collections" class="opportunity_collection editable editable-click  float-right  text-decoration-none textcolor-blue pr-2 pl-2" data-placement="bottom"   data-original-title="" title="">Add to collection</a>   
													
							@endif	
						</div>
					</div>
				</div>
			</div>
			@endforeach	
			<!-- opentowork -->
			@if(count($opw_rlt) > 0)
			@foreach($opw_rlt as $opc)
				@if($opc->refer)
					@if(!$third_person)
						<div class="card mt-5 mb-2">
						<div class="card-header pl-4 pr-4 color-opentowork h-100">
							<div class="row m-0 p-0 opportunity_header">
								<!-- <p class="w-50 m-0 p-0 font-weight-bold">Open-to-work</p> -->
								<div class="custom-control custom-checkbox w-50">
									<input type="checkbox" class="custom-control-input" id="MatchingOPW_{{ $opc->user_id }}_{{ $opc->id }}" name="MatchingOPW" checked value="{{ $opc->user_id }}">
									<label class="custom-control-label" for="MatchingOPW_{{ $opc->user_id }}_{{ $opc->id }}"><p class="m-0 p-0 pl-2 font-weight-bold">Professional card</p></label>					
								</div>
								<p class="w-50 m-0 p-0 text-right location_font ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2">{{ (isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : $opc->country_code).', '.$opc->city }}</span></p>
								
							</div>
						</div>
						<div class="card-block p-4">
							<a href="/opentowork/{{ $opc->id }}#" class="text-decoration-none" style="color:unset">
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
								@if($user_id == $opc->user_id)		

									<!-- <a href="/opentowork/{{ $opc->id }}/edit" class="textcolor-blue pull-right pl-2"><img src="/assets/images/Icon-edit.svg" alt="Edit" style="width:25px;"><span class="pl-2">Edit</span></a> -->
								@endif
									<a href="/opentowork/{{ $opc->id }}#"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2"  style="color: #219BC4">Read more</a>
								@if($third_person)	
									
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
							<!-- <div class="checkbox w-50 m-0 p-0 font-weight-bold checkbox-xl">
								<p class="m-0 p-0 font-weight-bold"><label><input type="checkbox" value="">Open-to-work</label></p>
							</div> -->
							<div class="custom-control custom-checkbox w-50">
								<input type="checkbox" class="custom-control-input" id="MatchingOPW_{{ $opc->user_id }}_{{ $opc->id }}" name="MatchingOPW" checked value="{{ $opc->user_id }}">
								<label class="custom-control-label" for="MatchingOPW_{{ $opc->user_id }}_{{ $opc->id }}"><p class="m-0 p-0 pl-2 font-weight-bold">Professional card</p></label>					
							</div>
							<p class="w-50 m-0 p-0 text-right font-weight-bold ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2">{{ (isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : $opc->country_code).', '.$opc->city }}</span></p>
							
						</div>
					</div>
					<div class="card-block p-4">
						<a href="/opentowork/{{ $opc->id }}#" class="text-decoration-none" style="color:unset">
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

								<!-- <a href="/opentowork/{{ $opc->id }}/edit" class="textcolor-blue pull-right pl-2"><img src="/assets/images/Icon-edit.svg" alt="Edit" style="width:25px;"><span class="pl-2">Edit</span></a> -->
							@endif
								<a href="/opentowork/{{ $opc->id }}#"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2"  style="color: #219BC4">Read more</a>
							@if($third_person)	
								
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
													
							@endif
								
							</div>
						</div>
					</div>
				</div>
				@endif	
				

			@endforeach	
			@endif
			@if(count($opt_rlt) == 0 && count($opw_rlt) == 0) 
				<div class="alert alert-secondary m-0 p-0 p-4 mt-5" role="alert" style="background:#fff;">
					No item.
				</div>
			@endif
			<div class="mt-5"></div>	
			@if($third_person)
			<p class="text-center">
            	<a onclick="window.history.back();" ckass="cusor_pointer"><img src='/assets/images/back_arrow_round.svg' alt='Back' ></a>
			</p>
			@endif	
			
		</div>
	</div>
@endsection