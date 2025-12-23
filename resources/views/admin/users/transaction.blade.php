@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')
<script src="{{ asset('js/admin/users/transaction_list.js?v=').env('ASSET_V', 1) }}"></script>

@stop

@section ('content')


<?php

$range = isset($_GET['range']) ? $_GET['range'] : 'today';

?>

<?php
$start_get = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d');
$end_get = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

?>

<script>
  var start_get = "<?php echo $start_get  ?>"
  var end_get = "<?php echo $end_get  ?>"
</script>



<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="fas fa-users"></i> {{__('admin.users_transaction')}}</h1>


  @include ('inc.alerts')


  <div class="row">
    <div class="col-sm-12 col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Filter</h6>
        </div>
        <div class="card-body">

          <form method="get" action="{{ admin_url('users/transaction_list') }}" style="padding: 10px">
            <div class="row">
              <div class="col-sm-12 col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">TXN ID</label>
                  <div class="col-sm-9">
                    <input type="text" name="txnid" class="form-control form-control-sm" value="<?php echo isset($_GET['txnid']) ? $_GET['txnid'] : ''; ?>">
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-md-6">

                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Member ID</label>
                  <div class="col-sm-9">
                    <input type="text" name="username" class="form-control form-control-sm" value="<?php echo isset($_GET['username']) ? $_GET['username'] : ''; ?>">
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Credit/Debit</label>
                  <div class="col-sm-9">
                    <select class="form-control form-control-sm" name="trans_type">
                      <option value="all">All</option>
                      <?php
                      $type = ['credit', 'debit'];
                      foreach ($type as $w) {
                        $selected = (isset($_GET['trans_type']) && $_GET['trans_type'] == $w) ? 'selected' : '';
                        echo '<option ' . $selected . ' value="' . $w . '">' . ucfirst($w) . '</option>';
                      }
                      ?>

                    </select>
                  </div>
                </div>
              </div>
              <!-- <div class="col-sm-12 col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Point Type</label>
                  <div class="col-sm-9">
                    <select class="form-control form-control-sm" name="point_type">
                      <option value="all">All</option>
                      <?php
                      $type = ['Type A', 'Type B', 'Type C'];
                      foreach ($type as $w) {
                        $selected = (isset($_GET['point_type']) && $_GET['point_type'] == $w) ? 'selected' : '';
                        echo '<option ' . $selected . ' value="' . $w . '">' . $w . '</option>';
                      }
                      ?>

                    </select>
                  </div>
                </div>
              </div> -->
              <div class="col-sm-12 col-md-6">
                <input type="hidden" value="" name="start_date" id="start_date" />
                <input type="hidden" value="" name="end_date" id="end_date" />

                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Start Date</label>
                  <div class="col-sm-9">
                    <div id="reportrange_start" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                      <i class="fa fa-calendar"></i>&nbsp;
                      <span></span> <i class="fa fa-caret-down"></i>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">End Date</label>
                  <div class="col-sm-9">
                    
                  <div id="reportrange_end" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span> <i class="fa fa-caret-down"></i>
                      </div>
                  </div>
                </div>
              </div>

              <div class="col-12">

                <div class="form-group ">
                 
                  <div class="row" style="margin-bottom: 35px;">
                    <input type="hidden" name="range" value="<?php echo $range ?>" />
                    <div class="col-sm"><button type="button" data-range="today" class="btn-prefix-range btn <?php echo ($range == 'today') ? 'btn-primary' : 'btn-outline-primary' ?> btn-sm btn-block">Today</button></div>
                    <div class="col-sm"><button type="button" data-range="yesterday" class="btn-prefix-range btn <?php echo ($range == 'yesterday') ? 'btn-primary' : 'btn-outline-primary' ?>  btn-sm btn-block">Yesterday</button></div>
                    <div class="col-sm"><button type="button" data-range="this_week" class="btn-prefix-range btn <?php echo ($range == 'this_week') ? 'btn-primary' : 'btn-outline-primary' ?>  btn-sm btn-block">This Week</button></div>
                    <div class="col-sm"><button type="button" data-range="this_month" class="btn-prefix-range btn <?php echo ($range == 'this_month') ? 'btn-primary' : 'btn-outline-primary' ?>  btn-sm btn-block">This Month</button></div>
                    <div class="col-sm"><button type="button" data-range="last_month" class="btn-prefix-range btn <?php echo ($range == 'last_month') ? 'btn-primary' : 'btn-outline-primary' ?>  btn-sm btn-block">Last Month</button></div>
                  </div>
                </div>
              </div>

            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <button class="btn btn-info btn-lg" style="width: 150px" type="submit" name="submit" value="submit">Filter</button>
                    <a href="{{ admin_url('users/transaction_list') }}" class=" btn btn-lg btn-secondary">Clear</a>
                  </div>
                </div>
              </div>
            </div>



          </form>
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
            <div class="">
              <div class="d-flex justify-content-end">{{ $transactions->links() }}</div>

              <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Txn ID</th>
                    <th>{{__('admin.member_id')}}</th>
                    <th>{{__('admin.amount')}}</th>
                    <th>{{__('admin.description')}}</th>
                    <th>{{__('admin.date')}}</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    foreach ($transactions as $l) {

                      $rowClass = ($l->type == 'credit') ? 'table-danger' : 'table-success';

                      $buttons = '';


                      $buttons .= '
                        <a href="' . admin_url('users/transaction/view/' . $l->id) . '" class="btn btn-sm btn-primary"><i class="far fa-eye"></i></a>
                        ';

                      $currency = $l->userDetail->country->currency;

                      echo '
                        <tr class="' . $rowClass . '">
                          <td>' . $l->txnid . '</td>
                          <td><a href="' . admin_url('users/view/' . $l->username) . '">' . $l->userDetail->username . '</a></td>
                          <td>' . currency_format($l->amount, $currency) . '</td>
                          <td>' . $l->description . '</td>
                          <td>' . dateformat($l->created_at) . '</td>
                          <td>' . $buttons . '</td>
                        </tr>
                      ';
                    } ?>
                </tbody>
              </table>
              <div class="d-flex justify-content-end">{{ $transactions->links() }}</div>

            </div>

          <?php } else {
            echo __('app.no_data_yet');
          } ?>

        </div>
      </div>
    </div>
  </div>

</div>

@stop