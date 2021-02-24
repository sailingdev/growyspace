<div data-opt-id="{{ $opc->id }}" class="opp_card_block msg_block">
	@if(false && $opc->user_id == $user_id)
	<div class="dropdown opp_card_actions_block">
		<button class="btn btn-light dropdown-toggle" type="button" id="opt{{ $opc->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<span class="sr-only"></span>
		</button>
		<div class="dropdown-menu dropdown-menu-right" aria-labelledby="opt{{ $opc->id }}">
			<a class="dropdown-item" href="#"> Invite user to this card</a>
			<a data-opt-id="{{ $opc->id }}" class="dropdown-item edit_opportunity_card_link" href=""> Edit</a>
			<a data-opt-id="{{ $opc->id }}" class="dropdown-item delete_opportunity_card_link"> Delete</a>
		</div>
	</div>
	@endif
	@if($url == 'collections')
		<img src="/assets/images/redesign-collections 5.svg" alt="sunil" class="msg_collection_img">
		<div class="msg_collection_opp">
			<p class="m-0 p-0 ellipsis">{{$name}}</p>
			<p class="m-0 p-0 ellipsis">Created by: <span>{{$user}}</span></p>
		</div>
		<a href="{{ URL::to('/') }}/{{$url}}/{{ $opc->id }}" style="text-decoration: none;color: #58C0FA;font-weight: 500;font-size: 20px;float: right;padding-bottom: 15px;padding-right: 10px;padding-top: 5px;" >Go to Collection</a>

	@else
		<p style="font-size: 20px;font-weight: 600; margin: 0px;padding-top: 20px;padding-left: 14px;">{{$name}}</p>
		@if($url == 'news')
			<p style="font-size: 18px;margin: 0px;padding-top: 18px;padding-left: 14px;" class="ellipsis">{{ strlen($opc->title) > 50 ? substr($opc->title,0,50).'...' : $opc->title }}</p>
			<p class="location_icon ellipsis" style="margin:0px;font-size: 18px;padding-left: 14px;padding-top: 10px;"> <span class="">{{ isset($subtitle) ? $subtitle : '' }} </span></p>
			<a href="{{ URL::to('/') }}/{{$url}}/{{ $opc->id }}{{ $url == 'user' ? '/view' : '' }}" style="text-decoration: none;color: #58C0FA;font-weight: 500;font-size: 20px;float: right;padding-bottom: 15px;padding-right: 10px;padding-top: 5px;">Go to {{$name}}</a>
		@elseif($url == 'user')
			<p style="font-size: 18px;margin: 0px;padding-top: 18px;padding-left: 14px;" class="ellipsis">{{ strlen($opc->full_name) > 50 ? substr($opc->full_name,0,50).'...' : $opc->full_name }}</p>

			<p class="location_icon ellipsis" style="margin:0px;font-size: 18px;padding-left: 14px;padding-top: 10px;"><img src="/assets/images/{{ $msg_state == 'inbox' ? 'location.png' : 'location2.png' }}" alt="Location" > <span class="">{{ $opc->city }}, {{ isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : '' }} </span></p>
			<a href="{{ URL::to('/') }}/{{$url}}/{{ $opc->id }}{{ $url == 'user' ? '/view' : '' }}" style="text-decoration: none;color: #58C0FA;font-weight: 500;font-size: 20px;float: right;padding-bottom: 15px;padding-right: 10px;padding-top: 5px;">Go to {{$name}}</a>

		@else
			<p style="font-size: 18px;margin: 0px;padding-top: 18px;padding-left: 14px;" class="ellipsis">{{ strlen($opc->title) > 50 ? substr($opc->title,0,50).'...' : $opc->title }}</p>
			<p class="location_icon ellipsis" style="margin:0px;font-size: 18px;padding-left: 14px;padding-top: 10px;"><img src="/assets/images/{{ $msg_state == 'inbox' ? 'location.png' : 'location2.png' }}" alt="Location" > <span class="">{{ $opc->city }}, {{ isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : '' }} </span></p>

			<a href="{{ URL::to('/') }}/{{$url}}/{{ $opc->id }}{{ $url == 'user' ? '/view' : '' }}" style="text-decoration: none;color: #58C0FA;font-weight: 500;font-size: 20px;float: right;padding-bottom: 15px;padding-right: 10px;padding-top: 5px;">Go to {{$name}}</a>
			
		@endif
		
		
	@endif

<div class="clearfix"></div>
</div>