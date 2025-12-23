@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')

<script src="{{ asset('js/admin/report/list.js?v=').env('ASSET_V', 1) }}" type="text/javascript"></script>

@stop

@section ('content')

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="fas fa-fw fa-chart-line"></i>Report</h1>


  @include ('inc.alerts')


  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">{{ __('admin.list') }}</h6>
    </div>
    <div class="card-body">

    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>ID</th>
              <th>{{ __('admin.username') }}</th>
              <th>Downline</th>
              <th>Downline Debit</th>
              <th>Downline Credit</th>
              <th>Downline {{ __('admin.balance') }}</th>
            </tr>
          </thead>
          <tbody>
           
          </tbody>
        </table>
    </div>
  </div>
</div>

@stop