@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')
<script src="{{ asset('js/admin/users/new.js?v=').env('ASSET_V', 1) }}" type="text/javascript"></script>
@stop

@section ('content')

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="fas fa-user-secret"></i> Edit Operator #<?php echo $data->id ?></h1>


  @include ('inc.alerts')

  <div class="row">
    <div class="col-sm-12 col-md-6">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{__('admin.operator')}}</h6>
        </div>
        <div class="card-body">

          <form id="frm-add-user" method="post" action="{{ admin_url('operator/edit/'.$data->id) }}">
            {{ csrf_field() }}
            <div class="form-group">
              <label>ID</label>
              <input type="text" readonly class="form-control" value="<?php echo $data->id ?>">
            </div>
            <div class="form-group">
              <label>{{__('admin.currency')}}</label>
              <select class="form-control" name="currency">
                <option value="myr" <?php ($data->currency == 'myr') ? 'selected' : ''; ?>>USD</option>
                <!-- <option value="rmb" <?php ($data->currency == 'rmb') ? 'selected' : ''; ?>>RMB</option>
                <option value="usd" <?php ($data->currency == 'usd') ? 'selected' : ''; ?>>USD</option>
                <option value="rp" <?php ($data->currency == 'rp') ? 'selected' : ''; ?>>RP</option> -->
              </select>
            </div>
            <div class="form-group">
              <label>{{__('admin.username')}}</label>
              <input type="text" data-validation="required" class="form-control" name="username" value="<?php echo $data->username ?>">
            </div>
            <div class="form-group">
              <label>{{__('admin.password')}}</label>
              <input type="text" class="form-control" name="password">
              <small class="form-text text-muted">{{__('admin.leave_empty')}}</small>
            </div>
            <div class="form-group">
              <label>{{__('admin.remarks')}}</label>
              <input type="text" class="form-control" name="remarks"  value="<?php echo $data->remarks ?>">
            </div>

            <div class="form-group" style="text-align: center">
              <button type="submit" name="submit" class="btn btn-success btn-middle btn-lg">{{__('admin.update')}}</button>
            </div>
          </form>


        </div>
      </div>
    </div>
  </div>

  <br><br>

</div>

@stop