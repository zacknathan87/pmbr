@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')

<script src="{{ asset('js/admin/rank/list.js?v=').env('ASSET_V', 1) }}" type="text/javascript"></script>

@stop

@section ('content')

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="fas fa-user-secret"></i>Operator</h1>


  @include ('inc.alerts')


  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">{{ __('admin.list') }}</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>ID</th>
              <th>{{ __('admin.username') }}</th>
              <th>{{ __('admin.remarks') }}</th>
              <th>{{ __('admin.currency') }}</th>
              <th>{{ __('admin.balance') }}</th>
              <th width="190">{{ __('admin.action') }}</th>
            </tr>
          </thead>
          <tbody>
            <?php
              foreach($list as $l) {


                $buttons = '';

                $buttons .= '
                  <a href="'.admin_url('operator/view/'.$l->id).'" class="btn btn-sm btn-primary"><i class="far fa-eye"></i></a>
                  <a href="'.admin_url('operator/edit/'.$l->id).'" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>
                  <a href="'.admin_url('operator/add_balance/'.$l->wallet->id).'" class="btn btn-sm btn-warning text-dark"><i class="fas fa-donate"></i> '.__('admin.add_balance').'</a>
                  ';

                echo '
                <tr>
                  <td>'.$l->id.'</td>
                  <td>'.$l->username.'</td>
                  <td>'.$l->remarks.'</td>
                  <td>'.strtoupper($l->currency).'</td>
                  <td>'.currency_format($l->wallet->balance, $l->currency).'</td>
                  <td style="text-align:center;">'.$buttons.'</td>
                </tr>
                ';
              }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@stop