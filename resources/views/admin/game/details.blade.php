@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')
<script src="{{ asset('js/admin/game/details.js?v=').env('ASSET_V', 1) }}" type="text/javascript"></script>

@stop

<?php

$timer = '';
$status = '<span class="tag bg-primary">Pending</span>';
if ($data->status_id == 2) {
  $status = '<span class="tag bg-success">In Progress</span>';

  $sec = 10;
  $timer = ' <div data-time="' . $sec . '" class="timer badge-timer badge badge-primary"></div>';
}
if ($data->status_id == 3) {
  $status = '<span class="tag bg-info">Announcing Winner</span>';
}
if ($data->status_id == 4) {
  $status = '<span class="tag bg-danger">Ended</span>';
}



?>
@section ('content')

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="fas fa-gamepad"></i> {{__('admin.game')}} - #<?php echo $data->id ?> </h1>

  <?php echo $timer ?>


  @include ('inc.alerts')

  <div class="row mb-40">
    <div class="col-sm-12">

      <div class="row">
        <div class="col-sm-12 col-md-5">
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">{{__('admin.details')}}</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered " width="100%" cellspacing="0">
                  <tr>
                    <th width="200">{{__('admin.game_id')}}</th>
                    <td><?php echo $data->id ?></td>
                  </tr>
                  <tr>
                    <th>{{__('admin.game')}}</th>
                    <td><?php echo __('app.' . $data->gameType->name_code); ?></td>
                  </tr>
                  <tr>
                    <th>{{__('admin.game_channel')}}</th>
                    <td><?php echo __('app.' . $data->gameChannel->name_code); ?></td>
                  </tr>
                  <tr>
                    <th>{{__('admin.start_at')}}</th>
                    <td><?php echo dateformat($data->start_at); ?></td>
                  </tr>
                  <tr>
                    <th>{{__('admin.end_at')}}</th>
                    <td><?php echo dateformat($data->end_at); ?></td>
                  </tr>
                  <tr>
                    <th>{{__('admin.status')}}</th>
                    <td><?php echo $status; ?></td>
                  </tr>
                  <tr>
                    <th>{{__('admin.winning_number')}}</th>
                    <td>
                      <?php if ($data->result_no) { ?>
                        <span style="font-size: 22px"><?php echo $data->result_no; ?></span><br>
                        <span style="font-size: 22px"><?php echo $data->no; ?></span><br>

                        <?php if ($data->status_id != 4) { ?>
                          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#setWin">{{__('admin.update')}}</button>
                        <?php } ?>
                      <?php } else { ?>
                        {{__('admin.set_now')}}
                        <?php if ($data->status_id != 4) { ?>
                          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#setWin">{{__('admin.set_now')}}</button>
                        <?php } ?>

                      <?php  } ?>

                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>

          <div class="card shadow mb-4">
            <div class="card-body">
              <div class="row no-gutters">
                <div class="col-sm-6 ">
                  <div style="text-align:center;font-size: 17px">{{__('admin.highest_count')}}</div>
                  <?php if ($highest_count != 0) { ?>
                    <div class="bet-box">
                      <div class="bet-body">
                        <div class="bet-detail">
                          <div class="bet-no"><sup>NO</sup><span><?php echo $highest_count ?></span></div>
                          <div class="bet-total">
                            {{__('admin.count')}}: <?php echo $bets[$highest_count]['count'] ?><br>
                            {{__('admin.amount')}}: <?php echo currency_format($bets[$highest_count]['total'], 'RM') ?>
                          </div>
                        </div>
                        <div class="progress" style="height: 5px;">
                          <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $bets[$highest_count]['percent'] ?>%"></div>
                        </div>
                      </div>
                    </div>
                  <?php } else {
                    echo 'No data yet.';
                  } ?>
                </div>
                <div class="col-sm-6 ">
                  <div style="text-align:center;font-size: 17px">{{__('admin.highest_amount')}}</div>
                  <?php if ($highest_amount != 0) { ?>
                    <div class="bet-box">
                      <div class="bet-body">
                        <div class="bet-detail">
                          <div class="bet-no"><sup>NO</sup><span><?php echo $highest_amount ?></span></div>
                          <div class="bet-total">
                            {{__('admin.count')}}: <?php echo $bets[$highest_amount]['count'] ?><br>
                            {{__('admin.amount')}}: <?php echo currency_format($bets[$highest_amount]['total'], 'RM') ?>
                          </div>
                        </div>
                        <div class="progress" style="height: 5px;">
                          <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $bets[$highest_amount]['percent'] ?>%"></div>
                        </div>
                      </div>
                    </div>
                  <?php } else {
                    echo 'No data yet.';
                  } ?>
                </div>
              </div>
            </div>
          </div>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">All Bets</h6>
            </div>
            <div class="card-body">

              <div class="row no-gutters">
                <?php if ($all_bets) { ?>

                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Member</th>
                        <th>Amount</th>
                        <th>Bet On</th>
                      </tr>
                    </thead>
                    <tbody class="">
                      <?php
                        foreach ($all_bets as $b) {
                          echo '<tr>
                          <td><a href="' . admin_url('users/view/' . $b->user->username) . '"> ' . $b->user->username . '</a></td>
                          <td>' . currency_format($b->amount, 'RM') . '</td>
                          <td>' . $b->betType->name . '</td>
                        </tr>';
                        }
                        ?>
                    </tbody>
                  </table>
                <?php  } else {
                  echo 'No bet yet';
                } ?>
              </div>
            </div>
          </div>
        </div>

        <div class="col-sm-12 col-md-7">

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">{{__('admin.betting')}}</h6>
            </div>
            <div class="card-body">

              <div class="row no-gutters">
                <?php

                foreach ($bet_type as $k => $b) {

                  $winningBox = '';

                  if ($b->type == 'range') {
                    $nums = explode(",", $b->value);
                    $winningBox = (in_array($data->result_no, $nums)) ? 'winning' : '';
                  } else {
                    $winningBox = ($b->value == $data->result_no) ? 'winning' : '';
                  }

                  $header = ($b->type == 'number') ? $b->name : __('app.' . $b->name_code);

                  $no = ($b->type == 'number') ? $b->value : implode(", ", explode(",", $b->value));

                  $noBetClass = ($bets[$b->id]['count'] == 0) ? 'no-bet' : '';

                  echo '
                    <div class="col-sm-4 ">
                      <div class="bet-box ' . $winningBox . ' ' . $noBetClass . '">
                        <div class="bet-header">
                        ' . $header . '
                        </div>
                        <div class="bet-body">
                          <div class="bet-detail">
                            <div class="bet-no">No: ' . $no . '</div>
                            <div class="bet-total">
                              Count: ' . $bets[$b->id]['count'] . '<br>
                              Amount: ' . currency_format($bets[$b->id]['total'], 'RM') . '<br>
                            </div>
                          </div>
                          <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: ' . $bets[$b->id]['percent'] . '%" ></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    ';
                }

                ?>
              </div>
            </div>
          </div>

        </div>
      </div>


    </div>


  </div>

</div>

<!-- Modal -->
<div class="modal fade" id="setWin" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{__('admin.set_winning_number')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="frm-set-win" method="post" action="{{ admin_url('game/set_winning_number') }}">
        <div class="modal-body">
          <div class="form-group">
            <input type="hidden" name="game_id" value="<?php echo $data->id; ?>">
            <?php if ($data->gameType->id == 1) { ?>
              <label>{{__('admin.number')}}</label>
              <input data-validation="number" type="text" class="form-control" name="result_no" />
            <?php } ?>
            <?php if ($data->gameType->id == 2) {

              for ($i = 0; $i < 5; $i++) {

                echo '
                <div class="form-group">
              <label>' . __('admin.number') . ' ' . ($i + 1) . '</label>
              <input data-validation="number" type="text" class="form-control" name="num[]" />
              </div>';
              }
            } ?>
            <?php if ($data->gameType->id == 3) {

              for ($i = 0; $i < 10; $i++) {
                echo '
  <div class="form-group">
<label>' . __('admin.number') . ' ' . ($i + 1) . '</label>
<input data-validation="number" type="text" class="form-control" name="num[]" />
</div>';
              }
            } ?>
            <?php if ($data->gameType->id == 4) {

              for ($i = 0; $i < 7; $i++) {

                echo '
  <div class="form-group">
<label>' . __('admin.number') . ' ' . ($i + 1) . '</label>
<input data-validation="number" type="text" class="form-control" name="num[]" />
</div>';
              }
            } ?>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('admin.close')}}</button>
          <button type="submit" name="submit" class="btn btn-success btn-submit">{{__('admin.submit')}}</button>
        </div>
      </form>

    </div>
  </div>
</div>


@stop