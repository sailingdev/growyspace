		<!-- About Section -->
<div class="section-full">
	<div class="container">
		<form class="row car-search-box m-lr0 p-lr15 p-b30 p-t15 bg-primary">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<label>Référence</label>
				<div class="selected-box">
					<input type="text" class="filter_reference ds-input form-control" value="{{ $ref }}"  />
				</div>
			</div>
			<div class="col-lg-2 col-md-4 col-sm-6">
				<label>&nbsp;</label>
				<div class="fdsfsdfsf">
					<select class="filter_category form-control">
						<option value="">Catégorie</option>
						@foreach($categories as $category)
						<option {{ $category_id == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-lg-2 col-md-4 col-sm-6">
				<label>&nbsp;</label>
				<div class="asdad">
					<select dependence="mark" class="filter_mark dynamic_mark_model_motorization_power form-control">
						<option value="">Marque</option>
						@foreach($marks as $mark)
							<option {{ $mark_id == $mark->id ? 'selected' : '' }} value="{{ $mark->id }}" >{{ $mark->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-lg-2 col-md-4 col-sm-6">
				<label>&nbsp;</label>
				<div class="asdad">
					<select dependence="model" class="filter_model form-control dynamic_mark_model_motorization_power">
						<option value="">Modèle</option>
						
					</select>
				</div>
			</div>
			
			<div class="col-lg-2 col-md-4 col-sm-6">
				<label>&nbsp;</label>
				<div class="asdad">
					<select dependence="motorization" class="filter_motorization form-control dynamic_mark_model_motorization_power">
						<option value="">Motorisation</option>
						
					</select>
				</div>
			</div>
			<div class="col-lg-2 col-md-4 col-sm-6">
				<label>&nbsp;</label>
				<div class="sadadasdsad">
					<select dependence="power" class="filter_power form-control dynamic_mark_model_motorization_power">
						<option value="">Puissance</option>
						
					</select>
				</div>
			</div>
			<div class="col-lg-2 col-md-6 col-sm-6">
				<label>&nbsp;</label>
				<button type="submit" class="site-button-secondry black btn-block filter_products">Rechercher</button>
			</div>
		</form>
	</div>
</div>	
<!-- About Section End -->