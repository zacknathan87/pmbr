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
use App\User;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Illuminate\Support\Str;
use Vinkla\Hashids\Facades\Hashids;

class GameChannelController extends Controller
{

  public function __construct()
  { }

  public function list()
  {
    $adata = [];

    $adata['list'] = GameChannel::orderBy('id', 'desc')->get();

    return view('admin.game_channel.list', $adata);
  }

  public function new(Request $request)
  {
    $adata = [];

    $input = $request->all();

    if ($input) {
      $validator = Validator::make($input, [
        'name' => 'required|unique:game_channel',
        'status' => 'required',
      ]);

      if ($validator->fails()) {
        return back()->withInput()->with('validation_errors', $validator->errors());
      } else {

        $worker = new WorkerController();


        // create channel
        $channel = GameChannel::create([
          'name' => $input['name'],
          'is_active' => $input['status'],
          'slug' => Str::slug($input['name']),
          'name_code' => Str::slug($input['name']),
        ]);

        $channel->uuid = Hashids::encode(strtotime('now'));
        $channel->save();

        $status = 'Added new channel!';
        return redirect(admin_url('game_channel/view/' . $channel->id))->with('status', $status);
      }
    }

    return view('admin.game_channel.new', $adata);
  }

  public function details($id = null)
  {
    $adata = [];

    if (empty($id)) {
      return redirect(admin_url('game_channel/list'));
    }

    $channel = GameChannel::where('id', $id)->first();
    if (empty($channel)) {
      return redirect(admin_url('game_channel/list'));
    }

    $adata['data'] = $channel;


    return view('admin.game_channel.details', $adata);
  }

  public function edit(Request $request, $id = null)
  {
    $adata = [];


    if (empty($id)) {
      return redirect(admin_url('game_channel/list'));
    }

    $channel = GameChannel::where('id', $id)->first();
    if (empty($channel)) {
      return redirect(admin_url('game_channel/list'));
    }

    $input = $request->all();

    if ($input) {

      $validator = Validator::make($input, [
        'name' => 'sometimes|required|unique:game_channel,name,'.$channel->id,
        'status' => 'required',
      ]);

      if ($validator->fails()) {
        return back()->with('validation_errors', $validator->errors());
      } else {

        $channel->name =  $input['name'];
        $channel->is_active = $input['status'];
        $channel->slug =  Str::slug($input['name']);
        $channel->name_code =  Str::slug($input['name']);
        $channel->save();

        $status = 'Updated channel!';
        return redirect(admin_url('game_channel/view/' . $channel->id))->with('status', $status);
      }
    }

    $adata['data'] = $channel;

    return view('admin.game_channel.edit', $adata);
  }
}
