<?php
 
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Mark extends Model
{
    protected $table = 'marks';
	
	public function models()
    {
        return $this->hasMany(Mark_model::class,'mark_id','id')->orderBy('name','ASC');
    }
}
