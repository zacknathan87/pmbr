@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')

<script src="{{ asset('js/admin/rank/list.js?v=').env('ASSET_V', 1) }}" type="text/javascript"></script>

@stop

@section ('content')

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="fas fa-wallet"></i> {{__('admin.wallet')}}</h1>


  @include ('inc.alerts')

  <div class="row mb-40">
    <div class="col-sm-12 col-md-7">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{__('admin.list')}}</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>{{__('admin.member_id')}}</th>
                  <th>{{__('admin.balance')}}</th>
                  <th width="120">{{__('admin.action')}}</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($list as $l) {


                  // $buttons = '
                  // <a data-toggle="tooltip" data-placement="top" title="View" href="' . admin_url('wallet/view/' . $l->id) . '" class="btn btn-sm btn-primary"><i class="far fa-eye"></i></a>
                  // <a data-toggle="tooltip" data-placement="top" title="Add Balance" href="' . admin_url('wallet/add_balance/' . $l->id) . '" class="btn btn-sm btn-warning text-dark"><i class="fas fa-donate"></i></a>
                  // <a data-toggle="tooltip" data-placement="top" title="Withdrawal" href="' . admin_url('wallet/withdrawal/' . $l->id) . '" class="btn btn-sm btn-success "><i class="fas fa-coins"></i></a>
                  // ';

                  $buttons = '
                  <a data-toggle="tooltip" data-placement="top" title="Add Balance" href="' . admin_url('wallet/add_balance/' . $l->id) . '" class="btn btn-sm btn-warning text-dark"><i class="fas fa-donate"></i></a>
                  <a data-toggle="tooltip" data-placement="top" title="View" href="' . admin_url('wallet/view/' . $l->id) . '" class="btn btn-sm btn-primary"><i class="far fa-eye"></i></a>
                  ';

              
                  echo '
                <tr>
                  <td>' . $l->userDetail->username . '</td>
                  <td>' . currency_format($l->balance, $l->userDetail->country->currency) . '</td>
                  <td style="text-align:right;">' . $buttons . '</td>
                </tr>
                ';
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

@stop