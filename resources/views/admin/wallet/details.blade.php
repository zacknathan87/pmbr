@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')

@stop

@section ('content')

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="fas fa-user"></i> Wallet - <?php echo $data->userDetail->username ?></h1>


  @include ('inc.alerts')

  <div class="row">
    <div class="col-sm-12 col-md-6">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Details</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered " width="100%" cellspacing="0">
              <tr>
                <th width="200">Member ID</th>
                <td><?php echo $data->userDetail->username ?></td>
              </tr>
              <tr>
                <th>Balance</th>
                <td><?php echo currency_format($data->balance, $data->userDetail->country->currency) ?></td>
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
          <h6 class="m-0 font-weight-bold text-primary">Transactions</h6>
        </div>
        <div class="card-body">

          <?php if (!empty($transactions)) { ?>
            <div class="table-responsive">
            <div class="d-flex justify-content-end">{{ $transactions->links() }}</div>
              <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Txn ID</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <!-- <th>Point Type</th> -->
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    foreach ($transactions as $l) {

                      $rowClass = ($l->type == 'credit') ? 'table-danger' : 'table-success';

                      $pointType =  isset($l->point_type) ? $l->point_type : '-';
                      echo '
                        <tr class="'.$rowClass.'">
                          <td>' . $l->txnid . '</td>
                          <td>' . $l->type . '</td>
                          <td>' . currency_format($l->amount, '$') . '</td>
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
            echo 'No data yet.';
          } ?>

        </div>
      </div>
    </div>
  </div>


</div>

@stop