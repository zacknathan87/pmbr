<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Http\Controllers\Controller;
use App\Http\Controllers\WorkerController;
use App\Models\UserWallet;
use App\Models\AgentWallet;
use App\Models\Transaction;
use App\Models\AgentTransaction;
use App\Models\TransactionType;
use App\User;
use Illuminate\Http\Request;
use Validator;
use Auth;


class OperatorController extends Controller
{

  public function __construct()
  { }

  public function list()
  {
    $adata = [];

    $adata['list'] = Admin::where('level', 2)->orderBy('id', 'desc')->get();


    return view('admin.operator.list', $adata);
  }

  public function details($id = null)
  {
    $adata = [];


    if (empty($id)) {
      return redirect(admin_url('operator/list'));
    }

    $agent = Admin::where('id', $id)->first();

    if (empty($agent)) {
      return redirect(admin_url('operator/list'));
    }


    $adata['data'] = $agent;
    $adata['transactions'] = AgentTransaction::where('is_active', 1)->where('admin_id', $agent->id)->orderBy('id', 'desc')->paginate(50);


    return view('admin.operator.details', $adata);
  }

  public function new(Request $request)
  {
    $adata = [];

    $input = $request->all();

    if ($input) {
      $validator = Validator::make($input, [
        'username' => 'required|unique:admins',
        'password' => 'required',
        'balance' => 'required|numeric',
      ]);

      if ($validator->fails()) {
        return back()->withInput()->with('validation_errors', $validator->errors());
      } else {

        $worker = new WorkerController();

        // create user
        $agent = Admin::create([
          'username' => $input['username'],
          'password' => bcrypt($input['password']),
          'password_text' => $input['password'],
          'remarks' => $input['remarks'],
          'currency' => $input['currency'],
          'level' => 2,

        ]);

        // create wallet
        $agent_wallet = AgentWallet::create([
          'admin_id' => $agent->id,
          'balance' => 0
        ]);

        if ($input['balance']) {

          $conf = [
            'admin_id' => $agent->id,
            'amount' => $input['balance'],
            'transaction_type_id' => 1,
            'description' => 'Add Balance',
          ];
          $worker->addAgentTransaction($conf);
        }



        $status = 'Added new agent!';
        return redirect(admin_url('operator/view/' . $agent->id))->with('status', $status);
      }
    }


    return view('admin.operator.new', $adata);
  }

  public function edit(Request $request, $id = null)
  {
    $adata = [];


    if (empty($id)) {
      return redirect(admin_url('operator/list'));
    }

    $agent = Admin::where('level', 2)->where('id', $id)->first();

    if (empty($agent)) {
      return redirect(admin_url('operator/list'));
    }

    $input = $request->all();

    if ($input) {

      $validator = Validator::make($input, [
        'username' => 'required',
      ]);

      if ($validator->fails()) {
        return back()->with('validation_errors', $validator->errors());
      } else {

        $agent->username = $input['username'];
        $agent->remarks = $input['remarks'];

        if ($input['password']) {
          $agent->password =  bcrypt($input['password']);
          $agent->password_text = $input['password'];
        }

        $agent->save();


        $status = 'Updated agent!';
        return redirect(admin_url('operator/view/' . $agent->id))->with('status', $status);
      }
    }


    $adata['data'] = $agent;


    return view('admin.operator.edit', $adata);
  }

  public function addBalance(Request $request, $id = null)
  {
    $adata = [];


    if (!empty($id)) {
      $wallet = AgentWallet::where('id', $id)->first();

      if (empty($wallet)) {
        return redirect(admin_url('operator/list'));
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


        $conf = [
          'admin_id' => $wallet->admin_id,
          'amount' => $input['amount'],
          'transaction_type_id' => 1,
          // 'point_type' => ($input['point_type']) ? $input['point_type'] : NULL,
          'description' => 'Add Balance',
        ];
        $worker->addAgentTransaction($conf);

        // if(isset($input['memid'])) {
        //   $wallet = UserWallet::where('memid', $input['memid'])->first();
        //   if(empty($wallet)) {
        //      return back()->with('errors', 'Invalid Member ID');
        //   }
        // }

        // $wallet->balance += $input['amount'];
        // $wallet->save();


        $status = 'Added balance!';
        return redirect(admin_url('operator/view/' . $wallet->admin_id))->with('status', $status);
      }
    }

    if (!empty($id)) {
      $adata['data'] = $wallet;
    }



    return view('admin.operator.addCredit', $adata);
  }


  public function transaction(Request $request)
  {
    $adata = [];
    $ipt = $request->all();


    $start_date = ($request->input('start_date')) ? $request->input('start_date') : date('Y-m-d');
    $end_date = ($request->input('end_date')) ? $request->input('end_date') : date('Y-m-d');


    $query = AgentTransaction::where('is_active', 1)->orderBy('id', 'desc');
    

    if (!empty($ipt)) {
      if (isset($ipt['txnid'])) {
        $query->where('txnid', 'LIKE', "%" . $ipt['txnid'] . "%");
      }

      if (isset($ipt['username'])) {
        $userIds = Admin::where('username', 'LIKE', "%" . $ipt['username'] . "%")->get()->pluck('id')->toArray();

        if (!empty($userIds)) {
          $query->whereIn('admin_id', $userIds);
        }
      }

      if (isset($ipt['wallet_id']) && strtolower($ipt['wallet_id']) != 'all') {
        $transaction_type = TransactionType::where('is_active', 1)->where('wallet_id', $ipt['wallet_id'])->pluck('id')->toArray();
        $query->whereIn('transaction_type_id', $transaction_type);
      }

      if (isset($ipt['trans_type']) && strtolower($ipt['trans_type']) != 'all') {
        $query->where('type', $ipt['trans_type']);
      }

      // if (isset($ipt['point_type']) && strtolower($ipt['point_type']) != 'all') {
      //   $query->where('point_type', $ipt['point_type']);
      // }
    }

    $query->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);


    $adata['transactions'] = $query->paginate(100);
    // $adata['transactions'] = AgentTransaction::where('is_active', 1)->orderBy('id', 'desc')->paginate(50);


    return view('admin.operator.transaction', $adata);
  }

  public function transactionAdd(Request $request)
  {
    $adata = [];

    $input = $request->all();

    if ($input) {
      $worker = new WorkerController();

      $validator = Validator::make($input, [
        'amount' => 'required|numeric',
      ]);

      if ($validator->fails()) {
        return back()->with('validation_errors', $validator->errors());
      } else {

        $transaction_type = TransactionType::where('id', $input['transaction_type_id'])->first();
        $agent = Admin::where('id', $input['agent_id'])->first();

        if ($transaction_type->type == 'credit') {
          // check agent wallet
          if ($agent->wallet->balance < $input['amount']) {
            return back()->with('errors', 'Low agent wallet balance, ask admin to topup');
          }
        }

        $conf = [
          'admin_id' => $agent->id,
          'amount' => $input['amount'],
          'transaction_type_id' => $transaction_type->id,
          'description' => $input['description'],
          // 'point_type' => isset($input['point_type']) ? $input['point_type'] : NULL,
        ];
        $txn = $worker->addAgentTransaction($conf);

        $status = 'Added Transaction!';
        return redirect(admin_url('operator/transaction/view/' . $txn->id))->with('status', $status);
      }
    }


    $adata['agents'] = Admin::where('level', 2)->get();

    return view('admin.operator.transaction_add', $adata);
  }

  public function transactionView($id = null) {
    $adata = [];

    if (empty($id)) {
      return redirect(admin_url('operator/transaction_list'));
    }

    $txn = AgentTransaction::where('id', $id)->first();

    if (empty($txn)) {
      return redirect(admin_url('operator/transaction_list'));
    }


    $adata['data'] = $txn;

    return view('admin.operator.transaction_view', $adata);
  }
}
