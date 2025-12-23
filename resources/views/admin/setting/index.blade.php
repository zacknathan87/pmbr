@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')

<script src="{{ asset('js/admin/setting/index.js?v=').env('ASSET_V', 1) }}" type="text/javascript"></script>

@stop

@section ('content')

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="fas fa-cog"></i> {{__('admin.setting')}}</h1>


  @include ('inc.alerts')

  <div class="row">
    <div class="col-sm-12 col-md-6">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{__('admin.all_setting')}}</h6>
        </div>
        <div class="card-body">

          <form id="frm-add-user" method="post" action="{{ admin_url('setting/update') }}">
            {{ csrf_field() }}
            <input type="hidden" value="<?php echo getSetting('game_runtime_start') ?>" name="faux_start_at" />
            <input type="hidden" value="<?php echo getSetting('game_runtime_end') ?>" name="faux_end_at" />

            <div class="form-group">
              <label>{{__('admin.game_start')}}</label>
              <input type="text" class="form-control datetimepicker-input" name="game_runtime_start" id="datetimepicker1" data-validation="required" data-toggle="datetimepicker" data-target="#datetimepicker1" autocomplete="off">
            </div>

            <div class="form-group">
              <label>{{__('admin.game_end')}}</label>
              <input type="text" class="form-control datetimepicker-input" name="game_runtime_end" id="datetimepicker2" data-validation="required" data-toggle="datetimepicker" data-target="#datetimepicker2" autocomplete="off">
            </div>

            <div class="form-group">
              <label>{{__('admin.game_status')}}</label>
              <select name="game_running" class="form-control">
                <option value="1" <?php  echo getSetting('game_running') == 1 ?  'selected' : ''?>>Live</option>
                <option value="0" <?php  echo  getSetting('game_running') == 0 ?  'selected' : ''?>>Off</option>
              </select>
            </div>
            <!-- <div class="form-group">
              <label>{{__('admin.game_runtime_start')}}</label>
              <input type="text" data-validation="required" class="form-control" name="game_runtime_start" value="<?php echo getSetting('game_runtime_start') ?>">
            </div>

            <div class="form-group">
              <label>{{__('admin.game_runtime_end')}}</label>
              <input type="text" data-validation="required" class="form-control" name="game_runtime_end" value="<?php echo getSetting('game_runtime_end') ?>">
            </div> -->


            <div class="form-group" style="text-align: center">
              <button type="submit" name="submit" class="btn btn-success btn-middle btn-lg btn-submit">{{__('admin.update')}}</button>
            </div>
          </form>


        </div>
      </div>
    </div>
  </div>

  <br><br>

</div>

@stop