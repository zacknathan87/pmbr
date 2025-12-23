@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')

<script src="{{ asset('js/admin/users/new.js?v=').env('ASSET_V', 1) }}" type="text/javascript"></script>

@stop

@section ('content')

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="fas fa-key"></i> {{ __('admin.change_password') }}</h1>


  @include ('inc.alerts')

  <div class="row">
    <div class="col-sm-12 col-md-6">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{ __('admin.details') }}</h6>
        </div>
        <div class="card-body">

          <form id="frm-add-user" method="post" action="{{ admin_url('account/change_password') }}">
            {{ csrf_field() }}
            
            <div class="form-group">
              <label>{{ __('admin.current_password') }}</label>
              <input type="password" data-validation="required" class="form-control" name="current_password" value="">
            </div>
            <div class="form-group">
              <label>{{ __('admin.new_password') }}</label>
              <input type="text" data-validation="required" class="form-control" name="new_password" value="">
            </div>
            <div class="form-group">
              <label>{{ __('admin.confirm_new_password') }}</label>
              <input type="text" data-validation="required" class="form-control" name="confirm_new_password" value="">
            </div>

            <div class="form-group" style="text-align: center">
              <button type="submit" name="submit" class="btn btn-success btn-middle btn-lg ">{{ __('admin.update') }}</button>
            </div>
          </form>


        </div>
      </div>
    </div>
  </div>

  <br><br>

</div>

@stop