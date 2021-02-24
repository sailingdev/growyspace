<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Response;
use App\Page; 
use App\Setting; 


class SettingController extends Controller
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
		$settings_ = Setting::all();
		$settings = [];
		
		foreach($settings_ as $setting) {
			$settings[$setting->key] = $setting->value;
		}
		
		return view('admin/settings.index',[
			'settings' => $settings
		]);
	}
	
	
	 /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_settings(Request $request)
    {
        if(isset($request->slider_text1)) {
			$s = Setting::where('key','slider_text1');
			
			if($s->count() > 0) {
				$s_row = $s->first();
			} else {
				$s_row = new Setting;
			}
			
			$s_row->key = 'slider_text1';
			$s_row->value = $request->slider_text1;
			$s_row->save();
			
		}
		
		if(isset($request->slider_text2)) {
			$s = Setting::where('key','slider_text2');
			
			if($s->count() > 0) {
				$s_row = $s->first();
			} else {
				$s_row = new Setting;
			}
			
			$s_row->key = 'slider_text2';
			$s_row->value = $request->slider_text2;
			$s_row->save();
			
		}
		
		if(isset($request->slider_text3)) {
			$s = Setting::where('key','slider_text3');
			
			if($s->count() > 0) {
				$s_row = $s->first();
			} else {
				$s_row = new Setting;
			}
			
			$s_row->key = 'slider_text3';
			$s_row->value = $request->slider_text3;
			$s_row->save();
		}
		
		$settings_files_path = base_path() . '/public/uploads/settings';
			
		if (!is_dir($settings_files_path)) {
			mkdir($settings_files_path, 0775,true);
		}
		
		
		if($request->file('slider_image1') !== null ) {
			$ext =  $request->file('slider_image1')->getClientOriginalExtension();
			$original_name = $request->file('slider_image1')->getClientOriginalName();
			$contentType = $request->file('slider_image1')->getClientMimeType();
			$filename = 'Autoturbo-Slider-1-'.time().'.'.$ext;
			$is_ok = $request->file('slider_image1')->move(
				$settings_files_path, $filename
			);
			
			if($is_ok) {
				$s = Setting::where('key','slider_image1');
				
				if($s->count() > 0) {
					$s_row = $s->first();
				} else {
					$s_row = new Setting;
				}
				
				$s_row->key = 'slider_image1';
				$s_row->value = $filename;
				$s_row->save();
			}
			
		}
		
		if($request->file('slider_image2') !== null ) {
			$ext =  $request->file('slider_image2')->getClientOriginalExtension();
			$original_name = $request->file('slider_image2')->getClientOriginalName();
			$contentType = $request->file('slider_image2')->getClientMimeType();
			$filename = 'Autoturbo-Slider-2-'.time().'.'.$ext;
			$is_ok = $request->file('slider_image2')->move(
				$settings_files_path, $filename
			);
			
			if($is_ok) {
				$s = Setting::where('key','slider_image2');
				
				if($s->count() > 0) {
					$s_row = $s->first();
				} else {
					$s_row = new Setting;
				}
				
				$s_row->key = 'slider_image2';
				$s_row->value = $filename;
				$s_row->save();
			}
		}
		
		if($request->file('slider_image3') !== null ) {
			$ext =  $request->file('slider_image3')->getClientOriginalExtension();
			$original_name = $request->file('slider_image3')->getClientOriginalName();
			$contentType = $request->file('slider_image3')->getClientMimeType();
			$filename = 'Autoturbo-Slider-3-'.time().'.'.$ext;
			$is_ok = $request->file('slider_image3')->move(
				$settings_files_path, $filename
			);
			
			if($is_ok) {
				$s = Setting::where('key','slider_image3');
				
				if($s->count() > 0) {
					$s_row = $s->first();
				} else {
					$s_row = new Setting;
				}
				
				$s_row->key = 'slider_image3';
				$s_row->value = $filename;
				$s_row->save();
			}
		}
		
		
				
		$message = 'Settings Updated Successfully';
		return redirect()->back()->with('message',  $message);
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