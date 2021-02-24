<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mark; 
use App\Mark_model; 
use App\Mark_model_motorization; 
use App\Mark_model_motorization_power; 
use App\Product; 
use App\Product_group; 
use App\Product_group_item; 
use App\Product_group_images; 

class Mark_treeController extends Controller
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
		$marks = Mark::orderBy('name','asc')->get();
		$tree_html = '';
			
		foreach($marks as $mark) {
			$mark_class = '';
			$mark_part = '<a href="#">'.$mark->name.'</a>';
			
			if (!empty($mark->models)) {
				$mark_class = 'expandable';
				$mark_part = '<div class="hitarea expandable-hitarea"></div><span>'.$mark->name.'</span>';
			}
					
			$tree_html .= '<li class="'.$mark_class.'">'.$mark_part;
				if (count($mark->models) > 0) {
					$tree_html .= '<ul style="display: none;">';
						foreach($mark->models as $model) {
							$model_class = '';
							$model_part = '<span>'.$model->name.'</span>';
							
							if (count($mark->models) > 0) {
								$model_class = 'expandable';
								$model_part = '<div class="hitarea expandable-hitarea"></div><span>'.$model->name.'</span>';
							}
							
							$tree_html .= '<li class="'.$model_class.'">'.$model_part;
								if (count($model->motorizations) > 0) {
									$tree_html .= '<ul style="display: none;">';
										foreach($model->motorizations as $motorization) {
											$motorization_class = '';
											$motorization_part = '<span>'.$motorization->name.'</span>';
											
											if (count($motorization->powers) > 0) {
												$motorization_class = 'expandable';
												$motorization_part = '<div class="hitarea expandable-hitarea"></div><span>'.$motorization->name.'</span>';
											}
											
											$tree_html .= '<li class="'.$motorization_class.'">'.$motorization_part;
												if (count($motorization->powers) > 0) {
													$tree_html .= '<ul style="display: none;">';
														foreach($motorization->powers as $power) {
															$power_class = '';
															$power_part = '<span>'.$power->name.'</span>';
																					
															
															$tree_html .= '<li class="'.$power_class.'">'.$power_part;
															
															$tree_html .= '</li>';
														}
													$tree_html .= '</ul>';
												}
											$tree_html .= '</li>';
										}
									$tree_html .= '</ul>';
								}
							$tree_html .= '</li>';
						}
					$tree_html .= '</ul>';
				}
			$tree_html .= '</li>';
		}
		
		return view('admin/mark_tree.index',[
			'tree_html' => $tree_html
		]);
	}
	
	 /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = [];
        if(Auth::user()->isAdmin())
            $users = User::all();

        return view('services.new',['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validation($request);
        $service = new Service;
        $service->service_name = $request->service_name;
        $service->service_description = $request->service_description;
        $service->abbreviation = $request->abbreviation;
		if(trim($request->SanDataID) != ''){
			$service->SanDataID = $request->SanDataID;
		}
				
		if(trim($request->calculate_rate_as) != ''){
			$service->calculate_rate_as = $request->calculate_rate_as;
		}
		
        $service->save();
		$insertedId = $service->id;
		
		$admin_log = new Admin_log;
		$log_data = array(
			'user_id'     => Auth::id(),
			'action'      => 'Create Service',
			'action_type' => 'Create',
			'function'    => 'ServiceController.store',
			'table_affected' => 'services',
			'primary_key_field' => 'id',
			'primary_key_value' => $insertedId,
			'submitted_data'    => json_encode($request->all()),
			'created_at'        => date("Y-m-d H:i:s")
		);
		$admin_log->add_log($log_data);
			
        $message = 'Service Created Successfully';
        return redirect()->action('ServiceController@index')->with('message',$message);
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
        $service = Service::find($id);
        $users = [];
        		
		return view('services.edit',[ 'element' => $service, 'users' => $users ]);
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
        $service = Service::find($id);
     	$this->validation($request);
		$service->service_name = $request->service_name;
		$service->service_description = $request->service_description;
		$service->abbreviation = $request->abbreviation;
		
		if(trim($request->SanDataID) != ''){
			$service->SanDataID = $request->SanDataID;
		}
		
		if(trim($request->calculate_rate_as) != ''){
			$service->calculate_rate_as = $request->calculate_rate_as;
		}
		
		$service->save();
				
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
        $service = Service::find($id);
        $service->delete();
		
        $message = 'Service Deleted Successfully';
        return redirect()->action('ServiceController@index')->with('message',$message);
       
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