<?php
 
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Mark_model extends Model
{
    protected $table = 'mark_models';
	
	public function motorizations()
    {
        return $this->hasMany(Mark_model_motorization::class,'model_id','id')->orderBy('name','ASC');
    }
	
	public function mark()
    {
        return $this->belongsTo(Mark::class,'mark_id','id');
    }
}
