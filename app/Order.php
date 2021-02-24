<?php
 
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Order extends Model
{
    protected $table = 'orders';
	
	public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
	
	public function products()
    {
        return $this->hasMany(Order_product::class,'order_id','id')->orderBy('created_at','desc');
    }
	
	public function shipping_method()
    {
        return $this->hasOne(Shipping_method::class,'id','shipping_id');
    }
	
	public function get_orders_products($order_id)
    {
        $order_products = DB::table('orders')
				->join('order_products', 'orders.id', '=', 'order_products.order_id')
				->leftJoin('users', 'users.id', '=', 'orders.user_id')
				->leftJoin('products', 'products.id', '=', 'order_products.product_id')
				->leftJoin('order_product_ref_items', function($join)
				{
					$join->on('order_product_ref_items.order_id', '=', 'order_products.order_id');
					$join->on('order_product_ref_items.product_id', '=', 'order_products.product_id');
				})
				->leftJoin('product_groups', 'product_groups.id', '=', 'products.group_id')
				->leftJoin('product_group_items', 'product_group_items.name', '=', 'order_products.ref_item')
				->leftJoin('product_groups AS pg', 'pg.id', '=', 'product_group_items.group_id')
				
                ->select(
					'order_products.*', 
					'product_group_items.name AS ref',
					DB::raw("GROUP_CONCAT(DISTINCT  pg.name SEPARATOR ',') as `group_names`"),
					'users.bill_first_name',
					'users.bill_last_name',
					'product_groups.price2',
					DB::raw("GROUP_CONCAT(DISTINCT order_product_ref_items.ref_item SEPARATOR ',') as `ref_items2`"),
					DB::raw("CONCAT(\"[\" ,GROUP_CONCAT(DISTINCT CONCAT('{\"ref\":\"', order_product_ref_items.ref_item, '\", \"qty\":\"',order_product_ref_items.qty,'\", \"facture_item_id\":\"',order_product_ref_items.facture_item_id,'\"}')), \"]\") ref_items3")
				)
				
                   
				->where('orders.id', $order_id)
                ->groupBy('order_products.id')
				->get();
		return $order_products;
    }
}
