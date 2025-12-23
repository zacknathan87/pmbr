@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')

<script src="{{ asset('js/admin/game/new.js?v=').env('ASSET_V', 1) }}" type="text/javascript"></script>

@stop

@section ('content')

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="fas fa-gamepad"></i> {{__('admin.add_game')}}</h1>


  @include ('inc.alerts')

  <div class="row">
    <div class="col-sm-12 col-md-6">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{__('admin.game_details')}}</h6>
        </div>
        <div class="card-body">

          <form id="frm-add-game" method="post" action="{{ admin_url('game/new') }}">
            {{ csrf_field() }}
         
            <div class="form-group">
              <label>{{__('admin.question')}}</label>
              <select class="form-control" data-validation="required" name="question_id" disabled="true">
                <option value="">{{__('admin.select_question')}}</option>
              </select>
            </div>
            <div class="form-group">
              <label>{{__('admin.date')}}</label>
              <input type="text" class="form-control datetimepicker-input" name="start_date" id="datetimepicker1" data-validation="required" data-toggle="datetimepicker" data-target="#datetimepicker1" autocomplete="off">
            </div>
            <div class="form-group">
              <label>{{__('admin.start_at')}}</label>
              <select name="start_time" class="form-control">
                <option value="10:00:00">10 AM</option>
                <option value="12:00:00">12 PM</option>
                <option value="14:00:00">2 PM</option>
                <option value="16:00:00">4 PM</option>
                <option value="18:00:00">6 PM</option>
                <option value="20:00:00">8 PM</option>
                <option value="22:00:00">10 PM</option>
                <option value="00:00:00">12 AM</option>
              </select>
            </div>
            <div class="form-group">
              <label>{{__('admin.end_at')}}</label>
              <input name="faux_end_time" class="form-control" readonly value="12 PM">
            </div>
            <input type="hidden" value="<?php echo date('Y-m-d H:i:s') ?>" name="faux_start_at" />
            <input type="hidden" value="<?php echo date('H:i:s', strtotime('10:00:00 +2 hours')) ?>" name="end_time" />
            <!-- <div class="form-group">
              <label>Duration (Minutes)</label>
              <input type="text" class="form-control" data-validation="number"  data-validation-allowing="range[10;240]" name="duration">
              <small class="form-text text-muted">Min: 10</small>
            </div> -->
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