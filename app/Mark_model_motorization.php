<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Mark_model_motorization extends Model
{
    protected $table = 'mark_model_motorizationes';

	public function powers()
    {
        return $this->hasMany(Mark_model_motorization_power::class,'motorization_id','id')->orderBy('name','ASC');
    }
}
