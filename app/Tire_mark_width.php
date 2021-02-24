<?php
 
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Tire_mark_width extends Model
{
    protected $table = 'tire_mark_widths';
	
	public function group_name($id) {
		if($id == 1) {
			return 'Valeurs principales';
		} else if($id == 2) {
			return 'Autres valeurs';
		} 
	}
}
