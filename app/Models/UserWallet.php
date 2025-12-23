<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWallet extends Model
{
     //
     protected $fillable = [];

     protected $dates = [];
 
     protected $guarded = [];
 
     public static $rules = [
         // Validation rules
     ];
 
     protected $table = 'user_wallets';


    public function userDetail()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
