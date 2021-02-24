<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\URL;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
	
	public function coupons()
    {
        return $this->hasMany(User_coupon::class,'user_id','id');
    }
	
	public function profile_image($no_image_return_type = false) {
		
		if(trim($this->profile_image_cropped) != '') {
			$path = base_path() . '/public/uploads/profile/'.$this->id.'/'.$this->profile_image_cropped;
					
			if (is_file($path)) {
				$profile_image_src = URL::to('/').'/uploads/profile/'.$this->id.'/'.$this->profile_image_cropped;
				return $profile_image_src;
			}				
		}
		
		if($no_image_return_type === true){
			return false;
		}
		
		// return 'https://ptetutorials.com/images/user-profile.png?88';
		return '/assets/images/icon-profile1.png';
	}
}
