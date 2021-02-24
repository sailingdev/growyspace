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
		<li class="active">Model Tree</li>
	</ul>
</div>

<div id="sidetree">
  <div class="treeheader">&nbsp;</div>
  <div id="sidetreecontrol"> <a href="?#">Collapse All</a> | <a href="?#">Expand All</a> </div>
	<ul class="treeview" id="tree">
		{!! $tree_html !!}
	</ul>
</div>


@endsection
