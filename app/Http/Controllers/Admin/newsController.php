<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Response;
use App\News_card; 


class newsController extends Controller
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
        $news = News_card::orderBy('created_at', 'desc')->get();
		
		return view('admin/news_cards.index',[
			'news' => $news
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

        return view('admin/news_cards.add',[
            'news' => ''
		]);
    }
    public function upload(Request $request)
    {
        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;

            $request->file('upload')->move(public_path('uploads/news'), $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('uploads/news/'.$fileName); 
            $msg = 'Image uploaded successfully'; 
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
        }
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
			'editor1' => 'required|string',
		]);

		if ($v->fails())
		{
			return redirect()->back()->withInput()->withErrors($v->errors());
		}
        if($request->id){
            $product = News_card::find($request->id);
            $product->title = $request->title;
            $product->subtitle = $request->subtitle;
            $product->content = $request->editor1;
            $product->save();
            $product_id = $product->id;
                    
            $message = 'News was Updated Successfully';
            return redirect('/growyspace-admin/news')->with('message',$message);
        }else{

            $product = new News_card;
            $product->title = $request->title;
            $product->subtitle = $request->subtitle;
            $product->content = $request->editor1;
            $product->save();
            $product_id = $product->id;
            
            $message = 'News was Created Successfully';
            return redirect('/growyspace-admin/news')->with('message',$message);
        }
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
        $product = News_card::where('id',$id)->first();
        

		
		return view('admin/news_cards.add',[ 
			'news' => $product
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
			'editor1' => 'required|string',
		]);

		if ($v->fails())
		{
			return redirect()->back()->withInput()->withErrors($v->errors());
		}
        
		$product = News_card::find($id);
		$product->title = $request->title;
		$product->subtitle = $request->subtitle;
		$product->content = $request->editor1;
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
        $opc = News_card::find($id);
        $opc->delete();
		
        $message = 'News was deleted Successfully';
        return redirect('/growyspace-admin/news')->with('message',$message);
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