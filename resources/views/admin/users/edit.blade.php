@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')
<script src="{{ asset('js/admin/users/new.js?v=').env('ASSET_V', 1) }}" type="text/javascript"></script>
@stop

@section ('content')

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="fas fa-user"></i> {{__('admin.edit_user')}} <?php echo $data->username ?></h1>


  @include ('inc.alerts')

  <div class="row">
    <div class="col-sm-12 col-md-6">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{__('admin.details')}}</h6>
        </div>
        <div class="card-body">

          <form id="frm-add-user" method="post" action="{{ admin_url('users/edit/'.$data->username) }}">
            {{ csrf_field() }}
            <div class="form-group">
              <label>Status</label>
              <select class="form-control" name="is_active">
                <option value="1" <?php echo ($data->is_active == 1) ? 'selected' : '' ?>>Active</option>
                <option value="0" <?php echo ($data->is_active == 0) ? 'selected' : '' ?>>Suspended</option>
              </select>
            </div>
            <div class="form-group">
              <label>Referrer Username</label>
              <input type="text" data-validation="required" class="form-control" name="referrer_username" value="<?php echo ($data->referrer) ? $data->referrer->username : ''?>">
            </div>
            <div class="form-group">
              <label>{{__('admin.member_id')}}</label>
              <input type="text" readonly class="form-control" value="<?php echo $data->username ?>">
            </div>
            <div class="form-group">
              <label>{{__('admin.name')}}</label>
              <input type="text" data-validation="required" class="form-control" name="name" value="<?php echo $data->name ?>">
            </div>
            <div class="form-group">
              <label>{{__('admin.contact')}}</label>
              <input type="text" data-validation="required" class="form-control" name="contact" value="<?php echo $data->contact ?>">
            </div>
            <div class="form-group">
              <label>Country</label>
              <select class="form-control" name="country_id">
                <?php foreach($countryList as $cl) {
                  $selected = ($cl->id == $data->country_id) ? 'selected' : '';
                  echo '<option value="'.$cl->id.'" '.$selected.'>'.$cl->name.' | '.$cl->currency.'</option>';
                } ?>
              </select>
            </div>
            <div class="form-group">
              <label>{{__('admin.rank')}}</label>
              <select name="rank_id" class="form-control" data-validation="required">
                <?php foreach($ranks as $r) {
                  $selected = ($data->rank_id == $r->id) ? 'selected' : '';
                  echo '<option value="'.$r->id.'" '.$selected.'>'.$r->name.' | '.$r->level_name.'</option>';
                } ?>
              </select>
            </div>

            <div class="form-group">
              <label>{{__('admin.password')}}</label>
              <input type="text" class="form-control" name="password">
              <small class="form-text text-muted">{{__('admin.leave_empty')}}</small>
            </div>


            <hr>
            <div class="form-group">
              <label>Bank Name</label>
              <input type="text" class="form-control" name="bank_name" value="<?php echo $data->bank_name ?>">
            </div>
            <div class="form-group">
              <label>Account Name</label>
              <input type="text" class="form-control" name="bank_account_name" value="<?php echo $data->bank_account_name ?>">
            </div>
            <div class="form-group">
              <label>Account No</label>
              <input type="text" class="form-control" name="bank_account_no" value="<?php echo $data->bank_account_no ?>">
            </div>
            <div class="form-group">
              <label>Bank Swift Code</label>
              <input type="text" class="form-control" name="bank_swift_code" value="<?php echo $data->bank_swift_code ?>">
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