<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Response;
use App\Mark; 
use App\Car; 
use App\Mark_model; 
use App\Mark_model_motorization; 
use App\Mark_model_motorization_power; 
use App\Product; 
use App\Category; 
use App\Product_group; 
use App\Product_group_item; 
use App\Product_group_images; 

class CarController extends Controller
{
	public $fuels = [
			1 => 'Diesel',
			2 => 'Essence',
			3 => 'hybrid',
			4 => 'Essence/gas',
			5 => 'electric',
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
		$marks = Mark::orderBy('name','asc')->get();
		
		$min_price = Car::min('price');
		$min_price = $min_price - $min_price%500;
		
		$max_price = Car::max('price');
		$max_price = $max_price - $max_price%500 + 500;
		
		$min_year = Car::min('model_year');
		$max_year = Car::max('model_year');
		
		
		$min_mileage = Car::min('mileage');
		$min_mileage = $min_mileage - $min_mileage%10000;
		
		$max_mileage = Car::max('mileage');
		$max_mileage = $max_mileage - $max_mileage%10000 + 10000;
		
		
		return view('admin/cars.index',[
			'marks' => $marks,
			'min_price'    => $min_price,
			'max_price'    => $max_price,
			'min_year'     => $min_year,
			'max_year'     => $max_year,
			'min_mileage'  => $min_mileage,
			'max_mileage'  => $max_mileage,
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

        return view('admin/cars.add',[
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
			'title'       => 'required|string',
			'price'       => 'required|numeric',
			'mark'        => 'required|numeric',
			'model'       => 'required|numeric',
			'model_year'  => 'required|numeric',
			'gearbox'     => 'required|string',
			'mileage'     => 'required|numeric',
			'fuel'        => 'required|string',
			'description' => 'required|string',
		]);

		if ($v->fails())
		{
			return redirect()->back()->withInput()->withErrors($v->errors());
		}
        
		$car = new Car;
		$car->title = $request->title;
		$car->title2 = $request->title2;
		$car->price = $request->price;
		$car->mark_id = $request->mark;
		$car->model_id = $request->model;
		$car->motorization_id = $request->motorization;
		$car->power_id = $request->power;
		$car->number_of_places = $request->number_of_places;
		$car->model_year = $request->model_year;
		$car->gearbox = $request->gearbox;
		$car->mileage = $request->mileage;
		$car->fuel = $request->fuel;
		$car->description = $request->description;
		$car->save();
		$car_id = $car->id;
		
        $message = 'Car Created Successfully';
        return redirect()->action('Admin\CarController@edit', ['id' => $car_id])->with('message',  $message);
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
        $marks = Mark::orderBy('name','asc')->get();
        $car   = Car::find($id);
		        		
		return view('admin/cars.edit',[ 
			'marks' => $marks,
			'car' => $car,
			'car_id' => $car->id,
			'fuels' => $this->fuels,
			'car_images' => $car->images
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
			'title'       => 'required|string',
			'price'       => 'required|numeric',
			'mark'        => 'required|numeric',
			'model'       => 'required|numeric',
			'model_year'  => 'required|numeric',
			'gearbox'     => 'required|string',
			'mileage'     => 'required|numeric',
			'fuel'        => 'required|string',
			'description' => 'required|string',
		]);

		if ($v->fails())
		{
			return redirect()->back()->withInput()->withErrors($v->errors());
		}
        
		$car = Car::find($id);
		$car->title = $request->title;
		$car->title2 = $request->title2;
		$car->price = $request->price;
		$car->mark_id = $request->mark;
		$car->model_id = $request->model;
		$car->motorization_id = $request->motorization;
		$car->power_id = $request->power;
		$car->number_of_places = $request->number_of_places;
		$car->model_year = $request->model_year;
		$car->gearbox = $request->gearbox;
		$car->mileage = $request->mileage;
		$car->fuel = $request->fuel;
		$car->description = $request->description;
		$car->save();
		$car_id = $car->id;
				
		$message = 'Car Updated Successfully';
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
        $car = Car::find($id);
        $car->delete();
		
        $message = 'Car Deleted Successfully';
        return redirect()->action('Admin\CarController@index')->with('message',$message);
    }
}