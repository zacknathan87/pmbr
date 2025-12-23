<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BetType extends Model
{
    //
    protected $fillable = [];

    protected $dates = [];

    protected $guarded = [];

    public static $rules = [
        // Validation rules
    ];

    protected $table = 'bet_type';

    public function betTypeGroup()
    {
      return $this->hasOne('App\Models\BetTypeGroup', 'id', 'bet_type_group_id');
    }
  
}
