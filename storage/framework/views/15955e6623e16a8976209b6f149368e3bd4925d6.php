<?php $__env->startSection('content'); ?>
<!-- Demo content-->

  <div class="row m-0 astronaut">
 
        <?php if(session('registration_success')): ?> 
        <div style="width:70%;margin:0 auto; border:0px solid red;">                
            <div class="alert alert-success alert-dismissible fade show" role="alert">            
            <?php echo e(session('registration_success')); ?>

              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
        </div>
        <?php endif; ?>  
          
    <div class="astronaut_text">
      <h1>Welcome to Growyspace</h1>
      <p class="textTitle">Tech is our tool, and to promote<br> individual professional growth is our mission</p>
    </div>

  </div>



<div class="row m-0 p-3 astronaut_mobile_text">
    <h1>Welcome to Growyspace</h1>
    <p class="textTitle">Tech is our tool, and to promote<br> individual professional growth is our mission</p>
</div>

<div class="row m-0 p-3 explore_circle">
  <div class="explore_circle_area">
    <h1>Explore Growyspace</h1>
    <p class="m-0">We are a professional development platform that bridges Opportunities with Open-to-work requests from individual professionals. 
    <?php if(Auth::guard('user')->check()): ?>
    <a href="/search" class="color_a">Try it now</a>
    <?php else: ?>    
    <a  data-toggle="modal" data-target="#signup_modal" class="color_a cusor_pointer">Sign up</a>
    <?php endif; ?>
    </p> 
  </div>
</div>
<div class="row m-0 p-3 opp_btn_list">
  <div class="opportunity_buttons">
    <h1>What are you looking for?</h1>
    <p class="pt-4"><button type="button" class="opportunityButton" onclick="location.href='#opportunitySeekers'">I'm looking for opportunities</button></p>
    <p class="pt-4"><button class="talentButton" onclick="location.href='#talentSeekers'">I'm looking for talents</button></p>
  </div>
  
</div>
<div id="opportunitySeekers" class="row m-0 p-3 seekers">
  <div class="row seekers_blog">
      <div class="col-md-12 pb-4 "><h1>Growyspace for opportunity seekers</h1></div>
    
      <div class="col-md-6 pb-3">1) Create an Open-to-work card, and fill out your areas of interest, presentation letter, past experience, skills or education.</div>
      <div class="col-md-6 pb-3">2) Share your Open-to-work card through the chat function or external, so to gain endorsements of your skills.</div>
      <div class="col-md-6 pb-3">3) Send your Open-to-work card to the available Opportunities, or other relevant users.</div>
      <div class="col-md-6 pb-3">4) Explore the available Opportunities, registered users, or available Open-to-work cards.</div>
      <div class="col-md-6 pb-3">5) Create, manage or share a collection or portfolio of either available Opportunities, Open-to-work, or users.</div>
      <div class="col-md-6 pb-3"><strong>Get started looking for opportunities by signing up. It’s free.</strong></div>
      <div class="col-md-12 pt-1 text-center">
        <?php if(Auth::guard('user')->check()): ?>

        <?php else: ?>
        <button class="signupButton" data-toggle="modal" data-target="#signup_modal">Sign up</button>
        <?php endif; ?>
      </div>
      <img src='assets/images/Vector 86.png' class="vector_seeker">
  </div>
</div>

<div id="talentSeekers" class="row m-0 p-3 seekers">
  <div class="row seekers_blog">
    <div class="col-md-12 pb-4 "><h1>Growyspace for talent seekers</h1></div>
   
    <div class="col-md-6 pb-3">1) Create an Opportunity card and fill out the relevant details such as location, fields (skills required), and the description of the opportunity.</div>
    <div class="col-md-6 pb-3">2) Share your created Opportunity card through the chat function or external, so to gain trafic and exposure.</div>
    <div class="col-md-6 pb-3">3) Send your Opportunity card to the available Open-to-work cards created by opportunity seeking profesionals.</div>
    <div class="col-md-6 pb-3">4) Explore the available Open-to-work cards, registered users, or available Opportunities.</div>
    <div class="col-md-6 pb-3">5) Create, manage or share a collection or portfolio of either available Open-to-work, users, or other Opportunities.</div>
    <div class="col-md-6 pb-3"><strong>Find great talents by signing up. It’s free.</strong></div>
    <div class="col-md-12 pt-1 text-center">
     
      <?php if(Auth::guard('user')->check()): ?>

      <?php else: ?>
      <button class="signupButton color-5" data-toggle="modal" data-target="#signup_modal">Sign up</button>
      <?php endif; ?>    
    </div>
  </div>
</div>
<div class="row m-0 contacts">
  <div class="contact_text">
    <h1>Contact us</h1>
      <p>Contact a member of <br> Growyspace if you have <br>any inquiries. <a href="/contact" class="color_contact">Contact us</a></p>
  </div>
  <div class="contact_img">
      <img src="assets/images/Icon-message-new.svg">
  </div>
</div>


<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\XAMPP7.4\htdocs\growyspace 2.0\resources\views/home.blade.php ENDPATH**/ ?>