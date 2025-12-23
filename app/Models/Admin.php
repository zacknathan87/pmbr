<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $fillable = [];

    protected $dates = [];

    protected $guarded = [];

    public static $rules = [
        // Validation rules
    ];

    public function wallet()
    {
        return $this->hasOne('App\Models\AgentWallet', 'admin_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\AgentTransaction', 'id', 'admin_id');
    }
    

}
