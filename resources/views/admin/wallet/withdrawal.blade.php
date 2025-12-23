@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')
<script src="{{ asset('js/admin/wallet/new.js?v=').env('ASSET_V', 1) }}" type="text/javascript"></script>
@stop

@section ('content')

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black">Withdrawal</h1>


  @include ('inc.alerts')

  <div class="row">
    <div class="col-sm-12 col-md-6">
      <div class="card shadow mb-4">
        <div class="card-body">

          <form id="frm-withdrawal" method="post" action="">
            {{ csrf_field() }}
            <?php if (isset($data)) { ?>

              <div class="form-group">
                <label>Member Username</label>
                <input type="text" readonly class="form-control" value="<?php echo $data->userDetail->username ?>">
              </div>
              <div class="form-group">
                <label>Current Balance</label>
                <input type="text" readonly class="form-control" value="<?php echo $data->balance ?>">
              </div>
            <?php } else { ?>

              <div class="form-group">
                <label>Member Username</label>
                <input type="text" data-validation="required" class="form-control" name="username" value="">
              </div>
            <?php } ?>
            <div class="form-group">
              <label>Amount</label>
              <input type="text" data-validation="required|number" class="form-control" name="amount">
            </div>
            <div class="form-group" style="text-align: center">
              <button type="submit" name="submit" class="btn btn-success btn-middle btn-lg btn-submit">Withdrawal</button>
            </div>
          </form>


        </div>
      </div>
    </div>
  </div>

  <br><br>

</div>

@stop