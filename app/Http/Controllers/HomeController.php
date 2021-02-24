<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use Auth;
use App\Setting; 
use Config;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		if(Auth::guard('user')->check()) {
			// return redirect('/user/my_account');
		}
		
		$home_page = true;
		$meta_title = "Growyspace";	
          $countries = Config::get('countries');
		

		return view('home',[
			'home_page' => $home_page,
               'meta_title' => $meta_title,
               'countries' => $countries,
			'is_home_page' => 1
		]);
	}
	
	/**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
    */
}