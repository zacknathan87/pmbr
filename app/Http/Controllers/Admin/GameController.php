<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bet;
use App\Models\Game;
use App\Http\Controllers\Controller;
use App\Http\Controllers\WorkerController;
use App\Models\BetType;
use App\Models\GameChannel;
use App\Models\GameRoom;
use App\Models\UserWallet;
use App\Services\GameDiceService;
use App\User;
use Illuminate\Http\Request;
use Validator;
use Auth;

use function React\Promise\resolve;

class GameController extends Controller
{

  public function __construct()
  { }

  public function liveGame()
  {
    $adata = [];

    $adata['game'] = Game::where('status_id', 2)->get();

    return view('admin.game.live', $adata);
  }

  public function list()
  {
    $adata = [];

    $adata['gameChannels'] = GameChannel::where('is_active', 1)->get();

    return view('admin.game.list', $adata);
  }

  public function details($id = null)
  {
    $adata = [];


    if (empty($id)) {
      return redirect(admin_url('game/list'));
    }

    $game = Game::where('id', $id)->first();

    if (empty($game)) {
      return redirect(admin_url('game/list'));
    }

    $bets = Bet::where('game_id', $id)->where('is_fake', 0)->orderBy('id', 'desc')->get();
    $bet_type = BetType::where('is_active', 1)->get();
    $total = count($bet_type);

    $bet_data = [];
    foreach ($bet_type as $bt) {
      $bet_data[$bt->id] = [
        'count' => 0,
        'total' => 0,
        'percent' => 0,
      ];
    }

    $total_bet = 0;
    $total_amount = 0;

    $highest_count = 0;
    $highest_amount = 0;

    foreach ($bets as $b) {
      $bet_data[$b->bet_type_id]['count']++;
      $bet_data[$b->bet_type_id]['total'] += $b->amount;

      $total_amount += $b->amount;
      $total_bet++;
    }

    foreach ($bets as $k => $b) {
      if (!empty($bet_data[$b->bet_type_id]['count'])) {
        $bet_data[$b->bet_type_id]['percent'] = ($bet_data[$b->bet_type_id]['count'] / $total_bet) * 100;
      }
    }

    if (!empty($total_bet)) {

      $total_arr = array_column($bet_data, "total");
      $highest_amount = array_keys($total_arr, max($total_arr))[0] + 1;

      $count_arr = array_column($bet_data, "count");
      $highest_count = array_keys($count_arr, max($count_arr))[0] + 1;
    }

    $adata['highest_count'] = $highest_count;
    $adata['highest_amount'] = $highest_amount;


    $adata['data'] = $game;
    $adata['bets'] = $bet_data;
    $adata['all_bets'] = $bets;
    $adata['bet_type'] = $bet_type;


    return view('admin.game.details', $adata);
  }


  public function setWin(Request $request)
  {
    $gameDiceService = new GameDiceService();

    $input = $request->all();

    if (isset($input['game_id'])) {


      $game = Game::where('id', $input['game_id'])->first();
      if (empty($game)) {
        return back()->with('errors', 'Invalid Data.');
      }

      if ($game->game_type_id == 1) {
        if ($input['result_no'] > 27) {
          return back()->with('errors', 'Result Number cant be more than 27');
        }

        // get dice number
        $finalNo = $input['result_no'];
        $dice = $gameDiceService->getDiceNumber($finalNo);

        $game->no = implode(",", $dice);

        $game->result_no = $finalNo;
        $game->save();
      }

      if (in_array($game->game_type_id, [2,3])) {
        $total = 0;
        foreach($input['num'] as $n) {
          if ($n > 9) {
            return back()->with('errors', 'Result Number cant be more than 9');
          }
          $total += $n;
        }

        $game->no = implode(",", $input['num']);
        $game->result_no = $total;
        $game->save();
      }

      if (in_array($game->game_type_id, [4])) {
        $total = 0;
        foreach($input['num'] as $n) {
          if ($n > 54) {
            return back()->with('errors', 'Result Number cant be more than 54');
          }
          $total += $n;
        }

        $game->no = implode(",", $input['num']);
        $game->result_no = $total;
        $game->save();
      }

      

      $status = 'Winning number set!';
      return redirect(admin_url('game/view/' . $game->id))->with('status', $status);
    } else {
      return back()->with('errors', 'Invalid Data.');
    }
  }

  public function setWin2(Request $request)
  {
    $gameDiceService = new GameDiceService();

    $input = $request->all();

    if (isset($input['game_id'])) {


      $game = Game::where('id', $input['game_id'])->first();
      if (empty($game)) {
        return back()->with('errors', 'Invalid Data.');
      }

      if ($game->game_type_id == 1) {
        if ($input['result_no'] > 27) {
          return back()->with('errors', 'Result Number cant be more than 27');
        }

        // get dice number
        $finalNo = $input['result_no'];
        $dice = $gameDiceService->getDiceNumber($finalNo);

        $game->no = implode(",", $dice);

        $game->result_no = $finalNo;
        $game->save();
      }

      if (in_array($game->game_type_id, [2,3])) {
        $total = 0;
        foreach($input['num'] as $n) {
          if ($n > 9) {
            return back()->with('errors', 'Result Number cant be more than 9');
          }
          $total += $n;
        }

        $game->no = implode(",", $input['num']);
        $game->result_no = $total;
        $game->save();
      }

      if (in_array($game->game_type_id, [4])) {
        $total = 0;
        foreach($input['num'] as $n) {
          if ($n > 54) {
            return back()->with('errors', 'Result Number cant be more than 54');
          }
          $total += $n;
        }

        $game->no = implode(",", $input['num']);
        $game->result_no = $total;
        $game->save();
      }

      

      $status = 'Winning number set!';
      return back()->with('status', $status);
    } else {
      return back()->with('errors', 'Invalid Data.');
    }
  }


  public function setLimit(Request $request)
  {

    $input = $request->all();

    if (isset($input['game_id'])) {


      $game = Game::where('id', $input['game_id'])->first();
      if (empty($game)) {
        return back()->with('errors', 'Invalid Data.');
      }

      $limit_data = json_decode($game->limit_data, true);
      $limit_data[$input['answer_no']] = $input['limit'];

      $game->limit_data = json_encode($limit_data);
      $game->save();

      $status = 'Limit Set!';
      return redirect(admin_url('game/view/' . $game->id))->with('status', $status);
    } else {
      return back()->with('errors', 'Invalid Data.');
    }
  }


  public function betList()
  {

    $adata = [];


    $adata['gameChannels'] = GameChannel::where('is_active', 1)->get();

    return view('admin.game.bet_list', $adata);
  }



  public function getList(Request $request)
  {
    $res = [];
    //DB::enableQueryLog();

    $limit = ($request->input('length')) ? $request->input('length') : 10;
    $start = ($request->input('start')) ? $request->input('start') : 0;
    // $order = $columns[$request->input('order.0.column')];
    // $dir = $request->input('order.0.dir');

    $query = Game::orderBy('id', 'desc');

    if (!empty($request->input('search.value'))) {
      $search = $request->input('search.value');

      $query->where(function ($query) use ($search) {
        $query->where('id', 'LIKE', "%{$search}%");
      });
    }

    if ($request->input('game_channel_id')) {
      $query->where('game_channel_id', $request->input('game_channel_id'));
    }

    if ($request->input('status_id')) {
      $query->where('status_id', $request->input('status_id'));
    }

    if ($request->input('date')) {

      $date = str_replace("/", "-",  $request->input('date'));
      $query->whereDate('start_at', date('Y-m-d', strtotime($date)));
    } else {
      $query->whereDate('start_at', date('Y-m-d'));
    }


    // get query
    $query->offset($start)->limit($limit);
    $list = $query->get();

    //dd(DB::getQueryLog());

    //get no filter query
    $totalData = $totalFiltered = Game::count();

    $data = [];
    if (!empty($list)) {

      foreach ($list as $l) {

        $actions = '
          <a href="' . admin_url('game/view/' . $l->id) . '" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
        ';

        $winNumber = $l->result_no ? '<span class="tag bg-success winning-no-list">' . $l->result_no . '</span><br>'.$l->no : '-';
        $status = '<span class=" text-primary"><b>' . __('admin.pending') . '</b></span>';
        if ($l->status_id == 2) {
          $status = '<span class=" text-success"><b>' . __('admin.in_progress') . '</b></span>';
        }
        if ($l->status_id == 3) {
          $status = '<span class=" text-info"><b>' . __('admin.announcing_winner') . '</b></span>';
        }
        if ($l->status_id == 4) {
          $status = '<span class=" text-danger"><b>' . __('admin.ended') . '</b></span>';
        }

        if ($l->status_id != 4) {
          $winNumber .= ' <div  class="btn-trigger-modal btn btn-sm btn-primary btn-set-win" game-type-id="' . $l->game_type_id . '" game-id="' . $l->id . '">Set Win</div>';
        }



        $data[] = [
          $l->id,
          $l->gameType->name,
          $l->gameChannel->name,
          $status,
          $winNumber,
          dateformat($l->start_at),
          dateformat($l->end_at),
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

  public function getBetList(Request $request)
  {
    $res = [];
    //DB::enableQueryLog();

    $limit = ($request->input('length')) ? $request->input('length') : 10;
    $start = ($request->input('start')) ? $request->input('start') : 0;
    // $order = $columns[$request->input('order.0.column')];
    // $dir = $request->input('order.0.dir');

    $query = Bet::selectRaw('bets.*, u.username as username, g.game_channel_id as game_channel_id, g.status_id as status_id')
      ->leftJoin('users as u', 'bets.user_id', '=', 'u.id')
      ->leftJoin('games as g', 'bets.game_id', '=', 'g.id')
      ->where('is_fake', 0)->orderBy('bets.id', 'desc');

    if (!empty($request->input('search.value'))) {
      $search = $request->input('search.value');

      $query->where(function ($query) use ($search) {
        $query->orWhere('bets.id', 'LIKE', "%{$search}%");
        $query->orWhere('bets.user_id', 'LIKE', "%{$search}%");
        $query->orWhere('bets.game_id', 'LIKE', "%{$search}%");
        $query->orWhere('username', 'LIKE', "%{$search}%");
      });
    }

    if ($request->input('game_channel_id')) {
      $query->where('game_channel_id', $request->input('game_channel_id'));
    }

    if ($request->input('status_id')) {
      $query->where('status_id', $request->input('status_id'));
    }

    // get query
    $query->offset($start)->limit($limit);
    $list = $query->get();

    //dd(DB::getQueryLog());

    //get no filter query
    $totalData = $totalFiltered = Bet::count();

    $data = [];
    if (!empty($list)) {

      foreach ($list as $l) {

        // $actions = '
        //   <a href="' . admin_url('game/view/' . $l->id) . '" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
        // ';

        $winning = '<span class="badge badge-danger">NO</span>';
        $win_amount = '-';

        if ($l->is_win) {
          $winning = '<span class="badge badge-success">YES</span>';
          $win_amount = currency_format($l->win_amount, $l->user->country->currency);
        }
        
        if($l->bet_ref == 'jackpot') {
          $bet_on = $l->bet_no.' - JACKPOT';
        } else {
          $bet_on = ($l->betType->type == 'range') ? __('app.' . $l->betType->name_code) : $l->betType->value;
        }

        $game = $l->game->gameType->name . ' / ' . $l->game->gameChannel->name;


        $status = '<span class="tag bg-primary">Pending</span>';
        if ($l->status_id == 2) {
          $status = '<span class="tag bg-success">In Progress</span>';
        }
        if ($l->status_id == 3) {
          $status = '<span class="tag bg-info">Announcing Winner</span>';
        }
        if ($l->status_id == 4) {
          $status = '<span class="tag bg-danger">Ended</span>';
        }


        $data[] = [
          '<a href="' . admin_url('users/view/' . $l->user->username) . '">' . $l->user->username . '</a>',
          $l->game_id,
          $game,
          $status,
          $bet_on,
          currency_format($l->amount, 'RM'),
          $winning,
          $win_amount,
          dateformat($l->created_at),
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
}
