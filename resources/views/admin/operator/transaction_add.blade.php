@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')
<script src="{{ asset('js/admin/operator/transaction.js?v=').env('ASSET_V', 1) }}" type="text/javascript"></script>
@stop

@section ('content')

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"> Add Operator Transaction</h1>


  @include ('inc.alerts')

  <div class="row">
    <div class="col-sm-12 col-md-6">
      <div class="card shadow mb-4">
        <div class="card-body">

          <form id="frm-add-transaction" method="post" action="">
            {{ csrf_field() }}
            <div class="form-group">
              <label>{{__('admin.operator')}}</label>
              <select data-validation="required" name="agent_id" class="form-control">
                <option value="">{{__('admin.select_agent')}}</option>
                <?php foreach ($agents as $a) {
                  echo '<option value="' . $a->id . '">' . $a->username . '</option>';
                } ?>
              </select>
            </div>
            <div class="form-group">
              <label>{{__('admin.type')}}</label>
              <select data-validation="required" name="transaction_type_id" class="form-control">
                <option value="">{{__('admin.select_type')}}</option>
                <option value="7">{{__('admin.debit')}}</option>
                <option value="8">{{__('admin.credit')}}</option>
              </select>
            </div>

            <!-- <div class="form-group">
              <label>Point Type</label>
              <select name="point_type" class="form-control">
                <option value="Type A">Type A</option>
                <option value="Type B">Type B</option>
              </select>
            </div> -->
            <div class="form-group">
              <label>{{__('admin.remarks')}}</label>
              <textarea class="form-control" name="description"></textarea>
            </div>
            <div class="form-group">
              <label>{{__('admin.amount')}}</label>
              <input type="text" data-validation="number" class="form-control" name="amount">
            </div>
            <div class="form-group" style="text-align: center">
              <button type="submit" name="submit" class="btn btn-success btn-middle btn-lg btn-submit">{{__('admin.add')}}</button>
            </div>
          </form>


        </div>
      </div>
    </div>
  </div>

  <br><br>

</div>

@stop