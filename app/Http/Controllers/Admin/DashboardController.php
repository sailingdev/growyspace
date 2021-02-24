<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;
use Validator;

class DashboardController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth:admin');
    }

    public function index()
    {
      return view('admin.dashboard');
    }
	
	
}
