<?php
 
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Cart extends Model
{
    protected $table = 'carts';
	
	public function products()
    {
        return $this->hasMany(Cart_product::class,'cart_id','id')->orderBy('created_at','desc');
    }
	
	public function get_cart_products($token)
    {
        $cart_products = DB::table('carts')
				->join('cart_products', 'carts.id', '=', 'cart_products.cart_id')
				->leftJoin('products', 'products.id', '=', 'cart_products.product_id')
				->leftJoin('cart_product_ref_items', function($join)
				{
					$join->on('cart_product_ref_items.cart_id', '=', 'cart_products.cart_id');
					$join->on('cart_product_ref_items.product_id', '=', 'cart_products.product_id');
				})
				->leftJoin('product_groups', 'product_groups.id', '=', 'products.group_id')
				->leftJoin('product_group_items', 'product_group_items.group_id', '=', 'product_groups.id')
                ->select(
					'cart_products.*', 
					'product_group_items.name AS ref',
					'product_groups.price2',
					DB::raw("GROUP_CONCAT(DISTINCT  cart_product_ref_items.ref_item SEPARATOR ',') as `ref_items2`")
				)
                   
				->where('carts.token', $token)
                ->groupBy('cart_products.id')
				->get();
		return $cart_products;
    }
}
