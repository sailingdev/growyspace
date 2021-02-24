<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Response;
use App\Mark; 
use App\Mark_model; 
use App\Mark_model_motorization; 
use App\Mark_model_motorization_power; 
use App\Product; 
use App\Order; 
use App\Shipping_method; 
use App\Order_product; 
use App\Category; 
use App\Product_group; 
use App\Product_group_item; 
use App\Product_group_images; 
use App\Facture_item; 
use App\Facture; 

class OrderController extends Controller
{
	
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$not_finished_orders_count = Order::where('status','!=','finished')->count();
		return view('admin/orders.index',[
			'not_finished_orders_count' => $not_finished_orders_count
		]);
	}
	
	public function view($id)
    {
		$order = Order::find($id);
		
		if (count((array)$order) == 0) {
			exit('Wrong Request');
		}
		
		$shipping_method_row = Shipping_method::find($order->shipping_id);
		$shipping_method = isset($shipping_method_row->name) ? $shipping_method_row->name : '';
		$o = new Order;
		$orders_products = $o->get_orders_products($id);
		
		foreach($orders_products as $k => $order_product) {
			$ref_items3 = $order_product->ref_items3;
			
			if(trim($ref_items3) != '') {
				$ref_items3_array = json_decode($ref_items3,true);
				
				if(is_array($ref_items3_array)) {
					foreach($ref_items3_array as $k2 =>  $ref_item_row) {
						$facture_item_id = $ref_item_row['facture_item_id'];
						$facture_item_row = Facture_item::find($facture_item_id);
						
						if(count((array)$facture_item_row) > 0) {
							$facture_id = $facture_item_row->facture_id;
							$facture_row = Facture::find($facture_id);
							
							if(count((array)$facture_row) > 0) {
								$facture_number = $facture_row->facture_number;
							}
						}
						
						$ref_items3_array[$k2]['facture_number'] = $facture_number;
						
						$orders_products[$k]->ref_items3_array = $ref_items3_array;
					}
				}
				
				
			}
		}
		
		$ref_items = Product_group_item::orderBy('name','asc')->get();
		//echo '<pre>';
		//print_r($orders_products);exit;
		return view('admin/orders.view',[
			'order' => $order,
			'shipping_method' => $shipping_method,
			'orders_products' => $orders_products,
			'ref_items' => $ref_items
		]);
	}
	
	public function download_products($file) {
		$file_path = base64_decode($file);
        return Response::download($file_path, basename($file_path))->deleteFileAfterSend(true);
	}
	
    /**
     * Validate Data
     */
    public function validation($request){
        $this->validate($request, [
			'service_name' => 'required|string',
			'service_description' => 'required|string'
		]);
    }
}