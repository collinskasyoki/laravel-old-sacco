U<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    protected $fillable = [
    	'user_id', 'amount', 
    ];

    public function user(){
    	return $this->belongsTo('\App\Member');
    }
}
