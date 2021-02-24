<?php
 
namespace App;
use Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Endorse_list extends Model
{
    protected $table = 'endorse_lists';
	
	public function owner() {
		return $this->belongsTo(Opentowork_card::class,'user_id','received_user_id');
	}

}
