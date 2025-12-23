<?php

namespace App\Http\Controllers;

use App\Models\Bet;
use App\Models\BetType;
use App\Models\GameChannel;
use App\Models\GameRoom;
use App\Models\Game;
use App\Models\GameType;
use Illuminate\Http\Request;
use Auth;

class GameController extends Controller
{
  public function __construct()
  { }

  public function getGame($game_type, $channel_uuid)
  {

    $gameType = GameType::where('uuid', $game_type)->first();
    $gameChannel = GameChannel::where('uuid', $channel_uuid)->first();

    $now = date('Y-m-d H:i:s');

    $gameRunning = getSetting('game_running');

    if ($gameRunning) {

      $game = Game::where('game_type_id', $gameType->id)
        ->where('game_channel_id', $gameChannel->id)
        ->whereIn('status_id', [2, 3])
        ->whereDate('start_at', '<=', $now)
        ->orderBy('id', 'desc')
        ->first();

      if ($game) {

        // get past game
        $pastGame = Game::where('game_type_id', $gameType->id)
          ->where('game_channel_id', $gameChannel->id)
          ->where('status_id', 4)
          ->orderBy('id', 'desc')
          ->whereDate('end_at', '<=', $now)
          ->first();

        $game->past_game = [];
        if ($pastGame) {
          $game->past_game = $pastGame;
        }

        // get latest 3 bet for the current game
        $bets = Bet::with('betType:id,type,value,name,name_code')
          ->with('user:id,username')
          ->where('game_id', $game->id)->orderBy('id', 'desc')->limit(3)->get()->toArray();

        $game->bets = [];
        if ($bets) {
          $game->bets = array_reverse($bets);
        }

        $game->load('betTypeGroup');
        $game->load('gameType');
        $game->load('gameChannel');
        
        return response()->json(['status' => 1, 'data' =>  $game]);
      } else {
        return response()->json(['status' => 0, 'code' => 2, 'msg' =>  'No game']);
      }
    } else {
      return response()->json(['status' => 0, 'code' => 1, 'msg' =>  'No game']);
    }
  }
}
