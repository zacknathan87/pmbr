<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BetTypeGroup extends Model
{
    //
    protected $fillable = [];

    protected $dates = [];

    protected $guarded = [];

    public static $rules = [
        // Validation rules
    ];

    protected $table = 'bet_type_groups';

    public function childBetTypeGroup() {
        return $this->hasMany(BetTypeGroup::class, 'parent_id', 'id')->with('betType');
    }

    public function betType() {
      return $this->hasMany(BetType::class, 'bet_type_group_id', 'id');
    }
  
}
