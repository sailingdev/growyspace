<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use Auth;
use App\Setting; 

use Illuminate\Support\Facades\URL;

class InfoController extends Controller
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
    public function about()
    {
	
		return view('info.about',[
		]);
	}
    public function contact()
    {
	
		return view('info.contact',[
		]);
	}
    public function terms()
    {
	
		return view('info.terms',[
		]);
	}
  public function privacy()
  {
	
		return view('info.privacy',[
		]);
	}
  public function oportunity_guide()
  {
	
		return view('info.oportunity_guide',[
		]);
	}
  public function opentowork_guide()
  {
	
		return view('info.opentowork_guide',[
		]);
	}
	
	/**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
    */
}