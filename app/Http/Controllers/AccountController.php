<?php

namespace App\Http\Controllers;

use App\Models\Bet;
use App\Models\BetType;
use App\Models\GameChannel;
use App\Models\GameRoom;
use App\Models\Game;
use App\User;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Hash;

class AccountController extends Controller
{
  public function __construct()
  { }

  public function getDownline(Request $request)
  {
    $downline = User::
      where('parent_id', Auth::user()->id)
      ->orderBy('id', 'desc')
      ->paginate(10)
      ->appends($request->query());

    $data = $downline->toArray();
    $res = [];
    $dd = [];

    if($data['data']) {
      foreach($downline as $k=>$d) {
        $dd['data'][$k]['today_bet'] = $d->todayBetAmount();
        $dd['data'][$k]['today_win'] = $d->todayWinning();
        $dd['data'][$k]['total_bet'] = $d->totalBetsAmount();
        $dd['data'][$k]['total_winning'] = $d->totalWinning();
        $dd['data'][$k]['username'] = $d->username;
      }
    } else {
      $res = $downline;
    }

    return response()->json(['status' => 1, 'data' => $dd], 200);
  }

  public function changePassword(Request $request)
  {

    $input = $request->all();

    if ($input) {

      $validator = Validator::make($input, [
        'current_password' => 'required',
        'new_password' => 'required',
        'confirm_new_password' => 'required|same:new_password',
      ]);

      if ($validator->fails()) {
        return response()->json(['status' => 0, 'errors' => $validator->errors()]);
      } else {

        if (Hash::check($input['current_password'], Auth::user()->password)) {
          // Success

          Auth::user()->password = bcrypt($input['new_password']);
          Auth::user()->password_text = $input['new_password'];
          Auth::user()->save();


          return response()->json(['status' => 1]);
        } else {
          return response()->json(['status' => 0, 'errors' => 'Invalid current password']);
        }
      }
    }
  }

  public function updateProfile(Request $request)
  {

    $input = $request->all();

    if ($input) {

      $validator = Validator::make($input, [
        'name' => 'required',
        'nric' => 'required',
        'contact' => 'required',
        'bank_name' => 'required',
        'bank_account_name' => 'required',
        'bank_account_no' => 'required',
      ]);

      if ($validator->fails()) {
        return response()->json(['status' => 0, 'errors' => $validator->errors()]);
      } else {

        // Success

        Auth::user()->name = $input['name'];
        Auth::user()->nric = $input['nric'];
        Auth::user()->contact = $input['contact'];
        Auth::user()->bank_name = $input['bank_name'];
        Auth::user()->bank_account_name = $input['bank_account_name'];
        Auth::user()->bank_account_no = $input['bank_account_no'];
        Auth::user()->bank_swift_code = $input['bank_swift_code'];
        Auth::user()->save();


        return response()->json(['status' => 1]);
      }
    }
  }
}
