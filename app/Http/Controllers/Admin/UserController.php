<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\WorkerController;
use App\Models\UserWallet;
use App\Models\Transaction;
use App\Models\TransactionType;
use App\User;
use App\Models\Bet;
use App\Models\Country;
use App\Models\Rank;
use Illuminate\Http\Request;
use Validator;
use Auth;


class UserController extends Controller
{

  public function __construct()
  { }

  public function list()
  {
    $adata = [];


    if (Auth::guard('admin')->user()->level == 1) {
      $adata['list'] = User::orderBy('id', 'desc')->get();
    } else {
      $adata['list'] = User::where('created_by',  Auth::guard('admin')->user()->id)->orderBy('id', 'desc')->get();
    }

    return view('admin.users.list', $adata);
  }

  public function details($username = null)
  {
    $adata = [];


    if (empty($username)) {
      return redirect(admin_url('users/list'));
    }

    $user = User::where('username', $username)->first();

    if (empty($user)) {
      return redirect(admin_url('users/list'));
    }


    $adata['data'] = $user;
    $adata['transactions'] = Transaction::where('is_active', 1)->where('user_id', $user->id)->orderBy('id', 'desc')->paginate(50);
    $adata['downline'] = User::where('parent_id', $user->id)->paginate(50);
    $adata['bets'] = Bet::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(50);


    return view('admin.users.details', $adata);
  }

  public function new(Request $request)
  {
    $adata = [];

    $input = $request->all();

    if ($input) {
      $validator = Validator::make($input, [
        'referrer_username' => 'required',
        'username' => 'required|alpha_num|unique:users',
        'name' => 'required',
        'password' => 'required_with:confirm_password|same:confirm_password',
        'confirm_password' => 'required',
        'contact' => 'required',
        'balance' => 'required|numeric',
      ]);

      if ($validator->fails()) {
        return back()->withInput()->with('validation_errors', $validator->errors());
      } else {

        $worker = new WorkerController();

        //$username = createusername();
        $username = $input['username'];

        $referrer = User::where('username', $input['referrer_username'])->first();

        if (!$referrer) {
          return back()->withInput()->with('errors', 'Inavlid referred username');
        }

        // create user
        $user = User::create([
          'parent_id' => $referrer->id,
          'username' => $username,
          'name' => $input['name'],
          'contact' => $input['contact'],
          'country_id' => $input['country_id'],
          'password' => bcrypt($input['password']),
          'password_text' => $input['password'],
          'created_by' => Auth::guard('admin')->user()->id,
          'bank_name' =>  $input['bank_name'],
          'bank_account_name' =>  $input['bank_account_name'],
          'bank_account_no' =>  $input['bank_account_no'],
          'bank_swift_code' =>  $input['bank_swift_code'],
          'rank_id' =>  $input['rank_id'],
        ]);

        // create wallet
        UserWallet::create([
          'user_id' => $user->id,
          'balance' => 0,
          'wallet_type' => 1
        ]);

        if ($input['balance']) {

          $conf = [
            'user_id' => $user->id,
            'amount' => $input['balance'],
            'transaction_type_id' => 1,
            'wallet_type' => 1,
            'description' => 'Add Balance',
          ];
          $worker->addTransaction($conf);
        }



        $status = 'Added new user!';
        return redirect(admin_url('users/view/' . $user->username))->with('status', $status);
      }
    }

    $adata['ranks'] = Rank::where('is_active', 1)->get();
    $adata['countryList'] = Country::get();

    return view('admin.users.new', $adata);
  }

  public function edit(Request $request, $username = null)
  {
    $adata = [];


    if (empty($username)) {
      return redirect(admin_url('users/list'));
    }

    $user = User::where('username', $username)->first();

    if (empty($user)) {
      return redirect(admin_url('users/list'));
    }

    $input = $request->all();

    if ($input) {

      $validator = Validator::make($input, [
        'referrer_username' => 'required',
        'name' => 'required',
        'contact' => 'required',
      ]);

      if ($validator->fails()) {
        return back()->with('validation_errors', $validator->errors());
      } else {


        $referrer = User::where('username', $input['referrer_username'])->first();

        if (!$referrer) {
          return back()->withInput()->with('errors', 'Inavlid referred username');
        }

        $user->parent_id = $referrer->id;
        $user->name = $input['name'];
        $user->contact = $input['contact'];
        $user->country_id = $input['country_id'];
        $user->bank_name = $input['bank_name'];
        $user->bank_account_name = $input['bank_account_name'];
        $user->bank_account_no = $input['bank_account_no'];
        $user->bank_swift_code = $input['bank_swift_code'];
        $user->rank_id = $input['rank_id'];
        $user->is_active = $input['is_active'];

        if ($input['password']) {
          $user->password =  bcrypt($input['password']);
          $user->password_text = $input['password'];
        }

        $user->save();


        $status = 'Updated user!';
        return redirect(admin_url('users/view/' . $user->username))->with('status', $status);
      }
    }


    $adata['data'] = $user;
    $adata['ranks'] = Rank::where('is_active', 1)->get();
    $adata['countryList'] = Country::get();

    return view('admin.users.edit', $adata);
  }

  public function transaction(Request $request)
  {
    $adata = [];
    $ipt = $request->all();


    $start_date = ($request->input('start_date')) ? $request->input('start_date') : date('Y-m-d');
    $end_date = ($request->input('end_date')) ? $request->input('end_date') : date('Y-m-d');


    if (Auth::guard('admin')->user()->level == 1) {
      $query = Transaction::where('is_active', 1)->orderBy('id', 'desc');
    } else {
      $memberIds = User::where('created_by',  Auth::guard('admin')->user()->id)->orderBy('id', 'desc')->pluck('id')->toArray();
      $query = Transaction::whereIn('user_id', $memberIds)->where('is_active', 1)->orderBy('id', 'desc');
    }

    if (!empty($ipt)) {
      if (isset($ipt['txnid'])) {
        $query->where('txnid', 'LIKE', "%" . $ipt['txnid'] . "%");
      }

      if (isset($ipt['username'])) {
        $userIds = User::where('username', 'LIKE', "%" . $ipt['username'] . "%")->get()->pluck('id')->toArray();

        if (!empty($userIds)) {
          $query->whereIn('user_id', $userIds);
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


    return view('admin.users.transaction', $adata);
  }

  public function transactionAdd(Request $request)
  {
    $adata = [];

    $input = $request->all();


    if ($input) {

      $worker = new WorkerController();

      $validator = Validator::make($input, [
        'username' => 'required',
        'amount' => 'required|numeric',
      ]);

      if ($validator->fails()) {
        return back()->with('validation_errors', $validator->errors());
      } else {

        $transaction_type = TransactionType::where('id', $input['transaction_type_id'])->first();

        if (Auth::guard('admin')->user()->level == 1) {
          $user = User::where('username', $input['username'])->first();
        } else {
          $user = User::where('username', $input['username'])->where('created_by', Auth::guard('admin')->user()->id)->first();
        }

        // check user
        if (empty($user)) {
          return back()->with('errors', 'Invalid Member ID');
        }

        if ($transaction_type->type == 'debit') {
          // check agent wallet
          if (Auth::guard('admin')->user()->level != 1) {
            if (Auth::guard('admin')->user()->wallet->balance < $input['amount']) {
              return back()->with('errors', 'Low agent wallet balance, ask admin to topup');
            }
          }
        }

        $conf = [
          'user_id' => $user->id,
          'amount' => $input['amount'],
          'transaction_type_id' => $transaction_type->id,
          'description' => $input['description'],
          // 'point_type' => isset($input['point_type']) ? $input['point_type'] : NULL,
          'wallet_type' => 1,
        ];
        $txn = $worker->addTransaction($conf);

        if (Auth::guard('admin')->user()->level != 1) {

          $reverse = $transaction_type->id == 12 ? 11 : 12;

          $conf = [
            'admin_id' => Auth::guard('admin')->user()->id,
            'amount' => $input['amount'],
            'transaction_type_id' => $reverse, // minus agent wallet
            'description' => $transaction_type->name . ' User',
          ];
          $worker->addAgentTransaction($conf);
        }

        $status = 'Added Transaction!';
        return redirect(admin_url('users/transaction/view/' . $txn->id))->with('status', $status);
      }
    }


    $adata['users'] = User::where('is_active', 1)->get();

    return view('admin.users.transaction_add', $adata);
  }

  public function transactionView($id = null)
  {
    $adata = [];

    if (empty($id)) {
      return redirect(admin_url('users/transaction_list'));
    }

    $txn = Transaction::where('id', $id)->first();

    if (empty($txn)) {
      return redirect(admin_url('users/transaction_list'));
    }


    $adata['data'] = $txn;

    return view('admin.users.transaction_view', $adata);
  }


  public function getList(Request $request)
  {
    $res = [];
    //DB::enableQueryLog();

    $limit = ($request->input('length')) ? $request->input('length') : 10;
    $start = ($request->input('start')) ? $request->input('start') : 0;
    // $order = $columns[$request->input('order.0.column')];
    // $dir = $request->input('order.0.dir');

    if (Auth::guard('admin')->user()->level == 1) {
      $query = User::orderBy('id', 'desc');
    } else {
      $query = User::where('created_by',  Auth::guard('admin')->user()->id)->orderBy('id', 'desc');
    }




    if (!empty($request->input('search.value'))) {
      $search = $request->input('search.value');

      $query->where(function ($query) use ($search) {
        $query->orWhere('id', 'LIKE', "%{$search}%");
        $query->orWhere('username', 'LIKE', "%{$search}%");
        $query->orWhere('name', 'LIKE', "%{$search}%");
      });
    }

    // get query
    $query->offset($start)->limit($limit);
    $list = $query->get();

    //dd(DB::getQueryLog());

    //get no filter query
    $totalData = $totalFiltered = User::count();

    $data = [];
    if (!empty($list)) {

      foreach ($list as $l) {

        $actions = '
                  <a href="' . admin_url('users/view/' . $l->username) . '" class="btn btn-sm btn-primary"><i class="far fa-eye"></i></a>
                  <a href="' . admin_url('users/edit/' . $l->username) . '" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>
                  ';

        if($l->is_active == 1) {
          $actions .= '<button type="button" id="' . $l->id . '"  data-toggle="modal" data-target="#mdl-delete" class="btn btn-sm btn-warning btn-trigger-modal btn-delete" ><i class="fa fa-ban"></i></button> ';
        } else {
          $actions .= '<button type="button" id="' . $l->id . '"  data-toggle="modal" data-target="#mdl-activate" class="btn btn-sm btn-success btn-trigger-modal btn-activate" ><i class="fa fa-check-circle"></i></button> ';
        }

        $winLossCount = $l->totalWinning() - $l->totalBetsAmount();

        if ($winLossCount > 0) {
          $winLoss = '<span class="text-success"><b>' . currency_format($winLossCount, $l->country->currency) . '</b></span>';
        } else {
          $winLoss = '<span class="text-danger"><b>' . currency_format($winLossCount, $l->country->currency) . '</b></span>';
        }

        $status = ($l->is_active) ? '<span class="badge badge-success badge-100">' . __('admin.active') . '</span>' : '<span class="badge badge-100 badge-warning">' . __('admin.inactive') . '</span>';

        $data[] = [
          $l->referrer->username,
          $l->username,
          $l->name,
          $l->contact,
          $winLoss,
          $l->wallet->balance,
          $status,
          dateformat($l->created_at),
          $actions,
        ];
      }
    }

    $res = [
      "draw" => intval($request->input('draw')),
      "recordsTotal" => intval($totalData),
      "recordsFiltered" => intval($totalFiltered),
      "data" => $data,
    ];

    echo json_encode($res);
  }
  public function suspend(Request $request)
  {

    $input = $request->all();

    if (isset($input['user_id'])) {

      $user = User::where('id', $input['user_id'])->first();

      if (empty($user)) {
        return redirect(admin_url('users/list'));
      }

      $user->is_active= 0;
      $user->save();

      $status = '<b>Suspended!</b>';
      return back()->with('status', $status);
    }

    return redirect(admin_url('users/list'));
  }

  public function activate(Request $request)
  {

    $input = $request->all();

    if (isset($input['user_id'])) {

      $user = User::where('id', $input['user_id'])->first();

      if (empty($user)) {
        return redirect(admin_url('users/list'));
      }

      $user->is_active= 1;
      $user->save();

      $status = '<b>Activated!</b>';
      return back()->with('status', $status);
    }

    return redirect(admin_url('users/list'));
  }
}
