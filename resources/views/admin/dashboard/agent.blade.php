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
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{ __('admin.my_users') }}</div>
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
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">{{ __('admin.my_balance') }}</div>
              <div class="h4 mb-0 font-weight-bold text-gray-900"><?php echo currency_format(Auth::guard('admin')->user()->wallet->balance, 'RM') ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-hand-holding-usd fa-2x text-gray-400"></i>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  



</div>




@stop