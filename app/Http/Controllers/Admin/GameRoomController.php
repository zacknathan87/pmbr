<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bet;
use App\Models\Game;
use App\Http\Controllers\Controller;
use App\Http\Controllers\WorkerController;
use App\Models\BetType;
use App\Models\GameRoom;
use App\Models\UserWallet;
use App\User;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Illuminate\Support\Str;
use Vinkla\Hashids\Facades\Hashids;

class GameRoomController extends Controller
{

  public function __construct()
  { }

  public function list()
  {
    $adata = [];

    $adata['list'] = GameRoom::orderBy('id', 'desc')->get();

    return view('admin.game_room.list', $adata);
  }

  public function new(Request $request)
  {
    $adata = [];

    $input = $request->all();

    if ($input) {
      $validator = Validator::make($input, [
        'name' => 'required|unique:game_room',
        'status' => 'required',
      ]);

      if ($validator->fails()) {
        return back()->withInput()->with('validation_errors', $validator->errors());
      } else {

        $worker = new WorkerController();


        // create room
        $room = GameRoom::create([
          'name' => $input['name'],
          'is_active' => $input['status'],
          'slug' => Str::slug($input['name']),
          'name_code' => Str::slug($input['name']),
          'min_balance' =>  $input['min_balance'],
          'win_ratio' =>  $input['win_ratio'],
          'min_bet' =>  $input['min_bet'],
          'bet_options' =>  $input['bet_options'],
        ]);

        $room->uuid = Hashids::encode(strtotime('now'));
        $room->save();

        $status = 'Added new room!';
        return redirect(admin_url('game_room/view/' . $room->id))->with('status', $status);
      }
    }

    return view('admin.game_room.new', $adata);
  }

  public function details($id = null)
  {
    $adata = [];

    if (empty($id)) {
      return redirect(admin_url('game_room/list'));
    }

    $room = GameRoom::where('id', $id)->first();
    if (empty($room)) {
      return redirect(admin_url('game_room/list'));
    }

    $adata['data'] = $room;


    return view('admin.game_room.details', $adata);
  }

  public function edit(Request $request, $id = null)
  {
    $adata = [];


    if (empty($id)) {
      return redirect(admin_url('game_room/list'));
    }

    $room = GameRoom::where('id', $id)->first();
    if (empty($room)) {
      return redirect(admin_url('game_room/list'));
    }

    $input = $request->all();

    if ($input) {

      $validator = Validator::make($input, [
        'name' => 'sometimes|required|unique:game_room,name,'.$room->id,
        'status' => 'required',
      ]);

      if ($validator->fails()) {
        return back()->with('validation_errors', $validator->errors());
      } else {

        $room->name =  $input['name'];
        $room->is_active = $input['status'];
        $room->slug =  Str::slug($input['name']);
        $room->name_code =  Str::slug($input['name']);
        $room->win_ratio =  $input['win_ratio'];
        $room->min_balance =  $input['min_balance'];
        $room->min_bet =  $input['min_bet'];
        $room->bet_options =  $input['bet_options'];
        $room->save();

        $status = 'Updated room!';
        return redirect(admin_url('game_room/view/' . $room->id))->with('status', $status);
      }
    }

    $adata['data'] = $room;

    return view('admin.game_room.edit', $adata);
  }
}
