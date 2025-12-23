<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Member\WorkerController;

use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Models\Banner;

class BannerController extends Controller
{

  public function __construct()
  { }


  public function new(Request $request)
  {
    $adata = [];

    $input = $request->all();

    if (isset($input['submit'])) {
      $validator = Validator::make($input, [
        'lang' => 'required',
        'file' => 'required',
      ]);

      if ($validator->fails()) {
        return  back()->with('validation_errors', $validator->errors());
      } else {

        $file = $input['file'];
        $destinationPath = public_path('uploads/banners/');
        $ext = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $md5Name = md5_file($file->getRealPath());
        $fname = $md5Name . '.' . $ext;

        //Move Uploaded File
        $file->move($destinationPath, $fname);

        $banner = Banner::create([
          'lang' => $input['lang'],
          'filename' => $fname,
          'is_active' => 1,
        ]);


        $status = '<b>' . __('app.uploaded') . '!</b>';
        return redirect(admin_url('banner/list'))->with('status', $status);
      }
    }

    return view('admin.banner.new', $adata);
  }

  public function list()
  {
    $adata = [];

    $adata['list'] = Banner::orderBy('id', 'desc')->get();

    return view('admin.banner.list', $adata);
  }

  public function delete(Request $request)
  {

    $input = $request->all();

    if (isset($input['banner_id'])) {

      $banner = Banner::where('id', $input['banner_id'])->first();
      if (empty($banner)) {
        return redirect(admin_url('banner/list'));
      }

      $banner->delete();

      $status = '<b>' . __('app.deleted') . '!</b>';
      return back()->with('status', $status);
    }

    return redirect(admin_url('banner/list'));
  }
}
