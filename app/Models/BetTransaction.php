<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BetTransaction extends Model
{
  //

  protected $fillable = [];

  protected $dates = [];

  protected $guarded = [];

  public static $rules = [
    // Validation rules
  ];

  public function user()
  {
    return $this->hasOne('App\\User', 'id', 'user_id');
  }

  public function bet()
  {
    return $this->hasOne('App\Models\Bet', 'id', 'bet_id');
  }

  public function betType()
  {
    return $this->hasOne('App\Models\BetType', 'id', 'bet_type_id');
  }
}
