@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')

@stop

@section ('content')

<?php

$winLossCount = $data->totalWinning() - $data->totalBetsAmount();
if($winLossCount > 0) {
  $winLoss = '<span class="text-success"><b>'.currency_format($winLossCount, $data->country->currency).'</b></span>';
} else {
  $winLoss = '<span class="text-danger"><b>'.currency_format($winLossCount, $data->country->currency).'</b></span>';
}


$todayWinLossCount = $data->todayWinning() - $data->todayBetAmount();
if($todayWinLossCount > 0) {
  $todayWinLoss = '<span class="text-success"><b>'.currency_format($todayWinLossCount, $data->country->currency).'</b></span>';
} else {
  $todayWinLoss = '<span class="text-danger"><b>'.currency_format($todayWinLossCount, $data->country->currency).'</b></span>';
}

$deposit = '<span class="text-success"><b>' . currency_format($data->depositAmount(), $data->country->currency) . '</b></span>';
$withdrawal = '<span class="text-danger"><b>' . currency_format($data->withdrawalAmount(), $data->country->currency) . '</b></span>';
$depositWithdrawal = $deposit . ' / ' . $withdrawal;

$status = ($data->is_active) ? '<span class="badge badge-success badge-100">' . __('admin.active') . '</span>' : '<span class="badge badge-100 badge-warning">' . __('admin.inactive') . '</span>';

?>

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="fas fa-user"></i> {{__('admin.user')}} - <?php echo $data->username ?></h1>


  @include ('inc.alerts')

  <div class="row">
    <div class="col-sm-12 col-md-6">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{__('admin.details')}}</h6>

          <a href="{{ admin_url('users/edit/'.$data->username) }}" class="btn btn-card-header btn-sm btn-success "><i class="fas fa-edit"></i> {{__('admin.edit')}}</a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered " width="100%" cellspacing="0">
            <tr>
                <th width="200">Status</th>
                <td><?php echo $status ?></td>
              </tr>

              <tr>
                <th width="200">Referrer</th>
                <td>
                  <?php if (isset($data->referrer)) { ?>
                    <a href="<?php echo admin_url('users/view/' . $data->referrer->username) ?>"><?php echo $data->referrer->username ?></a>
                  <?php } else {
                    echo '-';
                  } ?>

                </td>
              </tr>

              <tr>
                <th width="200">{{__('admin.member_id')}}</th>
                <td><?php echo $data->username ?></td>
              </tr>
              <tr>
                <th>Country</th>
                <td><?php echo $data->country->name ?></td>
              </tr>
              <tr>
                <th>{{__('admin.rank')}}</th>
                <td><?php echo $data->rank->name . ' | ' . $data->rank->level_name ?></td>
              </tr>
              <tr>
                <th>{{__('admin.name')}}</th>
                <td><?php echo $data->name ?></td>
              </tr>
              <tr>
                <th>{{__('admin.contact')}}</th>
                <td><?php echo $data->contact ?></td>
              </tr>
              <tr>

                <tr>
                <th>{{__('admin.id')}}</th>
                <td><?php echo $data->nric ?></td>
              </tr>
              <tr>

                <th>User Referral Link</th>
                <td><?php echo url('register/' . $data->username); ?></td>
              </tr>
              <tr>
                <th>{{__('admin.bank_name')}}</th>
                <td><?php echo $data->bank_name ?></td>
              </tr>
              <tr>
                <th>{{__('admin.account_name')}}</th>
                <td><?php echo $data->bank_account_name ?></td>
              </tr>
              <tr>
                <th>{{__('admin.account_no')}}</th>
                <td><?php echo $data->bank_account_no ?></td>
              </tr>
              <tr>
                <th>{{__('admin.swift_code')}}</th>
                <td><?php echo $data->bank_swift_code ?></td>
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

          <a href="{{ admin_url('wallet/add_balance/'.$data->wallet->id) }}" class="btn btn-card-header btn-sm btn-warning text-dark "><i class="fas fa-donate"></i> {{__('admin.add_balance')}}</a>

        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered " width="100%" cellspacing="0">
              <tr>
                <th width="200">{{__('admin.balance')}}</th>
                <td><?php echo currency_format($data->wallet->balance, $data->country->currency) ?></td>
              </tr>
              <tr>
                <th width="200">Today Win/Loss</th>
                <td><?php echo $todayWinLoss; ?></td>
              </tr>
              <tr>
                <th width="200">Win/Loss</th>
                <td><?php echo $winLoss; ?></td>
              </tr>
              <tr>
                <th width="200">Deposit/Withdrawal</th>
                <td><?php echo $depositWithdrawal; ?></td>
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
          <h6 class="m-0 font-weight-bold text-primary">{{__('admin.stats')}}</h6>
        </div>
        <div class="card-body">
          <div class="row mb-4">
            <div class="col-sm-12 col-md-3">
              <div class="card">
                <div class="card-body">
                  <span>Today Deposit</span>
                  <h2 style="margin: 0"><?php echo currency_format($data->todayDeposit(), $data->country->currency) ?></h2>
                </div>
              </div>
            </div>
            <div class="col-sm-12 col-md-3">
              <div class="card">
                <div class="card-body">
                  <span>Today Bet</span>
                  <h2 style="margin: 0"><?php echo currency_format($data->todayBetAmount(), $data->country->currency) ?></h2>
                </div>
              </div>
            </div>

            <div class="col-sm-12 col-md-3">
              <div class="card">
                <div class="card-body">
                  <span>Today Win</span>
                  <h2 style="margin: 0"><?php echo currency_format($data->todayWinning(), $data->country->currency) ?></h2>
                </div>
              </div>
            </div>

            <div class="col-sm-12 col-md-3">
              <div class="card">
                <div class="card-body">
                  <span>Today Loss</span>
                  <h2 style="margin: 0"><?php echo currency_format($data->todayBetAmount() - $data->todayWinning(), $data->country->currency) ?></h2>
                </div>
              </div>
            </div>

          </div>

          <div class="row">
            <div class="col-sm-12 col-md-3">
              <div class="card">
                <div class="card-body">
                  <span>{{__('admin.total_bet')}}</span>
                  <h2 style="margin: 0"><?php echo $data->totalBetsCount() ?></h2>
                </div>
              </div>
            </div>
            <div class="col-sm-12 col-md-3">
              <div class="card">
                <div class="card-body">
                  <span>{{__('admin.total_bet_amount')}}</span>
                  <h2 style="margin: 0"><?php echo currency_format($data->totalBetsAmount(), $data->country->currency) ?></h2>
                </div>
              </div>
            </div>

            <div class="col-sm-12 col-md-3">
              <div class="card">
                <div class="card-body">
                  <span>{{__('admin.winning_amount')}}</span>
                  <h2 style="margin: 0"><?php echo currency_format($data->totalWinning(), $data->country->currency) ?></h2>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-6">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Downline</h6>
        </div>
        <div class="card-body">

          <?php if (!empty($downline)) { ?>
            <div class="table-responsive">

              <div class="d-flex justify-content-end">{{ $downline->links() }}</div>
              <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Member</th>
                    <th>Reg. Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    foreach ($downline as $l) {

                      echo '
                        <tr>
                          <td><a href="'.admin_url('users/view/'.$l->username).'">'  .$l->username . '</a></td>
                          <td>' . dateformat($l->created_at) . '</td>
                        </tr>
                      ';
                    } ?>
                </tbody>
              </table>

              <div class="d-flex justify-content-end">{{ $downline->links() }}</div>
            </div>

          <?php } else {
            echo __('admin.no_data_yet');
          } ?>

        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-6">
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
                          <td>' . __('admin.' . $l->type) . '</td>
                          <td>' . currency_format($l->amount, $data->country->currency) . '</td>
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
    <div class="col-sm-6">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{__('admin.bet_list')}}</h6>
        </div>
        <div class="card-body">

          <?php if (!empty($bets)) { ?>
            <div class="table-responsive">

              <div class="d-flex justify-content-end">{{ $bets->links() }}</div>
              <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>{{__('admin.game_id')}}</th>
                    <th>{{__('admin.bet_no')}}</th>
                    <th>{{__('admin.bet_amount')}}</th>
                    <th>{{__('admin.date')}}</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    foreach ($bets as $l) {

                      $rowClass = '';
                      if ($l->is_win) {
                        $rowClass = 'table-success';
                      }
                      $betType = '';
                      if($l->betType) {
                        $betType =  $l->betType->name;
                      } else {
                        $betType = 'jackpot';
                      }

                      echo '
                        <tr class="' . $rowClass . '">
                          <td>' . $l->game_id . '</td>
                          <td>' .$betType. '</td>
                          <td>' . currency_format($l->amount,  $data->country->currency) . '</td>
                          <td>' . dateformat($l->created_at) . '</td>
                        </tr>
                      ';
                    } ?>
                </tbody>
              </table>

              <div class="d-flex justify-content-end">{{ $bets->links() }}</div>
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