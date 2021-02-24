@extends('layouts.front')
@section('content')
<!-- Content -->
 <header class="space_lab_main_content bottom_header_block">
    <div class="container">
      <div class="row align-items-center">
        <div style="position:relative;" class="col-lg-12">
          <h1 class="display-4 text-white mt-5 mb-2">{{ $user->full_name }}</h1>
          <p class="lead mb-5 text-white-50">{{ $user->profession }} <span style="cursor:pointer;" class="profession_update_link fa fa-pencil"></span></p>
		  
		  <img src="{{ URL::to('/') }}/assets/images/profile_pic_wrapper.png" />
        </div>
      </div>
    </div>
  </header>
<div class="container page-content bg-white">
  	<!-- Breadcrumb row -->
	<div class="breadcrumb-row">
		<div class="container">
			<ul class="list-inline">
				<li><a href="{{ URL::to('/') }}">Home</a></li>
				<li>My Account</li>
				<li class="active">{{ $user->full_name }}</li>
			</ul>
		</div>
	</div>
	<div class="row"> 
	 <!-- Header -->
		<div class="col-md-12 mb-5">
			<div class="card h-100 spacelab_spec_border_bottom">
				<div style="padding:10px;" class="card-body">
					<p class="card-text"><span class="fa fa-map-marker"></span> {{ $user->city }}, {{ $country }}</p>
				</div>
			</div>
		</div>
    </div>
	<div class="row"> 
	 <!-- Header -->
		<div class="col-md-12 mb-5">
			<div class="card h-100 spacelab_spec_border_bottom">
				<div class="card-body">
					<h4 class="card-title">My pitch</h4>
					<p class="card-text">dqw udg wydegq wyeg wqyge yqwue ywuq ewtqfe ywquge yuwq eqwyu eywg eyuwqg ywq egywqgeyuwqeyewqeqw</p>
				</div>
			</div>
		</div>
    </div>
	<div class="row"> 
	 <!-- Header -->
		<div class="col-md-12 mb-5">
			<div class="card h-100">
				<div class="card-body">
					<h3 class="card-title">Opportunity cards</h3>
					@foreach($opportunity_cards as $opc)
						<div data-opt-id="{{ $opc->id }}" class="opp_card_block">
							<div class="dropdown opp_card_actions_block">
								<button class="btn btn-light dropdown-toggle" type="button" id="opt{{ $opc->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<span class="sr-only">AsaS</span>
								</button>
								<div class="dropdown-menu dropdown-menu-right" aria-labelledby="opt{{ $opc->id }}">
									<a class="dropdown-item" href="#"> Invite user to this card</a>
									<a data-opt-id="{{ $opc->id }}" class="dropdown-item edit_opportunity_card_link" href=""> Edit</a>
									<a data-opt-id="{{ $opc->id }}" class="dropdown-item delete_opportunity_card_link"> Delete</a>
								</div>
							</div>
						
						
							@if(is_file(base_path() . '/public/uploads/opc/'.$opc->id.'/'.$opc->company_logo_url))
								<img class="opp_card_compny_img" src="{{ URL::to('/') }}/uploads/opc/{{ $opc->id }}/{{ $opc->company_logo_url }}" />
							@endif
							<div class="opp_card_block_bottom">
								<h4>{{ $opc->title }}</h4>
								<h3>{{ $opc->company }}</h3> 
							</div>
						</div>
					@endforeach
					<div class="add_opportuniti_card_link_block">
						<i class="add_opportuniti_card_link fa-4x fa fa-plus-circle" aria-hidden="true"></i>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12 mb-5">
			<div class="card h-100">
				<div class="card-body">
					<h3 class="card-title">My experience</h3>
					
						@foreach($user_experiences as $ue)
							<div data-exp-id="{{ $ue->id }}" class="experience_block">
								<div class="dropdown experience_actions_block">
									<button class="btn btn-light dropdown-toggle" type="button" id="exp{{ $ue->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<span class="sr-only"></span>
									</button>
									<div class="dropdown-menu dropdown-menu-right" aria-labelledby="ue{{ $ue->id }}">
										<a data-exp-id="{{ $ue->id }}" class="dropdown-item edit_experience_link" href=""> Edit</a>
										<a data-exp-id="{{ $ue->id }}" class="dropdown-item delete_experience_link"> Delete</a>
									</div>
								</div>
								@if(is_file(base_path() . '/public/uploads/exp/'.$ue->id.'/'.$ue->company_logo_url))
									<img class="experience_compny_img" src="{{ URL::to('/') }}/uploads/exp/{{ $ue->id }}/{{ $ue->company_logo_url }}" />
								@else
									<img class="experience_bag" src="{{ URL::to('/') }}/assets/images/bag.png" />
								@endif
								<div class="experience_block_bottom">
									<h4>{{ strlen($ue->title) > 15 ? substr($ue->title,0,15).'...' : $ue->title }}</h4>
									<h3>{{ strlen($ue->company) > 15 ? substr($ue->company,0,15).'...' : $ue->company }}</h3>
								</div>
							</div>
						@endforeach
					
					<div class="add_my_experience_link_block">
						<i class="add_my_experience_link fa-4x fa fa-plus-circle" aria-hidden="true"></i>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12 mb-5">
			<div class="card h-100">
				<div class="card-body">
					<h3 class="card-title">Skills</h3>
					@foreach($user_skills as $skill)
						<span class="user_skill_item_block"><span class="user_skill_item">{{ $skill }}</span> <i data-skill="{{ $skill }}" class="delete_user_skill fa fa-times-circle-o" aria-hidden="true"></i></span>
					@endforeach
					
					<span class="manage_skill_link_block">
						<i class="manage_skill_link fa-4x fa fa-plus-circle" aria-hidden="true"></i>
					</span>
				</div>
			</div>
		</div>
		<div class="col-md-12 mb-5">
			<div class="card h-100">
				<div class="card-body">
					<h3 class="card-title">Education</h3>
					@foreach($user_educations as $ue)
						<div data-edu-id="{{ $ue->id }}" class="edu_block">
							<div class="dropdown edu_actions_block">
								<button class="btn btn-light dropdown-toggle" type="button" id="edu{{ $ue->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<span class="sr-only"></span>
								</button>
								<div class="dropdown-menu dropdown-menu-right" aria-labelledby="edu{{ $ue->id }}">
									<a data-edu-id="{{ $ue->id }}" class="dropdown-item edit_education_link" href=""> Edit</a>
									<a data-edu-id="{{ $ue->id }}" class="dropdown-item delete_education_link"> Delete</a>
								</div>
							</div>
							<img class="edu_block_img" src="{{ URL::to('/') }}/assets/images/hat2.png" />		
							<div class="edu_block_bottom">
								<h3 alt="{{ $ue->degree }}" >{{ strlen($ue->degree) > 15 ? substr($ue->degree,0,15).'...' : $ue->degree }}</h3>
								<h4 alt="{{ $ue->school }}">{{ strlen($ue->school) > 15 ? substr($ue->school,0,15).'...' : $ue->school  }}</h4>
							</div>
						</div>
					@endforeach
					<div class="add_education_link_block">
						<i class="add_education_link fa-4x fa fa-plus-circle" aria-hidden="true"></i>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>	

@endsection