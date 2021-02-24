<?php
 
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Product_group extends Model
{
    protected $table = 'product_groups';
	
	public function items()
    {
        return $this->hasMany(Product_group_item::class,'group_id','id');
    }
	
	public function images()
    {
        return $this->hasMany(Product_group_images::class,'group_id','id')->orderBy('rank','DESC');
    }
	
	public function main_image() {
		return $this->images()->where('is_main','=', 1);
	}
	
	public function with_items($part_of_item) {
		return $this->items()->where('name','like','%'.$part_of_item.'%');
	}
	
}
