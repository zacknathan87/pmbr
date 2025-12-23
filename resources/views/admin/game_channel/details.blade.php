@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')

@stop

@section ('content')

<?php

$status = ($data->is_active == 1) ?'<span class="tag bg-success">'.__('admin.active').'</span>' : '<span class="tag bg-danger">'.__('admin.inactive').'</span>';


?>

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="fas fa-server"></i> {{__('admin.game_channel')}} - #<?php echo $data->id ?>

    <a class="btn btn-success float-right" href="{{ admin_url('game_channel/edit/'. $data->id) }}"><i class="fas fa-edit"></i> {{__('admin.edit')}}</a>
  </h1>


  @include ('inc.alerts')

  <div class="row">
    <div class="col-sm-12 col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{__('admin.details')}}</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered " width="100%" cellspacing="0">
              <tr>
                <th width="200">ID</th>
                <td><?php echo $data->id ?></td>
              </tr>
              <tr>
                <th>{{__('admin.channel_name')}}</th>
                <td><?php echo $data->name ?></td>
              </tr>
              <tr>
                <th>Status</th>
                <td><?php echo $status ?></td>
              </tr>
            
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>

</div>

@stop