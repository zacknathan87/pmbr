<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    
    protected $fillable = [];

    protected $dates = [];

    protected $guarded = [];

    public static $rules = [
        // Validation rules
    ];

    public function userDetail()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function transactionTypeDetail() 
    {
        return $this->hasOne('App\Models\TransactionType', 'id', 'transaction_type_id');
    }
}
