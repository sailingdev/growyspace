@foreach($user_experiences as $ue)
	<div data-exp-id="{{ $ue->id }}" class="experience_block">
		
		@if(is_file(base_path() . '/public/uploads/exp/'.$ue->id.'/'.$ue->company_logo_url))
			<img class="hidden experience_compny_img" src="{{ URL::to('/') }}/uploads/exp/{{ $ue->id }}/{{ $ue->company_logo_url }}" />
		@else
			<img class="hidden experience_bag" src="{{ URL::to('/') }}/assets/images/bag.png" />
		@endif
		<div class="hidden experience_block_bottom"></div>
			<h2>{{ strlen($ue->title) > 15 ? substr($ue->title,0,15).'...' : $ue->title }}</h2>
			<h3>{{ strlen($ue->company) > 15 ? substr($ue->company,0,15).'...' : $ue->company }}</h3>
			<p><span class="fa fa-map-marker"></span> {{ (isset($countries[$ue->country_code]) ? $countries[$ue->country_code] : '' ) .' '.$ue->city }}</p>
			<p>{{ date("m/Y", strtotime($ue->from_date)) }} to 
			@if($ue->currently_working == 1)
				Present
			@else	
				{{ date("m/Y", strtotime($ue->to_date)) }}
			@endif
			</p>
	</div>
@endforeach