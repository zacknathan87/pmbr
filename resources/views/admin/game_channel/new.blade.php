@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')

<script src="{{ asset('js/admin/game/new.js?v=').env('ASSET_V', 1) }}" type="text/javascript"></script>

@stop

@section ('content')

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="fas fa-server"></i> {{__('admin.add_game_channel')}}</h1>


  @include ('inc.alerts')

  <div class="row">
    <div class="col-sm-12 col-md-6">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{__('admin.details')}}</h6>
        </div>
        <div class="card-body">

          <form id="frm-add-channel" method="post" action="{{ admin_url('game_channel/new') }}">
            {{ csrf_field() }}
            <div class="form-group">
              <label>{{__('admin.channel_name')}}</label>
              <input data-validation="required"  class="form-control" type="text" name="name" value="" />
            </div>
            <div class="form-group">
              <label>{{__('admin.status')}}</label>
              <select data-validation="required"  class="form-control" data-validation="required" name="status">
                <option value="1">{{ __('admin.active') }}</option>
                <option value="0">{{ __('admin.inactive') }}</option>
              </select>
            </div>
            <div class="form-group" style="text-align: center">
              <button type="submit" name="submit" class="btn btn-success btn-middle btn-lg btn-submit">{{__('admin.submit')}}</button>
            </div>
          </form>


        </div>
      </div>
    </div>
  </div>

  <br><br>

</div>

@stop