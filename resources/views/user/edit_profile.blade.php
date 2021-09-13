@extends('layouts.front')
@section('content')
	<div class="row m-0 bg-gray">
		<div class="col-md-12 head_logo_area mt-5">
			<div class="head_logo">		
			<img src='/assets/images/icon-profile 1.svg' alt='profile' class="pull-left" ><h3 class="pull-left" >My profile</h3>
			</div>
		</div>

		<div class="col-md-8 mx-auto" >
			<!-- profile -->
			<div class="card mb-2">
				<div class="card-header color-user">
					@if($user->is_deleted == 1)
						<div class="alert alert-danger fade in alert-dismissible show">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true" style="font-size:20px">×</span>
						</button>    <strong>Alert!</strong> This account has been cancelled, please contact Support
						</div>
					@endif
				</div>
				<div class="card-block p-4">
						
						<div class="row m-0 p-0 profile_picture">
							<div class="mt-2 mb-2 w-100 profile_experience">
								<h3 class="font-weight-bold">About me</h3>
							</div>
							
							<div class="col-md-2 p-0 m-0 profile_img {{ $profile_image_src !== false ? ''  : '' }}">
									@if($profile_image_src !== false)
										<img src='{{$profile_image_src}}' class="profile_pic_wrapper img-fluid pull-left cusor_pointer" >
										<img  src="{{ URL::to('/') }}/assets/images/transparent_cricle.svg" class="changePicture img-fluid pull-left profile_pic_wrapper cusor_pointer" />
									@else
										<!-- @if($owner === true)
											<img  src="{{ URL::to('/') }}/assets/images/change_profile.png" class="profile_pic_wrapper img-fluid pull-left" />
										@else
											<img src="{{ URL::to('/') }}/assets/images/icon-profile 1.svg" class="profile_pic_wrapper img-fluid pull-left" />
										@endif -->
										<img  src="{{ URL::to('/') }}/assets/images/change_profile.png " class="profile_pic_wrapper img-fluid pull-left cusor_pointer" />
										
									@endif
									
							</div>
							<div class="col-md-10 p-0 m-0 profile_name pull-left">
								<div class="form-group form-inline p-0 m-0 ml-3">
									<label class="col-md-3 p-0 font-weight-bolder" for="name">Name:</label>
									<input class="form-control col-md-9" type="text" id="full_name"  value="{{ $user && $user->full_name ? $user->full_name  : '' }}">
								</div>
								<div class="form-group form-inline p-0 m-0 ml-3 mt-2">
									<label class="col-md-3 p-0 font-weight-bolder" for="profession">Title:</label>
									<input class="form-control col-md-9" type="text" id="profession"  value="{{ $user && $user->profession ? $user->profession  : '' }}">
								</div>
								<div class="form-group form-inline p-0 m-0 ml-3 mt-2">
									<label class="col-md-3 p-0 font-weight-bolder" for="profession">Location:</label>
									<select class="form-control col-md-5 mb-2 profile_country" name="chosen">
										<option value="">Select a Country</option>
										@foreach($countries as $country_code => $coutry_name)
											<option value="{{ $country_code }}" {{ $user && $user->country_code === $country_code ? 'selected' : '' }}>{{ $coutry_name }}</option>
										@endforeach
                                    </select>
									<div class="col-md-4 m-0 p-0 mb-2 profile_city has-location">
										<span class="fa fa-map-marker form-control-marker"></span>
										<input type="text" placeholder="city" class="opc_city form-control w-100 " value="{{ $user && $user->city ? $user->city : '' }}" />
									</div>
								</div>
								
							</div>
						</div>
				
						<div class="row m-0 p-0 ">
							<div class="w-100 mt-3 profile_pitch">
								<h3 class="font-weight-bold">Profile badge:</h3>
								<div class="form-check form-check-inline {{ ((count($errors->get('looking_for')) > 0) ? 'has-error' : '') }}">
									<input class="form-check-input" type="radio" name="pro_looking_for" id="inlineRadio1" value="1" {{ $user->looking_for == 1 ? 'checked'  : '' }}>
									<label class="form-check-label" for="inlineRadio1">Opportunity seeker</label>
									<span class="pl-2"><img src="/assets/images/Icon-opportunity seeker.svg" style="width:30px;"></span>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="pro_looking_for" id="inlineRadio2" value="2" {{ $user->looking_for == 2 ? 'checked'  : '' }}>
									<label class="form-check-label" for="inlineRadio2">Talent seeker</label>
									<span class="pl-2"><img src="/assets/images/Icon-talent seeker.svg" style="width:30px;"></span>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="pro_looking_for" id="inlineRadio3" value="3" {{ $user->looking_for == 3 ? 'checked'  : '' }}>
									<label class="form-check-label" for="inlineRadio3">Sourcer Pro</label>
									<span class="pl-2"><img src="/assets/images/Icon-news.svg" style="width:30px;"></span>
								</div>		
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="pro_looking_for" id="inlineRadio0" value="0" {{ $user->looking_for == 0 ? 'checked'  : '' }}>
									<label class="form-check-label" for="inlineRadio0">None</label>
								</div>		
							</div>
						</div>
						<div class="row m-0 p-0 ">
							<div class="w-100 mt-3 profile_pitch">
								<h3 class="font-weight-bold">Presentation letter:</h3>
								<textarea class="form-control profile_presentation">{{ $user && $user->my_pitch ? nl2br($user->my_pitch)  : '' }}</textarea>
							</div>
						</div>
						<div class="row m-0 p-0 mt-2">
							<div class="w-100 mt-3 profile_pitch">
								<h3 class="font-weight-bold">Experience:</h3>
								<div class="profile_experience_area">
									@foreach($user_experiences as $ue)
									<div class="row m-0 p-0 profile_company" id="profile_exp_{{$ue->id}}">
										<p class="w-33 m-0 p-0 font-weight-bold exp_db_role ellipsis" onclick="toggleEllipsis(this)">{{ $ue->title }}</p>
										<p class="w-33 m-0 p-0 text-center mb-2 exp_db_company ellipsis" onclick="toggleEllipsis(this)">{{ $ue->company }}</p>
										<p class="w-33 m-0 p-0 cusor_pointer text-right "><img src="/assets/images/Icon-edit.svg" alt="Edit" style="width:25px;"><span class="pl-2" onclick="javascript:editProfile_experience({{$ue->id}})">Edit</span></p>
										<p class="w-33 m-0 p-0 exp_db_country_city ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span>&nbsp;{{ (isset($countries[$ue->country_code]) ? $countries[$ue->country_code] : '' ) .', '.$ue->city }}</p>
										<p class="w-33 m-0 p-0 text-center exp_db_date ellipsis" onclick="toggleEllipsis(this)">
										{{ date("m/Y", strtotime($ue->from_date)) }} - 
											@if($ue->currently_working == 1)
												Present
											@else	
												{{ date("m/Y", strtotime($ue->to_date)) }}
											@endif
										</p>
										<p class="w-33 m-0 p-0 cusor_pointer text-right" onclick="javascript:removeProfile_experience({{$ue->id}})">Remove</p>
										<input type="hidden" class="db_country_code" value="{{$ue->country_code}}" />
										<input type="hidden" class="db_city" value="{{$ue->city}}" />
										<input type="hidden" class="db_from_date" value="{{$ue->from_date}}" />
										<input type="hidden" class="db_to_date" value="{{$ue->to_date}}" />
									</div>
									<hr>
									@endforeach
								</div>

								<div id="experience_wrapper" style="{{ count($user_experiences) == 0 ? 'display:block;' : 'display:none;' }}">
									<div class="form-group form-inline p-0 m-0 mt-2">
										<label class="col-md-3 p-0 font-weight-bold" for="role">Role:</label>
										<input class="form-control col-md-9 exp_role" placeholder="Ex: Retail Sales Manager" type="text"  value="">
									</div>
									<div class="form-group form-inline p-0 m-0 mt-2">
										<label class="col-md-3 p-0 font-weight-bold" for="company">Company:</label>
										<input class="form-control col-md-9 exp_company" type="text" placeholder="Ex: Microsoft" value="">
									</div>

									<div class="form-group form-inline p-0 m-0 mt-2">
										<label class="col-md-3 p-0 font-weight-bold" for="profession">Location:</label>
										<select class="form-control opc_country_code col-md-5 mb-2 exp_country"  name="chosen">
											<option value="">Select a Country</option>
											@foreach($countries as $country_code => $coutry_name)
												<option value="{{ $country_code }}">{{ $coutry_name }}</option>
											@endforeach
										</select>									
										<div class="col-md-4 m-0 p-0 mb-2 has-location">
											<span class="fa fa-map-marker form-control-marker"></span>
											<input type="text" placeholder="city" class="exp_city form-control w-100 " value="" />
										</div>									
									</div>

									<div class="form-group form-inline p-0 m-0 ">
										<label class="col-md-3 p-0 font-weight-bold" for="profession">Started:</label>
										<!-- <input type="text" placeholder="" class="exp_from_date form-control col-md-3 mb-2" value="" /> -->
										<input type="text"  placeholder="yyyy-mm-dd" class=" exp_from_date form-control col-md-3 mb-2" value="" >
										<label class="col-md-3 p-0 ended_align font-weight-bold" for="profession">Ended:</label>
										<input type="text" placeholder="yyyy-mm-dd"  class="exp_to_date form-control col-md-3 mb-2" value=""  />
										
										
									</div>
									<div class="w-100 row form-group p-0 m-0 ">
										<div class="col-md-9">
										</div>
										<div class="form-check col-md-3 mb-2">
											<input type="checkbox" class="form-check-input filled-in" id="ongoingExp" onclick="checkOngoingExp()">
											<label class="form-check-label " for="ongoingExp"> Ongoing</label>
										</div>
									</div>
								</div>								
							</div>
						</div>						

						<!-- Add Experience -->
						<div class="row m-0 p-0 mt-5 display_button1">
							<p class="w-75 m-0 p-0"></p>
							<p class="w-25 m-0 p-0 text-right">
								<button id="another_experience" data-id="" class="btn button_create_opportunity color-experience">Add experience</a>
								</button>
							</p>
						</div>
						<div class="row m-0 p-0 mt-5 display_button2">
							<p class="w-100 m-0 p-0 text-right">
								<button id="another_experience" data-id="" class="btn button_create_opportunity color-experience">Add experience</a>
								</button>
							</p>
						</div>
						<div class="row m-0 p-0 mt-2">
							<div class="w-100 mt-3 profile_pitch">
								<h3 class="font-weight-bold">Education:</h3>
								<div class="profile_education_area">
									@foreach($user_educations as $ue)
									<div class="row m-0 p-0 profile_company" id="profile_edu_{{$ue->id}}">
										<p class="w-33 m-0 p-0 font-weight-bold db_edu_role ellipsis" onclick="toggleEllipsis(this)">{{ $ue->title }}</p>
										<p class="w-33 m-0 p-0 text-center mb-2 db_edu_school ellipsis" onclick="toggleEllipsis(this)">{{ $ue->school}}</p>
										<p class="w-33 m-0 p-0 cusor_pointer text-right "><img src="/assets/images/Icon-edit.svg" alt="Edit" style="width:25px;"><span class="pl-2" onclick="javascript:editProfile_education({{$ue->id}})">Edit</span></p>
										<p class="w-33 m-0 p-0 db_edu_country_city ellipsis" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span>&nbsp;{{ (isset($countries[$ue->country_code]) ? $countries[$ue->country_code] : '' ) .', '.$ue->city }}</p>
										<p class="w-33 m-0 p-0 text-center db_edu_date ellipsis" onclick="toggleEllipsis(this)">
										{{ $ue->from_year }} - {{ $ue->to_year }}
										</p>
										<p class="w-33 m-0 p-0 cusor_pointer text-right" onclick="javascript:removeProfile_education({{$ue->id}})">Remove</p>
										<input type="hidden" class="db_edu_country_code" value="{{$ue->country_code}}" />
										<input type="hidden" class="db_edu_city" value="{{$ue->city}}" />
										<input type="hidden" class="db_edu_from_year" value="{{$ue->from_year}}" />
										<input type="hidden" class="db_edu_to_year" value="{{$ue->to_year}}" />
										<input type="hidden" class="db_edu_type_of_title" value="{{$ue->type_of_title}}" />
									</div>
									<hr>
									@endforeach
								</div>

								<div id="education_wrapper" style="{{ count($user_educations) == 0 ? 'display:block;' : 'display:none;' }}">
								<div class="form-group form-inline p-0 m-0 mt-2">
									<label class="col-md-3 p-0 font-weight-bold" for="role">Field of study:</label>
									<input class="form-control col-md-9 edu_role" placeholder="Ex: Software" type="text"  value="">
								</div>
								<div class="form-group form-inline p-0 m-0 mt-2">
									<label class="col-md-3 p-0 font-weight-bold" for="company">School:</label>
									<input class="form-control col-md-6 edu_school" type="text" placeholder="Ex: Boston University" value="">
									<input class="form-control col-md-3 edu_type_of_title" placeholder="Ex: Bachelor degree" type="text" value="">
								</div>

								<div class="form-group form-inline p-0 m-0 mt-2">
									<label class="col-md-3 p-0 font-weight-bold" for="profession">Location:</label>
									<select class="form-control opc_country_code col-md-5 mb-2 edu_country"  name="chosen">
										<option value="">Select a Country</option>
										@foreach($countries as $country_code => $coutry_name)
											<option value="{{ $country_code }}">{{ $coutry_name }}</option>
										@endforeach
                                    </select>
									<input type="text" placeholder="city" class="edu_city form-control col-md-4 mb-2" value="" />
								</div>

								<div class="form-group form-inline p-0 m-0 ">
									<label class="col-md-3 p-0 font-weight-bold" for="profession">Started:</label>
									<input type="number" placeholder="YYYY" min="2000" max="2100" class="edu_from_year form-control col-md-3 mb-2" value="" >
									
									<label class="col-md-3 p-0 ended_align font-weight-bold" for="profession">Ended:</label>
									<input type="text" placeholder="YYYY" min="2000" max="2100" class="edu_to_year form-control col-md-3 mb-2" value=""  />
	
								</div>
								<div class="w-100 row form-group p-0 m-0 ">
									<div class="col-md-9">
									</div>
									<div class="form-check col-md-3 mb-2">
										<input type="checkbox" class="form-check-input filled-in" id="ongoingEdu" onclick="checkOngoingEdu()">
										<label class="form-check-label " for="ongoingEdu"> Ongoing</label>
									</div>
								</div>	
								</div>				
							</div>
						</div>						

						<!-- Add Education -->
						<div class="row m-0 p-0 mt-5 display_button1">
							<p class="w-75 m-0 p-0"></p>
							<p class="w-25 m-0 p-0 text-right">
								<button id="another_education" data-id="" class="btn button_create_opportunity color-experience">Add education</a>
								</button>
							</p>
						</div>
						<div class="row m-0 p-0 mt-5 display_button2">
							<p class="w-100 m-0 p-0 text-right">
								<button id="another_education" data-id="" class="btn button_create_opportunity color-experience">Add education</a>
								</button>
							</p>
						</div>

                        <div class="form-group form-inline p-0 m-0 mt-3">
                            <label class="col-md-3 p-0 font-weight-bold" for="profession">Roles of interests:</label>
                            <select data-tags="true" multiple class="opc_roles col-md-9 form-control mt-2">
                            @foreach($opc_roles as $oc => $val)
                            <option value="{{$val}}" {{ isset($opc_roles_db) && count($opc_roles_db) > 0 && in_array($val, $opc_roles_db) ? 'selected' : '' }}>{{$val}}</option>
                            @endforeach
                            </select>
                            
                        </div> 		
						<div class="form-group form-inline p-0 m-0 mt-3">
                            <label class="col-md-3 p-0 font-weight-bold" for="profession">Skills:</label>
                            <select  data-tags="true"  multiple class="opc_fields col-md-9 form-control mt-2">
                            @foreach($opc_fields as $oc => $val)
                                <option value="{{$val}}" {{ isset($opc_fields_db) && count($opc_fields_db) > 0 && in_array($val, $opc_fields_db) ? 'selected' : '' }}>{{$val}}</option>
                            @endforeach
                            </select>
                            
                        </div>  										
						<!-- save -->
						<div class="row m-0 mt-5 p-0 ">
							<div class="w-100 m-0 p-0">	
								<a href="#" data-id="{{$user->id}}" class="text-decoration-none textcolor-blue pull-right  profile_save" style="color: #219BC4 !important">Save</a>

								@if(isset($id) && $id > 0)
									<a href="#" data-opt-id="{{ isset($id) ? $id  : 0 }}" class="text-decoration-none color-delete pull-right pl-2 pr-2 opt_align_mobile"  data-toggle="dropdown">Delete</a>
							
									<div class="dropdown-menu dropdown-menu-right"  style="padding: 0px;">
										<p style="padding: 10px;">Are you sure you want to delete?</p>
										<div style="width: 90%;margin: 0 auto;padding-bottom: 10px;">
											<span class="delete_opentowork_card_link cusor_pointer color-delete" data-opt-id="{{ isset($id) ? $id  : 0 }}" >Delete</span><span class="cusor_pointer pull-right" style="color: #219BC4;">Back</span>
										</div>	

									</div>
								@endif

								
							</div>
						</div>									
				</div>

			</div>

			<div class="mt-5"></div>		
		</div>
	</div>
	@if($owner === true) @include('popups.profile_image')
	@endif
@endsection