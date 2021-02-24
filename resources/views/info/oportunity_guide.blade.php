@extends('layouts.front')
@section('content')
<div class="row m-0">
    <div class="col-md-10 mx-auto mt-5">
        <div class="mt-5 mb-5">
            <section class="page-header">  
            <h2 style="color:#1C3041;text-align:center;font-weight:bold;">Opportunity seeker guide</h2>
            </section>
            <section class="terms-section">

            <h3 class="mt-5 font-weight-bold">
            How to “apply” for an opportunity
            </h3>
            <h4 class="mt-5">
            1) Sign-up or log-in into Growyspace.com
            </h4>
            <h4 class="mt-5">
            2) Find an opportunity by searching in <a href="/search" style="color:#219BC4;">Explore</a>
            </h4>
            <h4 class="mt-5">
            3) Press “Send my open-to-work” then either select one of your open-to-work cards or create a new one to send
            </h4>
            <!-- <p style="width: 90%;margin: 0 auto;">a. If you’ve already created an Open to work card, select and existing one</p>
            <p class="pb-3" style="width: 90%;margin: 0 auto;">b. Or create a new one</p>
            <img src="/assets/images/image 17.png" class="img-fluid" alt="Growyspace" /> -->
            <h4 class="mt-5">
            4) Start chatting with the Talent-seeker right away!
            </h4>
            <h3 class="mt-5 pt-5 font-weight-bold">
            Need help as a talent seeker?
            </h3>
            <button type="button" class="opportunityButton bgcolor-collection mt-3" onclick="location.href='/opentowork_guide'">Talent seeker guide</button>
            </section>
        </div>
    </div>
</div>

@endsection