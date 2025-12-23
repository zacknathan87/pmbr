@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')

<script src="{{ asset('js/admin/users/list.js?v=').env('ASSET_V', 1) }}" type="text/javascript"></script>

@stop

@section ('content')

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="fas fa-users"></i> {{__('admin.users')}}</h1>


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
              <th>Referrer</th>
              <th>{{__('admin.member_id')}}</th>
              <th>{{__('admin.name')}}</th>
              <th>{{__('admin.contact')}}</th>
              <th>Win/Loss</th>
              <th>Balance</th>
              <th width="70">{{__('admin.status')}}</th>
              <th width="180">Reg. Date</th>
              <th width="120">{{__('admin.action')}}</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="mdl-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-vcentered" role="document">
    <div class="modal-content">
      <div class="modal-header  bg-warning text-white">
        <h5 class="modal-title" id="exampleModalLabel">Suspend User?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <form method="post" action="{{ url('admin-management/users/suspend') }}">
        {{ csrf_field() }}

        <div class="modal-body">
          <input type="hidden" name="user_id" value="" />
          <p>Confirm Suspend?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('admin.close')}}</button>
          <button type="submit" class="btn btn-warning" name="submit" value="submit">Suspend</button>
        </div>

      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="mdl-activate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-vcentered" role="document">
    <div class="modal-content">
      <div class="modal-header  bg-success text-white">
        <h5 class="modal-title" id="exampleModalLabel">Activate User?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <form method="post" action="{{ url('admin-management/users/activate') }}">
        {{ csrf_field() }}

        <div class="modal-body">
          <input type="hidden" name="user_id" value="" />
          <p>Confirm Activate?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('admin.close')}}</button>
          <button type="submit" class="btn btn-success" name="submit" value="submit">Activate</button>
        </div>

      </form>
    </div>
  </div>
</div>



@stop