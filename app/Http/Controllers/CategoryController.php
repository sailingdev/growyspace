<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use App\Category; 
use App\Car; 
use App\Mark; 
use App\Mark_model; 
use App\Mark_model_motorization; 
use App\Mark_model_motorization_power; 
use App\Product; 
use App\Product_group; 
use App\Product_group_item; 
use App\Product_group_images; 
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

use App\Tire;
use App\Tire_image;
use App\Tire_mark;
use App\Tire_mark_width;
use App\Tire_mark_width_height;
use App\Tire_mark_width_height_diameter;
use App\Tire_mark_width_height_diameter_charge;
use App\Tire_mark_width_height_diameter_charge_speed;

class CategoryController extends Controller
{
	public $fuels = [
		1 => 'Diesel',
		2 => 'Essence',
		3 => 'hybrid',
		4 => 'petrol/gas',
		5 => 'electric',
	];
	
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
       
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($name,$id)
    {
		$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : false;
		$page_id = isset($_GET['page']) ? $_GET['page'] : 0;
		$mark_id = isset($_GET['mark_id']) ? $_GET['mark_id'] : false;
		$model_id = isset($_GET['model_id']) ? $_GET['model_id'] : false;
		$motorization_id = isset($_GET['motorization_id']) ? $_GET['motorization_id'] : false;
		$power_id = isset($_GET['power_id']) ? $_GET['power_id'] : false;
		$ref = isset($_GET['ref']) ? $_GET['ref'] : false;
		$sub_query = '1=1';
		
		if ($mark_id !== false) {
			$sub_query .= " AND products.mark_id='$mark_id'";
		}
		
		if ($model_id !== false) {
			$sub_query .= " AND products.model_id='$model_id'";
		}
		
		if ($motorization_id !== false) {
			$sub_query .= " AND products.motorization_id='$motorization_id'";
		}
		
		if ($power_id !== false) {
			$sub_query .= " AND products.power_id='$power_id'";
		}
			
		if ($ref !== false) {
			$sub_query .= " AND product_group_items.name LIKE '%$ref%'";
		}
		
		if ($category_id !== false) {
			$sub_query .= " AND products.category_id='$category_id'";
		}
		
		if($id == '1_2') {
			$category_ids = [1,2];
			$category_name = 'TURBOS / CHRAS';
			$category_url = URL::to('/').'/category/TURBOS CHRAS/'.$id.'.htm';
		} else {
			$category_ids = [$id];
			$category = Category::find($id);
			$category_name = $category->name;
			$category_url = URL::to('/').'/category/'.$name.'/'.$id.'.htm';
		}
		
		$category_products = DB::table('products')
            ->leftJoin('product_groups', 'product_groups.id', '=', 'products.group_id')
            ->leftJoin('product_group_items', 'product_group_items.group_id', '=', 'product_groups.id')
            ->leftJoin('product_group_images', function($join)
			{
				$join->on('product_group_images.group_id', '=', 'product_groups.id');
				$join->where('product_group_images.is_main','=', 1);
			})						
			->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->whereRaw($sub_query)
            ->select(
				'categories.name as category_name', 
				'products.id as product_id' , 
				'products.title', 
				'product_groups.price AS group_price',
				'product_groups.id AS group_id',
				'product_group_images.image_url AS main_image'
			)
			->groupBy('products.id')
			->paginate(32);
						
		$prod_groups = Product_group::all();
        $categories = Category::all();
        $marks = Mark::orderBy('name','asc')->get();
		$meta_title = 'Trouver mon turbo';				
		return view('category',[
			'meta_title' => $meta_title,
			'category_products' => $category_products,
			'category_name' => $category_name,
			'marks' => $marks,
			'categories' => $categories,
			'prod_groups' => $prod_groups,
			'page_id' => $page_id,
			'category_url' => $category_url,
			'mark_id' => $mark_id,
			'model_id' => $model_id,
			'motorization_id' => $motorization_id,
			'power_id' => $power_id,
			'ref' => $ref,
			'category_id' => $category_id
		]);
	}
	
	public function cars() {
		
		$page_id = isset($_GET['page']) ? $_GET['page'] : 0;
		$mark_id = isset($_GET['mark_id']) ? $_GET['mark_id'] : false;
		$model_id = isset($_GET['model_id']) ? $_GET['model_id'] : false;
		$motorization_id = isset($_GET['motorization_id']) ? $_GET['motorization_id'] : false;
		$power_id = isset($_GET['power_id']) ? $_GET['power_id'] : false;
		
		$min_price_ = isset($_GET['min_price']) ? $_GET['min_price'] : false;
		$max_price_ = isset($_GET['max_price']) ? $_GET['max_price'] : false;
		$min_year_ = isset($_GET['min_year']) ? $_GET['min_year'] : false;
		$max_year_ = isset($_GET['max_year']) ? $_GET['max_year'] : false;
		
		$min_mileage_ = isset($_GET['min_mileage']) ? $_GET['min_mileage'] : false;
		$max_mileage_ = isset($_GET['max_mileage']) ? $_GET['max_mileage'] : false;
		$fuel_ = isset($_GET['fuel']) ? $_GET['fuel'] : false;
		$gearbox_ = isset($_GET['gearbox']) ? $_GET['gearbox'] : false;
		
		$sub_query = '1=1';
		
		if ($gearbox_ !== false) {
			$sub_query .= " AND cars.gearbox = '$gearbox_'";
		}
		
		if ($fuel_ !== false) {
			$sub_query .= " AND cars.fuel = '$fuel_'";
		}
		
		if ($min_price_ !== false) {
			$sub_query .= " AND cars.price >= '$min_price_'";
		}
		
		if ($max_price_ !== false) {
			$sub_query .= " AND cars.price <= '$max_price_'";
		}
		
		if ($min_year_ !== false) {
			$sub_query .= " AND cars.model_year >= '$min_year_'";
		}
		
		if ($max_year_ !== false) {
			$sub_query .= " AND cars.model_year <= '$max_year_'";
		}
		
		if ($min_mileage_ !== false) {
			$sub_query .= " AND cars.mileage >= '$min_mileage_'";
		}
		
		if ($max_mileage_ !== false) {
			$sub_query .= " AND cars.mileage <= '$max_mileage_'";
		}
		
		
		
		if ($mark_id !== false) {
			$sub_query .= " AND products.mark_id='$mark_id'";
		}
		
		if ($model_id !== false) {
			$sub_query .= " AND products.model_id='$model_id'";
		}
				
		$cars = DB::table('cars')
            ->leftJoin('car_images', function($join)
			{
				$join->on('car_images.car_id', '=', 'cars.id');
				$join->where('car_images.is_main','=', 1);
			})
			->leftJoin('mark_models', 'mark_models.id', '=', 'cars.model_id')			
			->leftJoin('marks', 'marks.id', '=', 'cars.mark_id')			
			->whereRaw($sub_query)
            ->select(
				'mark_models.name as model_name', 
				'marks.name as mark_name', 
				'cars.id as car_id', 
				'cars.title', 
				'cars.model_year',
				'cars.price',
				'car_images.image_url AS main_image'
			)
			->groupBy('cars.id')
			->paginate(16);
			
		$marks = Mark::orderBy('name','asc')->get();
		$category_url = URL::to('/').'/cars';
		
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
		
		
		
		return view('cars.index',[
			'cars' => $cars,
			'marks' => $marks,
			'page_id' => $page_id,
			'mark_id'      => $mark_id,
			'model_id'     => $model_id,
			'category_url' => $category_url,
			'fuels'        => $this->fuels,
			'min_price'    => $min_price,
			'max_price'    => $max_price,
			'min_year'     => $min_year,
			'max_year'     => $max_year,
			'min_mileage'  => $min_mileage,
			'max_mileage'  => $max_mileage,
			
			
			'min_price_' => $min_price_,
			'max_price_' => $max_price_,
			'min_year_' => $min_year_,
			'max_year_' => $max_year_,
			'min_mileage_' => $min_mileage_,
			'max_mileage_' => $max_mileage_,
			'fuel_' => $fuel_,
			'gearbox_' => $gearbox_,
		]);
	}
	
	public function view_car($name,$id) {
		$car = Car::find($id);
		$car_images = $car->images;
		$fuels = $this->fuels;
		
		return view('cars.view',[
			'fuels' => $fuels,
			'car' => $car,
			'car_images' => $car_images
		]);
	}
	
	public function view_tire($name,$id) {
		$tire = Tire::find($id);
		$tire_images = $tire->images;
				
		return view('tires.view',[
			'tire' => $tire,
			'tire_images' => $tire_images,
			'tire_types' => $this->tire_types,
		]);
	}
	
	public function tires() {
		
		$page_id = isset($_GET['page']) ? $_GET['page'] : 0;
		
		$tire_type = isset($_GET['tire_type']) ? $_GET['tire_type'] : false;
		$tire_mark_id = isset($_GET['tire_mark_id']) ? $_GET['tire_mark_id'] : false;
		$tire_width_id = isset($_GET['tire_width_id']) ? $_GET['tire_width_id'] : false;
		$tire_height_id = isset($_GET['tire_height_id']) ? $_GET['tire_height_id'] : false;
		$tire_diameter_id = isset($_GET['tire_diameter_id']) ? $_GET['tire_diameter_id'] : false;
		$tire_charge_id = isset($_GET['tire_charge_id']) ? $_GET['tire_charge_id'] : false;
		$tire_speed_id = isset($_GET['tire_speed_id']) ? $_GET['tire_speed_id'] : false;
		$tire_season = isset($_GET['tire_season']) ? $_GET['tire_season'] : false;
		$runflat = isset($_GET['runflat']) ? $_GET['runflat'] : false;
		$reinforced = isset($_GET['reinforced']) ? $_GET['reinforced'] : false;
		
		$sub_query = '1=1';
		
		if ($reinforced !== false) {
			$sub_query .= " AND tires.reinforced = '$reinforced'";
		}
		
		if ($runflat !== false) {
			$sub_query .= " AND tires.runflat = '$runflat'";
		}
		
		if ($tire_season !== false) {
			$sub_query .= " AND tires.tire_season_id = '$tire_season'";
		}
		
		if ($tire_season !== false) {
			$sub_query .= " AND tires.tire_season_id = '$tire_season'";
		}
		
		if ($tire_type !== false) {
			$sub_query .= " AND tires.type = '$tire_type'";
		}
		
		if ($tire_mark_id !== false) {
			$sub_query .= " AND tires.tire_mark_id = '$tire_mark_id'";
		}
		
		if ($tire_width_id !== false) {
			$sub_query .= " AND tires.tire_width_id = '$tire_width_id'";
		}
		
		if ($tire_height_id !== false) {
			$sub_query .= " AND tires.tire_height_id = '$tire_height_id'";
		}
		
		if ($tire_diameter_id !== false) {
			$sub_query .= " AND tires.tire_diameter_id = '$tire_diameter_id'";
		}
		
		if ($tire_charge_id !== false) {
			$sub_query .= " AND tires.tire_charge_id = '$tire_charge_id'";
		}
		
		if ($tire_speed_id !== false) {
			$sub_query .= " AND tires.tire_speed_id = '$tire_speed_id'";
		}
		
				
		$tires = DB::table('tires')
            ->leftJoin('tire_images', function($join)
			{
				$join->on('tire_images.tire_id', '=', 'tires.id');
				$join->where('tire_images.is_main','=', 1);
			})
			->leftJoin('tire_marks', 'tire_marks.id', '=', 'tires.tire_mark_id')			
			->whereRaw($sub_query)
            ->select(
				'tire_marks.name as tire_mark_name', 
				'tires.id as tire_id', 
				'tires.title',
				'tires.price',
				'tire_images.image_url AS main_image'
			)
			->groupBy('tires.id')
			->paginate(16);
			
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
		
		$category_url = URL::to('/').'/tires';
		
		return view('tires.index',[
			'tires' => $tires,
			'page_id' => $page_id,
			'category_url' => $category_url,
						
			'tire_types' => $this->tire_types,
			'tires_marks' => $tires_marks,
			'tire_mark_widths' => $tire_mark_widths,
			'tire_mark_width_heights' => $tire_mark_width_heights,
			'tire_mark_width_height_diameters' => $tire_mark_width_height_diameters,
			'tire_mark_width_height_diameter_charges' => $tire_mark_width_height_diameter_charges,
			'tire_mark_width_height_diameter_charge_speedes' => $tire_mark_width_height_diameter_charge_speedes,
						
			'tire_type' => $tire_type,
			'tire_mark_id' => $tire_mark_id,
			'tire_width_id'	=> $tire_width_id,
			'tire_height_id' => $tire_height_id,
			'tire_diameter_id' => $tire_diameter_id,
			'tire_charge_id' =>	$tire_charge_id,
			'tire_speed_id' =>	$tire_speed_id,
			'tire_season' =>	$tire_season,
			'runflat' =>	$runflat,
			'reinforced' =>	$reinforced
		]);
	}
	
	public function advanced_search() {
		$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : false;
		$page_id = isset($_GET['page']) ? $_GET['page'] : 0;
		$mark_id = isset($_GET['mark_id']) ? $_GET['mark_id'] : false;
		$model_id = isset($_GET['model_id']) ? $_GET['model_id'] : false;
		$motorization_id = isset($_GET['motorization_id']) ? $_GET['motorization_id'] : false;
		$power_id = isset($_GET['power_id']) ? $_GET['power_id'] : false;
		$ref = isset($_GET['ref']) ? $_GET['ref'] : false;
		$keyword = isset($_GET['search']) ? $_GET['search'] : false;
		$sub_query = '1=1';
		
		if ($keyword !== false) {
			$sub_query .= " AND (product_group_items.name LIKE '%$keyword%' OR products.title LIKE  '%$keyword%' OR products.description LIKE  '%$keyword%')";
		}
		
		if ($mark_id !== false) {
			$sub_query .= " AND products.mark_id='$mark_id'";
		}
		
		if ($model_id !== false) {
			$sub_query .= " AND products.model_id='$model_id'";
		}
		
		if ($motorization_id !== false) {
			$sub_query .= " AND products.motorization_id='$motorization_id'";
		}
		
		if ($power_id !== false) {
			$sub_query .= " AND products.power_id='$power_id'";
		}
			
		if ($ref !== false) {
			$sub_query .= " AND product_group_items.name LIKE '%$ref%'";
		}
		
		if ($category_id !== false) {
			$sub_query .= " AND products.category_id='$category_id'";
		}
		$id = '1_2';
		if($id == '1_2') {
			$category_ids = [1,2];
			$category_name = 'TURBOS / CHRAS';
			//$category_url = URL::to('/').'/category/TURBOS CHRAS/'.$id.'.htm';
		} else {
			$category_ids = [$id];
			$category = Category::find($id);
			$category_name = $category->name;
			//$category_url = URL::to('/').'/category/'.$name.'/'.$id.'.htm';
		}
		
		$category_products = DB::table('products')
            ->leftJoin('product_groups', 'product_groups.id', '=', 'products.group_id')
            ->leftJoin('product_group_items', 'product_group_items.group_id', '=', 'product_groups.id')
            ->leftJoin('product_group_images', function($join)
			{
				$join->on('product_group_images.group_id', '=', 'product_groups.id');
				$join->where('product_group_images.is_main','=', 1);
			})						
			->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->whereRaw($sub_query)
            ->select(
				'categories.name as category_name', 
				'products.id as product_id' , 
				'products.title', 
				'product_groups.price AS group_price',
				'product_groups.id AS group_id',
				'product_group_images.image_url AS main_image'
			)
			->groupBy('products.id')
			->paginate(32);
						
		$prod_groups = Product_group::all();
        $categories = Category::all();
        $marks = Mark::orderBy('name','asc')->get();
		
		$category_url = URL::to('/').'/advanced_search';
		
		return view('search',[
			'category_products' => $category_products,
			'category_name' => $category_name,
			'marks' => $marks,
			'categories' => $categories,
			'prod_groups' => $prod_groups,
			'page_id' => $page_id,
			'category_url' => $category_url,
			'mark_id' => $mark_id,
			'model_id' => $model_id,
			'motorization_id' => $motorization_id,
			'power_id' => $power_id,
			'ref' => $ref,
			'category_id' => $category_id,
			'search_page' => true
		]);
	}
	
	/**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
    */
}