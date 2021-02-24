<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Response;
use App\Page; 


class PageController extends Controller
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
		$pages = Page::all();
       		
		return view('admin/pages.index',[
			'pages' => $pages
		]);
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
        $page = Page::find($id);
        		
		return view('admin/pages.edit',[ 
			'page' => $page
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
			'description' => 'required|string',
		]);

		if ($v->fails())
		{
			return redirect()->back()->withInput()->withErrors($v->errors());
		}
        
		$page = Page::find($id);
		$page->title = $request->title;
		
		$page->text = $request->description;
		$page->text2 = $request->description2;
		$page->save();
		$page_id = $page->id;
				
		$message = 'Page Updated Successfully';
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
        $product = Product::find($id);
        $product->delete();
		
        $message = 'Product Deleted Successfully';
        return redirect()->action('Admin\ProductController@index')->with('message',$message);
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