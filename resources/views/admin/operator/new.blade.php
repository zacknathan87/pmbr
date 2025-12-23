@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')

<script src="{{ asset('js/admin/users/new.js?v=').env('ASSET_V', 1) }}" type="text/javascript"></script>

@stop

@section ('content')

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="fas fa-user-secret"></i> Add Operator</h1>


  @include ('inc.alerts')

  <div class="row">
    <div class="col-sm-12 col-md-6">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{ __('admin.details') }}</h6>
        </div>
        <div class="card-body">

          <form id="frm-add-user" method="post" action="{{ admin_url('operator/new') }}">
            {{ csrf_field() }}
            <div class="form-group">
              <label>Currency</label>
              <select class="form-control" name="currency">
                <option value="myr">USD</option>
                <option value="rmb">RMB</option>
                <option value="usd">USD</option>
                <option value="rp">RP</option>
              </select>
            </div>
            <div class="form-group">
              <label>{{ __('admin.username') }}</label>
              <input type="text" data-validation="required" class="form-control" name="username" value="{{ old('name') }}">
            </div>
            <div class="form-group">
              <label>{{ __('admin.password') }}</label>
              <input type="text" data-validation="required" class="form-control" name="password" value="{{ old('password') }}">
            </div>
            <div class="form-group">
              <label>{{ __('admin.remarks') }}</label>
              <input type="text" class="form-control" name="remarks" value="{{ old('remarks') }}">
            </div>
            <div class="form-group">
              <label>{{ __('admin.wallet_balance') }}</label>
              <input type="text" class="form-control" name="balance" value="0">
            </div>



            <div class="form-group" style="text-align: center">
              <button type="submit" name="submit" class="btn btn-success btn-middle btn-lg ">{{ __('admin.submit') }}</button>
            </div>
          </form>


        </div>
      </div>
    </div>
  </div>

  <br><br>

</div>

@stop