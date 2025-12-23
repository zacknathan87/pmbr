<div class="row mb-40">
    <div class="col-md-3 col-sm-6">
      <div class="info-box">
        <div class="info-title">{{ __('app.member_id') }}<i class="fas fa-user float-right"></i></div>
        <div class="info-body"><?php echo Auth::user()->username; ?></div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6">
      <div class="info-box">
        <div class="info-title">{{ __('app.credit') }} <i class="fas fa-wallet float-right"></i> </div>
        <div class="info-body"><?php echo currency_format(Auth::user()->wallet->balance, '$'); ?></div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6">
      <div class="info-box">
        <div class="info-title">{{ __('app.betting') }} <i class="fas fa-coins float-right"></i> </div>
        <div class="info-body"><?php echo currency_format(Auth::user()->totalBetsAmount(), '$'); ?></div>
      </div>
    </div>
    <!-- <div class="col-md-3 col-sm-6">
      <div class="info-box is-reversed">
        <div class="info-title">{{ __('app.win') }} <i class="fas fa-hand-holding-usd float-right"></i></i> </div>
        <div class="info-body"><?php echo currency_format(Auth::user()->totalWinning(), '$'); ?></div>
      </div>
    </div> -->
    <div class="col-md-3 col-sm-6">
      <div class="info-box is-reversed">
        <div class="info-title">{{ __('app.cv_wallet') }} <i class="fas fa-hand-holding-usd float-right"></i></i> </div>
        <div class="info-body"><?php echo currency_format(Auth::user()->wallet->balance, '$'); ?></div>
      </div>
    </div>
  </div>