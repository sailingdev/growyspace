<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use App\Mark; 
use App\Mark_model; 
use App\Mark_model_motorization; 
use App\Mark_model_motorization_power; 
use App\Product; 
use App\Product_group; 
use App\Product_group_item; 
use App\Product_group_images; 
//use Excel;

class Product_groupController extends Controller
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
		
		/*$p = Product::all();
		$export = [];
		
		foreach($p as $v) {
			$title = $v->title;
			$product_id = $v->id;
			$uuu = Product::where('id','!=',$product_id)->where('title',$title)->pluck('id')->toArray();
			
			$conflict_string = '';
			if(!empty($uuu) ) {
				$conflict_string = 'Product ID ='. $product_id.' Have Same Title with Product ID ='.implode(",",$uuu);
				$export[] = [
					'Product ID' => $product_id,
					'Product Title' => $title,
					'Conflict' => $conflict_string,
					
				];
			}
		}
		
		$newCollection = collect($export);
		$newCollection->storeExcel(
			'xxx/xxx.xlsx',
			$disk = null,
			$writerType = null,
			$headings = true
		);*/
		
		
		
		$export = [];
		$x = Product_group::all();
		foreach($x as $v) {
			$group_id = $v->id;
			
			$items = $v->items;
			$items_string = '';
			$conflict_string = '';
			
			foreach($items as $item) {
				
				$items_string .= $item->name."\n";
				$uuu = Product_group_item::where('group_id','!=', $group_id)->where('name','like','%'.$item->name.'%')->pluck('group_id')->toArray();
				
				if(!empty($uuu) ) {
					$conflict_string .= $item->name.' Conflict with Group ID '.implode(",",$uuu)."\n ";
				}
			
			}
						
			$export[] = [
				'Group ID' => $v->id,
				'Group Name' => $v->name,
				'Conflict' => $conflict_string,
				'Group Items' => $items_string,
			];
		}
		
		
		$newCollection = collect($export);
		$newCollection->storeExcel(
			'xxx/popok.xlsx',
			$disk = null,
			$writerType = null,
			$headings = true
		);
		
		
		return view('admin/product_groups.index',[
		 
		]);
	}
	
	 /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       

        return view('admin/product_groups.add',[
		
		]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
			'group_name' => 'required|string',
			'group_price' => 'required|string',
		]);

		if ($v->fails())
		{
			return redirect()->back()->withInput()->withErrors($v->errors());
		}
		
		$pg = new Product_group;
		$pg->name = $request->group_name;
		$pg->price = $request->group_price;
		$pg->price2 = $request->group_price2;
     	$pg->save();
		
		if(!empty($request->group_item)) {
					
			foreach($request->group_item as $item_name) {
				if(trim($item_name) !== '') {
					$pgi = new Product_group_item;
					$pgi->group_id = $pg->id;
					$pgi->name = $item_name;
					$pgi->save();
				}
			}
		}
			
        $message = 'Product Group Created Successfully';
        return redirect()->action('Admin\Product_groupController@edit',['id' => $pg->id])->with('message',$message);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->edit($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pg = Product_group::find($id);
			
		if (count((array) $pg) == 0) {
			return abort(404);
		}
      	  
		return view('admin/product_groups.edit',[ 
			'product_group_id' => $id,
			'pg' => $pg,
			'pg_items' => $pg->items,
			'pg_images' => $pg->images
		]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		$v = Validator::make($request->all(), [
			'group_name' => 'required|string',
			'group_price' => 'required|string',
		]);

		if ($v->fails())
		{
			return redirect()->back()->withErrors($v->errors());
		}
		
		$pg = Product_group::find($id);
		$pg->name = $request->group_name;
		$pg->price = $request->group_price;
		$pg->price2 = $request->group_price2;
     	$pg->save();
		
		if(!empty($request->group_item)) {
			Product_group_item::where('group_id',$id)->delete();
			
			foreach($request->group_item as $item_name) {
				if(trim($item_name) !== '') {
					$pgi = new Product_group_item;
					$pgi->group_id = $id;
					$pgi->name = $item_name;
					$pgi->save();
				}
			}
		}
		
		$message = 'Product Group Updated Successfully';
		return redirect()->back()->with('message',$message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pg = Product_group::find($id);
        $pg->delete();
		
		Product_group_item::where('group_id',$id)->delete();
		Product_group_images::where('group_id',$id)->delete();
		
        $message = 'Product Group Deleted Successfully';
        return redirect()->action('Admin\Product_groupController@index')->with('message',$message);
    }

    /**
     * Validate Data
     */
    public function validation($request){
        $this->validate($request, [
			'group_name' => 'required|string',
			'group_price' => 'required|float'
		]);
    }
}