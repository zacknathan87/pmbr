<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Hash;

use App\Models\Member;

class AccountController extends Controller
{

  public function __construct()
  { }

  public function index()
  {

    return redirect(url('admin-management/dashboard'));
  }

  public function changePassword(Request $request)
  {
    $adata = [];

    $input = $request->all();

    $admin_user = Auth::guard('admin')->user();

    if ($input) {

      $validator = Validator::make($input, [
        'current_password' => 'required',
        'new_password' => 'required',
        'confirm_new_password' => 'required|same:new_password',
      ]);

      if ($validator->fails()) {
        return back()->with('validation_errors', $validator->errors());
      } else {
        
        if (Hash::check($input['current_password'], $admin_user->password)) {
          // Success

          if ($input['current_password'] == $input['new_password']) {
            return redirect('/admin-management/account/change_password')->with('errors', __('app.password_same_error'));
          }

          $admin_user->password = bcrypt($input['new_password']);
          $admin_user->password_text = $input['new_password'];
          $admin_user->save();

          $status = '<b>Updated!</b>';

          return redirect('/admin-management/account/change_password')->with('status', $status);
        } else {

          return redirect('/admin-management/account/change_password')->with('errors', 'Invalid current password');
        }
      }
    }

    return view('admin.account.change_password', $adata);
  }
}
