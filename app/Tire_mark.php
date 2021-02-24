<?php
 
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Tire_mark extends Model
{
    protected $table = 'tire_marks';
	
	public function group_name($id) {
		if($id == 1) {
			return 'PREMIUM BRANDS';
		} else if($id == 2) {
			return 'QUALITY BRANDS';
		} else if($id == 3) {
			return 'ECO BUDGET BRANDS';
		} else if($id == 4) {
			return 'RETREADED BRANDS';
		}
	}
}
