@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')

<script src="{{ asset('js/admin/game/list.js?v=').env('ASSET_V', 1) }}" type="text/javascript"></script>

@stop

@section ('content')

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="fas fa-gamepad"></i> {{__('admin.game')}}</h1>


  @include ('inc.alerts')

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Filter</h6>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-sm-8">
          <form action="{{ admin_url('game/list') }}" method="GET">
            <div class="row">
              <div class="col-sm-12 col-md-6">
                <div class="form-group">
                  <label>Game Channel</label>
                  <select class="form-control" name="game_channel_id">
                    <option value="">All</option>

                    <?php foreach ($gameChannels as $g) {
                      $selected = (isset($_GET['game_channel_id']) && $_GET['game_channel_id'] == $g->id) ? 'selected' : '';
                      echo '<option ' . $selected . ' value="' . $g->id . '">' . $g->gameType->name . ' / ' . $g->name . '</option>';
                    } ?>
                  </select>
                </div>
              </div>
              <div class="col-sm-12 col-md-6">
                <div class="form-group">
                  <label>Status</label>
                  <select class="form-control" name="status_id">
                    <option value="">All</option>

                    <?php
                    $status = [1 => 'Pending', 2 => 'Running', 3 => 'Waiting Winner', 4 => 'Ended'];

                    foreach ($status as $k => $g) {
                      $selected = (isset($_GET['status_id']) && $_GET['status_id'] == $k) ? 'selected' : '';
                      echo '<option ' . $selected . ' value="' . $k . '">' . $g . '</option>';
                    } ?>

                  </select>
                </div>
              </div>
              <div class="col-sm-12 col-md-6">
                <div class="form-group">
                  <label>Date</label>
                  <input type="text" class="form-control datetimepicker-input" name="date" id="datetimepicker1" data-toggle="datetimepicker" data-target="#datetimepicker1" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-6">
                <button class="btn btn-success" type="submit">Apply</button>
              </div>
            </div>

          </form>
          <input type="hidden" name="faux_date" value="<?php echo (isset($_GET['date'])) ?  $_GET['date'] : date('d/m/Y'); ?>" />

        </div>
      </div>
    </div>
  </div>

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">{{__('admin.list')}}</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>{{__('admin.game_id')}}</th>
              <th>{{__('admin.game')}}</th>
              <th>{{__('admin.game_channel')}}</th>
              <th>{{__('admin.status')}}</th>
              <th>Win Number</th>
              <th width="160">{{__('admin.start_at')}}</th>
              <th width="160">{{__('admin.end_at')}}</th>
              <th width="60">{{__('admin.action')}}</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // foreach($list as $l) {

            //   $status = '<span class="tag bg-primary">'.__('admin.pending').'</span>';
            //   if ($l->status_id == 2) {
            //     $status = '<span class="tag bg-success">'.__('admin.in_progress').'</span>';
            //   }
            //   if ($l->status_id == 3) {
            //     $status = '<span class="tag bg-info">'.__('admin.announcing_winner').'</span>';
            //   }
            //   if ($l->status_id == 4) {
            //     $status = '<span class="tag bg-danger">'.__('admin.ended').'</span>';
            //   }

            //   $buttons = '';
            //   $buttons .= '
            //     <a href="'.admin_url('game/view/'.$l->id).'" class="btn btn-sm btn-primary"><i class="far fa-eye"></i></a>
            //     <a href="'.admin_url('game/edit/'.$l->id).'" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>
            //     ';


            //   echo '
            //   <tr>
            //     <td>'.$l->id.'</td>
            //     <td>'.__('app.'.$l->gameChannel->name_code).'</td>
            //     <td>'.__('app.'.$l->gameRoom->name_code).'</td>
            //     <td>'.$status.'</td>
            //     <td>'.dateformat($l->start_at).'</td>
            //     <td>'.dateformat($l->end_at).'</td>
            //     <td style="text-align:center;">'.$buttons.'</td>
            //   </tr>
            //   ';
            // }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="mdl-set-win-1" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{__('admin.set_winning_number')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="frm-set-win" method="post" action="{{ admin_url('game/set_winning_number2') }}">
        <div class="modal-body">
          <div class="form-group">
            <input type="hidden" name="game_id" value="">
            <label>{{__('admin.number')}}</label>
            <input data-validation="number" type="text" class="form-control" name="result_no" />
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('admin.close')}}</button>
          <button type="submit" name="submit" class="btn btn-success btn-submit">{{__('admin.submit')}}</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="mdl-set-win-2" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{__('admin.set_winning_number')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="frm-set-win" method="post" action="{{ admin_url('game/set_winning_number2') }}">
        <div class="modal-body">
          <input type="hidden" name="game_id" value="">
          <?php
          for ($i = 0; $i < 5; $i++) {

            echo '
          <div class="form-group">
          <label>' . __('admin.number') . ' ' . ($i + 1) . '</label>
          <input data-validation="number" type="text" class="form-control" name="num[]" />
          </div>';
          }
          ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('admin.close')}}</button>
          <button type="submit" name="submit" class="btn btn-success btn-submit">{{__('admin.submit')}}</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="mdl-set-win-3" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{__('admin.set_winning_number')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="frm-set-win" method="post" action="{{ admin_url('game/set_winning_number2') }}">
        <div class="modal-body">
          <input type="hidden" name="game_id" value="">
          <?php
          for ($i = 0; $i < 10; $i++) {

            echo '
          <div class="form-group">
          <label>' . __('admin.number') . ' ' . ($i + 1) . '</label>
          <input data-validation="number" type="text" class="form-control" name="num[]" />
          </div>';
          }
          ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('admin.close')}}</button>
          <button type="submit" name="submit" class="btn btn-success btn-submit">{{__('admin.submit')}}</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="mdl-set-win-4" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{__('admin.set_winning_number')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="frm-set-win" method="post" action="{{ admin_url('game/set_winning_number2') }}">
        <div class="modal-body">
          <input type="hidden" name="game_id" value="">
          <?php
          for ($i = 0; $i < 7; $i++) {

            echo '
          <div class="form-group">
          <label>' . __('admin.number') . ' ' . ($i + 1) . '</label>
          <input data-validation="number" type="text" class="form-control" name="num[]" />
          </div>';
          }
          ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('admin.close')}}</button>
          <button type="submit" name="submit" class="btn btn-success btn-submit">{{__('admin.submit')}}</button>
        </div>
      </form>
    </div>
  </div>
</div>

@stop