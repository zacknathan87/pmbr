<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminMenu extends Model
{
    //
    
    protected $fillable = [];

    protected $dates = [];

    protected $guarded = [];

    public static $rules = [
        // Validation rules
    ];

    protected $table = 'admin_menus';
    
    // relationship
  
  
    public static function getMenus($parent_id = 0) {
          
          $menus = AdminMenu::where('parent_id', $parent_id)->where('is_active', 1)->get();
  
          return($menus);
    }
 
}
