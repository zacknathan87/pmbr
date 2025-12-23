<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameRoom extends Model
{
     //
     protected $fillable = [];

     protected $dates = [];
 
     protected $guarded = [];
 
     public static $rules = [
         // Validation rules
     ];
 
     protected $table = 'game_room';

     public function gameType() {
        return $this->hasOne('App\Models\GameType', 'id', 'game_type_id');
    }

    public function gameChannel() {
        return $this->hasOne('App\Models\GameChannel', 'id', 'game_channel_id');
    }
}
