@if($opportunity_cards !== null && $opportunity_cards->count() > 0)
	@foreach($opportunity_cards as $opc)
	<div data-opt-id="{{ $opc->id }}" class="search_user_block filter_oppbox">
		<div class="card mb-4">
			<div class="card-header pl-4 pr-4 color-oppportunity h-100">
				<div class="row m-0 p-0 opportunity_header">
					<p class="w-50 m-0 p-0 font-weight-bold">Opportunity</p>
					<p class="w-50 m-0 p-0 text-right location_font ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2">{{ (isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : $opc->country_code).', '.$opc->city }}</span></p>
					
				</div>
			</div>
			<div class="card-block p-4">
				<a href="/cards/{{ $opc->id }}#" class="text-decoration-none" style="color:unset">
					<div class="row m-0 p-0 ">
						<div class="w-100 profile_pitch">
							<h3 class="font-weight-bold">{{ $opc->title }}</h3>
							<p>{{ $opc->company }}</p>
							
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
						<a href="/cards/{{ $opc->id }}#"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2 opt_align_mobile"  style="color: #219BC4">Read more</a>

						<div>
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
					<p class="w-50 m-0 p-0 font-weight-bold">Professional card</p>
					<p class="w-50 m-0 p-0 text-right location_font ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2">{{ (isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : $opc->country_code).', '.$opc->city }}</span></p>
					
				</div>
			</div>
			<div class="card-block p-4">
				<a href="/opentowork/{{ $opc->id }}#" class="text-decoration-none" style="color:unset">
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
						<a href="/opentowork/{{ $opc->id }}#"  class="text-decoration-none textcolor-blue pull-right pr-2 pl-2 opt_align_mobile"  style="color: #219BC4 !important">Read more</a>

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
@if($users !== null && $users->count() > 0) 
	@foreach($users as $u)
	<div data-opt-id="{{ $u->id }}" class="search_user_block filter_oppbox">
		<div class="card mb-4">
			<div class="card-header pl-4 pr-4 color-user h-100">
				<div class="row m-0 p-0 opportunity_header">
					<p class="w-50 m-0 p-0 font-weight-bold">Profile</p>
					<p class="w-50 m-0 p-0 text-right location_font ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span><span class="pl-2">{{ isset($countries[$u->country_code]) ? $countries[$u->country_code] : $u->country_code }}, {{ $u->city }}</span></p>
					
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
@if($users->count() == 0 && $opportunity_cards->count() == 0  && $opentowork_cards->count() == 0) 
	<div class="alert alert-secondary m-0 p-0 p-4 " role="alert" style="background:#fff;">
	Go to <a href="/search" class="color_a">Explore</a> to add items to this collection. 
		<!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button> -->
	</div>
@endif