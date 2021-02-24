$(document).ready(function(){
	if(typeof product_group_id != 'undefined') {
		$('.reorder').on('click',function(){
			$("ul.nav").sortable({ tolerance: 'pointer' });
			$('.reorder').html('Save Reordering');
			$('.reorder').attr("id","updateReorder");
			$('#reorder-msg').slideDown('');
			$('.img-link').attr("href","javascript:;");
			$('.img-link').css("cursor","move");
			$("#updateReorder").click(function( e ){
				if(!$("#updateReorder i").length){
					$(this).html('').prepend('<i class="fa fa-spin fa-spinner"></i>');
					$("ul.nav").sortable('destroy');
					$("#reorder-msg").html( "Reordering Photos - This could take a moment. Please don't navigate away from this page." ).removeClass('light_box').addClass('notice notice_error');
		 
					var h = [];
					$(".gallery ul.nav li").each(function() {  
						h.push($(this).attr('id').substr(9)); 
					});
					 
					$.ajax({
						type: "POST",
						url: base_url + "ajax/change_product_group_images_order",
						dataType:'json',
						data: {
							ids: " " + h + "",
							group_id:window.product_group_id,
							_token: $('._token').val()
						},
						success: function(data){
							if(data.complete){
								window.location.reload();
							}
						}
					}); 
					return false;
				}       
				e.preventDefault();     
			});
		});
		 
		$(function() {
		  $("#myDrop").sortable({
			items: '.dz-preview',
			cursor: 'move',
			opacity: 0.5,
			containment: '#myDrop',
			distance: 20,
			tolerance: 'pointer',
		  });
	 
		  $("#myDrop").disableSelection();
		});
		 
		//Dropzone script
		Dropzone.autoDiscover = false;
		 
		var myDropzone = new Dropzone("div#myDrop", 
		{ 
			paramName: "files", // The name that will be used to transfer the file
			addRemoveLinks: true,
			uploadMultiple: true,
			autoProcessQueue: false,
			parallelUploads: 50,
			maxFilesize: 5, // MB
			acceptedFiles: ".png, .jpeg, .jpg, .gif",
			url: base_url + "ajax/upload_product_group_images",
		});

		myDropzone.on("sending", function(file, xhr, formData) {
		  var filenames = [];
		   
		  $('.dz-preview .dz-filename').each(function() {
			filenames.push($(this).find('span').text());
		  });
		 
		  formData.append('filenames', filenames);
		  formData.append('_token', $('._token').val());
		  formData.append('product_group_id', window.product_group_id);
		});
		 
		/* Add Files Script*/
		myDropzone.on("success", function(file, message){
			$("#msg").html(message);
			setTimeout(function(){window.location.reload() ;},200);
		});
		  
		myDropzone.on("error", function (data) {
			 $("#msg").html('<div class="alert alert-danger">There is some thing wrong, Please try again!</div>');
		});
		  
		myDropzone.on("complete", function(file) {
			myDropzone.removeFile(file);
		});
		  
		$("#add_file").on("click",function (){
			myDropzone.processQueue();
		});
	} 
	
	if(typeof car_id != 'undefined') {
		$('.reorder').on('click',function(){
			$("ul.nav").sortable({ tolerance: 'pointer' });
			$('.reorder').html('Save Reordering');
			$('.reorder').attr("id","updateReorder");
			$('#reorder-msg').slideDown('');
			$('.img-link').attr("href","javascript:;");
			$('.img-link').css("cursor","move");
			$("#updateReorder").click(function( e ){
				if(!$("#updateReorder i").length){
					$(this).html('').prepend('<i class="fa fa-spin fa-spinner"></i>');
					$("ul.nav").sortable('destroy');
					$("#reorder-msg").html( "Reordering Photos - This could take a moment. Please don't navigate away from this page." ).removeClass('light_box').addClass('notice notice_error');
		 
					var h = [];
					$(".gallery ul.nav li").each(function() {  
						h.push($(this).attr('id').substr(9)); 
					});
					 
					$.ajax({
						type: "POST",
						url: base_url + "ajax/change_car_images_order",
						dataType:'json',
						data: {
							ids: " " + h + "",
							car_id:window.car_id,
							_token: $('._token').val()
						},
						success: function(data){
							if(data.complete){
								window.location.reload();
							}
						}
					}); 
					return false;
				}       
				e.preventDefault();     
			});
		});
		 
		$(function() {
		  $("#myDrop").sortable({
			items: '.dz-preview',
			cursor: 'move',
			opacity: 0.5,
			containment: '#myDrop',
			distance: 20,
			tolerance: 'pointer',
		  });
	 
		  $("#myDrop").disableSelection();
		});
		 
		//Dropzone script
		Dropzone.autoDiscover = false;
		 
		var myDropzone = new Dropzone("div#myDrop", 
		{ 
			paramName: "files", // The name that will be used to transfer the file
			addRemoveLinks: true,
			uploadMultiple: true,
			autoProcessQueue: false,
			parallelUploads: 50,
			maxFilesize: 5, // MB
			acceptedFiles: ".png, .jpeg, .jpg, .gif",
			url: base_url + "ajax/upload_car_images",
		});

		myDropzone.on("sending", function(file, xhr, formData) {
		  var filenames = [];
		   
		  $('.dz-preview .dz-filename').each(function() {
			filenames.push($(this).find('span').text());
		  });
		 
		  formData.append('filenames', filenames);
		  formData.append('_token', $('._token').val());
		  formData.append('car_id', window.car_id);
		});
		 
		/* Add Files Script*/
		myDropzone.on("success", function(file, message){
			$("#msg").html(message);
			setTimeout(function(){window.location.reload() ;},200);
		});
		  
		myDropzone.on("error", function (data) {
			 $("#msg").html('<div class="alert alert-danger">There is some thing wrong, Please try again!</div>');
		});
		  
		myDropzone.on("complete", function(file) {
			myDropzone.removeFile(file);
		});
		  
		$("#add_file").on("click",function (){
			myDropzone.processQueue();
		});
	} 
	if(typeof tire_id != 'undefined') {
		$('.reorder').on('click',function(){
			$("ul.nav").sortable({ tolerance: 'pointer' });
			$('.reorder').html('Save Reordering');
			$('.reorder').attr("id","updateReorder");
			$('#reorder-msg').slideDown('');
			$('.img-link').attr("href","javascript:;");
			$('.img-link').css("cursor","move");
			$("#updateReorder").click(function( e ){
				if(!$("#updateReorder i").length){
					$(this).html('').prepend('<i class="fa fa-spin fa-spinner"></i>');
					$("ul.nav").sortable('destroy');
					$("#reorder-msg").html( "Reordering Photos - This could take a moment. Please don't navigate away from this page." ).removeClass('light_box').addClass('notice notice_error');
		 
					var h = [];
					$(".gallery ul.nav li").each(function() {  
						h.push($(this).attr('id').substr(9)); 
					});
					 
					$.ajax({
						type: "POST",
						url: base_url + "ajax/change_tire_images_order",
						dataType:'json',
						data: {
							ids: " " + h + "",
							tire_id:window.tire_id,
							_token: $('._token').val()
						},
						success: function(data){
							if(data.complete){
								window.location.reload();
							}
						}
					}); 
					return false;
				}       
				e.preventDefault();     
			});
		});
		 
		$(function() {
		  $("#myDrop").sortable({
			items: '.dz-preview',
			cursor: 'move',
			opacity: 0.5,
			containment: '#myDrop',
			distance: 20,
			tolerance: 'pointer',
		  });
	 
		  $("#myDrop").disableSelection();
		});
		 
		//Dropzone script
		Dropzone.autoDiscover = false;
		 
		var myDropzone = new Dropzone("div#myDrop", 
		{ 
			paramName: "files", // The name that will be used to transfer the file
			addRemoveLinks: true,
			uploadMultiple: true,
			autoProcessQueue: false,
			parallelUploads: 50,
			maxFilesize: 5, // MB
			acceptedFiles: ".png, .jpeg, .jpg, .gif",
			url: base_url + "ajax/upload_tire_images",
		});

		myDropzone.on("sending", function(file, xhr, formData) {
		  var filenames = [];
		   
		  $('.dz-preview .dz-filename').each(function() {
			filenames.push($(this).find('span').text());
		  });
		 
		  formData.append('filenames', filenames);
		  formData.append('_token', $('._token').val());
		  formData.append('tire_id', window.tire_id);
		});
		 
		/* Add Files Script*/
		myDropzone.on("success", function(file, message){
			$("#msg").html(message);
			setTimeout(function(){window.location.reload() ;},200);
		});
		  
		myDropzone.on("error", function (data) {
			 $("#msg").html('<div class="alert alert-danger">There is some thing wrong, Please try again!</div>');
		});
		  
		myDropzone.on("complete", function(file) {
			myDropzone.removeFile(file);
		});
		  
		$("#add_file").on("click",function (){
			myDropzone.processQueue();
		});
	}
});