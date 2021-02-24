<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Response;
use App\Mark; 
use Config;
use App\Mark_model; 
use App\Mark_model_motorization; 
use App\Mark_model_motorization_power; 
use App\Product; 
use App\Category; 
use App\Product_group; 
use App\Product_group_item; 
use App\Product_group_images;

use App\Tire;
use App\Tire_image;
use App\Tire_mark;
use App\Tire_mark_width;
use App\Tire_mark_width_height;
use App\Tire_mark_width_height_diameter;
use App\Tire_mark_width_height_diameter_charge;
use App\Tire_mark_width_height_diameter_charge_speed;


class TireController extends Controller
{
	public $tire_types = [
		1 => 'Tous',
		2 => 'Voiture / Tourisme',
		3 => '4x4 / SUV',
		4 => 'Camionnette / Utilitaire',
		5 => 'Compétition',
		6 => 'Collection',
		7 => 'Remorque bagagère'
	];
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
		$tires_marks  = [];
		$tires_marks_ = Tire_mark::all();
		
		foreach($tires_marks_ as $tm) {
			$group_name = $tm->group_name($tm->tire_mark_group_id);
			$tires_marks[$group_name][] = [
				'id'   => $tm->id,
				'name' => $tm->name
			];
		}
		
		$tire_mark_widths = [];
		$tire_mark_widths_ = Tire_mark_width::all();
		
		foreach($tire_mark_widths_ as $tmw) {
			$group_name = $tmw->group_name($tmw->tire_mark_width_group_id);
			$tire_mark_widths[$group_name][] = [
				'id'   => $tmw->id,
				'name' => $tmw->name
			];
		}
		
		$tire_mark_width_heights = Tire_mark_width_height::all();
		$tire_mark_width_height_diameters = Tire_mark_width_height_diameter::all();
		$tire_mark_width_height_diameter_charges = Tire_mark_width_height_diameter_charge::all();
		$tire_mark_width_height_diameter_charge_speedes = Tire_mark_width_height_diameter_charge_speed::all();
		
		return view('admin/tires.index',[
			'tire_types' => $this->tire_types,
			'tires_marks' => $tires_marks,
			'tire_mark_widths' => $tire_mark_widths,
			'tire_mark_width_heights' => $tire_mark_width_heights,
			'tire_mark_width_height_diameters' => $tire_mark_width_height_diameters,
			'tire_mark_width_height_diameter_charges' => $tire_mark_width_height_diameter_charges,
			'tire_mark_width_height_diameter_charge_speedes' => $tire_mark_width_height_diameter_charge_speedes
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
		$tires_marks  = [];
		$tires_marks_ = Tire_mark::all();
		
		foreach($tires_marks_ as $tm) {
			$group_name = $tm->group_name($tm->tire_mark_group_id);
			$tires_marks[$group_name][] = [
				'id'   => $tm->id,
				'name' => $tm->name
			];
		}
		
		$tire_mark_widths = [];
		$tire_mark_widths_ = Tire_mark_width::all();
		
		foreach($tire_mark_widths_ as $tmw) {
			$group_name = $tmw->group_name($tmw->tire_mark_width_group_id);
			$tire_mark_widths[$group_name][] = [
				'id'   => $tmw->id,
				'name' => $tmw->name
			];
		}
		
		$tire_mark_width_heights = Tire_mark_width_height::all();
		$tire_mark_width_height_diameters = Tire_mark_width_height_diameter::all();
		$tire_mark_width_height_diameter_charges = Tire_mark_width_height_diameter_charge::all();
		$tire_mark_width_height_diameter_charge_speedes = Tire_mark_width_height_diameter_charge_speed::all();
		
        return view('admin/tires.add',[
			'tire_types' => $this->tire_types,
			'tires_marks' => $tires_marks,
			'tire_mark_widths' => $tire_mark_widths,
			'tire_mark_width_heights' => $tire_mark_width_heights,
			'tire_mark_width_height_diameters' => $tire_mark_width_height_diameters,
			'tire_mark_width_height_diameter_charges' => $tire_mark_width_height_diameter_charges,
			'tire_mark_width_height_diameter_charge_speedes' => $tire_mark_width_height_diameter_charge_speedes
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
			'price' => 'required|numeric',
			'type' => 'required|numeric',
			'tire_mark' => 'required|numeric',
			'tire_width' => 'required|numeric',
			'tire_height' => 'required|numeric',
			'tire_diameter' => 'required|numeric',
			'tire_charge' => 'required|numeric',
			'tire_speed' => 'required|numeric',
			'tire_season' => 'required|numeric',
			'description' => 'required|string',
		]);

		if ($v->fails())
		{
			return redirect()->back()->withInput()->withErrors($v->errors());
		}
        
		$tire = new Tire;
		$tire->title = $request->title;
		$tire->price = $request->price;
		$tire->type = $request->type;
		$tire->tire_mark_id = $request->tire_mark;
		$tire->tire_width_id = $request->tire_width;
		$tire->tire_height_id = $request->tire_height;
		$tire->tire_diameter_id = $request->tire_diameter;
		$tire->tire_charge_id = $request->tire_charge;
		$tire->tire_speed_id = $request->tire_speed;
		$tire->tire_season_id = $request->tire_season;
		$tire->runflat = $request->runflat;
		$tire->reinforced = $request->reinforced;
		$tire->description = $request->description;
		$tire->save();
		$tire_id = $tire->id;
		
        $message = 'Tire Created Successfully';
        return redirect()->action('Admin\TireController@edit', ['id' => $tire_id])->with('message',  $message);
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
        $tires_marks  = [];
		$tires_marks_ = Tire_mark::all();
		
		foreach($tires_marks_ as $tm) {
			$group_name = $tm->group_name($tm->tire_mark_group_id);
			$tires_marks[$group_name][] = [
				'id'   => $tm->id,
				'name' => $tm->name
			];
		}
		
		$tire_mark_widths = [];
		$tire_mark_widths_ = Tire_mark_width::all();
		
		foreach($tire_mark_widths_ as $tmw) {
			$group_name = $tmw->group_name($tmw->tire_mark_width_group_id);
			$tire_mark_widths[$group_name][] = [
				'id'   => $tmw->id,
				'name' => $tmw->name
			];
		}
		
		$tire_mark_width_heights = Tire_mark_width_height::all();
		$tire_mark_width_height_diameters = Tire_mark_width_height_diameter::all();
		$tire_mark_width_height_diameter_charges = Tire_mark_width_height_diameter_charge::all();
		$tire_mark_width_height_diameter_charge_speedes = Tire_mark_width_height_diameter_charge_speed::all();
		
		$tire = Tire::find($id);
		
		return view('admin/tires.edit',[ 
			'tire_images' => $tire->images,
			'tire' => $tire,
			'tire_id' => $tire->id,
			'tire_types' => $this->tire_types,
			'tires_marks' => $tires_marks,
			'tire_mark_widths' => $tire_mark_widths,
			'tire_mark_width_heights' => $tire_mark_width_heights,
			'tire_mark_width_height_diameters' => $tire_mark_width_height_diameters,
			'tire_mark_width_height_diameter_charges' => $tire_mark_width_height_diameter_charges,
			'tire_mark_width_height_diameter_charge_speedes' => $tire_mark_width_height_diameter_charge_speedes
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
			'price' => 'required|numeric',
			'type' => 'required|numeric',
			'tire_mark' => 'required|numeric',
			'tire_width' => 'required|numeric',
			'tire_height' => 'required|numeric',
			'tire_diameter' => 'required|numeric',
			'tire_charge' => 'required|numeric',
			'tire_speed' => 'required|numeric',
			'tire_season' => 'required|numeric',
			'description' => 'required|string',
		]);

		if ($v->fails())
		{
			return redirect()->back()->withInput()->withErrors($v->errors());
		}
        
		$tire = Tire::find($id);
		$tire->title = $request->title;
		$tire->price = $request->price;
		$tire->type = $request->type;
		$tire->tire_mark_id = $request->tire_mark;
		$tire->tire_width_id = $request->tire_width;
		$tire->tire_height_id = $request->tire_height;
		$tire->tire_diameter_id = $request->tire_diameter;
		$tire->tire_charge_id = $request->tire_charge;
		$tire->tire_speed_id = $request->tire_speed;
		$tire->tire_season_id = $request->tire_season;
		$tire->runflat = $request->runflat;
		$tire->reinforced = $request->reinforced;
		$tire->description = $request->description;
		$tire->save();
		$tire_id = $tire->id;
				
		$message = 'Tire Updated Successfully';
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
        $tire = Tire::find($id);
        $tire->delete();
		
        $message = 'Tire Deleted Successfully';
        return redirect()->action('Admin\TireController@index')->with('message',$message);
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