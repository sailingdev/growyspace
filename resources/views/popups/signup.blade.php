<div id="signup_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered justify-content-center " role="document">
            <div class="modal-content border-0 mx-3">
                <div class="modal-body p-0">
                    <div class="row justify-content-center">
                        <div class="col">
                            <div class="card">
                                <div class="card-header bg-white border-0 pb-3">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="flex-col-auto"></div>
                                        <div class="col-auto text-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span class="cross" aria-hidden="true">&times;</span> </button></div>
                                    </div>
                                </div>
                                {!! Form::open(['url' => '/user/registration', 'method' => 'POST']) !!}
                                <div class="card-block p-4">
                                    <div class="row m-0 p-0 ">	
                                        <div class="w-100 text-center">
                                            <h2>Sign up</h2>
                                        </div>
                                        <div class="w-100 mt-3 profile_pitch">
                                            <div class="mt-3 mb-3 w-100">
                                                <h3 class="font-weight-bold">Register</h3>
                                            </div>
                                            <div class="form-group form-inline p-0 m-0 mt-2 {{ ((count($errors->get('full_name')) > 0) ? 'has-error' : '') }}">
                                                <label class="col-md-3 justify-content-start p-0" for="role">Full Name:</label>
                                                <input class="form-control col-md-9 " type="text" autocomplete="no" name="full_name" placeholder="Full Name" value="{{ old('full_name') !== null ? old('full_name') : '' }}">
                                                @if(count($errors->get('full_name')) > 0)
                                                    <p class="inline_error">{{ $errors->first('full_name')}}</p>
                                                @endif
                                            </div>
                                            <div class="form-group form-inline p-0 m-0 mt-2 {{ ((count($errors->get('email')) > 0) ? 'has-error' : '') }}">
                                                <label class="col-md-3 justify-content-start p-0" for="role">Email:</label>
                                                <input class="form-control col-md-9 " type="text" autocomplete="no" name="email" class="form-control" placeholder="Email" value="{{ old('email') !== null ? old('email') : '' }}">
                                                @if(count($errors->get('email')) > 0)
                                                    <p class="inline_error">{{ $errors->first('email')}}</p>
                                                @endif
                                            </div>
                                            <div class="form-group form-inline p-0 m-0 mt-2 {{ ((count($errors->get('profession')) > 0) ? 'has-error' : '') }}">
                                                <label class="col-md-3 justify-content-start p-0" for="role">Profession:</label>
                                                <input class="form-control col-md-9 " type="text" autocomplete="no" name="profession" class="form-control" placeholder="Profession" value="{{ old('profession') !== null ? old('profession') : '' }}">
                                                @if(count($errors->get('profession')) > 0)
                                                    <p class="inline_error">{{ $errors->first('profession')}}</p>
                                                @endif
                                            </div>
                                            
                                            <div class="mt-3 mb-3 w-100">
                                                <h3 class="font-weight-bold">Looking for</h3>
                                                @if(count($errors->get('looking_for')) > 0)
                                                    <p class="inline_error" style="text-align: left;">{{ $errors->first('looking_for')}}</p>
                                                @endif
                                            </div>		
                                            <div class="form-check form-check-inline {{ ((count($errors->get('looking_for')) > 0) ? 'has-error' : '') }}">
                                                <input class="form-check-input" type="radio" name="looking_for" id="inlineRadio1" value="1">
                                                <label class="form-check-label" for="inlineRadio1">Opportunities</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="looking_for" id="inlineRadio2" value="2">
                                                <label class="form-check-label" for="inlineRadio2">Talents</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="looking_for" id="inlineRadio3" value="3">
                                                <label class="form-check-label" for="inlineRadio3">Sourcer Pro</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="looking_for" id="inlineRadio0" value="0">
                                                <label class="form-check-label" for="inlineRadio0">Both/other</label>
                                            </div>			

                                            <div class="mt-3 mb-3 w-100">
                                                <h3 class="font-weight-bold">Location</h3>
                                            </div>						
                                            <div class="form-group form-inline p-0 m-0 mt-2 {{ ((count($errors->get('country_code')) > 0) ? 'has-error' : '') }}">
                                                <label class="col-md-3 justify-content-start p-0" for="profession">Country:</label>
                                                <select class="form-control opc_country_code col-md-5 mb-2 exp_country"  name="country_code">
                                                    <option value="">Select a Country</option>
                                                        @foreach(config('yourconfig.countries') as $country_code => $coutry_name)
                                                            <option 
                                                                @if(old('country_code') !==null && old('country_code') == $country_code)
                                                                    selected
                                                                @endif
                                                            value="{{ $country_code }}">{{ $coutry_name }}</option>
                                                        @endforeach
                                                    </select>	
                                                </select>
                                                <div class="col-md-4 m-0 p-0 mb-2 has-location {{ ((count($errors->get('city')) > 0) ? 'has-error' : '') }}">
                                                    <span class="fa fa-map-marker form-control-marker"></span>
                                                    <input type="text" placeholder="city" class="opc_city form-control w-100 " name="city" placeholder="City" value="{{ old('city') !== null ? old('city') : '' }}" />
                                                </div>

                                            </div>

                                            <div class="form-group form-inline p-0 m-0 mt-2 {{ ((count($errors->get('password')) > 0) ? 'has-error' : '') }}">
                                                <label class="col-md-3 justify-content-start p-0" for="company">Password:</label>
                                                <input type="password" class="form-control col-md-9" name="password" id="sign_pass" value="">
                                                @if(count($errors->get('password')) > 0)
                                                    <p class="inline_error">{{ $errors->first('password')}}</p>
                                                @endif
                                            </div>                                           
                                            <div class="form-group form-inline p-0 m-0 mt-2">
                                                <label class="col-md-3 justify-content-start p-0" for="company">Confirm password:</label>
                                                <input type="password" class="form-control col-md-9" autocomplete="no" name="password_confirmation" id="sign_confirm_pass" value="">
                                                <p id="matching_info" class="inline_error w-100"></p>
                                                @if(count($errors->get('password_confirmation')) > 0)
                                                    p class="inline_error">{{ $errors->first('password_confirmation')}}</p>
                                                @endif
                                            </div>           
                                                                                    
                                        </div>
                                    </div>

                                    <div class="row m-0 p-0 mt-4">
                                        <div class="w-100 m-0 p-0">	
                                            <button type="submit" class="pull-right text-light" style="background: #219BC4;box-shadow: 0px 4px 4px #32275F;border-radius: 10px; x">Save</button>                        
                                        </div>
                                    </div>
			                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<style>
@media (min-width: 576px){
    .modal-dialog {
        max-width: 600px;
    }
}
</style>