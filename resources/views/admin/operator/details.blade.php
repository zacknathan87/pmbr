@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')

@stop

@section ('content')

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="fas fa-user-secret"></i> {{__('admin.operator')}} - <?php echo $data->id ?></h1>


  @include ('inc.alerts')

  <div class="row">
    <div class="col-sm-12 col-md-6">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{__('admin.details')}}</h6>

          <a href="{{ admin_url('operator/edit/'.$data->id) }}" class="btn btn-card-header btn-sm btn-success "><i class="fas fa-edit"></i> {{__('admin.edit')}}</a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered " width="100%" cellspacing="0">
              <tr>
                <th width="200">ID</th>
                <td><?php echo $data->id ?></td>
              </tr>
              <tr>
                <th>{{__('admin.username')}}</th>
                <td><?php echo $data->username ?></td>
              </tr>
              <tr>
                <th>{{__('admin.remarks')}}</th>
                <td><?php echo $data->remarks ?></td>
              </tr>
              <tr>
                <th>{{__('admin.currency')}}</th>
                <td style="text-transform: uppercase"><?php echo $data->currency ?></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-12 col-md-6">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{__('admin.wallet')}}</h6>

          <a href="{{ admin_url('operator/add_balance/'.$data->wallet->id) }}" class="btn btn-card-header btn-sm btn-warning text-dark "><i class="fas fa-donate"></i> {{__('admin.add_balance')}}</a>

        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered " width="100%" cellspacing="0">
              <tr>
                <th width="200">{{__('admin.balance')}}</th>
                <td><?php echo currency_format($data->wallet->balance, $data->currency) ?></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>



  <div class="row">
    <div class="col-sm-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{__('admin.transactions')}}</h6>
        </div>
        <div class="card-body">

          <?php if (!empty($transactions)) { ?>
            <div class="table-responsive">
            <div class="d-flex justify-content-end">{{ $transactions->links() }}</div>
              <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Txn ID</th>
                    <th>{{__('admin.type')}}</th>
                    <th>{{__('admin.amount')}}</th>
                    <th>{{__('admin.description')}}</th>
                    <!-- <th>Point Type</th> -->
                    <th>{{__('admin.date')}}</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    foreach ($transactions as $l) {

                      $rowClass = ($l->type == 'credit') ? 'table-danger' : 'table-success';
                      $pointType =  isset($l->point_type) ? $l->point_type : '-';
                      echo '
                        <tr class="' . $rowClass . '">
                          <td>' . $l->txnid . '</td>
                          <td>' . $l->type . '</td>
                          <td>' . currency_format($l->amount, $l->adminDetail->currency) . '</td>
                          <td>' . $l->description . '</td>
                          <td>' . dateformat($l->created_at) . '</td>
                        </tr>
                      ';
                    } ?>
                </tbody>
              </table>
              <div class="d-flex justify-content-end">{{ $transactions->links() }}</div>
            </div>

          <?php } else {
            echo __('admin.no_data_yet');
          } ?>

        </div>
      </div>
    </div>
  </div>

</div>

@stop