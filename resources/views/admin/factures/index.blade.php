@extends('layouts.admin')
@section('content')
<!-- BEGIN Breadcrumb -->
<div id="breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="fa fa-home"></i>
			<a href="{{ URL::to('/auto-turbo-admin/dashboard/') }}">Home</a>
			<span class="divider"><i class="fa fa-angle-right"></i></span>
		</li>
		<li class="active">Factures</li>
	</ul>
</div>
<script>window.category_url='{{ $category_url }}';</script>
<!-- END Breadcrumb -->
<!-- END Breadcrumb -->
<div class="box-content" style="width:30%;float:left;">
	<button class="btn btn-primary create_facture_btn {{ count($errors)  > 0 ? 'hidden' : '' }}">Create Facture</button>
	<button class="btn btn-primary filter_facture_btn">Filter</button>
	
	<div class="{{ trim($filter_provider) != '' || trim($filter_ref_item) != '' || trim($filter_month) != '' ? '' :'hidden' }} facture_filter_fields_block form-horizontal">
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Fournisseur</label>
			<div class="col-sm-9 col-lg-10 controls">
				
				<select class="form-control filter_provider">
					<option value="">Select a Provider</option>
					@foreach($filter_providers as $pr)
					<option {{ $filter_provider == $pr ? 'selected' : '' }} value="{{ $pr }}">{{ $pr }}</option>
					@endforeach
				</select>
			
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Référence</label>
			<div class="col-sm-9 col-lg-10 controls">
				<select style="background:#fff;border:1px solid #ccc" class="chosen form-control" name="filter_ref_item_dropdown">
					<option value="">Sélectionnez un référent</option>
					@foreach($filter_references as $ref_item)
						<option {{ $filter_ref_item == $ref_item ? 'selected' : '' }} value="{{ $ref_item }}">{{ $ref_item }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Mois</label>
			<div class="col-sm-9 col-lg-10 controls">
				<select class="form-control" name="facture_month">
					<option value="">Mois</option>
					@foreach($factures_months as $m)
						<option {{ $filter_month ==  $m['year'].'-'.($m['month'] < 10 ? '0'.$m['month'] : $m['month']) ? 'selected' : '' }} value="{{ $m['year'].'-'.($m['month'] < 10 ? '0'.$m['month'] : $m['month']) }}">{{ $m['year'].' '.$month_names[$m['month']] }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label"></label>
			<div class="col-sm-9 col-lg-10 controls">
				<button class="btn btn-primary factures_filter">Filter Factures</button>
				<a class="btn btn-danger" href="{{ $category_url }}">Quit Filter</a>
			</div>
		</div>
	</div>
		
	<div style="margin-top:10px;" class="create_facture_fields_block {{ count($errors)  > 0 ? '' : 'hidden' }}">
	{!! Form::open(['url' => '/auto-turbo-admin/factures/' , 'method' => 'POST', 'route' => ['factures.store']]) !!}
	<div style="max-width:500px;border:1px dotted black;padding:20px;"  class="form-horizontal">
		<h3 style="text-align:center;">Ajouter un facteur</h3>
		
		
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Fournisseur</label>
			<div class="col-sm-9 col-lg-10 controls">
				<input type="text" placeholder="Fournisseur" name="provider" value="{{ old('provider') !== null ? old('provider') : '' }}" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">N de facture</label>
			<div class="col-sm-9 col-lg-10 controls">
				<input type="text" placeholder="N de facture" name="facture_number" value="{{ old('facture_number') !== null ? old('facture_number') : '' }}" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Date</label>
			<div class="col-sm-9 col-lg-10 controls">
				<input type="text" placeholder="Date" name="date" value="{{ old('date') !== null ? old('date') : '' }}" class="facture_date form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">T.V.A.</label>
			<div class="col-sm-9 col-lg-10 controls">
				<input type="checkbox" name="TVA" value="1"> T.V.A.
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label">Frais d'expédition</label>
			<div class="col-sm-9 col-lg-10 controls">
				<input type="text" class="form-control" name="extra_charges" value="0"> 
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-lg-2 control-label"></label>
			<div class="col-sm-9 col-lg-10 controls">
				<button class="btn btn-primary">Add Facture</button>
				<button class="btn btn-danger cancel_add_facture">Cancel</button>
			</div>
		</div>
	</div>
	{!! Form::close() !!}
	</div>
</div>

@if($show_filter_result)
<div style="margin-top:15px;width:30%;float:right;margin-top:100px;" class="row">
	<div class="col-md-12">
		<div class="box box-green">
			<div class="box-title">
				<h3><i class="fa fa-table"></i>Filtered Result Totals</h3>
				
			</div>
			<div class="box-content">
				<table class="table" id="facture_filter_table">
					<thead>
						<tr>
							<th>Total (HT)</th>
							<th>T.V.A.</th>
							<th>TOTAL T.T.C.</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{{ number_format((float)$filter_tital_price, 2, '.', '') }} €</td>
							<td>{{ number_format((float)$filter_total_TTC_price - $filter_tital_price, 2, '.', '') }} €</td>
							<td>{{ number_format((float)$filter_total_TTC_price, 2, '.', '') }} €</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>	
<div style="margin-top:15px;" class="row">
	<div class="col-md-12">
		<div class="box box-green">
			<div class="box-title">
				<h3><i class="fa fa-table"></i>Filtered Result</h3>
				
			</div>
			<div class="box-content">
				<table class="table" id="facture_filter_table">
					<thead>
						<tr>
							
							<th style="width:5%">N</th>
							<th style="width:10%">Catégorie</th>
							<th style="width:10%">Référence</th>
							<th style="width:10%;">Quantité</th>
							<th style="width:15%;">Prix unitaire (HT)</th>
							<th style="width:10%;">Total (HT)</th>
							<th style="width:5%">T.V.A.</th>
							<th style="width:10%;">TOTAL T.T.C.</th>
							<th>Fournisseur</th>
							<th>N de facture</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>
						@if(count($filtered_factures) > 0)
							@foreach($filtered_factures as $ff)
							<tr>
								<th>{{ $ff->id }}</th>
								<th>{{ $ff->category_name }}</th>
								<th>{{ $ff->reference }}</th>
								<th>{{ $ff->quantity }}</th>
								<th>{{ $ff->unit_price }} €</th>
								<th>{{ $ff->total_price }} €</th>
								<th>{{ $ff->TVA == 1 ? 'V' : '-' }}</th>
								<th>{{ $ff->total_TTC_price }}  €</th>
								<th>{{ $ff->provider }}</th>
								<th>{{ $ff->facture_number }}</th>
								<th>{{ $ff->date }}</th>
								
							</tr>
							@endforeach
						@else
							<tr>
								<th style="text-align:center;" colspan="11"><h1>No facture items found</h1></th>
								
							</tr>
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@endif
@if($show_filter_result == false)
<div style="height:30px"></div>
@foreach($factures as $facture)
<div style="margin-top:15px;" class="row">
	<div class="col-md-12">
		<div class="box fac_block">
			<div style="position:relative;padding:7px;" class="box-title">

				<h3 style="font-size:15px;">
					{{ $facture->provider }} {{ $facture->facteur_id }} {{ $facture->date }} {{ $facture->TVA == 1 ? 'V' : '-' }} 
					<span style="" class="fac_row_items_block">
						<span style="margin-left:28px;" class="fac_row_items_total_price">Total (HT): <span>{{ $facture->total_price }}</span> €</span>
						<span style="margin-left:28px;" class="fac_row_items_total_TVA_price">T.V.A.: <span>{{ $facture->total_TVA_price }}</span> €</span>
						<span style="margin-left:28px;" class="fac_row_items_total_TTC_price">TOTAL T.T.C.: <span>{{ $facture->total_TTC_price }}</span> €</span>
					</span>  
				</h3>
				<div class="box-tool">
					<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
				</div>
			</div>
			<div style="min-height:150px;" class="box-content fac_items_block">
				<div class="fac_item_table_block">
				{!! $facture->items_html($facture) !!}
				
				</div>
				<button class="btn btn-primary add_facture_item_btn">Add Ref Item</button>
				<button data-json="{{ json_encode($facture) }}" class="btn btn-success edit_facture_btn">Edit Facture</button>
				<div facture_id = "{{ $facture->id }}" class="form-horizontal add_facture_item_block_block">
					
				</div>
				<div style="margin-top:10px;" facture_id = "{{ $facture->id }}" class="form-horizontal edit_facture_block_block">
					
				</div>
			</div>
		</div>
	</div>
</div>
@endforeach

@endif

<div class="add_facture_item_block add_facture_item_block_ hidden" style="margin:10px 0;overflow:hidden;width:500px;border:1px dotted black;padding:10px;">
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">Référence</label>
		<div class="col-sm-9 col-lg-10 controls">
			<select style="background:#fff;border:1px solid #ccc" class="form-control" name="ref_item_dropdown">
				<option value="">Sélectionnez un référent</option>
				@foreach($ref_items as $ref_item)
					<option value="{{ $ref_item->name }}">{{ $ref_item->name }}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">Catégorie</label>
		<div class="col-sm-9 col-lg-10 controls">
			<select class="form-control" name="facture_category">
				<option value="">Choisissez une catégorie</option>
				@foreach($categories as $cat)
					<option value="{{ $cat->id }}">{{ $cat->name }}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">Quantité</label>
		<div class="col-sm-9 col-lg-10 controls">
			<input type="text" name="quantity" class="form-control" value=""> 
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">Prix unitaire (HT)</label>
		<div class="col-sm-9 col-lg-10 controls">
			<input type="text" name="price"class="form-control"  value=""> 
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label"></label>
		<div class="col-sm-9 col-lg-10 controls">
			<button class="btn btn-primary add_facture_item">Add Facture Item</button>
			<button class="btn btn-danger cancel_add_facture_item">Cancel</button>
			<input type="hidden" class="edit_mode" value="0" />
			<input type="hidden" class="extra_charges" value="0" />
		</div>
	</div>
</div>
<div style="max-width:500px;border:1px dotted black;padding:20px;"  class="edit_facture_block edit_facture_block_ hidden form-horizontal">
	<h3 style="text-align:center;">Edit facteur</h3>
	
	
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">Fournisseur</label>
		<div class="col-sm-9 col-lg-10 controls">
			<input type="text" placeholder="Fournisseur" name="provider" value="" class="form-control">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">N de facture</label>
		<div class="col-sm-9 col-lg-10 controls">
			<input type="text" placeholder="N de facture" name="facture_number" value="" class="form-control">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">Date</label>
		<div class="col-sm-9 col-lg-10 controls">
			<input type="text" placeholder="Date" name="date" value="" class="facture_date form-control">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">T.V.A.</label>
		<div class="col-sm-9 col-lg-10 controls">
			<input type="checkbox" name="TVA" value="1"> T.V.A.
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label"></label>
		<div class="col-sm-9 col-lg-10 controls">
			<button class="btn btn-primary update_facture">Update Facture</button>
			<button class="btn btn-danger cancel_edit_facture">Cancel</button>
		</div>
	</div>
</div>

@endsection
