<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentWallet extends Model
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
  
}
