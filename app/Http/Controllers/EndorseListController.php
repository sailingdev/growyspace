<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use Config;
use App\Category; 
use App\User_collection; 
use App\Product; 
use App\Skill; 
use App\User;  
use App\Opportunity_card_field; 
use App\roles; 
use Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use App\Opentowork_card;
use App\Endorse_list;


class EndorseListController extends Controller
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
    public function get($opc_id)
    {

	}

   
	/**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
    */
}