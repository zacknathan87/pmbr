<?php

namespace App\Http\Controllers;

use App\Events\BetAdded;
use App\Models\BetType;
use App\Models\Game;
use App\Models\GameChannel;
use App\Models\GameRoom;
use Illuminate\Http\Request;
use Auth;

class ResultController extends Controller
{
  public function __construct()
  { }

  public function getResult(Request $request)
  {

    $input = $request->all();

    $date = '';
    $gameChannelId = '';

    if (isset($input['date'])) {
      $date = date('Y-m-d', strtotime($input['date']));
    } else {
      $date = date('Y-m-d');
    }


    if (isset($input['game_type_id'])) {
      $gameChannelId = $input['game_type_id'];
    } else {
      $gameChannelId = 1;
    }

    if (isset($input['game_channel_id'])) {
      $gameChannelId = $input['game_channel_id'];
    } else {
      $gameChannelId = 1;
    }


    // $pastGames = Game::whereDate('start_at', $date)
    //   ->where('game_channel_id', $gameChannelId)
    //   ->where('status_id', 4)
    //   ->orderBy('id', 'desc')
    //   ->paginate(10)
    //   ->appends($request->query());
    $pastGames = Game::whereDate('start_at', $date)
      ->where('game_channel_id', $gameChannelId)
      ->where('status_id', 4)
      ->orderBy('id', 'desc')
      ->paginate($input['limit'])
      ->appends($request->query());

    return response()->json(['status' => 1,'data' => $pastGames], 200);
  }
}
