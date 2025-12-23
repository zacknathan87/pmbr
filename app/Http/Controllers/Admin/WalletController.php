<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\WorkerController;
use App\Models\UserWallet;
use App\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Validator;
use Auth;


class WalletController extends Controller
{

  public function __construct()
  { }

  public function list()
  {
    $adata = [];

    if (Auth::guard('admin')->user()->level == 1) {
      $adata['list'] = UserWallet::orderBy('id', 'desc')->get();
    } else {
      $members_ids = User::where('created_by', Auth::guard('admin')->user()->id)->get()->pluck('id')->toArray();
      $adata['list'] = UserWallet::whereIn('user_id', $members_ids)->orderBy('id', 'desc')->get();
    }

    return view('admin.wallet.list', $adata);
  }

  public function details($id = null)
  {
    $adata = [];


    if (empty($id)) {
      return redirect(admin_url('wallet/list'));
    }

    $wallet = UserWallet::where('id', $id)->first();

    if (empty($wallet)) {
      return redirect(admin_url('wallet/list'));
    }


    $adata['data'] = $wallet;
    $adata['transactions'] = Transaction::where('is_active', 1)->where('user_id', $wallet->user_id)->orderBy('id', 'desc')->paginate(50);

    return view('admin.wallet.details', $adata);
  }

  public function addBalance(Request $request, $id = null)
  {
    $adata = [];


    if (!empty($id)) {
      $wallet = UserWallet::where('id', $id)->first();

      if (empty($wallet)) {
        return redirect(admin_url('wallet/list'));
      }
    }

    $input = $request->all();

    if ($input) {
      $worker = new WorkerController();

      $validator = Validator::make($input, [
        'amount' => 'required|numeric',
      ]);

      if ($validator->fails()) {
        return back()->with('validation_errors', $validator->errors());
      } else {

        if (isset($input['username'])) {
          // check user
          $user = User::where('username', $input['username'])->first();
          if (empty($user)) {
            return back()->with('errors', 'Invalid Member Username');
          }

          $wallet = UserWallet::where('user_id', $user->id)->first();
          if (empty($wallet)) {
            return back()->with('errors', 'Invalid Member Username');
          }
        }

        // check agent wallet
        if (Auth::guard('admin')->user()->level != 1) {
          if (Auth::guard('admin')->user()->wallet->balance < $input['amount']) {
            return back()->with('errors', 'Low agent wallet balance, ask admin to topup');
          }
        }


        $conf = [
          'user_id' => $wallet->user_id,
          'amount' => $input['amount'],
          'transaction_type_id' => 1,
          // 'point_type' => isset($input['point_type']) ? $input['point_type'] : NULL,
          'wallet_type' => 1,
          'description' => 'Add Balance',
        ];
        $worker->addTransaction($conf);

        if (Auth::guard('admin')->user()->level != 1) {
          $conf = [
            'admin_id' => Auth::guard('admin')->user()->id,
            'amount' => $input['amount'],
            'transaction_type_id' => 5, // minus agent wallet
            'description' => 'Topup User',
          ];
          $worker->addAgentTransaction($conf);
        }

        $status = 'Added balance!';
        return redirect(admin_url('wallet/view/' . $wallet->id))->with('status', $status);
      }
    }

    if (!empty($id)) {
      $adata['data'] = $wallet;
    }



    return view('admin.wallet.addCredit', $adata);
  }

  public function withdrawal(Request $request, $id = null)
  {
    $adata = [];


    if (!empty($id)) {
      $wallet = UserWallet::where('id', $id)->first();

      if (empty($wallet)) {
        return redirect(admin_url('wallet/list'));
      }
    }

    $input = $request->all();

    if ($input) {
      $worker = new WorkerController();

      $validator = Validator::make($input, [
        'amount' => 'required|numeric',
      ]);

      if ($validator->fails()) {
        return back()->with('validation_errors', $validator->errors());
      } else {





        // check user wallet
        if (isset($input['username'])) {
          // check user
          $user = User::where('username', $input['username'])->first();
          if (empty($user)) {
            return back()->with('errors', 'Invalid Member Username');
          }

          $wallet = UserWallet::where('user_id', $user->id)->first();
          if (empty($wallet)) {
            return back()->with('errors', 'Invalid Member Username');
          }
        }

        // check balance
        if ($input['amount'] > $wallet->balance) {
          return back()->with('errors', 'Not enough balance');
        }


        $conf = [
          'user_id' => $wallet->user_id,
          'amount' => $input['amount'],
          'transaction_type_id' => 2,
          'wallet_type' => 1,
          'description' => 'Withdrawal',
        ];
        $worker->addTransaction($conf);


        $status = 'Withdraw!';
        return redirect(admin_url('wallet/view/' . $wallet->id))->with('status', $status);
      }
    }

    if (!empty($id)) {
      $adata['data'] = $wallet;
    }



    return view('admin.wallet.withdrawal', $adata);
  }
}
