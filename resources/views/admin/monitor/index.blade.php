@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')
<script src="{{ asset('js/admin/game/monitor.js?v=').env('ASSET_V', 1) }}" type="text/javascript"></script>

@stop

@section ('content')

<?php 


$result_duration = getSetting('result_duration');

?>

<div class="container-fluid" style="min-height: 100vh">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="fas fa-eye"></i> {{ __('admin.monitor') }} <a class="btn btn-info btn-sm" href="{{ admin_url('monitor')}}"><i class="fas fa-sync-alt"></i> {{ __('admin.refresh') }}</a></h1>

  @include ('inc.alerts')

  <div class="row mb-40">
    <div class="col-sm-12">

      <div class="row">
        <div class="col-sm-12 col-md-6">
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary"><span class="text-type-36"><b>36</b></span> {{ __('admin.game') }} 36</h6>
            </div>
            <div class="card-body">
              <div class="row">
                <?php
                if (count($game_36) > 0) {


                  foreach ($game_36 as $g) {

                    $badge = '<span class="badge badge-success">'. __('admin.in_progress').'</span>';
                    if ($g->status_id == 3) {
                      $badge = '<span class="badge badge-secondary">'. __('admin.waiting_result').'</span>';
                    }

                    if($g->status_id == 2) {
                      $sec = strtotime($g->end_at) - strtotime('now');
                      $timer = ' <div data-time="'.$sec.'" class="timer badge-timer badge badge-primary"></div>';
  
                    }
                    if($g->status_id == 3) {

                      $sec = strtotime($g->end_at.' +'.$result_duration.' minutes ') - strtotime('now');
                      $timer = ' <div data-time="'.$sec.'" class="timer badge-timer badge badge-secondary"></div>';

                    }


                    echo '<div class="col-sm-12 col-md-6"><div class="game-box">
                      <div class="game-title">'. __('admin.game').' ID#<b>' . $g->id . '</b> ' . $badge . '
                        <a class="game-btn float-right btn btn-info btn-sm" href="'.admin_url("game/view/".$g->id).'"><i class="fas fa-eye"></i></a>
                      </div>
                      <hr>
                     '.$timer.'

                      <div class="game-details">
                        <div class="game-detail-row">
                          <div class="game-label">'. __('admin.bet_count').'</div>
                          <div class="game-value">' . $g->totalBetsCount() . '</div>
                        </div>
                        <div class="game-detail-row">
                          <div class="game-label">'. __('admin.bet_amount').'</div>
                          <div class="game-value">' . currency_format($g->totalBetsAmount(), 'RM') . '</div>
                        </div>
                        <div class="game-detail-row">
                          <div class="game-label">'. __('admin.start_at').'</div>
                          <div class="game-value game-date">' . dateformat($g->start_at) . '</div>
                        </div>
                        <div class="game-detail-row">
                          <div class="game-label">'. __('admin.end_at').'</div>
                          <div class="game-value game-date">' . dateformat($g->end_at) . '</div>
                        </div>
                      </div>

                    </div></div>';
                  }
                } else { echo __('admin.no_game_yet').'.&nbsp;<a href="'.admin_url('game/new').'">'. __('admin.add_game').'</a>'; }
                ?>
              </div>
            </div>
          </div>

        </div>

        <div class="col-sm-12 col-md-6">
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary"><span class="text-type-37"><b>37</b></span> {{ __('admin.game')}} 37</h6>
            </div>
            <div class="card-body">
              <div class="row">
                <?php
                if (count($game_37) > 0) {

                  foreach ($game_37 as $g) {

                    $badge = '<span class="badge badge-success">'. __('admin.in_progress').'</span>';
                    if ($g->status_id == 3) {
                      $badge = '<span class="badge badge-success">'. __('admin.waiting_result').'</span>';
                    }

                    if($g->status_id == 2) {
                      $sec = strtotime($g->end_at) - strtotime('now');
                      $timer = ' <div data-time="'.$sec.'" class="timer badge-timer badge badge-primary"></div>';
  
                    }
                    if($g->status_id == 3) {

                      $sec = strtotime($g->end_at.' +'.$result_duration.' minutes ') - strtotime('now');
                      $timer = ' <div data-time="'.$sec.'" class="timer badge-timer badge badge-secondary"></div>';

                    }

                    echo '<div class="col-sm-12 col-md-6"><div class="game-box">
                      <div class="game-title">'. __('admin.game').' ID#<b>' . $g->id . '</b> ' . $badge . '
                        <a class="game-btn float-right btn btn-info btn-sm" href="'.admin_url("game/view/".$g->id).'"><i class="fas fa-eye"></i></a>
                      </div>
                      <hr>
                      '.$timer.'

                      <div class="game-details">
                        <div class="game-detail-row">
                          <div class="game-label">'. __('admin.bet_count').'</div>
                          <div class="game-value">' . $g->totalBetsCount() . '</div>
                        </div>
                        <div class="game-detail-row">
                          <div class="game-label">'. __('admin.bet_amount').'</div>
                          <div class="game-value">' . currency_format($g->totalBetsAmount(), 'RM') . '</div>
                        </div>
                        <div class="game-detail-row">
                          <div class="game-label">'. __('admin.start_at').'</div>
                          <div class="game-value game-date">' . dateformat($g->start_at) . '</div>
                        </div>
                        <div class="game-detail-row">
                          <div class="game-label">'. __('admin.end_at').'</div>
                          <div class="game-value game-date">' . dateformat($g->end_at) . '</div>
                        </div>
                      </div>

                    </div></div>';
                  }
                } else { echo __('admin.no_game_yet').'&nbsp;<a href="'.admin_url('game/new').'">'. __('admin.add_game').'</a>'; }
                ?>
              </div>
            </div>
          </div>

        </div>

      </div>

    </div>
  </div>

  @stop