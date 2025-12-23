<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Member\WorkerController;

use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Models\Investor;
use App\Models\Transaction;
use App\User;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

  public function __construct()
  { }


  public function index(Request $request)
  {
    $adata = [];

    $input = $request->all();

    $list = [];

    // $users = User::where('is_active', 1)->get();

    // foreach ($users as $u) {

    //   $downlineDebit = 0;
    //   $downlineCredit = 0;


    //   $downlineCount = !empty($u->downline) ? count($u->downline) : 0;
    //   $downlineIds = $u->downline->pluck('id')->toArray();

    //   if (!empty($downlineIds)) {
    //     $downlineDebit = Transaction::whereIn('user_id', $downlineIds)->where('type', 'debit')->sum('amount');
    //     $downlineCredit = Transaction::whereIn('user_id', $downlineIds)->where('type', 'credit')->sum('amount');
    //   }


    //   $list[] = array_merge($u->toArray(), [
    //     'wallet_id' => $u->wallet->id,
    //     'downline' => $downlineCount,
    //     'downline_debit' => (float) $downlineDebit,
    //     'downline_credit' => (float)  $downlineCredit,
    //     'downline_balance' => (float) $downlineDebit - (float)  $downlineCredit,
    //   ]);
    // }

    $adata['list'] = $list;

    return view('admin.report.index', $adata);
  }

  public function getList(Request $request)
  {

    $res = [];
    $input = $request->all();


    $limit = ($request->input('length')) ? $request->input('length') : 10;
    $start = ($request->input('start')) ? $request->input('start') : 0;

    $query = User::where('is_active', 1);

    if (!empty($request->input('search.value'))) {
      $search = $request->input('search.value');

      $query->where(function ($query) use ($search) {
        $query->orWhere('id', 'LIKE', "%{$search}%");
        $query->orWhere('username', 'LIKE', "%{$search}%");
      });
    }

    $query->offset($start)->limit($limit);
    $users = $query->get();

    foreach ($users as $u) {

      $downlineDebit = 0;
      $downlineCredit = 0;
      $downlineIds = [];



      $downlineCount = !empty($u->downline) ? count($u->downline) : 0;
      if($u->downline) {
        $downlineIds = $u->downline->pluck('id')->toArray();
      }

      if (!empty($downlineIds)) {
        $downlineDebit = Transaction::whereIn('user_id', $downlineIds)->where('type', 'debit')->sum('amount');
        $downlineCredit = Transaction::whereIn('user_id', $downlineIds)->where('type', 'credit')->sum('amount');
      }


      $list[] = array_merge($u->toArray(), [
        'wallet_id' => $u->wallet->id,
        'downline' => $downlineCount,
        'downline_debit' => (float) $downlineDebit,
        'downline_credit' => (float)  $downlineCredit,
        'downline_balance' => (float) $downlineDebit - (float)  $downlineCredit,
      ]);
    }

    $totalData = $totalFiltered = count($users);

    if (!empty($request->input('order'))) {
      $order = $request->input('order')[0];
      if ($order['column'] == 0) {
        $param = 'id';
      }
      if ($order['column'] == 1) {
        $param = 'username';
      }
      if ($order['column'] == 2) {
        $param = 'downline';
      }
      if ($order['column'] == 3) {
        $param = 'downline_debit';
      }
      if ($order['column'] == 4) {
        $param = 'downline_credit';
      }
      if ($order['column'] == 5) {
        $param = 'downline_balance';
      }

      $list = $this->sortData($list, $order, $param);
    }


    // dd($input);


    $data = [];
    if (!empty($list)) {

      foreach ($list as $l) {

        $balance = '';

        if ($l['downline_balance'] > 0) {
          $balance = '<span class="text-success"><b>' . currency_format($l['downline_balance'], 'RM') . '</b></span>';
        } else {
          $balance = '<span class="text-danger"><b>' . currency_format($l['downline_balance'], 'RM') . '</b></span>';
        }


        $data[] = [
          $l['id'],
          $l['username'],
          $l['downline'],
          currency_format($l['downline_debit']),
          currency_format($l['downline_credit']),
          $balance,
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

  public function sortData($list, $order, $param)
  {

    usort($list, function ($a, $b)  use ($order, $param) {
      if ($a[$param] == $b[$param]) return 0;

      if ($order['dir'] == 'desc') {
        return $a[$param] < $b[$param] ? 1 : -1;
      } else {
        return $a[$param] > $b[$param] ? 1 : -1;
      }
    });

    return $list;
  }
}
