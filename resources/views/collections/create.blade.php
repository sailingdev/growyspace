@extends('layouts.front')
@section('content') 
<div class="row m-0 bg-gray">
    <div class="col-md-12">
        <div class="opc_error_msg"></div>
    </div>

    <div class="col-md-8 mx-auto" >
        <div class="card mt-5 mb-2">
            <a onclick="window.history.back();" class="left_back mb-1 cusor_pointer display_image1"><img src="/assets/images/Frame 6.svg" alt="Back" ></a>
            <a onclick="window.history.back();" class="left_back cusor_pointer display_image2"><img src="/assets/images/backformobile.svg" alt="Back" ></a>
            <div class="card-header pl-4 pr-4 color-experience h-100">
                <div class="row m-0 p-0 opportunity_header">
                    <p class="w-100 m-0 p-0 font-weight-bold">Collection</p>
                </div>
            </div>
            <div class="card-block p-4">
                <div class="row m-0 p-0 mt-2">
					<div class="w-100 mt-3 profile_pitch">
                        <div class="form-group form-inline p-0 m-0 mt-2">
                            <label class="col-md-3 p-0" for="role">Name:</label>
                            <input class="form-control col-md-9 collection_name" type="text" maxlength="90" value="{{ $opc && $opc->name ? $opc->name : '' }}">
                        </div>
                                                                  
                    </div>
                </div>

                <div class="row m-0 p-0 mt-4">
                    <div class="w-100 m-0 p-0">	
                        <a href="#"  data-col-id="{{ isset($id) ? $id  : 0 }}"  data-opt-refer="{{ isset($refer) ? $refer  : 0 }}" class="text-decoration-none textcolor-blue pull-right pl-3 add_edit_collection">Save</a>
                        @if(isset($id) && $id > 0 && !$third_person)
                            <a href="#" data-opt-id="{{ isset($id) ? $id  : 0 }}" class="text-decoration-none color-delete pull-right pl-2 pr-2 "  data-toggle="dropdown">Delete</a>

                            <div class="dropdown-menu dropdown-menu-right"  style="padding: 0px;">
                                <p style="padding: 10px;">Are you sure you want to delete?</p>
								<div style="width: 90%;margin: 0 auto;padding-bottom: 10px;">
									<span class="delete_collection_link" style="color: #CA7073;cursor: pointer;" data-col-id="{{ $id }}">Delete</span> <span style="float: right;color: #219BC4;cursor: pointer;">Back</span>
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