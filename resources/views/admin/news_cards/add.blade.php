@extends('layouts.admin')
@section('content')
<script src="../../../admin/ckeditor/ckeditor.js"></script>
<h1 style="width: 1203px;margin: 0 auto;padding-bottom: 20px; padding-top: 25px;">{{ isset($news) && $news !=''   ? 'Update' : 'Post' }} the news</h1>
<div style="width:1170px; margin:0 auto;">

	{!! Form::open(['url' => '/growyspace-admin/news', 'method' => 'POST']) !!}
	
	<div class="row form-group form-inline p-0 m-0 mt-2">
		<input type="hidden" name="id" value="{{ isset($news) && $news !=''   ? $news->id : 0 }}">
		<label for="title">Title:</label>
		<input type="text" placeholder="type the title" class="form-control" id="title" name="title" value="{{ isset($news) && $news !=''   ? $news->title : '' }}" style="width:100%;margin-bottom:20px;">
		<label for="subtitle">Sub title:</label>
		<input type="text" placeholder="type the subtitle" class="form-control" id="subtitle" name="subtitle" value="{{ isset($news) && $news !=''  ? $news->subtitle : '' }}" style="width:100%;">
	</div>
	<div class="row">
		<textarea name="editor1" >{{ isset($news) && $news !=''  ? $news->content : '' }}</textarea>
	</div>
	<div class="row pull-right">
		<button type="submit"  id="saveNews" style="margin-top:10px;" class="btn btn-success"> Save</button>
	</div>
	{!! Form::close() !!}
</div>

<br>


<script type="text/javascript">
    CKEDITOR.replace('editor1', {
        filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
		filebrowserUploadMethod: 'form',
		
    });
</script>
@endsection
