<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;
use Validator;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;

use App\User;
use App\Opportunity_card;
use App\Opentowork_card;
use App\User_message;
use App\User_message_conversation;

use Artisan;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\URL;

class AjaxController extends Controller
{
	public $fuels = [
		1 => 'Diesel',
		2 => 'petrol',
		3 => 'hybrid',
		4 => 'petrol/gas',
		5 => 'electric',
	];
		
    public function __construct()
    {
      $this->middleware('auth:admin');
    }
	
	
	public function delete_power(Request $request) {
		if ($request->ajax()) {
			$tree_mark_id  = $request->tree_mark_id;
			$tree_model_id = $request->tree_model_id;
			$motorization_id = $request->motorization_id;
			$power_id = $request->power_id;
						
			$mark_model = Mark_model::where('mark_id',$tree_mark_id)->where('id',$tree_model_id)->first();
				
			if (count((array)$mark_model) == 0) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request'
				));exit;
			}
			
			Mark_model_motorization_power::where('motorization_id',$motorization_id)->where('id',$power_id)->delete();
						
			$mark_model = Mark_model::where('mark_id',$tree_mark_id)->where('id',$tree_model_id)->first();
			$motorizations = $mark_model->motorizations;
			$motorization_powers = [];
			
			foreach($motorizations as $motorization) {
				$motorization_powers[$motorization->id] = $motorization;
				$motorization_powers[$motorization->id]['powers'] = $motorization->powers;
			}
			
			$motorization_powers_html = (String) view('admin.marks.motorizations_tree_accordion',[
				'motorization_powers' => $motorization_powers
			]);
			
			echo json_encode(array(
				'complete' => true,
				'motorization_powers_html' => $motorization_powers_html
			));
			
		}
	}

	public function add_power(Request $request) {
		if ($request->ajax()) {
			$tree_mark_id  = $request->tree_mark_id;
			$tree_model_id = $request->tree_model_id;
			$motorization_id = $request->motorization_id;
			$power_name = $request->power_name;
			
			$mark_model = Mark_model::where('mark_id',$tree_mark_id)->where('id',$tree_model_id)->first();
				
			if (count((array)$mark_model) == 0) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request'
				));exit;
			}
			
			$mark_model_motorization = Mark_model_motorization::where('model_id',$tree_model_id)->where('id',$motorization_id)->first();
		
			if (count((array)$mark_model_motorization) == 0) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request'
				));exit;
			}
			
			$p = new Mark_model_motorization_power;
			$p->name = $power_name;
			$p->motorization_id = $motorization_id;
			$p->save();
			
			$mark_model = Mark_model::where('mark_id',$tree_mark_id)->where('id',$tree_model_id)->first();
			$motorizations = $mark_model->motorizations;
			$motorization_powers = [];
			
			foreach($motorizations as $motorization) {
				$motorization_powers[$motorization->id] = $motorization;
				$motorization_powers[$motorization->id]['powers'] = $motorization->powers;
			}
			
			$motorization_powers_html = (String) view('admin.marks.motorizations_tree_accordion',[
				'motorization_powers' => $motorization_powers
			]);
			
			echo json_encode(array(
				'complete' => true,
				'motorization_powers_html' => $motorization_powers_html
			));
		}
	}
	
	public function delete_motorization(Request $request) {
		if ($request->ajax()) {
			$tree_mark_id  = $request->tree_mark_id;
			$tree_model_id = $request->tree_model_id;
			$motorization_id = $request->motorization_id;
						
			$mark_model = Mark_model::where('mark_id',$tree_mark_id)->where('id',$tree_model_id)->first();
				
			if (count((array)$mark_model) == 0) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request'
				));exit;
			}
			
			Mark_model_motorization::where('model_id',$tree_model_id)->where('id',$motorization_id)->delete();
						
			$mark_model = Mark_model::where('mark_id',$tree_mark_id)->where('id',$tree_model_id)->first();
			$motorizations = $mark_model->motorizations;
			$motorization_powers = [];
			
			foreach($motorizations as $motorization) {
				$motorization_powers[$motorization->id] = $motorization;
				$motorization_powers[$motorization->id]['powers'] = $motorization->powers;
			}
			
			$motorization_powers_html = (String) view('admin.marks.motorizations_tree_accordion',[
				'motorization_powers' => $motorization_powers
			]);
			
			echo json_encode(array(
				'complete' => true,
				'motorization_powers_html' => $motorization_powers_html
			));
			
		}
	}
	
	public function add_motorization(Request $request) {
		if ($request->ajax()) {
			$tree_mark_id  = $request->tree_mark_id;
			$tree_model_id = $request->tree_model_id;
			$motorization_name = $request->motorization_name;
						
			$mark_model = Mark_model::where('mark_id',$tree_mark_id)->where('id',$tree_model_id)->first();
				
			if (count((array)$mark_model) == 0) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request'
				));exit;
			}
			
			$m = new Mark_model_motorization;
			$m->name = $motorization_name;
			$m->model_id = $tree_model_id;
			$m->save();
			
			$mark_model = Mark_model::where('mark_id',$tree_mark_id)->where('id',$tree_model_id)->first();
			$motorizations = $mark_model->motorizations;
			$motorization_powers = [];
			
			foreach($motorizations as $motorization) {
				$motorization_powers[$motorization->id] = $motorization;
				$motorization_powers[$motorization->id]['powers'] = $motorization->powers;
			}
			
			$motorization_powers_html = (String) view('admin.marks.motorizations_tree_accordion',[
				'motorization_powers' => $motorization_powers
			]);
			
			echo json_encode(array(
				'complete' => true,
				'motorization_powers_html' => $motorization_powers_html
			));
			
		}
	}
	
	public function get_mark_model_tree(Request $request) {
		if ($request->ajax()) {
			$tree_mark_id  = $request->tree_mark_id;
			$tree_model_id = $request->tree_model_id;
			
			$mark_model = Mark_model::where('mark_id',$tree_mark_id)->where('id',$tree_model_id)->first();
				
			if (count((array)$mark_model) == 0) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request'
				));exit;
			}
			
			$motorizations = $mark_model->motorizations;
			$motorization_powers = [];
			
			foreach($motorizations as $motorization) {
				$motorization_powers[$motorization->id] = $motorization;
				$motorization_powers[$motorization->id]['powers'] = $motorization->powers;
			}
			
			$motorization_powers_html = (String) view('admin.marks.motorizations_tree_accordion',[
				'motorization_powers' => $motorization_powers
			]);

			
			echo json_encode(array(
				'complete' => true,
				'mark' => $mark_model->mark,
				'mark_model' => $mark_model,
				'mark_model_motorizations' => $mark_model->motorizations,
				'motorization_powers' => $motorization_powers,
				'motorization_powers_html' => $motorization_powers_html
			));
			
			
			
		}
	}

	public function add_edit_mark_model(Request $request) {
		if ($request->ajax()) {
			$tree_mark_id = $request->tree_mark_id;
			$tree_model_id = $request->tree_model_id;
			$tree_model_name = isset($request->tree_model_name) ? $request->tree_model_name : '';
			$mark_model_edit_mode = $request->mark_model_edit_mode;
			
			if($mark_model_edit_mode == 1) {
				$mark_model = Mark_model::where('mark_id',$tree_mark_id)->where('id',$tree_model_id)->first();
				
				if (count((array)$mark_model) == 0) {
					echo json_encode(array(
						'complete' => false,
						'message' => 'Wrong Request'
					));exit;
				}
				
				$mark_model->name = $tree_model_name;
				$mark_model->save();
			} else {
				$mark_model = new Mark_model;
				$mark_model->mark_id = $tree_mark_id;
				$mark_model->name = $tree_model_name;
				$mark_model->save();
			}
			
			echo json_encode(array(
				'complete' => true,
			));
		}
	}
	
	public function dynamic_mark_model_motorization_power(Request $request) {
		if ($request->ajax()) {
			$dependence = $request->dependence;
			$data_id      = $request->data_id;
			
			if ($dependence == 'mark') {
				$options = Mark_model::where('mark_id',$data_id)->orderBy('name','ASC')->get();
				$id_field = 'model_id';
			} else if($dependence == 'model') {
				$options = Mark_model_motorization::where('model_id',$data_id)->orderBy('name','ASC')->get();
				$id_field = 'motorization_id';
			} else if($dependence == 'motorization') {
				$options = Mark_model_motorization_power::where('motorization_id',$data_id)->orderBy('name','ASC')->get();
				$id_field = 'power_id';
			}
			$options_html = '';
			
			foreach($options as $option) {
				$options_html.= '<option value="'.$option->id.'">'.$option->name.'</option>';
			}
			
			echo json_encode(array(
				'complete' => true,
				'options_html' => $options_html,
				'options' => $options
			));
		}
	}
	
    public function get_opportunity_cards(Request $request)
    {
		return Datatables::of(Opportunity_card::query())
			->addColumn('owner_name', function (Opportunity_card $opc) {
				return isset($opc->owner->full_name) ? $opc->owner->full_name : '';
			})
			->addColumn('country', function (Opportunity_card $opc) {
				return $opc->country();
			})
			->addColumn('actions', function ($card) {
             
				$delete_form ='<form action="'.URL::to('/growyspace-admin/opportunity_cards/'.$card->id).'" method="POST" onsubmit="return confirm(\'Are you sure?\');" style="display: inline-block;">';
					
					$delete_form .= '<input type="hidden" name="_method" value="DELETE">';
					$delete_form .= '<input type="hidden" name="_token" value="'. csrf_token().'">';
					$delete_form .= '<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Delete </button>';
					$delete_form .= '<a class="btn btn-primary" onclick="sendChat('.$card->id.')">Send Message</a>';
				$delete_form .= '</form>';
								
				return $delete_form;
			
			})
			->escapeColumns([])
			->rawColumns(['action'])
			->make(true);
    }
    public function get_opentowork_cards(Request $request)
    {
		return Datatables::of(Opentowork_card::query())
			->addColumn('owner_name', function (Opentowork_card $opc) {
				return isset($opc->owner->full_name) ? $opc->owner->full_name : '';
			})
			->addColumn('country', function (Opentowork_card $opc) {
				return $opc->country();
			})
			->addColumn('roles', function (Opentowork_card $opc) {
				$opc_fields = json_decode($opc->fields,true);
					$str ='<ul class="list-unstyled list-inline margin-0-auto mb-0 request_skills">';
				foreach($opc_fields as $oc){
					$str .='<li class="list-inline-item mr-0 pr-2 pb-2" style="margin:0px">';
					$str .='<div class="chip bgcolor-purple mr-0 chip-custom">'.$oc.'</div>';
					$str .='</li>';
				}
				$str .='</ul>';
				return $str;
			})
			->addColumn('actions', function ($card) {
             
				$delete_form ='<form action="'.URL::to('/growyspace-admin/opentowork_cards/'.$card->id).'" method="POST" onsubmit="return confirm(\'Are you sure?\');" style="display: inline-block;">';
					$delete_form .= '<input type="hidden" name="_method" value="DELETE">';
					$delete_form .= '<input type="hidden" name="_token" value="'. csrf_token().'">';
					$delete_form .= '<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Delete </button>';
				$delete_form .= '</form>';
								
				return $delete_form;
			
			})
			->escapeColumns([])
			->rawColumns(['action'])
			->make(true);
    }
	public function upgrade_user_license(Request $request)
    {
		$field = !empty($request->field) ? $request->field : false;
		$value = !empty($request->value) ? $request->value : false;
		$id = !empty($request->id) ? $request->id : false;
		echo $value;


		$user = User::find($id);
		$user->licence = $value; 
		$user->save();
		echo json_encode(array(
			'complete' => true,
			'messages_html' => 'Your account has been upgraded',
		));
	}
	public function upgrade_user_matchmaking(Request $request)
    {

		$id = !empty($request->id) ? $request->id : false;
		$matchmaking = !empty($request->matchmaking) ? $request->matchmaking : false;

		$value = 0;
		if($matchmaking) $value = 1;
		$user = User::find($id);
		$user->matchmaking = $value; 
		$user->save();
		echo json_encode(array(
			'complete' => true,
			'messages_html' => 'Your account has been upgraded',
		));
	}
	public function get_tires(Request $request)
    {
		$type = !empty($request->type) ? $request->type : false;
		$tire_mark_id = !empty($request->tire_mark_id) ? $request->tire_mark_id : false;
		$tire_width_id = !empty($request->tire_width_id) ? $request->tire_width_id : false;
		$tire_height_id = !empty($request->tire_height_id) ? $request->tire_height_id : false;
		$tire_diameter_id = !empty($request->tire_diameter_id) ? $request->tire_diameter_id : false;
		$tire_charge_id = !empty($request->tire_charge_id) ? $request->tire_charge_id : false;
		$tire_speed_id = !empty($request->tire_speed_id) ? $request->tire_speed_id : false;
		
		$sub_query = "1=1";
		
		if ($type !== false) {
			$sub_query .= " AND type='$type'";
		}
		
		if ($tire_mark_id !== false) {
			$sub_query .= " AND tire_mark_id='$tire_mark_id'";
		}
		
		if ($tire_width_id !== false) {
			$sub_query .= " AND tire_width_id='$tire_width_id'";
		}
		
		if ($tire_height_id !== false) {
			$sub_query .= " AND tire_height_id='$tire_height_id'";
		}
		
		if ($tire_diameter_id !== false) {
			$sub_query .= " AND tire_diameter_id='$tire_diameter_id'";
		}
		
		if ($tire_charge_id !== false) {
			$sub_query .= " AND tire_charge_id='$tire_charge_id'";
		}
		
		if ($tire_speed_id !== false) {
			$sub_query .= " AND tire_speed_id='$tire_speed_id'";
		}
				
		return Datatables::of(Tire::query()->select(
			'id',
			'title',
			'type',
			'tire_mark_id',
			'tire_width_id',
			'tire_height_id',
			'tire_diameter_id',
			'tire_charge_id',
			'tire_speed_id',
			'tire_season_id',
			'runflat',
			'reinforced'
		)->whereRaw($sub_query))
			->addColumn('tire_mark', function (Tire $tire) {
				return isset($tire->mark->name) ? $tire->mark->name : '';
			})
			->addColumn('tire_width', function (Tire $tire) {
				return isset($tire->width->name) ? $tire->width->name : '';
			})
			->addColumn('tire_height', function (Tire $tire) {
				return isset($tire->height->name) ? $tire->height->name : '';
			})
			->addColumn('tire_diameter', function (Tire $tire) {
				return isset($tire->diameter->name) ? $tire->diameter->name : '';
			})
			->addColumn('tire_charge', function (Tire $tire) {
				return isset($tire->charge->name) ? $tire->charge->name : '';
			})
			->addColumn('tire_speed', function (Tire $tire) {
				return isset($tire->speed->name) ? $tire->speed->name : '';
			})
			->addColumn('tire_season', function (Tire $tire) {
				if($tire->tire_season_id == 1) {
					return 'Pneu été / 4 saisons';
				} else if($tire->tire_season_id == 2) {
					return 'Pneu hiver';
				}
				
				return '';
			})
			->addColumn('runflat_name', function (Tire $tire) {
				if($tire->runflat == 1) {
					return 'Oui';
				} 
				
				return 'Non';
			})
			->addColumn('reinforced_name', function (Tire $tire) {
				if($tire->reinforced == 1) {
					return 'Oui';
				} 
				
				return 'Non';
			})
			->addColumn('type_name', function (Tire $tire) {
				$tire_types = [
					1 => 'Tous',
					2 => 'Voiture / Tourisme',
					3 => '4x4 / SUV',
					4 => 'Camionnette / Utilitaire',
					5 => 'Compétition',
					6 => 'Collection',
					7 => 'Remorque bagagère'
				];
				
				
				return isset($tire_types[$tire->type]) ? $tire_types[$tire->type] : '';
			})
			
			
			->addColumn('actions', function ($tire) {
                $edit_url = URL::to('/auto-turbo-admin/tires/'.$tire->id.'/edit');
				
				$delete_form ='<form action="'.URL::to('/auto-turbo-admin/tires/'.$tire->id).'" method="POST" onsubmit="return confirm(\'Are you sure?\');" style="display: inline-block;">';
					$delete_form .= '<input type="hidden" name="_method" value="DELETE">';
					$delete_form .= '<input type="hidden" name="_token" value="'. csrf_token().'">';
					$delete_form .= '<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Delete </button>';
				$delete_form .= '</form>';
								
				return '<a data-id="'.$tire->id.'" class="btn btn-primary btn-sm" href="'.$edit_url.'"><i class="fa fa-edit"></i> Edit</a>'.
						' '.$delete_form;
			
			})
			->escapeColumns([])
			->rawColumns(['action'])
			->make(true);
    }
	
	public function get_orders(Request $request)
    {
		//
		return Datatables::of(Order::query())
			->addColumn('shipping_method', function (Order $order) {
				return isset($order->shipping_method->name) ? $order->shipping_method->name : '';
			})	
			->addColumn('client_name', function (Order $order) {
				return isset($order->user->bill_first_name) ? $order->user->bill_first_name.' '.$order->user->bill_last_name : '';
			})	
			->addColumn('facture_id_', function (Order $order) {
				return trim($order->facture_id) == '' ? '----' : $order->facture_id;
			})	
			->addColumn('actions', function ($order) {
                $edit_url = URL::to('/auto-turbo-admin/orders/'.$order->id.'/view');
												
				return '<a  class="btn btn-primary btn-sm" href="'.$edit_url.'"><i class="fa fa-edit"></i> View</a>';
			
			})
			->escapeColumns([])
			->rawColumns(['action'])
			->make(true);
    }
	
	public function get_product_groups(Request $request)
    {
		$searchString = $request->item_name;
		$has_image = $request->has_image;
		
		if(trim($has_image) == '') {
			$pg = Product_group::query()->whereHas('items', function ($query) use ($searchString){
				if(trim($searchString) !='') {
					$query->where('name', 'like', '%'.$searchString.'%');
				} else {
					$query->whereRaw('1=1');
				}
			});
		} else if(trim($has_image) == 'Yes') {
			$pg = Product_group::query()->whereHas('items', function ($query) use ($searchString){
				if(trim($searchString) !='') {
					$query->where('name', 'like', '%'.$searchString.'%');
				} else {
					$query->whereRaw('1=1');
				}
			})->whereHas('images', function ($query) use ($searchString){
				$query->whereRaw('1=1');
			});
		} else if(trim($has_image) == 'No') {
			$pg = Product_group::query()->whereHas('items', function ($query) use ($searchString){
				if(trim($searchString) !='') {
					$query->where('name', 'like', '%'.$searchString.'%');
				} else {
					$query->whereRaw('1=1');
				}
			})->whereDoesntHave('images', function ($query) use ($searchString){
				$query->whereRaw('1=1');
			});
		}
		
		
		
		
        return Datatables::of($pg)
			->addColumn('items', function (Product_group $prod_group) {
				$items_html = '';
				
				if(count((array) $prod_group->items) > 0) {
					foreach($prod_group->items as $item) {
						$items_html .= $item->name.'<br/>';
					}
				}
				
				return $items_html;
			})	
			->addColumn('has_image', function (Product_group $prod_group) {
								
				if(count($prod_group->images) > 0) {
					return 'Yes';
				} else {
					return 'No';
				}
			})	
			->addColumn('actions', function ($pg) {
				$edit_url = URL::to('/auto-turbo-admin/product_groups/'.$pg->id.'/edit');
                
				$delete_form ='<form action="'.URL::to('/auto-turbo-admin/product_groups/'.$pg->id).'" method="POST" onsubmit="return confirm(\'Are you sure?\');" style="display: inline-block;">';
					$delete_form .= '<input type="hidden" name="_method" value="DELETE">';
					$delete_form .= '<input type="hidden" name="_token" value="'. csrf_token().'">';
					$delete_form .= '<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Delete </button>';
				$delete_form .= '</form>';
				
				
				return '<a data-id="'.$pg->id.'" class="btn btn-primary btn-sm edit_product_group_" href="'.$edit_url.'"><i class="fa fa-edit"></i> Edit</a>'.
						' '.$delete_form;
			
			})
			->escapeColumns([])
			->rawColumns(['action','items'])
			->make(true);
    }
	
	public function upload_product_group_images(Request $request) {
		if ($request->ajax()) {
			$photos = $request->file('files');
			$product_group_id = $request->product_group_id;
			$photos_path = base_path() . '/public/uploads/product_group_images/'.$product_group_id;
			if (!is_array($photos)) {
				$photos = [$photos];
			}
	 
			if (!is_dir($photos_path)) {
				mkdir($photos_path, 0777,true);
			}
	 
			$main_image_exist = Product_group_images::where('group_id',$product_group_id)->where('is_main',1)->count() > 0 ? true : false;
			
			for ($i = 0; $i < count($photos); $i++) {
				$photo = $photos[$i];
				$name = sha1(date('YmdHis') . str_random(30));
				$save_name = $name . '.' . $photo->getClientOriginalExtension();
				$resize_name = $name . str_random(2) . '.' . $photo->getClientOriginalExtension();
	 
				/*Image::make($photo)
					->resize(250, null, function ($constraints) {
						$constraints->aspectRatio();
					})
					->save($this->photos_path . '/' . $resize_name);*/
	 
				$photo->move($photos_path, $save_name);
	 
				$pgi = new Product_group_images;
				
				if ($main_image_exist === false && $i == 0) {
					$pgi->is_main = 1;
				}
								
				$pgi->group_id = $product_group_id;
				$pgi->image_url = $save_name;
				//$pgi->original_name = basename($photo->getClientOriginalName());
				$pgi->save();
			}
			echo 'Image saved Successfully';
			//return Response::json([
				//'message' => 'Image saved Successfully'
			//], 200);
		}
	}
	
	public function upload_tire_images(Request $request) {
		if ($request->ajax()) {
			$photos = $request->file('files');
			$tire_id = $request->tire_id;
			$photos_path = base_path() . '/public/uploads/tire_images/'.$tire_id;
			
			if (!is_array($photos)) {
				$photos = [$photos];
			}
	 
			if (!is_dir($photos_path)) {
				mkdir($photos_path, 0777,true);
			}
	 
			$main_image_exist = Tire_image::where('tire_id',$tire_id)->where('is_main',1)->count() > 0 ? true : false;
			
			for ($i = 0; $i < count($photos); $i++) {
				$photo = $photos[$i];
				$name = sha1(date('YmdHis') . str_random(30));
				$save_name = $name . '.' . $photo->getClientOriginalExtension();
				$resize_name = $name . str_random(2) . '.' . $photo->getClientOriginalExtension();
	 
				/*Image::make($photo)
					->resize(250, null, function ($constraints) {
						$constraints->aspectRatio();
					})
					->save($this->photos_path . '/' . $resize_name);*/
	 
				$photo->move($photos_path, $save_name);
	 
				$pgi = new Tire_image;
				
				if ($main_image_exist === false && $i == 0) {
					$pgi->is_main = 1;
				}
								
				$pgi->tire_id = $tire_id;
				$pgi->image_url = $save_name;
				//$pgi->original_name = basename($photo->getClientOriginalName());
				$pgi->save();
			}
			echo 'Image saved Successfully';
			//return Response::json([
				//'message' => 'Image saved Successfully'
			//], 200);
		}
	}
	
	public function upload_car_images(Request $request) {
		if ($request->ajax()) {
			$photos = $request->file('files');
			$car_id = $request->car_id;
			$photos_path = base_path() . '/public/uploads/car_images/'.$car_id;
			
			if (!is_array($photos)) {
				$photos = [$photos];
			}
	 
			if (!is_dir($photos_path)) {
				mkdir($photos_path, 0777,true);
			}
	 
			$main_image_exist = Car_image::where('car_id',$car_id)->where('is_main',1)->count() > 0 ? true : false;
			
			for ($i = 0; $i < count($photos); $i++) {
				$photo = $photos[$i];
				$name = sha1(date('YmdHis') . str_random(30));
				$save_name = $name . '.' . $photo->getClientOriginalExtension();
				$resize_name = $name . str_random(2) . '.' . $photo->getClientOriginalExtension();
	 
				/*Image::make($photo)
					->resize(250, null, function ($constraints) {
						$constraints->aspectRatio();
					})
					->save($this->photos_path . '/' . $resize_name);*/
	 
				$photo->move($photos_path, $save_name);
	 
				$pgi = new Car_image;
				
				if ($main_image_exist === false && $i == 0) {
					$pgi->is_main = 1;
				}
								
				$pgi->car_id = $car_id;
				$pgi->image_url = $save_name;
				//$pgi->original_name = basename($photo->getClientOriginalName());
				$pgi->save();
			}
			echo 'Image saved Successfully';
			//return Response::json([
				//'message' => 'Image saved Successfully'
			//], 200);
		}
	}
	
	public function change_car_images_order(Request $request) {
		if ($request->ajax()) {
			$ids = $request->ids;
			$ids_array = explode(',',$ids);
			$count_images = count($ids_array);
			$car_id = $request->car_id;
			Car_image::where('car_id',$car_id)->first();
			DB::table('car_images')
                ->where('car_id', $car_id)
                ->update(['is_main' => 0]);
			
			$counter = $count_images;
			foreach($ids_array as $k => $id) {
				$pgi = Car_image::where('id',$id)->where('car_id',$car_id)->first();
				
				if ($k == 0) {
					$pgi->is_main = 1;
				} else {
					$pgi->is_main = 0; 
				}					
				
				$pgi->rank = $counter;
				$pgi->save();
				$counter--;
			}
			
			echo json_encode(array(
				'complete' => true
			));
		}
	}
	
	public function change_tire_images_order(Request $request) {
		if ($request->ajax()) {
			$ids = $request->ids;
			$ids_array = explode(',',$ids);
			$count_images = count($ids_array);
			$tire_id = $request->tire_id;
			Tire_image::where('tire_id',$tire_id)->first();
			DB::table('tire_images')
                ->where('tire_id', $tire_id)
                ->update(['is_main' => 0]);
			
			$counter = $count_images;
			foreach($ids_array as $k => $id) {
				$pgi = Tire_image::where('id',$id)->where('tire_id',$tire_id)->first();
				
				if ($k == 0) {
					$pgi->is_main = 1;
				} else {
					$pgi->is_main = 0; 
				}					
				
				$pgi->rank = $counter;
				$pgi->save();
				$counter--;
			}
			
			echo json_encode(array(
				'complete' => true
			));
		}
	}
	
	public function change_product_group_images_order(Request $request) {
		if ($request->ajax()) {
			$ids = $request->ids;
			$ids_array = explode(',',$ids);
			$count_images = count($ids_array);
			$group_id = $request->group_id;
			Product_group_images::where('group_id',$group_id)->first();
			DB::table('product_group_images')
                ->where('group_id', $group_id)
                ->update(['is_main' => 0]);
			
			$counter = $count_images;
			foreach($ids_array as $k => $id) {
				$pgi = Product_group_images::where('id',$id)->where('group_id',$group_id)->first();
				
				if ($k == 0) {
					$pgi->is_main = 1;
				} else {
					$pgi->is_main = 0; 
				}					
				
				$pgi->rank = $counter;
				$pgi->save();
				$counter--;
			}
			
			echo json_encode(array(
				'complete' => true
			));
		}
	}
	
	public function delete_product_group_image(Request $request) {
		if ($request->ajax()) {
			$group_id = $request->group_id;
			$image_id = $request->image_id;
			
			$pgi = Product_group_images::where('id',$image_id)->where('group_id',$group_id)->first();
			
			if (count((array)$pgi) > 0) {
				$is_main = $pgi->is_main;
				$photos_path = base_path() . '/public/uploads/product_group_images/'.$group_id;
				
				if(is_file($photos_path.'/'.$pgi->image_url)) {
					unlink($photos_path.'/'.$pgi->image_url);
				}
				
				$pgi->delete();
				
				if($is_main) {
					$pgi_main = Product_group_images::where('group_id',$group_id)->orderBy('rank','DESC')->first();
					
					if(count((array)$pgi_main) > 0) {
						$pgi_main->is_main = 1;
						$pgi_main->save();
					}
				}
				
				Artisan::call('cache:clear');
				echo json_encode(array(
					'complete' => true
				));
			} else {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong request'
				));
			}
			
			
		}
	}
	
	public function delete_car_image(Request $request) {
		if ($request->ajax()) {
			$car_id = $request->car_id;
			$image_id = $request->image_id;
			
			$pgi = Car_image::where('id',$image_id)->where('car_id',$car_id)->first();
			
			if (count((array)$pgi) > 0) {
				$is_main = $pgi->is_main;
				$photos_path = base_path() . '/public/uploads/car_images/'.$car_id;
				
				if(is_file($photos_path.'/'.$pgi->image_url)) {
					unlink($photos_path.'/'.$pgi->image_url);
				}
				
				$pgi->delete();
				
				if($is_main) {
					$pgi_main = Car_image::where('car_id',$car_id)->orderBy('rank','DESC')->first();
					
					if(count((array)$pgi_main) > 0) {
						$pgi_main->is_main = 1;
						$pgi_main->save();
					}
				}
				
				echo json_encode(array(
					'complete' => true
				));
			} else {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong request'
				));
			}
			
			
		}
	}
	
	public function delete_tire_image(Request $request) {
		if ($request->ajax()) {
			$tire_id = $request->tire_id;
			$image_id = $request->image_id;
			
			$pgi = Tire_image::where('id',$image_id)->where('tire_id',$tire_id)->first();
			
			if (count((array)$pgi) > 0) {
				$is_main = $pgi->is_main;
				$photos_path = base_path() . '/public/uploads/car_images/'.$tire_id;
				
				if(is_file($photos_path.'/'.$pgi->image_url)) {
					unlink($photos_path.'/'.$pgi->image_url);
				}
				
				$pgi->delete();
				
				if($is_main) {
					$pgi_main = Car_image::where('tire_id',$tire_id)->orderBy('rank','DESC')->first();
					
					if(count((array)$pgi_main) > 0) {
						$pgi_main->is_main = 1;
						$pgi_main->save();
					}
				}
				
				echo json_encode(array(
					'complete' => true
				));
			} else {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong request'
				));
			}
			
			
		}
	}
	public function send_chat_opentowork_holder(Request $request) {
		if ($request->ajax()) {
			$opc_id = $request->id;
			$matching_users = [];

				$opc = Opportunity_card::find($opc_id);
				$dbskills = $opc->fields;
				$skills = [];					
				if (trim($dbskills) != '') {
					$skills = json_decode($dbskills,true);
				}
				$targetopc  = Opentowork_card::all();
				foreach($targetopc as $key => $value){
					$opc_fields_json = $value['fields'];
					$targetSkills = [];
					
					if (trim($opc_fields_json) != '') {
						$targetSkills = json_decode($opc_fields_json,true);
					}
					$matched_skills = array_intersect($targetSkills, $skills);
					$count = count($matched_skills);
					if($count > 0) {
						array_push($matching_users, $value['user_id']);
					}
				}


				if(count($matching_users) > 0){
					$user_id = 2; //Manuel
					$message = "{CARD".$opc->id."}";
					foreach($matching_users as $key => $to_id){
						$conversation_key = $to_id > $user_id ? md5($user_id.'_'.$to_id) : md5($to_id.'_'.$user_id);
						$umc = User_message_conversation::where('conversation_key',$conversation_key)->first();
						
						if($umc === null) {
							$umc = new User_message_conversation;
							$umc->conversation_key = $conversation_key;
						}
						
						$umc->last_message = $message;
						$umc->last_from_id = $user_id;
						$umc->last_to_id = $to_id;
						$umc->is_read = 0;
						$umc->sent_remind_email = 0;
						$umc->save();
									
						$conversation_id = $umc->id;
						$um = new User_message;
						$um->conversation_id = $conversation_id;
						$um->from_id = $user_id;
						$um->to_id = $to_id;
						$um->is_read = 0;
						$um->message = $message;;
						$um->save();
					}
				}
				echo json_encode(array(
					'complete' => true,
				));
			
		}
	}
	/*public function get_product_group_data(Request $request) {
		if ($request->ajax()) {
			$data = $request->all();
			$group_id  = isset($data['group_id']) ? $data['group_id'] : false;
			
			if($group_id === false) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong request'
				));exit;
			}
			
			$pg = Product_group::find($group_id);
			
			if (count((array) $pg) == 0) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Group does not exist'
				));exit;
			}
			
			echo json_encode(array(
				'complete' => true,
				'pg' => $pg,
				'pg_items' => $pg->items
			));
		}
	}*/
}
