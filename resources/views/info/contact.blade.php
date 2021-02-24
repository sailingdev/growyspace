@extends('layouts.front')
@section('content')
<div class="container">
	<div class="row">
      <div class="col-md-7 mt-5" style="margin:0 auto;">
        <div class="well well-sm">
        {!! Form::open(['url' => '/contact_us/', 'method' => 'POST']) !!}
          <fieldset>
            <legend class="text-center">Contact us</legend>
    
            <!-- Name input-->         <!-- Email input-->
            <div class="form-group {{ ((count($errors->get('email_address')) > 0) ? 'has-error' : '') }}">
              <label class="col-md-3 control-label" for="name">Email:</label>
              <div class="col-md-12">
                <input  name="email_address" placeholder="Email Address" value="{{ old('email_address') !== null ? old('email_address') : '' }}" class="form-control">
              </div>
            </div>
    
   
            <div class="form-group {{ ((count($errors->get('subject')) > 0) ? 'has-error' : '') }}">
              <label class="col-md-3 control-label" for="email">Subject:</label>
              <div class="col-md-12">
                <input autocomplete="off" class="form-control" name="subject" placeholder="Subject" value="{{ old('subject') !== null ? old('subject') : '' }}" class="form-control">
              </div>
            </div>
    
            <!-- Message body -->
            <div class="form-group {{ ((count($errors->get('text_message')) > 0) ? 'has-error' : '') }}">
              <label class="col-md-3 control-label" for="message">Message:</label>
              <div class="col-md-12">
                <textarea class="form-control"  name="text_message" placeholder="Please enter your message here..." rows="5">{{ old('text_message') !== null ? old('text_message') : '' }}</textarea>
              </div>
            </div>
    
            <!-- Form actions -->
            <div class="form-group">
              <div class="col-md-12 text-right">
                <button type="submit" class="btn bgcolor-collection text-white btn-lg">Submit</button>
              </div>
            </div>
          </fieldset>
          {!! Form::close() !!}
        </div>
      </div>
	</div>
</div>
<style>
.well {
    min-height: 20px;
    padding: 19px;
    margin-bottom: 20px;
    background-color: #f5f5f5;
    border: 1px solid #e3e3e3;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
}

</style>
  @endsection