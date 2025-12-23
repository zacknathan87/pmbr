@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')

@stop

@section ('content')

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="fas fa-user-secret"></i> {{__('admin.transactions')}} - #<?php echo $data->txnid ?></h1>


  @include ('inc.alerts')

  <div class="row">
    <div class="col-sm-12 col-md-7">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{__('admin.transaction_details')}}</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered " width="100%" cellspacing="0">
              <tr>
                <th width="200">ID</th>
                <td><?php echo $data->txnid ?></td>
              </tr>
              <tr>
                <th>{{__('admin.type')}}</th>
                <td><?php echo $data->transactionTypeDetail->type ?></td>
              </tr>
              <tr>
                <th>{{__('admin.operator')}}</th>
                <td><a href="{{ admin_url('operator/view/'.$data->admin_id) }}"><?php echo $data->adminDetail->username ?></a></td>
              </tr>
              <!-- <tr>
                <th>Point Type</th>
                <td><?php echo $data->point_type ?></td>
              </tr> -->
              <tr>
                <th>{{__('admin.remarks')}}</th>
                <td><?php echo $data->description ?></td>
              </tr>
              <tr>
                <th>{{__('admin.amount')}}</th>
                <td><?php echo currency_format($data->amount, '$') ?></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>

</div>

@stop