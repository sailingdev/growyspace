<?php
 
namespace App;
use Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Opentowork_card extends Model
{
    protected $table = 'opentowork_cards';
	
	public function owner() {
		return $this->belongsTo(User::class,'user_id','id');
	}
	
	public function country() {
		$country_code = $this->country_code;
		$countries = Config::get('countries');
		
		return isset($countries[$country_code]) ? $countries[$country_code] : '';
		
	}
}
