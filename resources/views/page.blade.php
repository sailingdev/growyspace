@extends('layouts.front')
@section('content') 
	<div style="min-height:500px;" class="messages_page container page-content bg-white">
		<!-- Breadcrumb row -->
		<div style="margin-top:83px;" class="breadcrumb-row">
			<div class="container">
				<ul class="list-inline">
					<li><a href="{{ URL::to('/') }}">Home</a></li>
					<li class="active">{{ $page->title }}</li>
					
				</ul>
			</div>
		</div>
		<div style="min-height:600px;">
			
			@if($content_page_id == 3)
			<div class="col-md-12 mb-5">
				<div class="growyspace_card card h-100">
					<div class="card-body allign_center">
						<h1 class="about_us_title"> {{ $page->title }}</h1>
						<p class="about_us_title2">Growyspace is the result of a willingness to revolutionise the future of work, 
through a platform whereby individuals will grow professionally not only by finding 
new opportunities, but also by performing other work or productivity related activities.
</p>						
					</div>
				</div>
			</div>
			
			<div style="float:left;" class="col-md-6 mb-5">
				<div class="growyspace_card card h-100">
					<div class="card-body">
						<h1 class="about_us_title">Our Purpose</h1>
						<p class="about_us_title3">To be the tool whereby our users will grow professionally</p>						
					</div>
				</div>
			</div>
			<div style="float:right;" class="col-md-6 mb-5">
				<div class="growyspace_card card h-100">
					<div class="card-body">
						<h1 class="about_us_title">Our Mission</h1>
						<p class="about_us_title3">Growyspace was born to use all channels available, so to champion a mission to promote individual professional growth. </p>						
					</div>
				</div>
			</div>
			<div style="clear:both;" class="col-md-12 mb-5">
				<div class="growyspace_card card h-100">
					<div class="card-body">
						<h2 class="about_us_title">Our Commitments</h2>
						<p class="about_us_title2">We will always stay true to the following commitments.</p>						
						<ol class="about_us_true_list">
							<li>To empower the individual</li>
							<li>To promote professional growth</li>
							<li>To create beautifully designed, and easy-to-use products.</li>
							<li>To connect people</li>
							<li>To be the tool through which maximum potential will be achieved</li>
						</ol>
					
					</div>
				</div>
			</div>
			
				
			
			@elseif($content_page_id == 4)
				<h1 class="page_title"> {{ $page->title }}</h1>
				{!! Form::open(['url' => '/contact_us/', 'method' => 'POST']) !!}
				<div class="contact_texts_block">
					
					<br/>
					<p style="margin-bottom:0;"><strong>Customer support:</strong> manuel.maguga@growyspace.com</p>
					
					<br/>
				</div>
				<div class="form-group {{ ((count($errors->get('email_address')) > 0) ? 'has-error' : '') }}">
					<label>Email  <span class="red">*</span></label>
					<input type="text" autocomplete="off" class="form-control" name="email_address" placeholder="Email Address" value="{{ old('email_address') !== null ? old('email_address') : '' }}">
				</div>
				<div class="form-group {{ ((count($errors->get('subject')) > 0) ? 'has-error' : '') }}">
					<label>Subject <span class="red">*</span></label>
					<input type="text" autocomplete="off" class="form-control" name="subject" placeholder="Subject" value="{{ old('subject') !== null ? old('subject') : '' }}">
				</div>
				<div class="form-group {{ ((count($errors->get('text_message')) > 0) ? 'has-error' : '') }}">
					<label>Message <span class="red">*</span></label>
					<textarea class="form-control" name="text_message">{{ old('text_message') !== null ? old('text_message') : '' }}</textarea>
				</div>
				
				<div class="form-group">
					<button type="submit" class="btn btn-primary">Send</button>
				</div>
				
				{!! Form::close() !!}
			@else
				<h1 class="page_title"> {{ $page->title }}</h1>
				{!! $page->text !!}
				
			@endif
		</div>
	
	</div>
	
	
	

@endsection