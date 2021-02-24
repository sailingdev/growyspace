<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Admin\Admin_auth; 

class UserController extends Controller
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
		$admin_users = Admin_auth::all();
		return view('admin/users.index',[
			'admin_users' => $admin_users
		]);
	}
	
	 /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/users.add',[
			
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
			'user_name' => 'required|string|unique:admin_users,user_name' ,
			'password' => 'required|string|confirmed|min:8|',
		]);
		
		if ($v->fails())
		{
			return redirect()->back()->withInput()->withErrors($v->errors());
		}
		
		$admin_user = new Admin_auth;
		$admin_user->user_name = $request->user_name;
		$admin_user->password = bcrypt($request->password);
		$admin_user->save();
				
        $message = 'User Created Successfully';
        return redirect()->action('Admin\UserController@edit', ['id' => $admin_user->id])->with('message',  $message);
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
        $admin_user = Admin_auth::find($id);
        	
		return view('admin/users.edit',[ 
			'admin_user' => $admin_user
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
		$admin_user = Admin_auth::find($id);
		
		if(trim($request->password) != '') {
			$v = Validator::make($request->all(), [
				'user_name' => 'required|string',
				'password' => 'required|string|confirmed|min:8|',
			]);
			
			$admin_user->password = bcrypt($request->password);
		} else {
			$v = Validator::make($request->all(), [
				'user_name' => 'required|string',
			]);
		}
       
		if ($v->fails())
		{
			return redirect()->back()->withInput()->withErrors($v->errors());
		}
        
		$admin_user->user_name = $request->user_name;
		$admin_user->save();
				
		$message = 'Admin User Updated Successfully';
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
        $admin_user = Admin_auth::find($id);
        $admin_user->delete();
		
        $message = 'User Deleted Successfully';
        return redirect()->action('Admin\UserController@index')->with('message',$message);
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