<?php

namespace App\Services;

use App\Http\Controllers\WorkerController;
use App\Models\Bet;
use App\Models\Game;
use App\Models\User;
use Hash;
use Illuminate\Support\Carbon;

class Game5numService
{

  private $worker;

  public function __construct()
  {
    $this->worker = new WorkerController();
  }

  public function autoSetWinning($gameId = null)
  {
    if ($gameId) {

      $game = Game::where('id', $gameId)->first();

      $weightBet = json_decode(getSetting('result_percentage_5_number'));

      $bets = Bet::where('game_id', $game->id)->where('is_fake', 0)->get();
      $betData = $this->simplifyBets($bets, $game->game_type_id);

      $nums = [];

      foreach ($betData as $k => $b) {

        // find lowest amount
        // lowest including 0 bet
        $totalData = array_map(function ($r) {
          return $r['total'];
        }, $b);
        $allLowest = array_keys($totalData, min($totalData));

        // if lowest is only bet no 0
        if (count($allLowest) == 1 && isset($allLowest[0])) {
          $nums[] = getRandomWeightedElement($weightBet);
        } else if (count($allLowest) == 1) {
          $finalNo = array_keys($allLowest)[0];
        } else {
          $newWeightBet = [];
          foreach ($allLowest as $al) {
            $newWeightBet[] = $weightBet[$al];
          }
          $nums[] = getRandomWeightedElement($weightBet);
        }
      }


      $numsTotal = 0;
      foreach ($nums as $n) {
        $numsTotal += $n;
      }

      $game->no = implode(",", $nums);
      $game->result_no = $numsTotal;
      $game->save();

      return true;
    }
  }

  public function checkResult($gameId)
  {
    if ($gameId) {
      $game = Game::where('id', $gameId)->first();
      $bets = $game->allBets;

      $gameWinningNum =  explode(',', $game->no);
      $gameTotalNum = $game->result_no;

      if (!$bets->isEmpty()) {

        $betWin = [];
        foreach ($bets as $b) {

          $betRef = explode("_", $b->bet_ref);

          // check bet ball
          if($betRef[0] == 'num') {
            $betBall = $betRef[1];

            if ($gameWinningNum[$betBall - 1] == $b->betType->value) {
              $betWin[] = $b;
            }
          }

          // check bet total 
          if($betRef[0] == 'total') {
            $betArray = explode(",",  $b->betType->value);
            if (in_array($gameTotalNum, $betArray)) {
              $betWin[] = $b;
            }
          }

           // check bet total 
           if($betRef[0] == 'unique') {
            if(in_array($b->betType->value, $gameWinningNum)) {
              $betWin[] = $b;
            }
          }
          
        }

        if (!empty($betWin)) {

          foreach ($betWin as $b) {
            // get game win ratio
            $winRatio = $b->odd;

            $user = $b->user;
            $winAmount = $b->amount * $winRatio;

            // update bet data
            $b->win_amount = $winAmount;
            $b->win_ratio = $winRatio;
            $b->is_win = 1;
            $b->save();

            // add transaction to user wallet
            $conf = [
              'user_id' => $user->id,
              'amount' => $winAmount,
              'wallet_type' => 1,
              'transaction_type_id' => 4, // 4 - winning
              'description' => 'Win Game ID#' . $game->id,
            ];
            $this->worker->addTransaction($conf);
          }
        }
      }
    }
  }

  public function simplifyBets($bets, $gameTypeId)
  {
    $betData = [];

    for ($i = 0; $i < 5; $i++) {
      for ($j = 0; $j <= 9; $j++) {
        $betData[$i][$j] = [
          'count' => 0,
          'total' => 0,
          'total_odd' => 0,
          'percent' => 0,
        ];
      }
    }


    $totalBet = 0;
    $totalAmount = 0;

    foreach ($bets as $b) {

      $betRef = explode("_", $b->bet_ref);
      if ($betRef[0] == 'num') {
        $num = $betRef[1] - 1;

        if ($b->betType->type == 'number') {
          $betData[$num][$b->betType->value]['count']++;
          $betData[$num][$b->betType->value]['total'] += $b->amount;
          $betData[$num][$b->betType->value]['total_odd'] += $b->betType->odd;

          $totalAmount += $b->amount;
          $totalBet++;
        } else {

          if ($b->betType->final_no == 0) {
            $betNums = explode(',', $b->betType->value);

            foreach ($betNums as $bn) {

              $betData[$num][$bn]['count']++;
              $betData[$num][$bn]['total'] += $b->amount;
              $betData[$num][$bn]['total_odd'] += $b->betType->odd;

              $totalAmount += $b->amount;
              $totalBet++;
            }
          }
        }
      }
    }



    return $betData;
  }
}
