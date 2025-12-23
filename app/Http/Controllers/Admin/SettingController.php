<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\WorkerController;
use App\Models\Setting;
use App\User;
use Illuminate\Http\Request;
use Validator;
use Auth;


class SettingController extends Controller
{

  public function __construct()
  { }

  public function index()
  {
    $adata = [];



    return view('admin.setting.index', $adata);
  }

 
  public function update(Request $request)
  {
    $adata = [];

    $input = $request->all();

    if ($input) {
      $validator = Validator::make($input, [
      ]);

      if ($validator->fails()) {
        return back()->with('validation_errors', $validator->errors());
      } else {

        unset($input['submit']);
        unset($input['_token']);
        unset($input['faux_start_at']);
        unset($input['faux_end_at']);

        foreach($input as $k=>$i) {
          $setting = Setting::where('key', $k)->first();
          if($setting) {
            $setting->value = $i;
            $setting->save();
          }
        }

        $status = 'Updated!';
        return back()->with('status', $status);
      }
    }


  }


}
