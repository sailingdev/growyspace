@extends('layouts.front')
@section('content')
<div class="row m-0">
    <div class="col-md-10 mx-auto mt-5 mb-5">
      <div class="mt-5 mb-5">
          <section class="page-header">  
          <h2 style="color:#1C3041;text-align:center;font-weight:bold;">About us</h2>
          </section>
          <section class="terms-section">
          <p class="mt-4">
          Growyspace is the result of a willingness to revolutionise the future of work, through a platform that will not only bridge opportunities with individual professionals, but will also enable the performance of other work, professional, or productivity related activities.
          </p>
          <h3 style="margin-top:56px">
          Our purpose
          </h3>
          <p>To be the tool whereby our users will grow professionally.</p>
          <h3 style="margin-top:56px">
          Our mission
          </h3>
          <p>To use tech as a tool, so as to champion a mission to promote individual professional growth.</p>
          <h3 style="margin-top:56px">
          Our Commitments
          </h3>
          <p>We will always stay true to the following commitments.</p>
        
        <p>- To empower the individual</p>
        <p>- To create beautifully designed, and easy-to-use products</p>
        <p>- To create beautifully designed, and easy-to-use products</p>
        <p>- To connect professionals</p>
        <p>- To be the tool through which maximum potential will be achieved</p>
        <h3 style="margin-top:56px; margin-bottom:45px;">
        The team behind Growyspace
        </h3>   
        
          <div class="col-md-4 pull-left card custom_pictures">
              <img class="card-img-top img-fluid" src="{{ URL::to('/') }}/assets/images/IMG_7803 1.png" alt="" >
              <div class="overlay"></div>
              <div class="card-body pl-0">
                <p class="card-text">Manuel Maguga Darbinian </p>
                <p class="card-text">Co-founder & CEO</p>
              </div>
          </div> 

          <div class="col-md-4 pull-left card custom_pictures">
              <img class="card-img-top img-fluid" src="{{ URL::to('/') }}/assets/images/Screenshot 2020-10-02 at 13.07 1.png" alt="" >
              <div class="overlay"></div>
              <div class="card-body pl-0">
                <p class="card-text">Mathias Lyngman</p>
                <p class="card-text">Co-founder & CCO</p>
              </div>
          </div> 
          <div class="col-md-4 pull-left card custom_pictures">
              <img class="card-img-top img-fluid" src="{{ URL::to('/') }}/assets/images/qqIMG_20200429_174145 1.png" alt="" >
              <div class="overlay"></div>
              <div class="card-body pl-0">
                <p class="card-text">Alexander Chao</p>
                <p class="card-text">Co-founder & Lead developer</p>
              </div>
          </div> 
          </section>
      </div>
    </div>
</div>
@endsection