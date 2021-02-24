<?php
 
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Facture;

class Facture extends Model
{
    protected $table = 'factures';
	
	public function items() {
		 return $this->hasMany(Facture_item::class,'facture_id','id');
	}
	
	public function items_html($facture) {
		
		$fac_items = Facture_item::where('facture_id',$facture->id)->orderByRaw("extra_charges ASC, created_at ASC")->get();
			
		$fac_items_html = (String) view('admin.factures.fac_items_html',[
			'fac_items' => $fac_items,
			'facture' => $facture
		]);
		
		return $fac_items_html;
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
