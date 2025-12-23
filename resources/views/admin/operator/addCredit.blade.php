@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')
<script src="{{ asset('js/admin/wallet/new.js?v=').env('ASSET_V', 1) }}" type="text/javascript"></script>
@stop

@section ('content')

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black">Add Agent Balance</h1>


  @include ('inc.alerts')

  <div class="row">
    <div class="col-sm-12 col-md-6">
      <div class="card shadow mb-4">
        <div class="card-body">

          <form id="frm-add-credit" method="post" action="">
            {{ csrf_field() }}
            <div class="form-group">
              <label>ID</label>
              <input type="text" readonly class="form-control" value="<?php echo $data->admin_id ?>">
            </div>
            <div class="form-group">
              <label>Username</label>
              <input type="text" readonly class="form-control" value="<?php echo $data->adminDetail->username ?>">
            </div>
            <div class="form-group">
              <label>Current Balance</label>
              <input type="text" readonly class="form-control" value="<?php echo $data->balance ?>">
            </div>
            <!-- <div class="form-group">
              <label>Point Type</label>
              <select name="point_type" class="form-control">
                <option value="Type A">Type A</option>
                <option value="Type B">Type B</option>
              </select>
            </div> -->

            <div class="form-group">
              <label>Amount</label>
              <input type="text" data-validation="number" class="form-control" name="amount">
            </div>
            <div class="form-group" style="text-align: center">
              <button type="submit" name="submit" class="btn btn-success btn-middle btn-lg btn-submit">Add</button>
            </div>
          </form>


        </div>
      </div>
    </div>
  </div>

  <br><br>

</div>

@stop