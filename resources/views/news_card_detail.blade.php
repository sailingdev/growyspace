@extends('layouts.front')
@section('content') 
<style>
p{
    width:100%;
}
@media (max-width: 767px){
 img{
     max-width:100% !important;
     height:auto !important;
 }
}
@media (min-width: 768px){
 
}
</style>
<div class="row m-0 bg-gray">

    <div class="col-md-12 head_logo_area mt-5">

        <div class="head_logo">		
            <img src='/assets/images/Icon-news.svg' alt='profile' class="pull-left" style="width:30px;"><h3 class="pull-left" >News</h3>
        </div>
        <div class="pull-left ml-3">
            <a onclick="window.history.back();" class="cusor_pointer display_image1"><img src="/assets/images/Frame 6.svg" alt="Back" ></a>
        </div>
    
    </div>

    <div class="col-md-10 mx-auto" >
        <div class="row m-0 p-0 ">
            <div class="w-100">
          
                    <div class="row w-100 m-0" style="background: #fff;">
                        <div class="w-75 p-3 pull-left ellipsis" style="color:#000;font-size:1.625rem;font-weight:bold">{{$news->title}}</div>
                        <div class="w-25 p-3 pull-left text-right ellipsis" style="color:#1C3041;font-size:1.25rem;">{{ date("D j, M, Y", strtotime($news->created_at)) }}</div>

                        <div class="w-100" style="box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);">
                            <p class="pl-3 pr-3">{{$news->subtitle}}

                            <a href="#" id="opportunity_share" data-type="text" data-title="Copy this link to share" class="editable editable-click  float-right  text-decoration-none textcolor-blue  pr-2 pl-2 opt_align_mobile" data-placement="bottom" data-original-title="" title="" data-value="{{ URL::to('/') }}/news/{{ $news->id }}#">Share</a> 
                        </p> 
                        
                        </div>
                        

                        <div class="row w-100  m-0 p-3 pt-5">
                        {!! nl2br($news->content) !!}            
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