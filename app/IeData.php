<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IeData extends Model
{
    protected $table = 'ie_data';

    protected $fillable = [
        'id','note', 'amount', 'ie_by', 'ie_type', 'cat_id', 'created_at', 'updated_at'
    ];

    public $timestamps = true;

    public function IeCat(){
    	return $this->belongsTo('App\IeCat', 'cat_id');
    }
    
    public function IeBy(){
    	return $this->belongsTo('App\User', 'id');
    }
}
