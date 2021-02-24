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
use Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use App\Opportunity_card;
use App\User_collection_item;
use App\Opentowork_card;

class Opportunity_cardController extends Controller
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
    public function get($card_id)
    {
		$opc  = Opportunity_card::find($card_id);

		if($opc === null) {
			abort(404);
		}
		$third_person = true;
		$logged_in_user_id = 0;
		if(Auth::guard('user')->user() && Auth::guard('user')->user()->id){
			$logged_in_user_id = Auth::guard('user')->user()->id;
			if($logged_in_user_id == $opc->user_id) $third_person = false;

		}
		
		 
		
		$countries = Config::get('countries');
		$opc_fields_json = $opc->fields;
		$opc_fields = [];
		
		if (trim($opc_fields_json) != '') {
			$opc_fields = json_decode($opc_fields_json,true);
		}
		
		$meta_title = $opc->company.' '.$opc->title;
		
		//checking the card is in the collections
		$user_collections = User_collection::where('user_id',$logged_in_user_id)->get();
		
		$checked_value = [];
		foreach($user_collections as $uc) {
			$itemList = User_collection_item::where('collection_id',$uc->id)->where('opportunity_card_id',$card_id)->pluck('opportunity_card_id')->toArray();
			
			if(count($itemList) > 0){
				array_push($checked_value, $uc->id);
			}
		}
		//getting my opentowork list
		$opentoworkList = Opentowork_card::where('user_id',$logged_in_user_id)->get();
		
		//SEO
		$og_url = URL::to('/')."/cards"."/".$opc->id;
		$og_title = $opc->company.' '.$opc->title;
		$og_description = $opc->description;
		$og_image = URL::to('/')."/assets/images/external-icon-opportunity.png";

		return view('opportunity_card',[
			'countries' => $countries,
			'opc_fields' => $opc_fields,
			'meta_title' => $meta_title,
			'opc' => $opc,
			'checked_value' => $checked_value,
			'third_person'=> $third_person,
			'opc_list' => $opentoworkList,
			'user_id' => $logged_in_user_id,
			'opportunity_card_page' => true,
			'og_url'=>$og_url,
			'og_title'=>$og_title,
			'og_description'=>$og_description,
			'og_image'=>$og_image,
		]);


	}

    public function create()
    {
		if(!Auth::guard('user')->user()){
			return redirect('/');
		}
		$licence = Auth::guard('user')->user()->licence;
		$num_of_opc = Opportunity_card::where('user_id',Auth::guard('user')->user()->id)->get();
		if(count($num_of_opc) > 0 && $licence <= 1){ //free version		
			return redirect()->back()->with([ 'membership_error' => 'You can only post an opportunity. Please contact the manager !' ]);
			exit;
		}
		if(count($num_of_opc) >= $licence){ // limit
			return redirect()->back()->with([ 'membership_error' => 'You can only post '.$licence.' opportunity. Please contact the manager !' ]);
			exit;			
		}
		$countries = Config::get('countries');
		$opc_fields = Opportunity_card_field::orderBy('name','asc')->pluck('name')->toArray();
		$opc = [];
		return view('opportunity_create',[
			'countries' => $countries,
			'opc_fields' => $opc_fields,
			'opc' => $opc,
		]);
	}

    public function update($card_id)
    {
		$opc  = Opportunity_card::find($card_id);
		
		if($opc === null) {
			abort(404);
		}
		if(!Auth::guard('user')->user()){
			return redirect('/');
		}		
		$countries = Config::get('countries');
		$opc_fields_json = $opc->fields;
		$opc_fields = [];
		
		if (trim($opc_fields_json) != '') {
			$opc_fields = json_decode($opc_fields_json,true);
		}
		
		$meta_title = $opc->company.' '.$opc->title;
		$opc_fields_all = Opportunity_card_field::orderBy('name','asc')->pluck('name')->toArray();

		return view('opportunity_create',[
			'countries' => $countries,
			'opc_fields' => $opc_fields_all,
			'opc_fields_db' => $opc_fields,
			'meta_title' => $meta_title,
			'opc' => $opc,
			'id' => $card_id,
		]);
	}	
    public function referCreate($card_id)
    {
		$opc  = Opentowork_card::find($card_id);
		
		if($opc === null) {
			abort(404);
		}

		if(!Auth::guard('user')->user()){
			return redirect('/');
		}

		$countries = Config::get('countries');
		$opc_fields_json = $opc->fields;
		$opc_fields = [];
		
		if (trim($opc_fields_json) != '') {
			$opc_fields = json_decode($opc_fields_json,true);
		}
		
		$meta_title = $opc->company.' '.$opc->title;
		$opc_fields_all = Opportunity_card_field::orderBy('name','asc')->pluck('name')->toArray();
		$opc->title = '';
		$opc->description = '';
		//SEO
		$og_url = URL::to('/')."/cards"."/".$opc->id;
		$og_title = $opc->company.' '.$opc->title;
		$og_description = $opc->description;
		$og_image = URL::to('/')."/assets/images/external-icon-opportunity.png";

		return view('opportunity_create',[
			'countries' => $countries,
			'opc_fields' => $opc_fields_all,
			'opc_fields_db' => $opc_fields,
			'meta_title' => $meta_title,
			'opc' => $opc,
			'refer' => 1,
			'targetid' => $card_id,
			'og_url'=>$og_url,
			'og_title'=>$og_title,
			'og_description'=>$og_description,
			'og_image'=>$og_image,
		]);
	}	
	/**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
    */
}