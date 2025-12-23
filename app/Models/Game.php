<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    //
    
    protected $fillable = [];

    protected $dates = [];

    protected $guarded = [];

    public static $rules = [
        // Validation rules
    ];

    public function allBets() {
        return $this->hasMany('App\Models\Bet', 'game_id', 'id')->where('is_fake', 0);
    }

    public function gameType() {
        return $this->hasOne('App\Models\GameType', 'id', 'game_type_id');
    }

    public function betTypes() {
        return $this->hasMany('App\Models\BetType', 'game_type_id', 'game_type_id');
    }

    public function betTypeGroup() {
        return $this->hasMany('App\Models\BetTypeGroup', 'game_type_id', 'game_type_id')->where('parent_id', null)->with('betType')->with('childBetTypeGroup');
    }

    public function gameChannel() {
        return $this->hasOne('App\Models\GameChannel', 'id', 'game_channel_id');
    }

    public function totalBetsCount() {
        return $this->hasMany('App\Models\Bet', 'game_id', 'id')->where('is_fake', 0)->count();
    }

    public function totalBetsAmount() {
        return $this->hasMany('App\Models\Bet', 'game_id', 'id')->where('is_fake', 0)->sum('amount');
    }
}
