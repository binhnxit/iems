<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IeCat extends Model
{
	protected $table = 'ie_cat';

    protected $fillable = [
        'id','cat_name', 'level', 'color','cat_by',
    ];

    public $timestamps = true;

    public function IeData(){
    	return $this->hasMany('App\IeData', 'cat_id', 'id');
    }
    
    public function countIeData(){
    	return $this->hasMany('App\IeData', 'cat_id', 'id')->count();
    }
}
