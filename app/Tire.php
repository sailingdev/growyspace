<?php
 
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Tire extends Model
{
    protected $table = 'tires';
	
	public function images() {
		 return $this->hasMany(Tire_image::class,'tire_id','id')->orderBy('rank','DESC');
	}
	
	public function mark()
    {
        return $this->hasOne(Tire_mark::class,'id','tire_mark_id');
    }
	
	public function width()
    {
        return $this->hasOne(Tire_mark_width::class,'id','tire_width_id');
    }
	
	public function height()
    {
        return $this->hasOne(Tire_mark_width_height::class,'id','tire_height_id');
    }
	
	public function diameter()
    {
        return $this->hasOne(Tire_mark_width_height_diameter::class,'id','tire_diameter_id');
    }
	
	public function charge()
    {
        return $this->hasOne(Tire_mark_width_height_diameter_charge::class,'id','tire_charge_id');
    }
	
	public function speed()
    {
        return $this->hasOne(Tire_mark_width_height_diameter_charge_speed::class,'id','tire_speed_id');
    }
	
	
}
