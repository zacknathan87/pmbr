<?php

namespace App\Http\Controllers;

use App\Models\AgentTransaction;
use App\Models\AgentWallet;
use App\Models\Bet;
use App\Models\BetTransaction;
use App\Models\BetType;
use App\Models\BetTypeGroup;
use App\Models\Game;
use App\Models\Transaction;
use App\Models\TransactionType;
use App\Models\UserWallet;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
  public function __construct()
  { }



  public function placeBet($user_id, $game_id, $amount, $bet_type_ids)
  {

    $bet_type_ids = explode(",", $bet_type_ids);
    $total =  $amount * count($bet_type_ids);
    $game = Game::where('id', $game_id)->first();
    
    // add transaction 
    $conf = [
      'user_id' => $user_id,
      'amount' => $total,
      'wallet_type' => 1,
      'transaction_type_id' => 3, // 3 - bet
      'description' => 'Bet Game ID#' . $game_id,
    ];
    $this->addTransaction($conf);

    // add bet transaction 
    $betTransaction = BetTransaction::create([
      'user_id' => $user_id,
      'game_id' => $game_id,
      'game_type_id' => $game->game_type_id,
      'amount' => $total,
    ]);

    foreach ($bet_type_ids as $b) {
      // add bet
      $betType = BetType::where('id', $b)->first();
      $bet = Bet::create([
        'bet_transaction_id' => $betTransaction->id,
        'game_id' => $game_id,
        'game_type_id' => $game->game_type_id,
        'bet_type_id' => $betType->id,
        'odd' => $betType->odd,
        'user_id' => $user_id,
        'amount' => $amount,
        'bet_ref' => $betType->betTypeGroup->bet_ref,
      ]);
    }

    return $betTransaction;
  }

  public function placeBetJackpot($user_id, $game_id, $amount, $jackpotNo)
  {

    $game = Game::where('id', $game_id)->first();

    $total =  $amount;

    // add transaction 
    $conf = [
      'user_id' => $user_id,
      'amount' => $total,
      'wallet_type' => 1,
      'transaction_type_id' => 3, // 3 - bet
      'description' => 'Bet Game ID#' . $game_id,
    ];
    $this->addTransaction($conf);

    // add bet transaction 
    $betTransaction = BetTransaction::create([
      'user_id' => $user_id,
      'game_id' => $game_id,
      'game_type_id' => $game->game_type_id,
      'amount' => $total,
    ]);

    // add bet
    $bet = Bet::create([
      'bet_transaction_id' => $betTransaction->id,
      'game_id' => $game_id,
      'game_type_id' => $game->game_type_id,
      'bet_no' => $jackpotNo,
      'odd' => 54,
      'user_id' => $user_id,
      'amount' => $amount,
      'bet_ref' => 'jackpot',
    ]);

    return $betTransaction;
  }

  public function placeFakeBet($username, $game_id, $amount, $bet_type_ids)
  {

    $bet_type_ids = explode(",", $bet_type_ids);
    $game = Game::where('id', $game_id)->first();

    
    $total =  $amount * count($bet_type_ids);

    // add bet transaction 
    $betTransaction = BetTransaction::create([
      'game_id' => $game_id,
      'game_type_id' => $game->game_type_id,
      'amount' => $total,
      'fake_username' => $username,
      'is_fake' => 1,
    ]);


    foreach ($bet_type_ids as $b) {
      // add bet
      $betType = BetType::where('id', $b)->first();
      $bet = Bet::create([
        'bet_transaction_id' => $betTransaction->id,
        'game_id' => $game_id,
        'game_type_id' => $game->game_type_id,
        'bet_type_id' => $betType->id,
        'odd' => $betType->odd,
        'fake_username' => $username,
        'is_fake' => 1,
        'amount' => $amount,
        'bet_ref' => $betType->betTypeGroup->bet_ref,
      ]);
    }


 
    return $betTransaction;
    
  }

  public function addTransaction($conf = [])
  {
    // conf [
    //   user_id,
    //   amount,
    //   wallet_type,
    //   transaction_type_id,
    //   description
    // ]

    if ($conf) {

      $txnid_id_base = 1000000;
      $transaction_details = TransactionType::where('id', $conf['transaction_type_id'])->first();

      // insert transaction
      $new_txn = Transaction::create([
        'user_id' => $conf['user_id'],
        'amount' => (float) $conf['amount'],
        'transaction_type_id' => $conf['transaction_type_id'],
        'description' => isset($conf['description']) ? $conf['description'] : '',
        // 'point_type' => isset($conf['point_type']) ? $conf['point_type'] : NULL,
        'status' => 1,
        'type' => $transaction_details->type,
        'wallet_type' => $conf['wallet_type'],
        'ip_address' => \Request::ip()
      ]);
      $new_txn->txnid = $txnid_id_base + $new_txn->id;
      $new_txn->save();

      // update wallet
      $wallet_conf = [
        'user_id' => $conf['user_id'],
        'wallet_type' => $conf['wallet_type'],
        'amount' => (float) $conf['amount'],
        'type' => $transaction_details->type,
      ];

      $this->updateWallet($wallet_conf);

      return $new_txn;
    }
  }

  public function updateWallet($conf = [])
  {
    // conf [
    //  user_id,
    //  wallet_type,
    //  amount,
    //  type,
    // ]

    if ($conf) {
      $wallet = UserWallet::where('user_id', $conf['user_id'])->where('wallet_type', $conf['wallet_type'])->first();

      if ($conf['type'] == 'debit') {
        $highest_balance = $wallet->highest_balance;
        $wallet->balance =  $wallet->balance + (float) $conf['amount'];

        if ($wallet->balance > $highest_balance) {
          $wallet->highest_balance = $wallet->balance;
        }
      }

      if ($conf['type'] == 'credit') {
        $wallet->balance =  $wallet->balance - (float) $conf['amount'];
      }

      $wallet->save();
    }
  }

  public function addAgentTransaction($conf = [])
  {
    // conf [
    //   memid,
    //   transaction_type_id,
    //   from_memid,
    //   description
    // ]

    if ($conf) {

      $txnid_id_base = 1000000;
      $transaction_details = TransactionType::where('id', $conf['transaction_type_id'])->first();
      $use_wallet_id = $transaction_details->wallet_id;

      // insert transaction
      $new_txn = AgentTransaction::create([
        'admin_id' => $conf['admin_id'],
        'amount' => (float) $conf['amount'],
        'transaction_type_id' => $conf['transaction_type_id'],
        'description' => isset($conf['description']) ? $conf['description'] : '',
        // 'point_type' => isset($conf['point_type']) ? $conf['point_type'] : NULL,
        'status' => 1,
        'type' => $transaction_details->type,
        'ip_address' => \Request::ip()
      ]);
      $new_txn->txnid = $txnid_id_base + $new_txn->id;
      $new_txn->save();

      // update wallet
      $wallet_conf = [
        'admin_id' => $conf['admin_id'],
        'amount' => (float) $conf['amount'],
        'type' => $transaction_details->type,
      ];

      $this->updateAgentWallet($wallet_conf);

      return $new_txn;
    }
  }


  public function updateAgentWallet($conf = [])
  {
    // conf [
    //  memid,
    //  amount,
    //  type,
    // ]

    if ($conf) {
      $wallet = AgentWallet::where('admin_id', $conf['admin_id'])->first();

      if ($conf['type'] == 'debit') {
        $highest_balance = $wallet->highest_balance;
        $wallet->balance =  $wallet->balance + (float) $conf['amount'];

        if ($wallet->balance > $highest_balance) {
          $wallet->highest_balance = $wallet->balance;
        }
      }

      if ($conf['type'] == 'credit') {
        $wallet->balance =  $wallet->balance - (float) $conf['amount'];
      }

      $wallet->save();
    }
  }

  // ------------------------------------------------------------------------------

  

  
}
