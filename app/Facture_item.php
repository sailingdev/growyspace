<?php
 
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Facture_item extends Model
{
    protected $table = 'facture_items';
	
	public function category()
    {
        return $this->hasOne(Category::class,'id','category_id');
    }
	/*public function mark()
    {
        return $this->hasOne(Mark::class,'id','mark_id');
    }
	
	public function model()
    {
        return $this->hasOne(Mark_model::class,'id','model_id');
    }
	
	public function motorization()
    {
        return $this->hasOne(Mark_model_motorization::class,'id','motorization_id');
    }
	
	public function power()
    {
        return $this->hasOne(Mark_model_motorization_power::class,'id','power_id');
    }
		
	public function images() {
		 return $this->hasMany(Car_image::class,'car_id','id')->orderBy('rank','DESC');
	}*/
}
