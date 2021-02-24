@extends('layouts.front')
@section('content') 
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
                @if(count($news) > 0)
                    <div class="row w-100 m-0" style="background: #fff;">
                        <div class="w-75 p-3 pull-left ellipsis" style="color:#000;font-size:1.625rem;font-weight:bold">{{$news[0]->title}}</div>
                        <div class="w-25 p-3 pull-left text-right ellipsis" style="color:#1C3041;font-size:1.25rem;">{{ date("D j, M, Y", strtotime($news[0]->created_at)) }}</div>

                        <div class="w-100" style="box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);">
                            <p class="pl-3">{{$news[0]->subtitle}}<a href="{{ URL::to('/') }}/news/{{$news[0]->id}}" class="pl-2" style="color:#3170AF !important">read more</a></p> 
                        
                        </div>
                        

                        <div class="row w-100  m-0 p-3 pt-5">
                        @if($refined[0]['firstImg'])
                            <img src="{{$refined[0]['firstImg']}}" class="news_img">
                            <div class="mt-2">
                                {!!$refined[0]['firstStr']!!} <a href="{{ URL::to('/') }}/news/{{$news[0]->id}}" class="pl-2" style="color:#3170AF !important">read more</a>

                            </div>
                        @else
                            {!!$refined[0]['firstStr']!!}<a href="{{ URL::to('/') }}/news/{{$news[0]->id}}" class="pl-2" style="color:#3170AF !important">read more</a>
                        @endif                        
                        </div>                       
                    </div>

                    <div class="row mt-4">
                    @foreach($news as $key => $value)
                    @if($key > 0)
                        <div class="col-md-4 pull-left mt-4">
                            <div class="row w-100 m-0" style="background: #fff;">
                            <div class="w-100 p-3 pull-left ellipsis" style="color:#000;font-size:1.625rem;font-weight:bold">{{$news[$key]->title}}</div>

                            <div class="w-100" style="box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);">
                                <p class="pl-3">{{ date("D j, M, Y", strtotime($news[$key]->created_at)) }}<a href="{{ URL::to('/') }}/news/{{$news[$key]->id}}" class="pl-2" style="color:#3170AF !important">read more</a></p> 
                            
                            </div>
                            

                            <div class="row w-100  m-0 p-3 pt-3">
                            @if($refined[$key]['firstImg'])
                                <img src="{{$refined[0]['firstImg']}}" class="news_img">
                                <div class="mt-2 ">
                                    {!!$refined[$key]['secondStr']!!} <a href="{{ URL::to('/') }}/news/{{$news[$key]->id}}" class="pl-2" style="color:#3170AF !important">read more</a>

                                </div>
                            @else
                                <div class="">{!!$refined[$key]['thirdStr']!!}<a href="{{ URL::to('/') }}/news/{{$news[$key]->id}}" class="pl-2" style="color:#3170AF !important">read more</a></div>
                            @endif                        
                            </div>                       
                        </div>                            
                        </div>
                    @endif
                    @endforeach
                    </div>

                   

                        
                    
                @else
                <p>No news</p>
                @endif
            </div>
        </div>
        <div class="mt-5"></div>
        <p class="text-center">
            <a  onclick="window.history.back();" class="cusor_pointer"><img src='/assets/images/back_arrow_round.svg' alt='Back' ></a>
        </p>
    </div>
    
		
  
</div>
@endsection