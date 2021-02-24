<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;
use Validator;

class LoginController extends Controller
{
    public function __construct()
    {
       $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    public function showLoginForm()
    {
		
      return view('admin.login');
    }

    public function login(Request $request)
    {
		
        //--- Validation Section
        $rules = [
		   'user_name' => 'required',
		   'user_name' => 'required'
		];

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails()) {
			return redirect()->back()->withErrors($validator->errors());
        }
        //--- Validation Section Ends
		// Attempt to log the user in
		if (Auth::guard('admin')->attempt(['user_name' => $request->user_name, 'password' => $request->password], $request->remember)) {
			// if successful, then redirect to their intended location
			return redirect(route('admin.dashboard'));
		}

		return redirect()->back()->withErrors([ 0 => 'Credentials Does Not Match !' ]);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect(route('admin.login'));
    }
}
