@extends('layouts.front')
@section('content')
<div class="row m-0">
    <div class="col-md-10 mx-auto mt-5">
        <div class="mt-5 mb-5">
            <section class="page-header">  
            <h2 style="color:#1C3041;text-align:center;font-weight:bold;">Talent seeker guide</h2>
            </section>
            <section class="terms-section">

            <h3 class="mt-5 font-weight-bold">
            How to create an opportunity or job-offer
            </h3>
            <h4 class="mt-5 mb-3">
            To create an Opportunity (Job-offer) go to <a href="user/my_account" style="color:#219BC4;">My profile</a> and press the button <a href="/cards" style="color:#219BC4;">Create new opportunity</a>
            </h4>
            <h3 class="mt-5 font-weight-bold">
            How to find talent
            </h3>
            <h4 class="mt-5 mb-3">
            To find users, or Professional cards (online CV) go to <a href="/search" style="color:#219BC4;">Explore</a> and search
            </h4>
            <h3 class="mt-5 pt-5 font-weight-bold">
            Need help as an opportunity seeker?
            </h3>
            <button type="button" class="opportunityButton bgcolor-collection mt-3" onclick="location.href='/oportunity_guide'">Opportunity seeker guide</button>
            </section>
        </div>
    </div>
</div>

@endsection