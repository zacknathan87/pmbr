<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Models\Member;

class AdminController extends Controller {

  public function __construct() {
  }

  public function index() {

    return redirect(url('admin-management/dashboard'));
  }


}