<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{

    protected $dates = ['deleted_at'];

    protected $fillable = [
    	'member_id', 'loan_id', 'paid_by_id', 'amount', 'received_date', 'paid_by'
    ];

    public function members(){
    	return $this->belongsTo('\App\Member');
    }

    public function paid_by(){
    	return $this->hasOne('\App\Member', 'id', 'paid_by_id');
    }

    public function loan(){
    	return $this->hasOne('\App\Loan', 'id', 'loan_id');
    }
}
