@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')

<script src="{{ asset('js/admin/users/new.js?v=').env('ASSET_V', 1) }}" type="text/javascript"></script>

@stop

@section ('content')

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="fas fa-user"></i> {{__('admin.add_user')}}</h1>


  @include ('inc.alerts')

  <div class="row">
    <div class="col-sm-12 col-md-6">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{__('admin.details')}}</h6>
        </div>
        <div class="card-body">

          <form id="frm-add-user" method="post" action="{{ admin_url('users/new') }}">
            {{ csrf_field() }}
            <div class="form-group">
              <label>Referrer Username </label>
              <input type="text" data-validation="required" class="form-control" name="referrer_username" value="{{ old('referrer_username') }}">
            </div>
            <div class="form-group">
              <label>{{__('admin.member_id')}} / {{__('admin.username')}} </label>
              <input type="text" data-validation="required" class="form-control" name="username" value="{{ old('username') }}">
            </div>
            <div class="form-group">
              <label>{{__('admin.name')}}</label>
              <input type="text" data-validation="required" class="form-control" name="name" value="{{ old('name') }}">
            </div>
            <div class="form-group">
              <label>{{__('admin.contact')}}</label>
              <input type="text" data-validation="required" class="form-control" name="contact"value="{{ old('contact') }}">
            </div>
            <div class="form-group">
              <label>Country</label>
              <select class="form-control" name="country_id">
                <?php foreach($countryList as $cl) {
                  echo '<option value="'.$cl->id.'">'.$cl->name.' | '.$cl->currency.'</option>';
                } ?>
              </select>
            </div>
            <div class="form-group">
              <label>{{__('admin.password')}}</label>
              <input type="text" data-validation="required" class="form-control" name="password" value="{{ old('password') }}">
            </div>
            <div class="form-group">
              <label>Confirm Password</label>
              <input type="text" data-validation="required" class="form-control" name="confirm_password" value="{{ old('confirm_password') }}">
            </div>
            <div class="form-group">
              <label>{{__('admin.rank')}}</label>
              <select name="rank_id" class="form-control" data-validation="required">
                <?php foreach($ranks as $r) {
                  echo '<option value="'.$r->id.'">'.$r->name.' | '.$r->level_name.'</option>';
                } ?>
              </select>
            </div>
            <div class="form-group">
              <label>{{__('admin.wallet_balance')}}</label>
              <input type="text" class="form-control" name="balance" value="0">
            </div>

            <hr>
            <div class="form-group">
              <label>Bank Name</label>
              <input type="text" class="form-control" name="bank_name" value="{{ old('bank_name') }}">
            </div>
            <div class="form-group">
              <label>Account Name</label>
              <input type="text" class="form-control" name="bank_account_name" value="{{ old('bank_account_name') }}">
            </div>
            <div class="form-group">
              <label>Account No</label>
              <input type="text" class="form-control" name="bank_account_no" value="{{ old('bank_account_no') }}">
            </div>
            <div class="form-group">
              <label>Bank Swift Code</label>
              <input type="text" class="form-control" name="bank_swift_code" value="{{ old('bank_swift_code') }}">
            </div>



            <div class="form-group" style="text-align: center">
              <button type="submit" name="submit" class="btn btn-success btn-middle btn-lg ">{{__('admin.submit')}}</button>
            </div>
          </form>


        </div>
      </div>
    </div>
  </div>

  <br><br>

</div>

@stop