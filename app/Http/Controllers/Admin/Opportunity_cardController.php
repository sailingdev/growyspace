<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Response;
use App\Opportunity_card; 


class Opportunity_cardController extends Controller
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
		return view('admin/opportunity_cards.index',[
			
		]);
	}
	
	public function download_products($file) {
		$file_path = base64_decode($file);
        return Response::download($file_path, basename($file_path))->deleteFileAfterSend(true);
	}
	 /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $prod_groups = Product_group::all();
        $categories = Category::all();
        $marks = Mark::orderBy('name','asc')->get();

        return view('admin/products.add',[
			'prod_groups' => $prod_groups,
			'categories' => $categories,
			'marks' => $marks
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
			'title' => 'required|string',
			'title2' => 'required|string',
			'category' => 'required|string',
			'group' => 'required|string',
			'mark' => 'required|string',
			'model' => 'required|string',
			'motorization' => 'required|string',
			'power' => 'required|string',
			'description' => 'required|string',
		]);

		if ($v->fails())
		{
			return redirect()->back()->withInput()->withErrors($v->errors());
		}
        
		$product = new Product;
		$product->title = $request->title;
		$product->title2 = $request->title2;
		$product->description = $request->description;
		$product->category_id = $request->category;
		$product->group_id = $request->group;
		$product->mark_id = $request->mark;
		$product->model_id = $request->model;
		$product->motorization_id = $request->motorization;
		$product->power_id = $request->power;
		$product->save();
		$product_id = $product->id;
		
        $message = 'Product Created Successfully';
        return redirect()->action('Admin\ProductController@edit', ['id' => $product_id])->with('message',  $message);
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
        $prod_groups = Product_group::all();
        $categories = Category::all();
        $marks = Mark::orderBy('name','asc')->get();
        $product = Product::find($id);
        

		
		return view('admin/products.edit',[ 
			'prod_groups' => $prod_groups,
			'categories' => $categories,
			'marks' => $marks,
			'product' => $product
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
			'title' => 'required|string',
			'title2' => 'required|string',
			'category' => 'required|string',
			'group' => 'required|string',
			'mark' => 'required|string',
			'model' => 'required|string',
			'motorization' => 'required|string',
			'power' => 'required|string',
			'description' => 'required|string',
		]);

		if ($v->fails())
		{
			return redirect()->back()->withInput()->withErrors($v->errors());
		}
        
		$product = Product::find($id);
		$product->title = $request->title;
		$product->title2 = $request->title2;
		$product->description = $request->description;
		$product->category_id = $request->category;
		$product->group_id = $request->group;
		$product->mark_id = $request->mark;
		$product->model_id = $request->model;
		$product->motorization_id = $request->motorization;
		$product->power_id = $request->power;
		$product->save();
		$product_id = $product->id;
				
		$message = 'Service Updated Successfully';
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
        $opc = Opportunity_card::find($id);
        $opc->delete();
		
        $message = 'Card Deleted Successfully';
        return redirect()->action('Admin\Opportunity_cardController@index')->with('message',$message);
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