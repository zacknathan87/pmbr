@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')
<script src="{{ asset('js/admin/withdrawal/approve.js?v=').env('ASSET_V', 1) }}" type="text/javascript"></script>

@stop

@section ('content')

<?php


$status = '<span class="badge badge-warning badge-100">Pending</span>';
if ($data->status == 2) {
  $status = '<span class="badge badge-success badge-100">Approved</span>';
}
if ($data->status == 3) {
  $status = '<span class="badge badge-danger badge-100">Rejected</span>';
}

?>

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="fas fa-hand-holding-usd"></i> {{__('admin.withdrawal_request')}} #<?php echo $data->id ?></h1>


  @include ('inc.alerts')

  <div class="row">
    <div class="col-sm-12 col-md-6">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{__('admin.details')}}</h6>
        </div>
        <div class="card-body">
          <div class="">
            <table class="table table-bordered " width="100%" cellspacing="0">
              <tr>
                <th width="200">{{__('admin.request_id')}}</th>
                <td><?php echo $data->id ?></td>
              </tr>
              <tr>
                <th>{{__('admin.bank_name')}}</th>
                <td><?php showOrDash($data->bank_name)  ?></td>
              </tr>
              <tr>
                <th>{{__('admin.account_name')}}</th>
                <td><?php showOrDash($data->account_name)  ?></td>
              </tr>
              <tr>
                <th>{{__('admin.account_no')}}</th>
                <td><?php showOrDash($data->account_no)  ?></td>
              </tr>
              <tr>
                <th>{{__('admin.country')}}</th>
                <td><?php showOrDash($data->country)  ?></td>
              </tr>
              <tr>
                <th>{{__('admin.swift_code')}}</th>
                <td><?php showOrDash($data->bank_swift_code)  ?></td>
              </tr>
              <tr>
                <th width="200">{{__('admin.amount')}}</th>
                <td><b><?php echo currency_format($data->amount, $data->userDetail->userCurrency()) ?></b></td>
              </tr>
              <tr>
                <th>{{__('admin.status')}}</th>
                <td><?php echo $status ?></td>
              </tr>
              <tr>
                <th>{{__('admin.request_at')}}</th>
                <td><?php echo dateformat($data->created_at) ?></td>
              </tr>
            </table>

            <?php if ($data->status == 1) { ?>
              <div style="text-align: center">
                <div class="row">

                <div class="col-6">
                    <form id="frm-reject-withdrawal" action="{{ admin_url('withdrawal_request/reject') }}" method="post">
                      <div class="form-group" style="display:none">
                        <label>{{__('admin.member_id')}}</label>
                        <input type="text" class="form-control" value="<?php echo $data->username ?>">
                      </div>
                      <div class="form-group" style="display:none">
                        <label>{{__('admin.amount')}}</label>
                        <input type="text" class="form-control" value="<?php echo currency_format($data->amount) ?>">
                      </div>
                      <input type="hidden" name="withdrawal_request_id" value="<?php echo $data->id ?>">
                      <button type="submit" class="btn btn-lg btn-danger btn-middle btn-reject">{{__('admin.reject')}}</button>
                    </form>
                  </div>
                  
                  <div class="col-6">
                    <form id="frm-approve-withdrawal" action="{{ admin_url('withdrawal_request/approve') }}" method="post">
                      <div class="form-group" style="display:none">
                        <label>{{__('admin.member_id')}}</label>
                        <input type="text" class="form-control" value="<?php echo $data->username ?>">
                      </div>
                      <div class="form-group" style="display:none">
                        <label>{{__('admin.amount')}}</label>
                        <input type="text" class="form-control" value="<?php echo currency_format($data->amount) ?>">
                      </div>
                      <input type="hidden" name="withdrawal_request_id" value="<?php echo $data->id ?>">
                      <button type="submit" class="btn btn-lg btn-success btn-middle btn-submit">{{__('admin.approve')}}</button>
                    </form>
                  </div>

                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-12 col-md-6">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{__('admin.agent_details')}}</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered " width="100%" cellspacing="0">

              <tr>
                <th width="200">{{__('admin.agent_id')}}</th>
                <td><a href="{{ admin_url('operator/view/'.$data->userDetail->createdByDetail->id) }}"><?php echo $data->userDetail->createdByDetail->id ?></a></td>
              </tr>
              <tr>
                <th>{{__('admin.agent_name')}}</th>
                <td><a href="{{ admin_url('operator/view/'.$data->userDetail->createdByDetail->id) }}"><?php echo $data->userDetail->createdByDetail->username ?></a></td>
              </tr>
              <tr>
                <th>{{__('admin.currency')}}</th>
                <td><?php echo strtoupper($data->userDetail->createdByDetail->currency) ?></td>
              </tr>
            </table>
          </div>
        </div>
      </div>

      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{__('admin.user_details')}}</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered " width="100%" cellspacing="0">

              <tr>
                <th width="200">{{__('admin.user_balance')}}</th>
                <td><?php echo currency_format($data->userDetail->wallet->balance) ?></td>
              </tr>
              <tr>
                <th width="200">{{__('admin.member_id')}}</th>
                <td><a href="{{ admin_url('users/view/'.$data->username) }}"><?php echo $data->username ?></a></td>
              </tr>
              <tr>
                <th>{{__('admin.name')}}</th>
                <td><?php echo $data->userDetail->name ?></td>
              </tr>
              <tr>
                <th>{{__('admin.contact')}}</th>
                <td><?php echo $data->userDetail->contact ?></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>




  </div>


  <br><br>

</div>

@stop