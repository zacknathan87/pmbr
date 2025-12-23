<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameChannel extends Model
{
    //
    protected $fillable = [];

    protected $dates = [];

    protected $guarded = [];

    public static $rules = [
        // Validation rules
    ];

    protected $table = 'game_channel';

    public function gameType() {
        return $this->hasOne('App\Models\GameType', 'id', 'game_type_id');
    }
}
