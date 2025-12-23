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
  <h1 class="h3 mb-4 text-black"><i class="fas fa-dice"></i> {{__('admin.game_room')}} - #<?php echo $data->id ?>

    <a class="btn btn-success float-right" href="{{ admin_url('game_room/edit/'. $data->id) }}"><i class="fas fa-edit"></i> {{__('admin.edit')}}</a>
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
                <th>{{__('admin.room_name')}}</th>
                <td><?php echo $data->name ?></td>
              </tr>
              <tr>
                <th>{{__('admin.min_balance')}}</th>
                <td><?php echo $data->min_balance ?></td>
              </tr>
              <tr>
                <th>Min Bet</th>
                <td><?php echo $data->min_bet ?></td>
              </tr>
              <tr>
                <th>Bet Options</th>
                <td><?php echo $data->bet_options ?></td>
              </tr>
              <tr>
                <th>{{__('admin.win_ratio')}}</th>
                <td>1 : <?php echo $data->win_ratio ?></td>
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