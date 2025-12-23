@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')
<script src="{{ asset('js/admin/withdrawal/index.js?v=').env('ASSET_V', 1) }}" type="text/javascript"></script>

@stop

@section ('content')

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="fas fa-hand-holding-usd"></i> {{__('admin.withdrawal_request')}}</h1>


  @include ('inc.alerts')

  <div class="row">
    <div class="col-sm-12">
      <div class="card shadow mb-4">
        <div class="card-body">


          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>{{__('admin.request_id')}}</th>
                  <th>{{__('admin.member_id')}}</th>
                  <th>{{__('admin.amount')}}</th>
                  <th>{{__('admin.status')}}</th>
                  <th>{{__('admin.request_at')}}</th>
                  <th width="80">{{__('admin.action')}}</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($list as $l) {

                  $status = '<span class="badge badge-warning badge-100">'.__('admin.pending').'</span>';
                  if($l->status == 2) {
                    $status = '<span class="badge badge-success badge-100">'.__('admin.approved').'</span>';
                  }
                  if($l->status == 3) {
                    $status = '<span class="badge badge-danger badge-100">'.__('admin.rejected').'</span>';
                  }


                  $buttons = '';

                  $buttons .= '
                  <a href="' . admin_url('withdrawal_request/view/' . $l->id) . '" class="btn btn-sm btn-primary"><i class="far fa-eye"></i></a>
                  ';

                  echo '
                <tr>
                  <td>' . $l->id . '</td>
                  <td>' . $l->userDetail->username . '</td>
                  <td>' . currency_format($l->amount, '$') . '</td>
                  <td>' . $status . '</td>
                  <td>' . dateformat($l->created_at) . '</td>
                  <td style="text-align:center;">' . $buttons . '</td>
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
  </div>

  <br><br>

</div>

@stop