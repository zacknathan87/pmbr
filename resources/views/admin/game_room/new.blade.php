@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')

<script src="{{ asset('js/admin/game/new.js?v=').env('ASSET_V', 1) }}" type="text/javascript"></script>

@stop

@section ('content')

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="fas fa-dice"></i> {{__('admin.add_game_room')}}</h1>


  @include ('inc.alerts')

  <div class="row">
    <div class="col-sm-12 col-md-6">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{__('admin.details')}}</h6>
        </div>
        <div class="card-body">

          <form id="frm-add-room" method="post" action="{{ admin_url('game_room/new') }}">
            {{ csrf_field() }}
            <div class="form-group">
              <label>{{__('admin.room_name')}}</label>
              <input data-validation="required" class="form-control" type="text" name="name" value="" />
            </div>
            <div class="form-group">
              <label>{{__('admin.min_balance')}}</label>
              <input data-validation="number" class="form-control" type="text" name="min_balance" value="0" />
            </div>
            <div class="form-group">
              <label>Min Bet</label>
              <input data-validation="number" class="form-control" type="text" name="min_bet"  />
            </div>
            <div class="form-group">
              <label>Bet Options</label>
              <input data-validation="required" class="form-control" type="text" name="bet_options" />
              <small class="form-text text-muted">Use "," to separate the value.</small>
            </div>
            <div class="form-group">
              <label>{{__('admin.win_ratio')}}</label>
              <div class="input-group mb-2 mr-sm-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">1:</div>
                </div>
                <input type="text" data-validation="number" data-validation-allowing="float" class="form-control" name="win_ratio" value="1">
              </div>
            </div>
            <div class="form-group">
              <label>{{__('admin.status')}}</label>
              <select class="form-control" data-validation="required" name="status">
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