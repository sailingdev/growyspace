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
<li class="active">Settings</li>
</ul>
</div>
<!-- END Breadcrumb -->

<!-- BEGIN Main Content -->
<div class="row">
<div class="col-md-12">
<div class="box">

<div  class="form-horizontal">
	<h1>Settings</h1>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">Prix</label>
		<div class="col-sm-9 col-lg-10 controls">
			
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">Année-modèle</label>
		<div class="col-sm-9 col-lg-10 controls">
			
		
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">Carburant</label>
		<div class="col-sm-9 col-lg-10 controls">
			
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">Boîte de vitesse</label>
		<div class="col-sm-9 col-lg-10 controls">
			
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">Kilométrage</label>
		<div class="col-sm-9 col-lg-10 controls">
			
		</div>
	</div>
	
	
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label">Titre</label>
		<div class="col-sm-9 col-lg-10 controls">
			<input type="text" placeholder="Titre" name="title" value="" class="title_filter form-control">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 col-lg-2 control-label"></label>
		<div class="col-sm-9 col-lg-10 controls">
			<button class="btn btn-primary ">Filter</button>
			<button class="btn btn-danger">Reset</button>
		</div>
	</div>
	
</div>


@endsection
