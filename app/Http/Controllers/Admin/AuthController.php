<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Models\Member;

class AuthController extends Controller {


  use AuthenticatesUsers;

  public function __construct() {
    $this->middleware('guest:admin')->except('logout');
  }


  public function login(Request $request)  {
    $adata = [];

    $input = $request->all();

    if ($input) {
        $validator = Validator::make($input, [
                'username' => 'required',
                'password' => 'required',
        ]);

        if ($validator->fails()) {
            return  back()->with('validation_errors', $validator->errors() );
        } else {
          if (Auth::guard('admin')->attempt(['username' => $input['username'], 'password' => $input['password']])) {
              // Authentication passed...
             
              $data = array('username' => $input['username']);
              return redirect('/admin-management/dashboard');

          } else {
            return back()->with('errors', __('app.admin_error_login'));
          }
        }
    }

    return view('admin.auth.login', $adata);
  }

  public function logout(Request $request) {
    Auth::guard('admin')->logout();
    return redirect('/admin-management/login');
  }
}