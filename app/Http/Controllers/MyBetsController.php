<?php

namespace App\Http\Controllers;

use App\Events\BetAdded;
use App\Models\Bet;
use App\Models\BetType;
use App\Models\Game;
use App\Models\GameChannel;
use App\Models\GameRoom;
use Illuminate\Http\Request;
use Auth;

class MyBetsController extends Controller
{
  public function __construct()
  { }

  public function getMyBets(Request $request)
  {

    $input = $request->all();

    $bets = Bet::with('betType')
      ->with('betType:id,name_code')
      ->with('game:id,start_at,game_channel_id,game_type_id')
      ->with('game.gameType:id,name_code')
      ->with('game.gameChannel:id,name_code')
      ->where('user_id', Auth::user()->id)
      ->orderBy('id', 'desc')
      ->paginate($input['limit'])
      ->appends($request->query());

    return response()->json(['status' => 1,'data' => $bets], 200);
  }
}
