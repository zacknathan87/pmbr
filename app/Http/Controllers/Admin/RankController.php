<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Member\WorkerController;

use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Models\Rank;

class RankController extends Controller
{

  public function __construct()
  { }


  public function new(Request $request)
  {
    $adata = [];

    $input = $request->all();

    if (isset($input['submit'])) {
      $validator = Validator::make($input, [
        'name' => 'required',
        'level_name' => 'required',
      ]);

      if ($validator->fails()) {
        return  back()->with('validation_errors', $validator->errors());
      } else {

        $rank = Rank::create([
          'name' => $input['name'],
          'level_name' => $input['level_name'],
          'amount' => $input['amount'],
          'bonus' => $input['bonus'],
          'skip_level_bonus' => $input['skip_level_bonus'],
          'is_active' => 1,
        ]);


        $status = '<b>Added!</b>';
        return redirect(admin_url('rank/list'))->with('status', $status);
      }
    }

    return view('admin.rank.new', $adata);
  }

  public function edit(Request $request, $id = null)
  {
    $adata = [];


    if (empty($id)) {
      return redirect(admin_url('rank/list'));
    }

    $rank = Rank::where('id', $id)->first();

    if (empty($rank)) {
      return redirect(admin_url('rank/list'));
    }

    $input = $request->all();

    if ($input) {

      $validator = Validator::make($input, [
        'name' => 'required',
        'level_name' => 'required',
      ]);

      if ($validator->fails()) {
        return back()->with('validation_errors', $validator->errors());
      } else {

        $rank->name = $input['name'];
        $rank->level_name = $input['level_name'];
        $rank->amount = $input['amount'];
        $rank->bonus = $input['bonus'];
        $rank->skip_level_bonus = $input['skip_level_bonus'];

        $rank->save();


        $status = 'Updated rank!';
        return redirect(admin_url('rank/list/'))->with('status', $status);
      }
    }


    $adata['data'] = $rank;
    
    return view('admin.rank.edit', $adata);
  }


  public function list()
  {
    $adata = [];

    $adata['list'] = Rank::orderBy('id', 'asc')->get();

    return view('admin.rank.list', $adata);
  }

  public function delete(Request $request)
  {

    $input = $request->all();

    if (isset($input['rank_id'])) {

      $rank = Rank::where('id', $input['rank_id'])->first();
      if (empty($rank)) {
        return redirect(admin_url('rank/list'));
      }

      $rank->delete();

      $status = '<b>' . __('app.deleted') . '!</b>';
      return back()->with('status', $status);
    }

    return redirect(admin_url('rank/list'));
  }
}
