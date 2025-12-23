<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Member\WorkerController;

use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Models\Investor;

class InvestorController extends Controller
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
        'bank_name' => 'required',
        'bank_account_no' => 'required',
      ]);

      if ($validator->fails()) {
        return  back()->with('validation_errors', $validator->errors());
      } else {

        $investor = Investor::create([
          'name' => $input['name'],
          'bank_name' => $input['bank_name'],
          'bank_account_no' => $input['bank_account_no'],
        ]);


        $status = '<b>Added!</b>';
        return redirect(admin_url('investor/list'))->with('status', $status);
      }
    }

    return view('admin.investor.new', $adata);
  }

  public function edit(Request $request, $id = null)
  {
    $adata = [];


    if (empty($id)) {
      return redirect(admin_url('investor/list'));
    }

    $investor = Investor::where('id', $id)->first();

    if (empty($investor)) {
      return redirect(admin_url('investor/list'));
    }

    $input = $request->all();

    if ($input) {

      $validator = Validator::make($input, [
        'name' => 'required',
        'bank_name' => 'required',
        'bank_account_no' => 'required',
      ]);

      if ($validator->fails()) {
        return back()->with('validation_errors', $validator->errors());
      } else {

        $investor->name = $input['name'];
        $investor->bank_name = $input['bank_name'];
        $investor->bank_account_no = $input['bank_account_no'];

        $investor->save();


        $status = 'Updated investor!';
        return redirect(admin_url('investor/list/'))->with('status', $status);
      }
    }


    $adata['data'] = $investor;
    
    return view('admin.investor.edit', $adata);
  }


  public function list()
  {
    $adata = [];

    $adata['list'] = Investor::orderBy('id', 'asc')->get();

    return view('admin.investor.list', $adata);
  }

  public function delete(Request $request)
  {

    $input = $request->all();

    if (isset($input['investor_id'])) {

      $investor = Investor::where('id', $input['investor_id'])->first();
      if (empty($investor)) {
        return redirect(admin_url('investor/list'));
      }

      $investor->delete();

      $status = '<b>' . __('app.deleted') . '!</b>';
      return back()->with('status', $status);
    }

    return redirect(admin_url('investor/list'));
  }
}
