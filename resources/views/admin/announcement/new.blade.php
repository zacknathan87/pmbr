@extends ('admin.plane')

@section('pagespecificstyles')
<link rel="stylesheet" href="{{ asset("plugins/summernote/summernote-lite.css") }}" />

@stop

@section('pagespecificscripts')
<script src="{{ asset('plugins/summernote/summernote-lite.min.js') }}"></script>

<script src="{{ asset('js/admin/announcement/new.js?v=').env('ASSET_V', 1) }}" type="text/javascript"></script>

@stop

@section ('content')

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="fas fa-bullhorn"></i> {{__('admin.add_announcement')}}</h1>


  @include ('inc.alerts')

  <div class="row">
    <div class="col-sm-12 col-md-8">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{__('admin.announcement')}}</h6>
        </div>
        <div class="card-body">

          <form id="frm-add-announcement" method="post" action="{{ admin_url('announcement/new') }}">
            {{ csrf_field() }}

            <div class="form-group">
              <label>{{__('admin.language')}}</label>
              <select class="form-control" data-validation="required" name="lang">
                <option value="">{{__('admin.select_language')}}</option>
                <option value="cn">Mandarin</option>
                <option value="en">English</option>
                <option value="my">Bahasa Malaysia</option>
              </select>
            </div>
            <div class="form-group">
              <label>{{__('admin.title')}}</label>
              <input data-validation="required" class="form-control" name="title"/>
            </div>
            <div class="form-group">
              <label>{{__('admin.content')}}</label>
              <textarea data-validation="required" id="summernote"  class="form-control" name="content"></textarea>
            </div>

            <div class="form-group" style="text-align: center">
              <button type="submit" name="submit" value="submit" class="btn btn-success btn-middle btn-lg btn-submit">{{__('admin.submit')}}</button>
            </div>
          </form>


        </div>
      </div>
    </div>
  </div>

  <br><br>

</div>

@stop