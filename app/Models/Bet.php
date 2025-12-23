<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    //
    
    protected $fillable = [];

    protected $dates = [];

    protected $guarded = [];

    public static $rules = [
        // Validation rules
    ];

    public function betType() {
        return $this->hasOne('App\Models\BetType', 'id', 'bet_type_id');
    }

    public function game() {
        return $this->hasOne('App\Models\Game', 'id', 'game_id');
    }

    public function user() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function userDetail() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
