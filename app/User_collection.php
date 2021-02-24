<?php
 
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User_collection extends Model
{
    protected $table = 'user_collections';
	
	public function items()
    {
        return $this->hasMany(User_collection_item::class,'collection_id','id');
    }
	
	public function items_count() {
		$collection_id = $this->id;
		$collection_item_user_ids = User_collection_item::where('collection_id',$collection_id)->whereNotNull('user_id')->pluck('user_id')->toArray();;
		$collection_item_opc_ids = User_collection_item::where('collection_id',$collection_id)->whereNotNull('opportunity_card_id')->pluck('opportunity_card_id')->toArray();
		
		$users_count = User::whereIn('id',$collection_item_user_ids)->count();
		$opportunity_cards_count = Opportunity_card::whereIn('id',$collection_item_opc_ids)->count();
				
		return $users_count + $opportunity_cards_count;
	}
	
	public function items_with_user($user_id)
    {	
		$collection_id = $this->id;
        return User_collection_item::where('collection_id',$collection_id)->where('user_id','=', $user_id)->first();
    }
	
	public function items_with_opc($opc_id)
    {	
		$collection_id = $this->id;
        return User_collection_item::where('collection_id',$collection_id)->where('opportunity_card_id','=', $opc_id)->first();
    }
	
}
