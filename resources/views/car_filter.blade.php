		<!-- About Section -->
<div class="section-full">
	<div class="container">
		<div class="row car-search-box m-lr0 p-lr15 p-b30 p-t15 bg-primary">
			<div class="col-lg-6 col-md-4 col-sm-6">
				<label>Carburant</label>
				<div class="asdad">
					<select class="car_filter_fuel form-control">
						<option value="">Sélectionnez une option</option>
						@foreach($fuels as $f_id => $f)
							<option {{ $fuel_ == $f_id ? 'selected' : '' }} value="{{ $f_id }}">{{ $f }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-lg-6 col-md-4 col-sm-6">
				<label>Boîte de vitesse</label>
				<div class="asdad">
					<select class="car_filter_gearbox form-control">
						<option value="">Sélectionnez une option</option>
						<option {{ $gearbox_ == 1 ? 'selected' : '' }} value="1">Manuelle</option>
						<option {{ $gearbox_ == 2 ? 'selected' : '' }} value="2">Automatique</option>
					</select>
				</div>
			</div>
			
			
			<div class="col-lg-3 col-md-4 col-sm-6">
				<label>Prix</label>
				<div class="fdsfsdfsf">
					<select style="width: 49%;float:left;" class="car_filter_min_price form-control">
						<option value="">Min</option>
						@for($i = $min_price; $i <= $max_price; $i = $i + 500)
							<option {{ $min_price_ == $i ? 'selected' : '' }} value="{{ $i }}">{{ $i }} €</option>
						@endfor
					</select>
					<select style="width: 49%;float:right;" class="car_filter_max_price form-control">
						<option value="">Max</option>
						@for($i = $min_price; $i <= $max_price; $i = $i + 500)
							<option {{ $max_price_ == $i ? 'selected' : '' }} value="{{ $i }}">{{ $i }} €</option>
						@endfor
					</select>
				</div>
			</div>
			
			<div class="col-lg-3 col-md-4 col-sm-6">
				<label>Année-modèle</label>
				<div class="fdsfsdfsf">
					<select style="width: 49%;float:left;" class="car_filter_min_year form-control">
						<option value="">Min</option>
						@for($i = $min_year; $i <= $max_year; $i = $i + 1)
							<option {{ $min_year_ == $i ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
						@endfor
					</select>
					<select style="width: 49%;float:right;" class="car_filter_max_year form-control">
						<option value="">Max</option>
						@for($i = $min_year; $i <= $max_year; $i = $i + 1)
							<option {{ $max_year_ == $i ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
						@endfor
					</select>
				
				</div>
			</div>
			
			<div class="col-lg-3 col-md-4 col-sm-6">
				<label>Kilométrage</label>
				<div class="fdsfsdfsf">
					<select style="width: 49%;float:left;" class="car_filter_min_mileage form-control">
						<option value="">Min</option>
						@for($i = $min_mileage; $i <= $max_mileage; $i = $i + 10000)
							<option {{ $min_mileage_ == $i ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
						@endfor
					</select>
					<select style="width: 49%;float:right;" class="car_filter_max_mileage form-control">
						<option value="">Max</option>
						@for($i = $min_mileage; $i <= $max_mileage; $i = $i + 10000)
							<option {{ $max_mileage_ == $i ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
						@endfor
					</select>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 col-sm-6">
				<label>&nbsp;</label>
				<button type="submit" class="site-button-secondry black btn-block filter_products">Rechercher</button>
			</div>
		</div>
	</div>
</div>	
<!-- About Section End -->