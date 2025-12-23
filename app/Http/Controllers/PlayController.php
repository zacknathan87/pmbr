<?php

namespace App\Http\Controllers;

use App\Events\BetAdded;
use App\Models\BetType;
use App\Models\BetTypeGroup;
use App\Models\Game;
use App\Models\GameChannel;
use App\Models\GameRoom;
use Illuminate\Http\Request;
use Auth;

class PlayController extends Controller
{
  public function __construct()
  { }

  public function placeBetDice(Request $request)
  {

    $input = $request->all();

    if ($input) {
      $worker = new WorkerController();

      $game = Game::where('id', $input['game_id'])->first();
      $betTypesIds = $input['bet_type_ids'];


      $bet_type_ids = explode(",", $betTypesIds);
      $total =  $input['amount'] * count($bet_type_ids);

      // check user
      if (Auth::user()->is_active == 0) {
        return response()->json(['status' => 0, 'message' => __('app.account_suspended'), 'code' => 500]);
      }

      // check game
      if ($game->status_id != 2) {
        return response()->json(['status' => 0, 'message' => __('app.invalid_game')]);
      }

      // check balance
      if (Auth::user()->wallet->balance < $total) {
        return response()->json(['status' => 0, 'message' => __('app.not_enough_balance')]);
      }

      // place bet
      $bet = $worker->placeBet(Auth::user()->id, $game->id, $input['amount'], $betTypesIds);
      // event(new BetAdded($bet));

      return response()->json(['status' => 1]);
    }
  }

  public function placeBetNum(Request $request)
  {

    $input = $request->all();

    if ($input) {
      $worker = new WorkerController();

      $game = Game::where('id', $input['game_id'])->first();
      $betTypesIds = $input['bet_type_ids'];
      $betTypesIdsArray = explode(",", $betTypesIds);
      $betTypeId = $betTypesIdsArray[0];


      $total =  $input['amount'] * count($betTypesIdsArray);


      // check user
      if (Auth::user()->is_active == 0) {
        return response()->json(['status' => 0, 'message' => __('app.account_suspended'), 'code' => 500]);
      }

      // check game
      if ($game->status_id != 2) {
        return response()->json(['status' => 0, 'message' => __('app.invalid_game')]);
      }

      // check balance
      if (Auth::user()->wallet->balance < $total) {
        return response()->json(['status' => 0, 'message' => __('app.not_enough_balance')]);
      }


      if (isset($input['jackpot']) && $input['jackpot'] == 1) {

        // place bet
        $bet = $worker->placeBetJackpot(Auth::user()->id, $game->id, $input['amount'], $betTypesIds);
      } else {

        // place bet
        $bet = $worker->placeBet(Auth::user()->id, $game->id, $input['amount'], $betTypesIds);
      }

      // event(new BetAdded($bet));

      return response()->json(['status' => 1]);
    }
  }
}
