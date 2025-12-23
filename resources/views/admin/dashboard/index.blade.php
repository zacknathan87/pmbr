@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')
@stop

@section ('content')



<div class="container-fluid" style="min-height: 100vh;">

  <!-- Page Heading -->
  <h1 class="h3 mb-40 text-black"><i class="fas fa-desktop"></i> {{ __('admin.dashboard') }}</h1>

  @include ('inc.alerts')

  

  <div class="row mb-40">

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{ __('admin.total_user') }}</div>
              <div class="h4 mb-0 font-weight-bold text-gray-900"><?php echo $total_user; ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-gray-400"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">{{ __('admin.pending_withdrawal') }}</div>
              <div class="h4 mb-0 font-weight-bold text-gray-900"><?php echo $pending_withdrawal; ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-hand-holding-usd fa-2x text-gray-400"></i>
            </div>
          </div>
          <a href="{{ admin_url('withdrawal_request') }}">{{ __('admin.see_all') }}</a>

        </div>
      </div>
    </div>
  </div>

  

  <h4>Games</h4>
  <div class="row">

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">{{ __('admin.total_game') }}</div>
              <div class="h4 mb-0 font-weight-bold text-gray-900"><?php echo $total_game; ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-gamepad fa-2x text-gray-400"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">{{ __('admin.total_game_ended') }}</div>
              <div class="h4 mb-0 font-weight-bold text-gray-900"><?php echo $total_game_ended; ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-gamepad fa-2x text-gray-400"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <h4>Bets</h4>
  <div class="row">

  <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{ __('admin.total_bet') }}</div>
              <div class="h4 mb-0 font-weight-bold text-gray-900"><?php echo $total_bets; ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-coins fa-2x text-gray-400"></i>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">{{ __('admin.total_bet_amount') }}</div>
              <div class="h4 mb-0 font-weight-bold text-gray-900"><?php echo currency_format($total_bets_amount, 'RM'); ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-coins fa-2x text-gray-400"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">{{ __('admin.bet_win') }}</div>
              <div class="h4 mb-0 font-weight-bold text-gray-900"><?php echo $total_bets_win; ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-coins fa-2x text-gray-400"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">{{ __('admin.bet_win_amount') }}</div>
              <div class="h4 mb-0 font-weight-bold text-gray-900"><?php echo currency_format($total_bets_win_amount, 'RM'); ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-coins fa-2x text-gray-400"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>


</div>




@stop