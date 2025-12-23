<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bet;
use App\Models\Game;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Hash;

use App\User;

class DashboardController extends Controller {

  public function __construct() {
    //dd(Hash::make('2uVZHdgpMk', ['rounds' => 12]));
  }

  public function index() {
    $adata = [];

    if(Auth::guard('admin')->user()->level == 1) {
      $adata['total_user'] = User::where('is_active', 1)->count();
      $adata['total_game'] = Game::count();
      $adata['total_game_ended'] = Game::where('status_id', 4)->count();
      $adata['total_bets'] = Bet::where('is_fake', 0)->count();
      $adata['total_bets_amount'] = Bet::where('is_fake', 0)->sum('amount');
      $adata['total_bets_win'] = Bet::where('is_fake', 0)->where('is_win', 1)->count();
      $adata['total_bets_win_amount'] = Bet::where('is_fake', 0)->where('is_win', 1)->sum('win_amount');
      $adata['pending_withdrawal'] = 0;
      $adata['user_winning'] = 0;
      

      return view('admin.dashboard.index', $adata);
    
    } else {
      $adata['total_user'] = User::where('created_by',  Auth::guard('admin')->user()->id)->count();

    return view('admin.dashboard.agent', $adata);

    }
    
    

    
  }

}