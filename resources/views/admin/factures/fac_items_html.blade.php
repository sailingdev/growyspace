
<table class="table">
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
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach($fac_items as $item)
		<tr>
			<th>{{ $item->id }}</th>
			<th>{{ isset($item->category) && isset($item->category->name) ? $item->category->name : '' }}</th>
			<th>{{ $item->reference }}</th>
			<th>{{ $item->quantity }}</th>
			<th>{{ $item->unit_price }} €</th>
			<th>{{ $item->total_price }} €</th>
			<th>{{ $facture->TVA == 1 ? 'V' : '-' }}</th>
			<th>{{ $item->total_TTC_price }} €</th>
			<th>{{ $facture->provider }}</th>
			<th>{{ $facture->facture_number }}</th>
			<th>{{ $facture->date }}</th>
			<th>
				<button data-json="{{ json_encode($item) }}" data-id="{{ $item->id }}" data-facture-id="{{ $facture->id }}" class="btn btn-primary edit_fac_item">Edit</button>
				<button data-id="{{ $item->id }}" data-facture-id="{{ $facture->id }}" class="btn btn-danger delete_fac_item">Delete</button>
				
				
			</th>
		</tr>
		@endforeach
		
	</tbody>
</table>