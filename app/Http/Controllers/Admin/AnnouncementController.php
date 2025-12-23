<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Member\WorkerController;

use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Models\Announcement;

class AnnouncementController extends Controller {

  public function __construct() {

  }


  public function new(Request $request) {
    $adata = [];

    $input = $request->all();

    if(isset($input['submit'])) {
      $validator = Validator::make($input, [
              'lang' => 'required',
              'content' => 'required',
      ]);

      if ($validator->fails()) {
          return  back()->with('validation_errors', $validator->errors() );
      } else {

        $title = $input['title'];
        $lang = $input['lang'];
        $content = $input['content'];

        $author = env('APP_NAME').' Management';
        $announcement = Announcement::create([
            'author' => $author,
            'lang' => $lang,
            'title' => $title,
            'content' => htmlentities($content),
            'is_active' => 1,
        ]);

        return redirect(admin_url('announcement/view/'.$announcement->id));

      }
    }

    return view('admin.announcement.new', $adata);
  }

  public function list() {
    $adata = [];

    $adata['list'] = Announcement::orderBy('id','desc')->paginate();

    return view('admin.announcement.list', $adata);
  }

  public function view($aid = null) {
    $adata = [];

    if(empty($aid)) {
      return redirect(admin_url('announcement/list'));
    }

    $announcement = Announcement::where('id', $aid)->first();
    if(empty($announcement)) {
      return redirect(admin_url('announcement/list'));
    }

    $adata['data'] = $announcement;


    return view('admin.announcement.view', $adata);
  }

  public function edit(Request $request, $aid = null) {
    $adata = [];

    if(empty($aid)) {
      return redirect(admin_url('announcement/list'));
    }

    $announcement = Announcement::where('id', $aid)->first();
    if(empty($announcement)) {
      return redirect(admin_url('announcement/list'));
    }


    $input = $request->all();

    if(isset($input['submit'])) {
      $validator = Validator::make($input, [
              'lang' => 'required',
              'content' => 'required',
      ]);

      if ($validator->fails()) {
          return  back()->with('validation_errors', $validator->errors() );
      } else {

        $title = $input['title'];
        $lang = $input['lang'];
        $content = $input['content'];

        $author =  env('APP_NAME').' Management';

        $announcement->author = $author;
        $announcement->lang = $lang;
        $announcement->title = $title;
        $announcement->content = htmlentities($content);
        $announcement->save();


        $status = '<b>'.__('app.updated').'!</b>';
        return back()->with('status', $status);
      }
    }


    $adata['data'] = $announcement;


    return view('admin.announcement.edit', $adata);
  }

public function delete(Request $request) {

  $input = $request->all();

  if(isset($input['announcement_id'])) {

    $announcement = Announcement::where('id', $input['announcement_id'])->first();
    if(empty($announcement)) {
      return redirect(admin_url('announcement/list'));
    }

    $announcement->delete();
    
    $status = '<b>'.__('app.deleted').'!</b>';
    return back()->with('status', $status);
  }

  return redirect(admin_url('announcement/list'));

}

}