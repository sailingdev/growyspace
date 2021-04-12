<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\User_collection; 
use App\User_collection_item; 
use App\Opportunity_card; 
use App\Opentowork_card; 
use App\User; 
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Auth;
use Config;
use Helpers;


class CollectionController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
		if(!Auth::guard('user')->check()) {
			return redirect('user/login');
		}
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		if(!Auth::guard('user')->check()) {
			return redirect('/');
		}
		$user_id = Auth::guard('user')->user()->id;
		$collections = User_collection::where('user_id',$user_id)->get();
		$countries = Config::get('countries');
		// if(count($collections) == 0){
		// 	$initial = ["Users", "Opportunities", "Professional cards"];		
			
		// 	foreach($initial as $key){
		// 		$Newcollection = new User_collection;
		// 		$Newcollection->name = $key;
		// 		$Newcollection->user_id = $user_id;
		// 		$Newcollection->save();
		// 	}
		// 	$collections = User_collection::where('user_id',$user_id)->get();
						
		// }
		$userLists = User::where('id',$user_id)->first();

		
		return view('collections.index',[
			'countries' => $countries,
			'collections' => $collections,
			'user_id' => $user_id,
			'username' => $userLists->full_name
		]);
	}
    public function create()
    {
		if(!Auth::guard('user')->check()) {
			return redirect('/');
		}


		return view('collections.create',[
			'opc' => [],
		]);
	}
    public function update($id)
    {
		if(!Auth::guard('user')->check()) {
			return redirect('/');
		}
		$user_id = Auth::guard('user')->user()->id;

		$collections = User_collection::where('id',$id)->where('user_id',$user_id)->first();

		$third_person = true;
		if(Auth::guard('user')->user() && Auth::guard('user')->user()->id){
			$logged_in_user_id = Auth::guard('user')->user()->id;
			if($logged_in_user_id == $collections->user_id) $third_person = false;
		}

		return view('collections.create',[
			'opc' => $collections,
			'id' => $id,
			'third_person'=> $third_person,
		]);
	}
    public function get($id)
    {

		
		$collection = User_collection::where('id',$id)->first();
		if($collection === null) {
			abort(404);
		}
		$third_person = true;
		$user_id = 0;
		if(Auth::guard('user')->user() && Auth::guard('user')->user()->id){
			$user_id = Auth::guard('user')->user()->id;
			if($user_id == $collection->user_id) $third_person = false;
		}

		$countries = Config::get('countries');
		$user = User::where('id',$user_id)->first();

		$collection_id = $id;
		$collection_item_user_ids = User_collection_item::where('collection_id',$collection_id)->whereNotNull('user_id')->pluck('user_id')->toArray();
		$collection_item_opc_ids = User_collection_item::where('collection_id',$collection_id)->whereNotNull('opportunity_card_id')->pluck('opportunity_card_id')->toArray();
		$collection_item_opentowork_ids = User_collection_item::where('collection_id',$collection_id)->whereNotNull('opentowork_card_id')->pluck('opentowork_card_id')->toArray();
		
		$users = User::whereIn('id',$collection_item_user_ids)->get();
		$opportunity_cards = Opportunity_card::whereIn('id',$collection_item_opc_ids)->get();

		$opentowork_cards = Opentowork_card::whereIn('id',$collection_item_opentowork_ids)->get();
		
		$items_count = $users->count() + $opportunity_cards->count();
		$opportunityList = Opportunity_card::where('user_id',$user_id)->get();
		$opentoworkList = Opentowork_card::where('user_id',$user_id)->get();

		return view('collections.get',[
			'collection' => $collection,
			'user' => $user,
			'countries' => $countries,				
			'user_id' => $user_id,			
			'collection_id' => $collection_id,			
			'users' => $users,	
			'collection_name' => $collection->name,				
			'opportunity_cards' => $opportunity_cards,
			'opentowork_cards' => $opentowork_cards,
			'third_person' => $third_person,
			'opc_list' => $opportunityList,
			'opt_list' => $opentoworkList,
		]);
	}	
	
}