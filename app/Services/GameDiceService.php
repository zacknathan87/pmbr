<?php

namespace App\Services;

use App\Http\Controllers\WorkerController;
use App\Models\Bet;
use App\Models\BetTypeGroup;
use App\Models\Game;
use App\Models\User;
use Hash;
use Illuminate\Support\Carbon;

class GameDiceService
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

      $weightBet = json_decode(getSetting('result_percentage_dice'));

      $bets = Bet::where('game_id', $game->id)->where('is_fake', 0)->get();

      $betData = $this->simplifyBets($bets, $game->game_type_id);

      // find lowest amount
      // lowest including 0 bet
      $totalData = array_map(function ($r) {
        return $r['total'];
      }, $betData);
      $allLowest = array_keys($totalData, min($totalData));

      // if lowest is only bet no 0
      if (count($allLowest) == 1 && isset($allLowest[0])) {
        $finalNo = getRandomWeightedElement($weightBet);
      } else if (count($allLowest) == 1) {
        $finalNo = array_keys($allLowest)[0];
      } else {
        $newWeightBet = [];
        foreach ($allLowest as $al) {
          $newWeightBet[] = $weightBet[$al];
        }
        $finalNo = getRandomWeightedElement($newWeightBet);
      }


      // get dice number
      $d1 = $d2 = $d3 = 0;
      $dice = $this->getDiceNumber($finalNo);

      $game->no = implode(",", $dice);
      // $game->dice_1 = $dice[0];
      // $game->dice_2 = $dice[1];
      // $game->dice_3 = $dice[2];
      $game->result_no = $finalNo;
      $game->save();


      return true;
    }
  }

  public function checkResult($gameId)
  {
    if ($gameId) {
      $game = Game::where('id', $gameId)->first();
      $bets = $game->allBets;

      if (!$bets->isEmpty()) {

        $betWin = [];
        foreach ($bets as $b) {
          if (in_array($game->result_no, explode(',', $b->betType->value))) {
            $betWin[] = $b;
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

  public function getDiceNumber($finalNo)
  {
    $dice = [0, 0, 0];

    $dice = shuffle_assoc($dice);

    $total = 0;
    $c = 0;
    foreach ($dice as $k => $d) {

      $max = 9;
      if ($c == 0) {
        if ($finalNo / 3 > 9) {
          $max = 9;
        } else {
          $max = $finalNo / 3;
        }
        $dice[$k] = mt_rand(0, $max);
      } else if ($c == 1) {
        if (floor($finalNo) / 2 > 9) {
          $max = 9;
        } else {
          $max = floor($finalNo / 2);
        }
        $dice[$k] = mt_rand(0, $max);
      } else {
        $left = $finalNo - $total;
        if ($left > 9) {
          $dice[$k] = 9;

          $balance = $left - 9;

          $fix = true;
          while ($fix) {
            foreach ($dice as $sk => $sd) {
              if ($balance > 0) {
                if ($sd + $balance <= 9) {
                  $dice[$sk] = $sd + $balance;
                  $balance = 0;
                } else {
                  $tmp = $dice[$sk];
                  $dice[$sk] = 9;
                  $balance = $balance - $dice[$sk] + $tmp;
                }
              }


              if ($balance == 0) {
                $fix = false;
              }
            }
          }
        } else {
          $dice[$k] = $left;
        }
      }

      $total += $dice[$k];
      $c++;

      // var_dump($dice[$k]);
      // var_dump($total);
      // echo '<br>';
    }

    sort($dice);
    return $dice;
  }

  public function simplifyBets($bets, $gameTypeId)
  {
    $betData = [];

    for ($i=0; $i<=27; $i++) {
        $betData[$i] = [
          'count' => 0,
          'total' => 0,
          'percent' => 0,
        ];
    }

    $totalBet = 0;
    $totalAmount = 0;

    foreach ($bets as $b) {

      if ($b->betType->type == 'number') {
        $betData[$b->betType->value]['count']++;
        $betData[$b->betType->value]['total'] += $b->amount;

        $totalAmount += $b->amount;
        $totalBet++;
      } else {
        $betNums = explode(',', $b->betType->value);

        foreach ($betNums as $bn) {
          $betData[$bn]['count']++;
          $betData[$bn]['total'] += $b->amount;

          $totalAmount += $b->amount;
          $totalBet++;
        }
      }
    }


    return $betData;
  }

}
