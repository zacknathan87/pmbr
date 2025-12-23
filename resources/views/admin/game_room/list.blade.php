@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')

@stop

@section ('content')

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="fas fa-dice"></i> {{__('admin.game_room')}}</h1>


  @include ('inc.alerts')


  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">{{__('admin.list')}}</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>{{__('admin.id')}}</th>
              <th>{{__('admin.room_name')}}</th>
              <th>{{__('admin.win_ratio')}}</th>
              <th>{{__('admin.min_wallet_ballance')}}</th>
              <th>Min Bet</th>
              <th>{{__('admin.status')}}</th>
              <th width="120">{{__('admin.action')}}</th>
            </tr>
          </thead>
          <tbody>
            <?php
              foreach($list as $l) {

                $status = ($l->is_active == 1) ?'<span class="tag bg-success">'.__('admin.active').'</span>' : '<span class="tag bg-danger">'.__('admin.inactive').'</span>';

                $buttons = '
                  <a href="'.admin_url('game_room/view/'.$l->id).'" class="btn btn-sm btn-primary"><i class="far fa-eye"></i></a>
                  <a href="'.admin_url('game_room/edit/'.$l->id).'" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>
                  ';

                echo '
                <tr>
                  <td>'.$l->id.'</td>
                  <td>'.__('app.'.$l->name_code).'</td>
                  <td>1 : '.$l->win_ratio.'</td>
                  <td>'.$l->min_balance.'</td>
                  <td>'.$l->min_bet.'</td>
                  <td>'.$status.'</td>
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