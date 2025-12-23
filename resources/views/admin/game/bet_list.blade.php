@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')

<script src="{{ asset('js/admin/game/bet_list.js?v=').env('ASSET_V', 1) }}" type="text/javascript"></script>

@stop

@section ('content')

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="fas fa-coins"></i> {{__('admin.bet_list')}}</h1>


  @include ('inc.alerts')

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Filter</h6>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-sm-8">
          <form action="{{ admin_url('bets') }}" method="GET">
            <div class="row">
              <div class="col-sm-12 col-md-6">
                <div class="form-group">
                  <label>Game Channel</label>
                  <select class="form-control" name="game_channel_id">
                    <option value="">All</option>

                    <?php foreach ($gameChannels as $g) {
                      $selected = (isset($_GET['game_channel_id']) && $_GET['game_channel_id'] == $g->id) ? 'selected' : '';
                      echo '<option ' . $selected . ' value="' . $g->id . '">' . $g->gameType->name . ' / ' . $g->name . '</option>';
                    } ?>
                  </select>
                </div>
              </div>
           
              <div class="col-sm-12 col-md-6">
                <div class="form-group">
                  <label>Status</label>
                  <select class="form-control" name="status_id">
                    <option value="">All</option>

                    <?php
                    $status = [1 => 'Pending', 2 => 'Running', 3 => 'Waiting Winner', 4 => 'Ended'];

                    foreach ($status as $k => $g) {
                      $selected = (isset($_GET['status_id']) && $_GET['status_id'] == $k) ? 'selected' : '';
                      echo '<option ' . $selected . ' value="' . $k . '">' . $g . '</option>';
                    } ?>

                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-6">
                <button class="btn btn-success" type="submit">Apply</button>
              </div>
            </div>

          </form>
          <input type="hidden" name="faux_date" value="<?php echo (isset($_GET['date'])) ?  $_GET['date'] : date('d/m/Y'); ?>" />

        </div>
      </div>
    </div>
  </div>


  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">{{__('admin.list')}}</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Member</th>
              <th>{{__('admin.game_id')}}</th>
              <th>{{__('admin.game')}}</th>
              <th>Game Status</th>
              <th>{{__('admin.bet_on')}}</th>
              <th>{{__('admin.bet_amount')}}</th>
              <th>{{__('admin.winning_bet')}}</th>
              <th>{{__('admin.win_amount')}}</th>
              <th>{{__('admin.created_at')}}</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // foreach($list as $l) {

            //   $winning = '<span class="badge badge-danger">NO</span>';
            //   $win_amount = '-';

            //   if($l->is_win) {
            //     $winning = '<span class="badge badge-success">YES</span>';
            //     $win_amount = currency_format($l->win_amount, '$');
            //   }

            //   $bet_on = ($l->betType->type == 'range') ? __('app.'.$l->betType->name_code) : $l->betType->value;


            //   echo '
            //   <tr>
            //     <td>'.$l->userDetail->username.'</td>
            //     <td>'.$l->game_id.'</td>
            //     <td>'.__('app.'.$l->game->gameChannel->name_code).' / '.__('app.'.$l->game->gameRoom->name_code).'</td>
            //     <td>'.$bet_on.'</td>
            //     <td>'.currency_format($l->amount, '$').'</td>
            //     <td>'.$winning.'</td>
            //     <td>'.$win_amount.'</td>
            //     <td>'.dateformat($l->created_at).'</td>
            //   </tr>
            //   ';
            // }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@stop