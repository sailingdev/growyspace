<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Response;
use App\Page; 
use App\Category; 
use App\Facture; 
use App\Facture_item; 
use App\Product_group_item; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class FactureController extends Controller
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
		$factures = Facture::orderBy('created_at','desc')->get();
		$ref_items = Product_group_item::orderBy('name','asc')->get();
       	$categories = Category::all();
		
		$month_names = [
			1 => 'Janvier',
			2 => 'Février',
			3 => 'Mars',
			4 => 'Avril',
			5 => 'Mai',
			6 => 'Juin',
			7 => 'Juillet',
			8 => 'Août',
			9 => 'Septembre',
			10 => 'Octobre',
			11 => 'Novembre',
			12 => 'Décembre'
		];
		
		$filter_providers = Facture::select('provider')->groupBy('provider')->pluck('provider')->toArray(); ;
		$filter_references = Facture_item::select('reference')->groupBy('reference')->pluck('reference')->toArray(); ;
		
		$factures_months = Facture::select(DB::raw("YEAR(date) year"),DB::raw("MONTH(date) month"))->orderBy('created_at')->groupBy(DB::raw('YEAR(date)'),DB::raw('MONTH(date)'))->get()->toArray();
		
		$category_url = URL::to('/').'/auto-turbo-admin/factures';
		
		$filter_ref_item = isset($_GET['ref_item']) ? $_GET['ref_item'] : false;
		$filter_provider = isset($_GET['provider']) ? $_GET['provider'] : false;
		$filter_month = isset($_GET['month']) ? $_GET['month'] : false;
		
		$sub_query = '1=1';
		
		if ($filter_ref_item !== false) {
			$sub_query .= " AND facture_items.reference = '$filter_ref_item'";
		}
		
		if ($filter_provider !== false) {
			$sub_query .= " AND factures.provider LIKE '%$filter_provider%'";
		}
		
		if ($filter_month !== false) {
			$sub_query .= " AND factures.date LIKE '%$filter_month%'";
		}
		
		$show_filter_result = false;
		
		if($filter_ref_item !== false || $filter_provider !== false || $filter_month !== false) {
			$show_filter_result = true;
		}
		
		$filtered_factures = [];
		$filter_tital_price = 0.00;
		$filter_total_TTC_price = 0.00;
		
		if($show_filter_result) {
			$filtered_factures = DB::table('factures')
				->leftJoin('facture_items', 'facture_items.facture_id', '=', 'factures.id')			
				->leftJoin('categories', 'facture_items.category_id', '=', 'categories.id')			
				->whereRaw($sub_query)
				->select(
					'facture_items.*',
					'categories.name as category_name',
					'factures.TVA',
					'factures.provider',
					'factures.date',
					'factures.facture_number'
				)
				->groupBy('facture_items.id')
				->get();
				
				foreach($filtered_factures as $ff){
					$filter_tital_price += $ff->total_price;
					$filter_total_TTC_price += $ff->total_TTC_price;
				}
		}
		
		$meta_title = 'Trouver mon turbo';
		
		return view('admin/factures.index',[
			'meta_title' => $meta_title,
			'ref_items' => $ref_items,
			'categories' => $categories,
			'factures' => $factures,
			'month_names' => $month_names,
			'factures_months' => $factures_months,
			'category_url' => $category_url,
			'filter_ref_item' => $filter_ref_item,
			'filter_provider' => $filter_provider,
			'filter_month' => $filter_month,
			'filtered_factures' => $filtered_factures,
			'show_filter_result' => $show_filter_result,
			'filter_tital_price' => $filter_tital_price,
			'filter_total_TTC_price' => $filter_total_TTC_price,
			'filter_providers' => $filter_providers,
			'filter_references' => $filter_references
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
			'provider' => 'required|string',
			'facture_number' => 'required|string',
			'date' => 'required|string',
			'extra_charges' => 'required|numeric'
		]);

		if ($v->fails())
		{
			return redirect()->back()->withInput()->withErrors($v->errors());
		}
        
		$facture = new Facture;
		$facture->provider = $request->provider;
		$facture->facture_number = $request->facture_number;
		$facture->date = date("Y-m-d", strtotime($request->date));
		$facture->TVA = isset($request->TVA) ? 1 : 0;
		$facture->save();
		$facture_id = $facture->id;
		
		$fi = new Facture_item;
		$fi->facture_id = $facture_id;
		$fi->quantity = 1;
		$fi->unit_price = $request->extra_charges;
		$fi->category_id = 0;
		$fi->reference = 'Frais d\'expédition';
		$fi->extra_charges = 1;
		$fi->save();		
        $message = 'Facture Created Successfully';
        return redirect()->action('Admin\FactureController@index', ['id' => $facture_id])->with('message',  $message);
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