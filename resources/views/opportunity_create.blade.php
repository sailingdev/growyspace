@extends('layouts.front')
@section('content') 
<div class="row m-0 bg-gray">
    <div class="col-md-12">
        <div class="opc_error_msg"></div>
    </div>

    <div class="col-md-8 mx-auto" >
        
        <!-- opportunity -->
        <div class="card mt-5 mb-2 bgcolor-e1e3dd">
            <a onclick="window.history.back();" class="left_back mb-1 cusor_pointer display_image1"><img src="/assets/images/Frame 6.svg" alt="Back" ></a>
            <a onclick="window.history.back();" class="left_back cusor_pointer display_image2"><img src="/assets/images/backformobile.svg" alt="Back" ></a>
            <div class="card-header pl-4 pr-4  color-oppportunity h-100">
                <div class="row m-0 p-0 opportunity_header">
                    <p class="w-100 m-0 p-0 font-weight-bold">Opportunity</p>
                </div>
            </div>
            <div class="card-block p-4">
                <div class="row m-0 p-0 mt-2">
					<div class="w-100 mt-3 profile_pitch">
                        <div class="form-group form-inline p-0 m-0 mt-2">
                            <label class="col-md-3 p-0" for="role">Position:</label>
                            <input class="form-control col-md-9 opc_title" type="text" autocomplete="no"  value="{{ $opc && $opc->title ? $opc->title : '' }}">
                        </div>
                        <div class="form-group form-inline p-0 m-0 mt-2">
                            <label class="col-md-3 p-0" for="company">Company:</label>
                            <input class="form-control col-md-9 opc_company" type="text" autocomplete="no" value="{{ $opc && $opc->company ? $opc->company : '' }}">
						</div>
                        <div class="form-group form-inline p-0 m-0 mt-2">
                            <label class="col-md-3 p-0" for="profession">Location:</label>
                            <select data-tags="true"  class="form-control opc_country_code col-md-5 mb-2 exp_country"  name="chosen">
                                <option value="">Select a Country</option>
                                @foreach($countries as $country_code => $coutry_name)
                                    <option value="{{ $country_code }}" {{ $opc && $opc->country_code === $country_code ? 'selected' : '' }}>{{ $coutry_name }}</option>
                                @endforeach
                            </select>
                            <div class="col-md-4 m-0 p-0 mb-2 has-location">
                                <span class="fa fa-map-marker form-control-marker"></span>
                                <input type="text" placeholder="city" class="opc_city form-control w-100 " autocomplete="false" value="{{ $opc && $opc->city ? $opc->city : '' }}" />
                            </div>

                        </div>
                        <div class="form-group form-inline p-0 m-0 mt-2">
                            <label class="col-md-3 p-0" for="Description">Description:</label>
                            <textarea class="col-md-12 form-control profile_presentation opc_description mt-2">{{ $opc && $opc->description ? nl2br($opc->description)  : '' }}</textarea>
                        </div>    
                        
                        <div class="form-group form-inline p-0 m-0 mt-3">
                            <label class="col-md-3 p-0" for="profession">Requested Skills:</label>
                            <select data-tags="true"  multiple class="opc_fields col-md-9 form-control mt-2">
                            @foreach($opc_fields as $oc => $val)
                                <option value="{{$val}}" {{ isset($opc_fields_db) && count($opc_fields_db) > 0 && in_array($val, $opc_fields_db) ? 'selected' : '' }}>{{$val}}</option>
                            @endforeach
                            </select>
                            
                        </div>                                            
                    </div>
                </div>

                <div class="row m-0 p-0 mt-4">
                    <div class="w-100 m-0 p-0">	
                        <a href="#" data-opt-id="{{ isset($id) ? $id  : 0 }}" data-opt-refer="{{ isset($refer) ? $refer  : 0 }}" class="text-decoration-none textcolor-blue pull-right pl-3 opt_align_mobile add_edit_opportunity_card" data-owner-id="{{ isset($opc->user_id) ? $opc->user_id  : 0 }}" data-owner-product="{{ isset($targetid) ? $targetid  : 0 }}">Save</a>

                        
                        @if(isset($id) && $id > 0)
                            <a href="#" data-opt-id="{{ isset($id) ? $id  : 0 }}" class="text-decoration-none color-delete pull-right pl-2 pr-2 opt_align_mobile"  data-toggle="dropdown">Delete</a>
                 	
                            <div class="dropdown-menu dropdown-menu-right"  style="padding: 0px;">
                                <p style="padding: 10px;">Are you sure you want to delete?</p>
                                <div style="width: 90%;margin: 0 auto;padding-bottom: 10px;">
                                    <span class="delete_opportunity_card_link cusor_pointer color-delete" data-opt-id="{{ isset($id) ? $id  : 0 }}" >Delete</span><span class="cusor_pointer pull-right" style="color: #219BC4;">Back</span>
                                </div>	

                            </div>
                        @endif

                           

                        
                    </div>
                </div>
            </div>
        </div>
    
        <div class="mt-5"></div>
        <p class="text-center">
            <a  onclick="window.history.back();" class="cusor_pointer"><img src='/assets/images/back_arrow_round.svg' alt='Back' ></a>
        </p>		
    </div>
</div>
@endsection