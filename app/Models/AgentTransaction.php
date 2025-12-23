<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentTransaction extends Model
{
    //

    protected $fillable = [];

    protected $dates = [];

    protected $guarded = [];

    public static $rules = [
        // Validation rules
    ];

    public function adminDetail()
    {
        return $this->hasOne('App\Models\Admin', 'id', 'admin_id');
    }

    public function transactionTypeDetail() 
    {
        return $this->hasOne('App\Models\TransactionType', 'id', 'transaction_type_id');
    }

}
