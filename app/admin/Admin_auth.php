<?php

namespace App\Admin;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin_auth extends Authenticatable
{
    protected $guard = 'admin';
    protected $table = 'admin_users';

    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'created_at', 'updated_at', 'remember_token'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
    	return $this->belongsTo('App\Models\Role')->withDefault(function ($data) {
            foreach($data->getFillable() as $dt){
                $data[$dt] = __('Deleted');
            }
        });
    }

    public function IsSuper(){
        if ($this->id == 1) {
           return true;
        }
        return false;
    }

    public function sectionCheck($value){
        $sections = explode(" , ", $this->role->section);
        if (in_array($value, $sections)){
            return true;
        }else{
            return false;
        }
    }


}
