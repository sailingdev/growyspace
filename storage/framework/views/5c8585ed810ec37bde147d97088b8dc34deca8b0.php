<?php $__env->startSection('content'); ?>

<script>window.default_msg = '<?php echo e($default_msg); ?>';</script>
<div class="row m-0 bg-gray messages_page">
		<div class="col-md-12 head_logo_area_message mt-5">
			<div class="head_logo">		
			<img src='/assets/images/message_icon1.png' alt='message' class="pull-left" style="width:30px" ><h3 class="pull-left" >Messages</h3>
			</div>

        <div id="sent_match" style="width:60%;margin:0 auto; border:0px solid red; visibility: hidden;">                
            <div class="alert alert-success alert-dismissible fade show" role="alert">            
            <p id="sent_match_body"></p>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
        </div>

		</div>

		<div class="col-md-10 mx-auto mt-4 ">

			<div class="row m-0 p-0 msg_body">
				<div class="msg_left col-md-4 min-vh-100">
					<div class="messages_conversation_items_block">
						
					</div> 
					<div class="alert alert-light alert-dismissible fade show msg_note">
						<div class="msg_note_cont">Are you looking for other users to connect with? Go to <a href="/search">explore</a> to search for them.</div>
						<button type="button" class="close" data-dismiss="alert">&times;</button>
					</div>
				</div>	
				<div style="min-height:300px;" class="<?php echo e($user !== null ? 'load_messages_case' : ''); ?> messages_right col-md-8">
					<?php if($user !== null): ?>
						<input type="hidden" class="message_to_id" value="<?php echo e($user->id); ?>" />
						<a href="/messages" class="btn btn-primary change_chat" data-user-id="<?php echo e($user->id); ?>" style="width: 100%;color: #fff;text-decoration:none;">Change Chat<img src="/assets/images/mobile_new_message.png" class="<?php echo e($not_read_messages_count > 0 ? '' : 'hidden'); ?>" style="margin-top: -10px;margin-left: 10px;" /></a>
						<div data-user-id="<?php echo e($user->id); ?>" class="message_recipient_info_block">

              <div class="post-container">                
                <div class="post-thumb">
                <?php if($user->profile_image(true) === false): ?> 
                  <img class="" src="/assets/images/icon-profile1.png">
                <?php else: ?> 
                  <img class="" src="<?php echo e($user->profile_image()); ?>" style="width:50px;">
                <?php endif; ?>
                </div>
                <div class="post-content">
                    <h3 class="post-title p-0 m-0 ellipsis" onclick="toggleEllipsis(this)"><?php echo e($user->full_name); ?></h3>
                    <p class="msg_profession ellipsis" onclick="toggleEllipsis(this)"><?php echo e($user->profession); ?></p>
                </div>
                <a href="<?php echo e(URL::to('/')); ?>/user/<?php echo e($user->id); ?>/view" class="msg_go_profile">Go to Profile</a>
              </div>
						</div>
						
						<div id="messages_block" class="messages_block msg_block_custom">
							
						</div>
						<div class="messages_input_block">
							
							<div class="input-group mb-3 bg-white" style="border:1px solid;">
							<textarea value="<?php echo e($default_msg); ?>" data-to-id="<?php echo e($user->id); ?>" style="padding-right:5%;border:0px;    margin-top: 7px; height: 45px;" class="message_input form-control msg_input_custom" placeholder="Type a message..." ><?php echo e($default_msg); ?></textarea>
							<!-- <img src="/assets/images/message_pin.png" data-to-id="<?php echo e($user->id); ?>" class="send_message msg_attach"> -->
              <!-- <img src="/assets/images/message_pin.png" data-to-id="<?php echo e($user->id); ?>" style="opacity:0;" class="send_message msg_attach"> -->
              
               <a data-to-id="<?php echo e($user->id); ?>"  class="send_message msg_attach cusor_pointer">Send</a>
							</div>
						</div>
					<?php endif; ?>
				</div>			
        		<div class="mt-5"></div>
   			</div>
   		</div>
</div>

<style>
.message_recipient_info_block {
  height: 100px;
  background-color: #fff;
  position: relative;
  padding: 10px;
  background: #FFFFFF;
  box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
  z-index: 1;
  cursor: pointer;
}





.message_loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
  position: absolute;
  left: 50%;
  margin-left: -60px;
  top: 89px;
}



.outgoing_opp_card {
  overflow: hidden;
  margin: 26px 0 26px;
}
.outgoing_opp_card .opp_card_block {
  float: right;
  width: 46%;
}
.incoming_opp_card .opp_card_block {
  float: left
}
.incoming_opp_card {
  overflow: hidden;
  margin: 26px 0 26px;
}


.not_read_conversation h4,
.not_read_conversation p {
  color: #000;
  font-weight: bold;
}
.red {
  color: red;
}


.change_chat {
  display: none;
}

.msg_left {
          overflow-y: auto;
          height: 3em;
          width: 10em;
          line-height: 1em;
}
      
.msg_left::-webkit-scrollbar {
    width:8px;
    background:#fff;
}
::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px grey; 
  border-radius: 10px;
}
.msg_left::-webkit-scrollbar:vertical {
    width: 11px;
}

.msg_left::-webkit-scrollbar:horizontal {
    height: 11px;
}

.msg_left::-webkit-scrollbar-thumb {
    border-radius: 8px;
    border: 2px solid white; /* should match background, can't be transparent */
    background-color:#332960;
}
.msg_left_item {
  min-height: 120px;
  border: 1px solid #118ed3;
  margin-bottom: 18px;
  padding: 10px 18px 10px 26px;
  position: relative;
  cursor: pointer;
  background: #FFFFFF;
  border: 4px solid #FFFFFF;
  box-sizing: border-box;
  box-shadow: 0px 4px 4px rgba(51, 41, 96, 0.5);
  border-radius: 10px;
}
.msg_left_item.active {
  background: #EAEAEA;
  border: 4px solid #E0D5D5;
  box-sizing: border-box;
  border-radius: 10px;
}
.messages_block{
  overflow-y: auto;
  height: 3em;
  line-height: 1em;
}
      
.messages_block::-webkit-scrollbar {
  -webkit-appearance: none;
}

.messages_block::-webkit-scrollbar:vertical {
  width: 11px;
}

.messages_block::-webkit-scrollbar:horizontal {
  height: 11px;
}

.messages_block::-webkit-scrollbar-thumb {
  border-radius: 8px;
  border: 2px solid white; /* should match background, can't be transparent */
  background-color:#332960;
}
.msg_block{
    max-width: 455px;
    background: #332960;
    border-radius: 10px;
  
  }
.incoming_opp_card .msg_block{
  max-width: 455px;
  background: #EAEAEA;
  border-radius: 10px;

}
.incoming_opp_card p{
  color: #000;
}
.outgoing_opp_card p{
  color: #fff;
}
	        /* Messages */
      
.msg_body{
  margin-top:30px;
  margin-bottom:40px;
}
.msg_note{
  padding: 25px;
  line-height: 30px;
  border-radius: 10px;
  margin-top: 55px;
}
.msg_note a{
  text-decoration:none;
  color:#219BC4
}
.msg_note_cont{
  width: 97%;
  font-size: 17px;
}
.msg_note .alert-dismissible .close {
  top: -5px;
}
.msg_go_profile{
  position: absolute;
  right: 20px;
  bottom: 15px;
  color: #219BC4;
  text-decoration: none;
}
.msg_block_custom{
  position:relative;
  height:400px;
  overflow-y:scroll;
  padding: 12px;
  background:#fff;
}
.msg_input_custom{
  z-index:0;
  background: #FFFFFF; 
  border: 0.5px solid #000000;
  box-sizing: border-box;
  height: 58px;
}
.msg_attach{
  border-radius: 10px;
  text-align: center; 
  margin: auto;
  background: #219BC4;
  color:#fff !important;
  width: 80px;    
  margin-right: 10px;
  padding: 10px;
}
.msg_attach:hover, .msg_attach:focus, .msg_attach:active{
  background: #B0EAFD;
  color:#000000 !important;
}

.msg_name{
  font-size: 26px;
  margin: 0px;
}
.msg_profession{
  font-size: 20px;
  margin: 0px;
}
.msg_left_img{
  width: 57px;
  float: left;
  margin-right: 18px;
}
.msg_left_name{
  font-weight: 600;
  font-size: 26px;
  line-height: 36px;
  letter-spacing: -0.015em;
  color: #000000;
  margin:0px;
  padding-top: 5px
}
.msg_left_profession{
  color:#000;
  padding-left: 8px;
}
.edit_collection_link{
  position: absolute;
  right:5px;
  top:5px;
}
.mgs_date{
  position: absolute;
  right:5px;
  bottom: 5px;
  font-size: 12px;
}
.msg_collection_opp{
  font-size: 20px;
  font-weight: 600;
  margin: 0px;
  padding-top: 16px;
  padding-left: 14px;
  width: 80%;
  float: left;
}
.msg_collection_go{
  text-decoration: none;
  color: #58C0FA;
  font-weight: 500;
  font-size: 20px;
  position: absolute;
  bottom: 12px;
  right: 12px;
}
.msg_collection_img{
  float: left;
  width: 57px;
  margin: 13px 0px 0px 12px;
}

@media  only screen and (max-width: 1150px) and (min-width: 768px) {

  .messages_right {
    -ms-flex: 0 0 52%;
    flex: 0 0 52%;
    max-width: 52%;
  }
}


@media (min-width:320px)  {
	.msg_left.col-md-4{
	width: 100%;
	}
	.msg_left_item{
	padding: 25px 15px 10px 15px;
	}
	.msg_left_name{
	font-size: 1rem;
	}
	.header {
	font-size: 1.8rem;
	}
	.header p {
	float: left;
	padding-left: 15px;
	padding-right: 15px;
	margin: 0px;
	padding-top: 12px;
	padding-bottom: 12px;
	}

	.main_area{
	padding:0px;
	}
	.msg_left_name{
	line-height: normal;
	}
	.msg_left_profession{
	margin-top:5px;
	margin-bottom: 0px;
	font-size: 16px;
	}
	.msg_name {
	font-size: 1.8rem;
	margin: 0px;
	}
	.msg_profession {
	font-size: 16px;
	margin: 0px;
	}
	.msg_go_profile {
	position: absolute;
	right: 30%;
	left: 30%;
	text-align: center;
	bottom: 3px;
	color: #219BC4;
	text-decoration: none;
	}



	.outgoing_opp_card .opp_card_block, .incoming_opp_card .opp_card_block  {
    width: 100%;
    margin: 0 auto;
  }
  .chat li {
    width: 100%;
  }
	.msg_collection_opp{
    font-size: 18px;
    width: 70%;
    line-height:25px
	}
	.msg_collection_go{
	bottom: 20px;
	}
	.msg_collection_img{
	width: 50px;
	margin: 17px 0px 0px 12px;
	}
}
@media  only screen and (max-width:599px){
  .change_chat {
    display: block;
  }


}
@media  screen and (min-width: 600px) and  (max-width: 1024px){

  .main_area {
    padding: 0px;
    max-width: 100%;
  }
  .col-md-4 {
    flex: 0 0 40%;
    max-width: 40%;
  }
  .messages_right {
    flex: 0 0 60%;
    max-width: 60%;
  } 

  .msg_go_profile {
    position: absolute;
    right: 20px;
    left:unset;
    bottom: 15px;
    color: #219BC4;
    text-decoration: none;
  }
}
@media (min-width:1025px) { 

  .msg_go_profile {
    position: absolute;
    right: 20px;
    left:unset;
    bottom: 15px;
    color: #219BC4;
    text-decoration: none;
  }
}
@media (max-width:480px) {
  .chat li {
    margin-bottom: 40px;
    padding-bottom: 5px;
    margin-top: 10px;
    width: 100%;
  }
}
@media (min-width:481px) {
  .chat li {
    margin-bottom: 40px;
    padding-bottom: 5px;
    margin-top: 10px;
    width: 80%;
  }
}

.ellipsis{
  text-overflow: ellipsis;
  overflow: hidden;
  white-space: nowrap;
}
.post-container {
}
.post-thumb {
    float: left
}
.post-thumb img {
    display: block
}
.post-content {
    margin-left: 65px
}
.post-title {
    font-weight: bold;
    font-size: 150%
}
.chat
{
    list-style: none;
    margin: 0;
    padding: 0;
}




.chat li .chat-body p
{
    margin: 0;
    /* color: #777777; */
}


.chat-care
{

}
.chat-care .chat-img
{
    width: 50px;
    height: 50px;
}
.chat-care .img-circle
{
    border-radius: 50%;
}
.chat-care .chat-img
{
    display: inline-block;
}
.chat-care .chat-body
{
    display: inline-block;
    max-width: 80%;
    background-color: #E5E5E5;
    border-radius: 12.5px;
    padding: 15px;
}
.chat-care .chat-body strong
{
  color: #0169DA;
}

.chat-care .admin
{
    text-align: right ;
    float: right;
}
.chat-care .admin p
{
    text-align: left ;
}
.chat-care .agent
{
    text-align: left ;
    float: left;
}
.chat-care .left
{
    float: left;
}
.chat-care .right
{
    float: right;
}

.clearfix {
  clear: both;
}


MsgtextArea{
		width: 500px;
		min-height: 75px;
		font-family: Arial, sans-serif;
		font-size: 13px;
		color: #444;
		padding: 5px;
	  }
	  .noscroll{
		overflow: hidden;
		resize: none;
	  }
	  .hiddendiv{
		display: none;
		white-space: pre-wrap;
		width: 500px;
		min-height: 75px;
		font-family: Arial, sans-serif;
		font-size: 13px;
		padding: 5px;
		word-wrap: break-word;
	  }
	  .lbr {
		line-height: 3px;
	  }
    .form-control:focus {
    box-shadow: unset;
  }
</style>
<script>
var sentMatch = localStorage.getItem('sent_match');
console.log(sentMatch);
if(sentMatch != undefined && sentMatch == "true"){
  document.querySelector('#sent_match').style.visibility = "visible";
  document.getElementById("sent_match_body").innerHTML = "Successful submission to selected matches";
  setTimeout(function() {
    document.getElementById("sent_match_body").innerHTML = "";
    document.querySelector('#sent_match').style.visibility = "hidden";
    localStorage.removeItem('sent_match');
  }, 8000);	
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\XAMPP7.4\htdocs\growyspace 2.0\resources\views/messages.blade.php ENDPATH**/ ?>