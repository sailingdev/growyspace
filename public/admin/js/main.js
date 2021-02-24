$(document).ready(function() {
	$('.factures_filter').click(function(){
		var url_parameters = {};
		var ref_item = $('select[name=filter_ref_item_dropdown]').val();
		var provider = $('.filter_provider').val();
		var facture_month = $('select[name=facture_month]').val();
		
		if($.trim(ref_item) != '') {
			url_parameters.ref_item = ref_item;
		}
		
		if($.trim(provider) != '') {
			url_parameters.provider = provider;
		}
		
		if ($.trim(facture_month) != '') {
			url_parameters.month = facture_month;
		}
		
		var querystring = encodeQueryData(url_parameters);
		
		window.location.href = category_url + '?' + querystring;
		return false;
	});
	
	
	$('.filter_facture_btn').click(function(){
		$('.facture_filter_fields_block').removeClass('hidden');
		return false;
	});
	$(document).on('click','.update_facture',function() {
		var this_ = $(this);
		var button_text = this_.html();
		this_.html('Processing...');
		this_.prop('disabled', true);
		
		
		var fac_items_block = $(this).parents('.fac_items_block');
		var facture_id = $(this).attr('facture_id');
		var provider = fac_items_block.find('input[name=provider]').val();
		var facture_number = fac_items_block.find('input[name=facture_number]').val();
		var date = fac_items_block.find('input[name=date]').val();
		var TVA = fac_items_block.find('input[name=TVA]').is(':checked') ? 1 : 0;
		
		if($.trim(provider) == '') {
			$.notify('Please add a Provider', "error");
			return false;
		}
		
		if($.trim(facture_number) == '') {
			$.notify('Please add a facture_number', "error");
			return false;
		}
		
		if($.trim(date) == '') {
			$.notify('Please add a date', "error");
			return false;
		}
		
		$.ajax({
			type:'POST',
			url:base_url + 'ajax/update_facture',
			dataType:'json',
			data:{
				facture_id:facture_id,
				provider:provider,
				facture_number:facture_number,
				date:date,
				TVA:TVA,
				_token: $('._token').val()
			},
			cache: false,
			success:function(data) {
				if (data.complete) {
					var fac_items_html = data.fac_items_html;
					fac_items_block.find('.fac_item_table_block').html(fac_items_html);
					this_.html(button_text);
					this_.prop('disabled', false);
					$.notify("Facture updated successfully.", "success");
					fac_items_block.find('.edit_facture_block').remove();
				}
			}
		});
	});

	
	$(document).on('click','.delete_fac_item',function() {
		var result = confirm("Are you sure?");
		var fac_items_block = $(this).parents('.fac_items_block');
		var fac_block = $(this).parents('.fac_block');
		if (result) {
			var this_ = $(this);
			var button_text = this_.html();
			this_.html('Processing...');
			this_.prop('disabled', true);
		
			$.ajax({
				type:'POST',
				url:base_url + 'ajax/delete_factura_item',
				dataType:'json',
				data:{
					data_id:$(this).attr('data-id'),
					_token: $('._token').val()
				},
				cache: false,
				success:function(data) {
					if (data.complete) {
						var fac_items_html = data.fac_items_html;
						var facture = data.facture;
						fac_items_block.find('.fac_item_table_block').html(fac_items_html);
						this_.html(button_text);
						this_.prop('disabled', false);
						
						fac_block.find('.fac_row_items_total_price span').text(facture.total_price);
						fac_block.find('.fac_row_items_total_TVA_price span').text(facture.total_TVA_price);
						fac_block.find('.fac_row_items_total_TTC_price span').text(facture.total_TTC_price);
						$.notify("Facture item deleted successfully.", "success");
						
						
					}
				}
			});
		}
		return false;
	});
	
	$(document).on('click','.cancel_add_facture_item',function(){
		$(this).parents('.add_facture_item_block_block').prev('.add_facture_item_btn').removeClass('hidden');
		$(this).parents('.add_facture_item_block').remove();
		return false;
	});
	
	$(document).on('click','.edit_fac_item',function() {
		var data_id = $(this).attr('data-id');
		var data_json = $(this).attr('data-json');
		var data_obj = JSON.parse(data_json);
		var reference = data_obj.reference;
		var category_id = data_obj.category_id;
		var quantity = data_obj.quantity;
		var unit_price = data_obj.unit_price;
		var extra_charges = data_obj.extra_charges;
		
		var data_facture_id = $(this).attr('data-facture-id');
		var add_facture_item_block_block = $(this).parents('.fac_items_block').find('.add_facture_item_block_block');
		
		var add_facture_item_block = $('.add_facture_item_block.add_facture_item_block_').clone().removeClass('add_facture_item_block_').removeClass('hidden');
		add_facture_item_block_block.html(add_facture_item_block);
		add_facture_item_block_block.find('.add_facture_item').attr('data-id',data_id);
		add_facture_item_block_block.find('.add_facture_item').attr('data-facture-id',data_facture_id);
		add_facture_item_block_block.find('.add_facture_item').text('Edit Facture Item');
		add_facture_item_block_block.find('.edit_mode').val(1);
		
		if(extra_charges == 1) {
			add_facture_item_block_block.find('.extra_charges').val(1);
		} else {
			add_facture_item_block_block.find('.extra_charges').val(0);
		}
		
		add_facture_item_block_block.find('select[name=ref_item_dropdown]').val(reference);
		add_facture_item_block_block.find('select[name=facture_category]').val(category_id);
		add_facture_item_block_block.find('input[name=quantity]').val(quantity);
		add_facture_item_block_block.find('input[name=price]').val(unit_price);
						
		$(this).parents('.fac_items_block').find('.add_facture_item_btn').addClass('hidden');
		
		return false;
	});
	$(document).on('click','.add_facture_item',function(){
		var fac_block = $(this).parents('.fac_block');
		var fac_items_block = $(this).parents('.fac_items_block');
		var add_facture_item_block = $(this).parents('.add_facture_item_block');
		var ref_item = add_facture_item_block.find('select[name=ref_item_dropdown]').val();
		var category = add_facture_item_block.find('select[name=facture_category]').val();
		var quantity = add_facture_item_block.find('input[name=quantity]').val();
		var price = add_facture_item_block.find('input[name=price]').val();
		var edit_mode = add_facture_item_block.find('input.edit_mode').val();
		var extra_charges = add_facture_item_block.find('input.extra_charges').val();
		var data_id = $(this).attr('data-id');
		var data_facture_id = $(this).attr('data-facture-id');
		
		if(extra_charges == 0 && $.trim(ref_item) == '') {
			$.notify('Please select a ref item', "error");
			return false;
		}
		
		if(extra_charges == 0 && $.trim(category) == '') {
			$.notify('Please select a category', "error");
			return false;
		}
		
		if($.trim(quantity) == '') {
			$.notify('Please add a quantity', "error");
			return false;
		}
		
		if($.trim(price) == '') {
			$.notify('Please add a price', "error");
			return false;
		}
		
		var facture_id = $(this).parents('.add_facture_item_block_block').attr('facture_id');
		var this_ = $(this);
		var button_text = this_.html();
		this_.html('Processing...');
		this_.prop('disabled', true);
		
		$.ajax({
			type:'POST',
			url:base_url + 'ajax/add_facture_item',
			dataType:'json',
			data:{
				data_id:data_id,
				edit_mode:edit_mode,
				extra_charges:extra_charges,
				data_facture_id:data_facture_id,
				quantity:quantity,
				price:price,
				ref_item:ref_item,
				category:category,
				facture_id:facture_id,
				_token: $('._token').val()
			},
			cache: false,
			success:function(data) {
				if (data.complete) {
					if(edit_mode == 1) {
						$.notify("Facture item updated successfully.", "success");
					} else {
						$.notify("Facture item added successfully.", "success");
					}
										
					var facture = data.facture;
					var fac_items_html = data.fac_items_html;
					fac_items_block.find('.fac_item_table_block').html(fac_items_html);
					this_.html(button_text);
					this_.prop('disabled', false);
					add_facture_item_block.remove();
					fac_items_block.find('.add_facture_item_btn').removeClass('hidden');
					
					fac_block.find('.fac_row_items_total_price span').text(facture.total_price);
					fac_block.find('.fac_row_items_total_TVA_price span').text(facture.total_TVA_price);
					fac_block.find('.fac_row_items_total_TTC_price span').text(facture.total_TTC_price);
					
				}
			}
		});
		
		return false;
	});
	
	$('.add_facture_item_btn').click(function(){
		var fac_items_block = $(this).parents('.fac_items_block');
		
		var add_facture_item_block = $('.add_facture_item_block.add_facture_item_block_').clone().removeClass('add_facture_item_block_').removeClass('hidden');
		fac_items_block.find('.add_facture_item_block_block').html(add_facture_item_block);
		
		$("select[name=ref_item_dropdown]").chosen({
            no_results_text: "Oops, nothing found!",
            width: "100%"
        });

		return false;
	});
	
	$('.edit_facture_btn').click(function(){
		$(this).removeClass('hidden');
		var edit_facture_block = $('.edit_facture_block.edit_facture_block_').clone().removeClass('edit_facture_block_').removeClass('hidden');
		var fac_items_block = $(this).parents('.fac_items_block');
		fac_items_block.find('.edit_facture_block_block').html(edit_facture_block);
		
		var data_json = $(this).attr('data-json');
		var data_obj = JSON.parse(data_json);
		
		var provider = data_obj.provider;
		var facture_number = data_obj.facture_number;
		var facture_date = data_obj.date;
		var TVA = data_obj.TVA;
		
		fac_items_block.find('input[name=provider]').val(provider);
		fac_items_block.find('input[name=facture_number]').val(facture_number);
		fac_items_block.find('input[name=date]').val(facture_date);
		fac_items_block.find('input[name=TVA]').prop('checked',(TVA == 1 ? true : false));
		fac_items_block.find('input[name=date]').removeClass('hasDatepicker').datepicker();
		fac_items_block.find('.update_facture').attr('facture_id',data_obj.id);
		
		return false;
	});
	
	$(document).on('click','.cancel_edit_facture',function(){
		var fac_items_block = $(this).parents('.fac_items_block');
		fac_items_block.find('.edit_facture_block').remove();
		return false;
	});
	
	$('.create_facture_btn').click(function(){
		$('.create_facture_fields_block').removeClass('hidden');
		$(this).addClass('hidden');
		return false;
	});
	
	$('.cancel_add_facture').click(function(){
		$('.create_facture_btn').removeClass('hidden');
		$('.create_facture_fields_block').addClass('hidden');
		return false;
	});
	
	$( ".facture_date" ).datepicker();
	
	$('.edit_order_status_btn').click(function(){
		$('.order_statuses_block').removeClass('hidden');
		return false;
	});
	$(document).on('click','.update_ref',function(){
		var this_ = $(this);
		var button_text = this_.html();
		this_.html('Processing...');
		this_.prop('disabled', true);
		var cart_row_id = $(this).attr('cart_row_id');
		var ref_item = $(this).parents('tr').find('.ref_item').val();
		
		$.ajax({
			type:'POST',
			url:base_url + 'ajax/update_ref',
			dataType:'json',
			data:{
				ref_item:ref_item,
				cart_row_id:cart_row_id,
				_token: $('._token').val()
			},
			cache: false,
			success:function(data) {
				if (data.complete) {
					$.notify("Ref item updated successfully.", "success");
					this_.html(button_text);
					this_.prop('disabled', false);
				}
			}
		});
		
		return false;
	});
	
	$(document).on('click','.finish_order',function(){
		var status = $(this).attr('status');
		var cancel_order_text = '';
		if (status == 'cancelled') {
			if($('.cancel_order_text_block').hasClass('hidden')) {
				$('.cancel_order_text_block').removeClass('hidden');
				return false;
			}
			
			var cancel_order_text = $('.cancel_order_text').val();
			
			if ($.trim(cancel_order_text) == '') {
				$.notify('Please provide Cancel Order Note', "error");
				return false;
			}
		}
		
		var result = confirm("Are you sure?");
		
		if (result) {
			var this_ = $(this);
			var button_text = this_.html();
			this_.html('Processing...');
			this_.prop('disabled', true);
			
			$.ajax({
				type:'POST',
				url:base_url + 'ajax/finish_order',
				dataType:'json',
				data:{
					status:status,
					cancel_order_text:cancel_order_text,
					order_id:$(this).attr('order_id'),
					_token: $('._token').val()
				},
				cache: false,
				success:function(data) {
					if (data.complete) {
						if(status == 'finished') {
							$.notify("Order Finished successfully.", "success");
						} else if (status == 'cancelled') {
							$.notify("Order Cancelled successfully.", "success");
						}
						
						setTimeout(function(){ 
							window.location.reload();
						}, 3000);
					}
				}
			});
		}
		
		return false;
	});
	
	
	
	// range slider
	$("#slider-range-price").slider({
		range: true,
		min: 0,
		max: 30000,
		values: [0, 30000],
		slide: function (event, ui) {
			$("#slider-range-price-amount").text("€" + ui.values[0] + " - €" + ui.values[1]);
		}
	});

	$("#slider-range-price-amount").text("€" + $("#slider-range-price").slider("values", 0) + " - €" + $("#slider-range-price").slider("values", 1));

	///////////////////////////////////////
	$("#slider-range-model-year").slider({
		range: true,
		min: 2000,
		max: 2020,
		values: [0, 2020],
		slide: function (event, ui) {
			$("#slider-range-model-year-amount").text("" + ui.values[0] + " - " + ui.values[1]);
		}
	});

	$("#slider-range-model-year-amount").text("" + $("#slider-range-model-year").slider("values", 0) + " - " + $("#slider-range-model-year").slider("values", 1));
	
	$("#slider-range-mileage").slider({
		range: true,
		min: 0,
		max: 500000,
		values: [0, 500000],
		slide: function (event, ui) {
			$("#slider-range-mileage-amount").text(ui.values[0] + " - " + ui.values[1]);
		}
	});

	$("#slider-range-mileage-amount").text($("#slider-range-mileage").slider("values", 0) + " - " + $("#slider-range-mileage").slider("values", 1));
	
	$('input.float_only').on('input', function() {
	  this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
	});
	
	window.orders_table = $('.orders_table').DataTable({
		"processing": true,
        "serverSide": true,
		"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		aaSorting: [[0, 'desc']],
		ajax: {
			"url": base_url + 'ajax/get_orders',
			cache: false,
			"data": function ( d ) {
				//d.power_id = $('select[name=power]').val()
			},
			dataFilter: function(data) {
				var json = jQuery.parseJSON( data );
				$('.orders_count').text(json.recordsFiltered);
	 			return JSON.stringify( json ); // return JSON string
			}
		},
		columns: [
			{ data: 'id' },
			{ data: 'client_name' },
			{ data: 'transaction_id' },
			{ data: 'shipping_method' },
			{ data: 'shipping_price' },
			{ data: 'subtotal' },
			{ data: 'order_total_price' },
			{ data: 'status' },
			{ data: 'facture_id_' },
			{ data: 'created_at' },
			{ data: 'payment_type' },
			{ data: 'actions' }
		]
	});


	
	$('.generate_excel_products').click(function(){
		var this_ = $(this);
		var button_text = this_.html();
		this_.html('Processing...');
		this_.prop('disabled', true);
		$.ajax({
			type:'POST',
			url:base_url + 'ajax/generate_excel_products',
			dataType:'json',
			data:{
				group_id:$('select[name=group]').val(),
				category_id:$('select[name=category]').val(),
				mark_id:$('select[name=mark]').val(),
				model_id:$('select[name=model]').val(),
				motorization_id:$('select[name=motorization]').val(),
				power_id:$('select[name=power]').val(),
				_token: $('._token').val()
			},
			cache: false,
			success:function(data) {
				if (data.complete) {
					this_.html(button_text);
					this_.prop('disabled', false);
					var download_url = data.download_url;
					window.location.href = download_url;
				}
			}
		});
		return false;
	});
	
	$(document).on('click','.delete_mark_model_motorization_power',function(){
		var result = confirm("Are you sure?");
		
		if (result) {
			$.ajax({
				type:'POST',
				url:base_url + 'ajax/delete_power',
				dataType:'json',
				data:{
					power_id:$(this).attr('power_id'),
					motorization_id:$(this).attr('motorization_id'),
					tree_mark_id:window.tree_mark_id,
					tree_model_id:window.tree_model_id,
					_token: $('._token').val()
				},
				cache: false,
				success:function(data) {
					if (data.complete) {
						var motorization_powers_html = data.motorization_powers_html;
						$('.motorization_powers_block').html(motorization_powers_html);
						$.notify("Power deleted successfully.", "success");
					}
				}
			});
		}
		
		return false;
	});
	
	$(document).on('click','.add_power_btn',function(){
		$(this).addClass('hidden');
		$('.add_power_block').removeClass('hidden');
		return false;
	});
	
	$(document).on('click','.cancel_add_power',function(){
		$('.add_power_btn').removeClass('hidden');
		$('.add_power_block').addClass('hidden');
		return false;
	});
	
	$(document).on('click','.add_motorization_btn',function(){
		$(this).addClass('hidden');
		$('.add_motorization_block').removeClass('hidden');
		return false;
	});
	
	$(document).on('click','.cancel_add_motorization',function(){
		$('.add_motorization_btn').removeClass('hidden');
		$('.add_motorization_block').addClass('hidden');
		return false;
	});
	
	$(document).on('click','.add_power',function() {
		var power_name = $('.power_name').val();
		
		if($.trim(power_name) == '') {
			$.notify('Please add power name', "error");
		}
		
		$.ajax({
			type:'POST',
			url:base_url + 'ajax/add_power',
			dataType:'json',
			data:{
				power_name:power_name,
				motorization_id:$(this).attr('motorization_id'),
				tree_mark_id:window.tree_mark_id,
				tree_model_id:window.tree_model_id,
				_token: $('._token').val()
			},
			cache: false,
			success:function(data) {
				if (data.complete) {
					var motorization_powers_html = data.motorization_powers_html;
					$('.motorization_powers_block').html(motorization_powers_html);
					$.notify("Power added successfully.", "success");
				}
			}
		});
		
		return false;
	});
	
	
	$(document).on('click','.delete_mark_model_motorization',function(){
		var result = confirm("Are you sure?");
		
		if (result) {
			$.ajax({
				type:'POST',
				url:base_url + 'ajax/delete_motorization',
				dataType:'json',
				data:{
					motorization_id:$(this).attr('motorization_id'),
					tree_mark_id:window.tree_mark_id,
					tree_model_id:window.tree_model_id,
					_token: $('._token').val()
				},
				cache: false,
				success:function(data) {
					if (data.complete) {
						var motorization_powers_html = data.motorization_powers_html;
						$('.motorization_powers_block').html(motorization_powers_html);
						$.notify("Motorization deleted successfully.", "success");
					}
				}
			});
		}
		
		return false;
	});
	$(document).on('click','.add_motorization',function() {
		var motorization_name = $('.motorization_name').val();
		
		if($.trim(motorization_name) == '') {
			$.notify('Please add motorization name', "error");
		}
		
		$.ajax({
			type:'POST',
			url:base_url + 'ajax/add_motorization',
			dataType:'json',
			data:{
				motorization_name:motorization_name,
				tree_mark_id:window.tree_mark_id,
				tree_model_id:window.tree_model_id,
				_token: $('._token').val()
			},
			cache: false,
			success:function(data) {
				if (data.complete) {
					var motorization_powers_html = data.motorization_powers_html;
					$('.motorization_powers_block').html(motorization_powers_html);
					$.notify("Motorization added successfully.", "success");
				}
			}
		});
		
		return false;
	});
	
	if($('.cars_table').length > 0) {
		window.cars_table = $('.cars_table').DataTable({
			"processing": true,
			"serverSide": true,
			"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			ajax: {
				"url": base_url + 'ajax/get_cars',
				cache: false,
				"data": function ( d ) {
					d.min_price = $(".car_filter_min_price").val();
					d.max_price = $(".car_filter_max_price").val();
					d.min_model_year = $(".car_filter_min_year").val();
					d.max_model_year = $(".car_filter_max_year").val();
					d.fuel_filter = $('.fuel_filter').val();
					d.gearbox = $('.gearbox').val();
					d.min_mileage = $(".car_filter_min_mileage").val();
					d.max_mileage = $(".car_filter_max_mileage").val();
					d.title_filter = $(".title_filter").val();
					
				},
				dataFilter: function(data) {
					var json = jQuery.parseJSON( data );
					$('.cars_count').text(json.recordsFiltered);
					return JSON.stringify( json ); // return JSON string
				}
			},
			columns: [
				{ data: 'id' },
				{ data: 'title' },
				{ data: 'price' },
				{ data: 'mark' },
				{ data: 'model' },
				{ data: 'model_year' },
				{ data: 'gearbox_name' },
				{ data: 'mileage' },
				{ data: 'fuel_name' },
				{ data: 'actions' }
			]
		});
		
		$('.filter_cars').click(function(){
			cars_table.draw();
			return false;
		});
	}
	
	if($('.tires_table').length > 0) {
		window.tires_table = $('.tires_table').DataTable({
			"processing": true,
			"serverSide": true,
			"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			ajax: {
				"url": base_url + 'ajax/get_tires',
				cache: false,
				"data": function ( d ) {
					d.type = $('select[name=type]').val();
					d.tire_mark_id = $('select[name=tire_mark]').val()
					d.tire_width_id = $('select[name=tire_width]').val()
					d.tire_height_id = $('select[name=tire_height]').val()
					d.tire_diameter_id = $('select[name=tire_diameter]').val()
					d.tire_charge_id = $('select[name=tire_charge]').val()
					d.tire_speed_id = $('select[name=tire_speed]').val()
				},
				dataFilter: function(data) {
					var json = jQuery.parseJSON( data );
					$('.tires_count').text(json.recordsFiltered);
					return JSON.stringify( json ); // return JSON string
				}
			},
			columns: [
				{ data: 'id' },
				{ data: 'title' },
				{ data: 'type_name' },
				{ data: 'tire_mark' },
				{ data: 'tire_width' },
				{ data: 'tire_height' },
				{ data: 'tire_diameter' },
				{ data: 'tire_charge' },
				{ data: 'tire_speed' },
				{ data: 'tire_season' },
				{ data: 'runflat_name' },
				{ data: 'reinforced_name' },
				{ data: 'actions' }
			]
		});
		
		$('.filter_tires').click(function(){
			tires_table.draw();
			return false;
		});
	
	}
	
	window.opportunity_cards = $('.opportunity_cards').DataTable({
		"processing": true,
        "serverSide": true,
		"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		ajax: {
			"url": base_url + 'ajax/get_opportunity_cards',
			cache: false,
			"data": function ( d ) {
				
			},
			dataFilter: function(data) {
				var json = jQuery.parseJSON( data );
				
	 			return JSON.stringify( json ); // return JSON string
			}
		},
		columns: [
			{ data: 'id' },
			{ data: 'owner_name' },
			{ data: 'title' },
			{ data: 'company' },
			{ data: 'salary' },
			{ data: 'hours' },
			{ data: 'country' },
			{ data: 'city' },
			{ data: 'description' },
			{ data: 'actions' }
		]
	});

	window.opentowork_cards = $('.opentowork_cards').DataTable({
		"processing": true,
        "serverSide": true,
		"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		ajax: {
			"url": base_url + 'ajax/get_opentowork_cards',
			cache: false,
			"data": function ( d ) {
				
			},
			dataFilter: function(data) {
				var json = jQuery.parseJSON( data );
				
	 			return JSON.stringify( json ); // return JSON string
			}
		},
		columns: [
			{ data: 'id' },
			{ data: 'owner_name' },
			{ data: 'title' },
			{ data: 'email' },
			// { data: 'salary' },
			{ data: 'roles' },
			{ data: 'country' },
			{ data: 'city' },
			{ data: 'description' },
			{ data: 'actions' }
		]
	});
	
	
	
	if($('.product_groups_table').length > 0) {
		window.product_groups_table = $('.product_groups_table').DataTable({
			"processing": true,
			"serverSide": true,
			"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			aaSorting: [[6, 'asc']],
			ajax: {
				"url": base_url + 'ajax/get_product_groups',
				cache: false,
				"data": function ( d ) {
					d.item_name = $('.item_name').val();
					d.has_image = $('.has_image').val();
				},
				dataFilter: function(data) {
					var json = jQuery.parseJSON( data );
					$('.grouos_count').text(json.recordsFiltered);
					return JSON.stringify( json ); // return JSON string
				}
			},
			columns: [
				{ data: 'id' },
				{ data: 'name' },
				{ data: 'items', searchable: true },
				{ data: 'has_image' },
				{ data: 'price' },
				{ data: 'price2' },
				{ data: 'rank' },
				{ data: 'actions' }
			]
		});
		
		$('.filter_product_groups').click(function(){
			product_groups_table.draw();
			return false;
		});
		
		$('.reset_filter_product_groups').click(function(){
			$('.item_name').val('');
			product_groups_table.draw();
			return false;
		});
	}
	
	$('.dynamic_mark_model_motorization_power').change(function() {
		var dependence = $(this).attr('dependence');
		if(dependence == 'power') {
			return false;
		}
		var data_id = $(this).val();
		
		
		$.ajax({
			type:'POST',
			url:base_url + 'ajax/dynamic_mark_model_motorization_power',
			dataType:'json',
			data:{
				dependence:dependence,
				data_id:data_id,
				_token: $('._token').val()
			},
			cache: false,
			success:function(data){
				if(data.complete){
					var options_html = data.options_html;
					
					if(dependence == 'mark') {
						$('.dynamic_mark_model_motorization_power[dependence=model] option[value!=""]').remove();
						$('.dynamic_mark_model_motorization_power[dependence=model]').append(options_html);
						
						if (typeof product_mark_model != 'undefined') {
							$('.dynamic_mark_model_motorization_power[dependence=model]').val(product_mark_model).change();
						}
						
						$('.dynamic_mark_model_motorization_power[dependence=motorization] option[value!=""]').remove();
						$('.dynamic_mark_model_motorization_power[dependence=power] option[value!=""]').remove();
					} else if(dependence == 'model') {
						$('.dynamic_mark_model_motorization_power[dependence=motorization] option[value!=""]').remove();
						$('.dynamic_mark_model_motorization_power[dependence=motorization]').append(options_html);
						
						if (typeof product_mark_model_motorization != 'undefined') {
							$('.dynamic_mark_model_motorization_power[dependence=motorization]').val(product_mark_model_motorization).change();
						}
						
						$('.dynamic_mark_model_motorization_power[dependence=power] option[value!=""]').remove();
					}  else if(dependence == 'motorization') {
						$('.dynamic_mark_model_motorization_power[dependence=power] option[value!=""]').remove();
						$('.dynamic_mark_model_motorization_power[dependence=power]').append(options_html);
												
						if (typeof product_mark_model_motorization_power != 'undefined') {
							$('.dynamic_mark_model_motorization_power[dependence=power]').val(product_mark_model_motorization_power).change();
						}
					}
				}
			}
		});
		return false;
	}).change();

	

	$(document).on('click','.manage_mark_model_tree_btn',function(){
		window.tree_mark_id = $(this).attr('mark_id');
		window.tree_model_id = $(this).attr('model_id');
		$('.open_manage_mark_model_popup').click();
		return false;
	});
	
	$(document).on('click','.edit_product_group',function(){
		window.product_group_id = $(this).attr('data-id');
		$('.open_manage_product_group_popup_popup').click();
		return false;
	});
	
	$(document).on('click','.add_new_model_btn',function(){
		window.tree_mark_id = $(this).attr('mark_id');
		window.tree_model_id = $(this).attr('model_id');
		$('.mark_model_edit_mode').val(0);
		$('.mark_model_name').val('');
		$('.open_add_edit_mark_popup').click();
		return false;
	});
		
	$(document).on('click','.edit_mark_model_btn',function() {
		window.tree_mark_id = $(this).attr('mark_id');
		window.tree_model_id = $(this).attr('model_id');
		window.tree_model_name = $(this).attr('model_name');
		$('.mark_model_edit_mode').val(1);
		$('.mark_model_name').val(tree_model_name);
		$('.open_add_edit_mark_popup').click();
		return false;
	});
	
	$('.add_edit_mark_model').click(function() {
		var mark_model_name = $('.mark_model_name').val();
		
		if ($.trim(mark_model_name) == '') {
			$.notify("Please provide model name.", "error");
			return false;
		}
		
		var mark_model_edit_mode = $('.mark_model_edit_mode').val();
		
		$.ajax({
			type:'POST',
			url:base_url + 'ajax/add_edit_mark_model',
			dataType:'json',
			data:{
				tree_mark_id:window.tree_mark_id,
				tree_model_id:window.tree_model_id,
				tree_model_name:$('.mark_model_name').val(),
				mark_model_edit_mode:mark_model_edit_mode,
				_token: $('._token').val()
			},
			cache: false,
			success:function(data){
				if(data.complete){
					if (mark_model_edit_mode == 1) {
						$.notify("Model updated successfully.", "success");
					} else {
						$.notify("Model created successfully.", "success");
					}
					
					setTimeout(function(){ 
						window.location.reload();
					}, 1000);
					
				} else {
					$.notify(data.message, "error");
				}
			}
		});
		return false;
	});
	
	$('.open_add_edit_mark_popup').magnificPopup({
		type:'inline',
		midClick: true,
		preloader: true,
   	    callbacks: {
			open: function() {
				
				
				
			}
		}
	});
	
	$('.open_manage_mark_model_popup').magnificPopup({
		type:'inline',
		midClick: true,
		preloader: true,
   	    callbacks: {
			open: function() {
				$.ajax({
					type:'POST',
					url:base_url + 'ajax/get_mark_model_tree',
					dataType:'json',
					data: {
						tree_mark_id:  window.tree_mark_id,
						tree_model_id: window.tree_model_id,
						_token: $('._token').val()
					},
					cache: false,
					success:function(data) {
						if (data.complete) {
							var motorization_powers_html = data.motorization_powers_html;
							var motorization_powers = data.motorization_powers;
							var mark = data.mark;
							var mark_model = data.mark_model;
							
							$('.mark_name').text(mark.name);
							$('.model_name').text(mark_model.name);
							$('.motorization_powers_block').html(motorization_powers_html);
						}
					}
				});
			}
		}
	});
	
	$('.open_manage_product_group_popup_popup').magnificPopup({
		type:'inline',
		midClick: true,
		preloader: true,
   	    callbacks: {
			open: function() {
				$.ajax({
					type:'POST',
					url:base_url + 'ajax/get_product_group_data',
					dataType:'json',
					data:{
						group_id:window.product_group_id,
						_token: $('._token').val()
					},
					cache: false,
					success:function(data){
						if(data.complete){
							
						}
					}
				});
			}
		}
	});
	
	$('.open_user_assign_coupon_popup').magnificPopup({
		type:'inline',
		midClick: true,
		preloader: true,
   	    callbacks: {
			open: function() {
								
				$.ajax({
					type:'POST',
					url:base_url + 'ajax/get_user_coupons',
					dataType:'json',
					data:{
						
						user_id:window.user_id,
						_token: $('._token').val()
					},
					cache: false,
					success:function(data) {
						if (data.complete) {
							var coupons_html = data.coupons_html;
							$('.coupon_items').html(coupons_html);
							var user_full_name = data.user.bill_first_name + ' ' + data.user.bill_first_name;
							
							$('.coupon_user_info').text(user_full_name + '\'s coupon(s)');
							
							$('input.float_only').on('input', function() {
							  this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
							});
												
						}
					}
				});
			},
			close: function() {
				if(typeof need_reload_true != 'undefined') {
					window.location.reload();
				}
			}
		}
	});
	
	$('.save_user_coupons').click(function() {
		var coupons = [];
		var percentages = [];
		
		$('.coupon_items input[name="coupon_percentage[]"]').each(function() {
			percentages.push($(this).val());
		});
		
		$('.coupon_items input[name="coupon_code[]"]').each(function() {
			coupons.push($(this).val());
		});
		
		if(coupons.length > 0) {
			for(var i in coupons) {
				var code = coupons[i];
				var percentage = percentages[i]
				
				if($.trim(code) == '' || $.trim(percentage) == '' ) {
					$.notify('Please provide coupon code and percentage', "error");
					return false;
				}
			}
		}
		
		$.ajax({
			type:'POST',
			url:base_url + 'ajax/save_user_coupons',
			dataType:'json',
			data:{
				coupons:coupons,
				percentages:percentages,
				user_id:window.user_id,
				_token: $('._token').val()
			},
			cache: false,
			success:function(data) {
				if (data.complete) {
					$.notify("Coupones updated successfully.", "success");
					window.need_reload_true = 1;
				}
			}
		});
		return false;
	});
	
	
	$(document).on('click','.assign_coupon',function(){
		window.user_id = $(this).attr('user_id');
		$('.open_user_assign_coupon_popup').click();
		return false;
	});
	
	$('.delete_group_image_btn').click(function(){
		var result = confirm("Are you sure?");
		if (result) {
			$.ajax({
				type:'POST',
				url:base_url + 'ajax/delete_product_group_image',
				dataType:'json',
				data:{
					group_id:window.product_group_id,
					image_id:$(this).attr('data-id'),
					_token: $('._token').val()
				},
				cache: false,
				success:function(data){
					if(data.complete){
						window.location.reload();
					}
				}
			});
		}
		return false;
	});
	
	$('.delete_car_image_btn').click(function(){
		var result = confirm("Are you sure?");
		if (result) {
			$.ajax({
				type:'POST',
				url:base_url + 'ajax/delete_car_image',
				dataType:'json',
				data:{
					car_id:window.car_id,
					image_id:$(this).attr('data-id'),
					_token: $('._token').val()
				},
				cache: false,
				success:function(data){
					if(data.complete){
						window.location.reload();
					}
				}
			});
		}
		return false;
	});
	
	$('.delete_tire_image_btn').click(function(){
		var result = confirm("Are you sure?");
		if (result) {
			$.ajax({
				type:'POST',
				url:base_url + 'ajax/delete_tire_image',
				dataType:'json',
				data:{
					tire_id:window.tire_id,
					image_id:$(this).attr('data-id'),
					_token: $('._token').val()
				},
				cache: false,
				success:function(data){
					if(data.complete){
						window.location.reload();
					}
				}
			});
		}
		return false;
	});
	
	$('.add_coupon_item_btn').click(function() {
		var coupon_item_block = $('.coupon_item.coupon_item_').clone().removeClass('coupon_item_').removeClass('hidden');
		$('.coupon_items').append(coupon_item_block);
		
		$('input.float_only').on('input', function() {
		  this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
		});
			
		return false;
	});
	
	$(document).on('click','.delete_coupon_item',function() {
		$(this).parents('.coupon_item').remove();
		return false;
	});
	
	
	$('.add_product_group_item_btn').click(function() {
		var product_group_item_block = $('.product_group_item.product_group_item_').clone().removeClass('product_group_item_').removeClass('hidden');
		$('.product_group_items_block').append(product_group_item_block);
		return false;
	});
	
	$(document).on('click','.delete_product_group_item',function() {
		$(this).parents('.product_group_item').remove();
		return false;
	});
	
	if($("#tree").length) {
		$("#tree").treeview({
			collapsed: true,
			animated: "fast",
			control:"#sidetreecontrol",
			prerendered: true,
			persist: "location"
		});
	}
	
    $('.edit_license').click(function(){
        $('.txtedit').hide();
        $(this).next('.txtedit').show().focus();
        $(this).hide();
    });

    // Save data
    $(".txtedit").on('focusout',function(){
        
        // Get edit id, field name and value
        var id = this.id;
        var split_id = id.split("_");
        var field_name = split_id[0];
        var edit_id = split_id[1];
        var value = $(this).val();
        
        // Hide Input element
        $(this).hide();

        // Hide and Change Text of the container with input elmeent
        $(this).prev('.edit_license').show();
        $(this).prev('.edit_license').text(value);

        // Sending AJAX request
        $.ajax({
            url:base_url + 'ajax/upgrade_user_license',
            type: 'post',
            data: { field:field_name, value:value, id:edit_id ,_token: $('._token').val()},
            success:function(response){
                alert("The licence has been updated successfuly.");  
            }
        });
    
    });

});

function encodeQueryData(data) {
   const ret = [];
   for (let d in data)
     ret.push(encodeURIComponent(d) + '=' + encodeURIComponent(data[d]));
   return ret.join('&');
}
function sendChat(id) {
	var result = confirm("Are you sure?");
	if (result) {
		$.ajax({
			type:'POST',
			url:base_url + 'ajax/send_chat_opentowork_holder',
			dataType:'json',
			data:{
				id:id,
				_token: $('._token').val()
			},
			cache: false,
			success:function(data){
				if(data.complete){
					alert("The chat has been sent successfuly.");  
					window.location.reload();
				}
			}
		});
	}
	return false;
	
}
function updateMatchmaking(id){
	var state = $('#matchmaking_'+id).prop('checked');
	var value = 0;
	if(state == true) value = 1;
	$.ajax({
		url:base_url + 'ajax/upgrade_user_matchmaking',
		type: 'post',
		data: {id:id, matchmaking:value ,_token: $('._token').val()},
		success:function(response){
			alert("The VIP feature has been updated successfuly.");  
		}
	});	
}