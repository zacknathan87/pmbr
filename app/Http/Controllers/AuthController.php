<?php

namespace App\Http\Controllers;

use App\Models\Rank;
use App\Models\UserWallet;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\User;

class AuthController extends Controller
{
  /**
   * Register a new user
   */
  public function register(Request $request)
  {
    $v = Validator::make($request->all(), [
      'username' => 'required|alpha_dash|unique:users',
      'password'  => 'required|min:3',
      'contact'  => 'required',
    ]);
    if ($v->fails()) {
      return response()->json([
        'status' => 0,
        'errors' => implode(",", $v->messages()->all())
      ], 200);
    }

    $worker = new WorkerController();

    $input = $request->all();

    $username = $input['username'];

    $parent_id = '';
    if (isset($input['parent_id'])) {
      $parent_id = $input['parent_id'];
    } else {
      $referrer = User::where('username', $input['referrer'])->first();
      if (!$referrer) {
        return response()->json(['status' => 0, 'errors' => 'Invalid Referrer.'], 200);
      }

      $parent_id = $referrer->id;
    }

    $rank = Rank::first();

    // create user
    $user = User::create([
      'username' => $username,
      'parent_id' => $parent_id,
      'name' => $input['name'],
      'nric' => $input['nric'],
      'contact' => $input['contact'],
      'country_id' => isset($input['country']) ? $input['country'] : '2',
      'password' => bcrypt($input['password']),
      'password_text' => $input['password'],
      'created_by' => NULL,
      'rank_id' =>  $rank->id,
    ]);

    // create wallet
    UserWallet::create([
      'user_id' => $user->id,
      'balance' => 0,
      'wallet_type' => 1
    ]);

    return response()->json(['status' => 1], 200);
  }

  /**
   * Login user and return a token
   */
  public function login(Request $request)
  {
    $credentials = $request->only('username', 'password');
    if ($token = $this->guard()->attempt($credentials)) {

 
      $user = User::where('username', $request->only('username'))->first();
      if($user->is_active == 0) {
        return response()->json(['status' => 0, 'error' => 'Account Suspended'], 401);
      }
      
      return response()->json([
        'status' => 1,
        'token' => $token,
        'data' => $user
      ], 200)->header('Authorization', $token);
    }
    return response()->json(['status' => 0, 'error' => __('app.did_not_match')], 401);
  }

  /**
   * Logout User
   */
  public function logout()
  {
    $this->guard()->logout();
    return response()->json([
      'status' => 1,
      'msg' => 'Logged out Successfully.'
    ], 200);
  }

  /**
   * Get authenticated user
   */
  public function user(Request $request)
  {
    $user = User::find(Auth::user()->id);

    $user->load('rank');
    $user->load('wallet');
    $user->load('referrer');
    $user->load('country');

    $data = $user->toArray();
    $data['total_bets'] = $user->totalBetsAmount();
    $data['total_win_bets'] = $user->totalWinning();

    return response()->json([
      'status' => 1,
      'data' => $data
    ]);
  }

  /**
   * Refresh JWT token
   */
  public function refresh()
  {
    if ($token = $this->guard()->refresh()) {
      return response()
        ->json(['status' => 1], 200)
        ->header('Authorization', $token);
    }
    return response()->json(['error' => 'refresh_token_error'], 401);
  }

  /**
   * Return auth guard
   */
  private function guard()
  {
    return Auth::guard();
  }
}
