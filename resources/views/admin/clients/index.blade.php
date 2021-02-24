@extends('layouts.admin')
@section('content')
	<!-- BEGIN Breadcrumb -->

<div id="breadcrumbs">
<ul class="breadcrumb">
<li>
<i class="fa fa-home"></i>
<a href="{{ URL::to('/auto-turbo-admin/dashboard/') }}">Dashboard</a>
<span class="divider"><i class="fa fa-angle-right"></i></span>
</li>
<li class="active">Users</li>
</ul>
</div>
<!-- END Breadcrumb -->

<!-- BEGIN Main Content -->
<div class="row">
<div class="col-md-12">
<div class="box">
<div class="box-title">
<h3><i class="fa fa-table"></i> Users</h3>
<div class="box-tool">

</div>
</div>
<div class="box-content">
	
	<br/><br/>
	<div class="clearfix"></div>
	<div class="table-responsive" style="border:0">
		<table class="clients_table table table-bordered" id="clients_table">
			<thead>
				<tr>
					
					<th>ID</th>
					<th>Email</th>
					<th>Full Name</th>
					<th>Is activated</th>
					<th>Licence</th>
					<th>VIP Features</th>
					<th>Unsubscribe</th>
					<th>Status</th>
					
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($clients as $client)
					<tr>
						<td>{{ $client->id }}</td>
						<td>{{ $client->email }}</td>
						<td>{{ $client->full_name }}</td>
						<td>{{ $client->verified == 1 ? 'Yes' : 'No' }}</td>
						<!-- <td contentEditable='true' class='edit_license editMode' id='license_{{ $client->id }}'>{{$client->licence}}</td> -->
						<td> 
                            <div class='edit_license' > {{$client->licence}}</div> 
                            <input type='text' class='txtedit' value='{{$client->licence}}' style="border: 1px solid;" id='license_{{ $client->id }}' >
                        </td>
						<td> 
							<div class="form-check">
							<input class="form-check-input" type="checkbox" onclick="updateMatchmaking({{$client->id}})" data-user={{$client->id}} value="{{$client->matchmaking}}" id="matchmaking_{{$client->id}}" class="matchmaking" {{ $client->matchmaking == 1 ? 'checked' : '' }}>
								<label class="form-check-label" for="matchmaking_{{$client->id}}">
									Matchmaking
								</label>
							</div>                           
                        </td>
						<td>{{ $client->unsubscribe == 1 ? 'Yes' : 'No' }}</td>
						<td>{{ $client->is_deleted == 1 ? 'Suspended' : 'Active' }}</td>
						
						<td>
							@if($client->is_deleted == 1)
								<form action="{{ URL::to('/growyspace-admin/clients/'.$client->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
									<input type="hidden" name="_method" value="DELETE">
									<input type="hidden" name="action" value="recover">
									<input type="hidden" name="_token" value="{{  csrf_token() }}">
									<button type="submit" class="btn btn-primary btn-sm"> Recover account</button>
								</form>
							@else
								<form action="{{ URL::to('/growyspace-admin/clients/'.$client->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
									<input type="hidden" name="_method" value="DELETE">
									<input type="hidden" name="_token" value="{{  csrf_token() }}">
									<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Suspend account </button>
								</form>
							@endif
							
							<form action="{{ URL::to('/growyspace-admin/clients/'.$client->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
								<input type="hidden" name="_method" value="DELETE">
								<input type="hidden" name="action" value="delete_permanent">
								<input type="hidden" name="_token" value="{{  csrf_token() }}">
								<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Delete Permanent </button>
							</form>
							
							@if($client->verified == 0)
								<form action="{{ URL::to('/growyspace-admin/activate_client/'.$client->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
									<input type="hidden" name="_method" value="POST">
									<input type="hidden" name="_token" value="{{  csrf_token() }}">
									<button type="submit" class="btn btn-primary btn-sm">Activate User </button>
								</form>
							@endif
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
</div>
</div>
</div>
<style>

.edit_license{
    width: auto;
    height: 25px;
}
.editMode{
    border: 1px solid black !important;

}
.txtedit{
    display: none;
    width: 99%;
    height: 30px;
}

</style>
@endsection
