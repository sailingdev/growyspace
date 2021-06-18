<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>PDF</title>
 <link rel="stylesheet" type="text/css" href="{{ public_path('assets/css/custom.css')}}">
</head>
<body>


<div class="card mt-5 mb-2 bgcolor-e1e3dd">                        
    <div class="card-header pl-4 pr-4 color-oppportunity ">
        <div class="row m-0 p-0 opportunity_header">
            <p class="w-65 m-0 p-0 font-weight-bold" style="font-size:1.5rem;">Opportunity</p>
            <p class="w-35 m-0 p-0 text-right font-weight-bold "></p>            
        </div>
    </div>

    <div class="card-block p-4">
        <div class="row m-0 p-0 ">
            <div class="w-100 profile_pitch ">
                <h3 class="font-weight-bold ellipsis" >{{ $opc->title }}</h3>
                <p >{{ $opc->company }}</p>
                <p ><img src="{{ public_path('assets/images/location1.png')}}"  /> <span class="pl-2" style="position: absolute;">{{ $opc->city }}, {{ isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : '' }}</span></p>
                <p >{{ $remote }}</p>
            </div>
        </div>
        @if($opc->salary_range)
            <div class="row m-0 p-0 ">
                <div class="w-100 profile_pitch ">
                    <h3 class="font-weight-bold">Salary</h3>
                    <p >{{ $opc->salary_range }}</p>
                </div>
            </div>	
        @endif

        <div class="row m-0 p-0 ">
            <div class="w-100 profile_pitch">
                <h3 class="font-weight-bold">Technical skills</h3>
               
                @foreach($opc_fields as $key => $oc)
                    @if(count($opc_fields)-1 == $key) {{$oc}}
                    @else {{$oc}} |
                    @endif
                @endforeach
              
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
        <div class="row m-0 p-0" style="height:30px;"></div>
        <div class="row m-0 p-0">
            <div class="mt-3 w-100 profile_pitch " style="text-align:right;">	
                 <a href="{{ URL::to('/') }}/cards/{{ $opc->id }}#" class=" text-decoration-none textcolor-blue pr-2 pl-2">Send my professional card</a>
                 <a href="{{ URL::to('/') }}/cards/{{ $opc->id }}#" class=" text-decoration-none textcolor-blue pr-2 pl-2">Share</a>
                 <a href="{{ URL::to('/') }}/cards/{{ $opc->id }}#" class=" text-decoration-none textcolor-blue pr-2 pl-2">Add to collection</a>
                 <a href="{{ URL::to('/') }}/user/{{ $opc->user_id }}/view" class="text-decoration-none textcolor-blue pr-2 pl-2">Go to user profile</a>
            </div>
					
        </div>
    </div>
</div>


<style>

.card-header {
    border-radius: 10px 10px 0px 0px;
}
.pl-4, .px-4 {
    padding-left: 1.5rem!important;
}
.pr-4, .px-4 {
    padding-right: 1.5rem!important;
}
.h-100 {
    height: 100%!important;
}
.card-header {
  padding: .75rem 1.25rem;
  margin-bottom: 0;
  background-color: rgba(0,0,0,.03);
  border-bottom: 1px solid rgba(0,0,0,.125);
}
.card-header {
    height: 30px;
}
.p-0 {
    padding: 0!important;
}
.m-0 {
    margin: 0!important;
}
.row {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
}

.w-65 {
    width: 65% !important;
}
.font-weight-bold {
    font-weight: 700!important;
}

.w-35 {
    width: 35% !important;
}
.text-right {
    text-align: right!important;
}
.card-block {
    box-shadow: 0px 4px 4px rgb(0 0 0 / 25%);
    border-radius: 0px 0px 10px 10px;
    background: #fff;
    
}
.w-100 {
    width: 100%!important;
}


.h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
    margin-bottom: .5rem;
    font-weight: 500;
    line-height: 1.2;
}
p {
    margin-top: 0;
    margin-bottom: 1rem;
}
.pl-2, .px-2 {
    padding-left: .5rem!important;
}
.p-4 {
    padding: 1.5rem!important;
}

.text-left {
    text-align: left!important;
}

.w-50 {
    width: 50%!important;
}
.mt-2, .my-2 {
    margin-top: .5rem!important;
}

.mb-0, .my-0 {
    margin-bottom: 0!important;
}
.pb-2, .py-2 {
    padding-bottom: .5rem!important;
}
.list-inline-item {
    display: inline-block;
}

.mr-0, .mx-0 {
    margin-right: 0!important;
}
.margin-0-auto {
    margin: 0 auto;
}

.pull-right {
    float: right;
}
.pull-left {
    float: left;
}
.textcolor-blue {
    color: #219BC4 !important;
}
.opt_align_mobile {
    width: unset;
    text-align: unset;
    padding: unset;
    margin: unset;
}
.text-decoration-none {
    text-decoration: none!important;
}
.pl-2, .px-2 {
    padding-left: .5rem!important;
}
.pr-2, .px-2 {
    padding-right: .5rem!important;
}
.float-right {
    float: right!important;
}
.mt-5, .my-5 {
    margin-top: 3rem!important;
}
.mt-3, .my-3 {
    margin-top: 1rem!important;
}
.mt-4, .my-4 {
    margin-top: 1.5rem!important;
}
.pl-4, .px-4 {
    padding-left: 1.5rem!important;
}
.list-inline {
    padding-left: 0;
    list-style: none;
}
.list-inline-item {
    display: inline-block;
}
</style>

</body>

</html>