@extends ('admin.plane')

@section('pagespecificstyles')
<link rel="stylesheet" href="{{ asset("plugins/summernote/summernote-lite.css") }}" />

@stop

@section('pagespecificscripts')
<script src="{{ asset('plugins/summernote/summernote-lite.min.js') }}"></script>

<script src="{{ asset('js/admin/banner/new.js?v=').env('ASSET_V', 1) }}" type="text/javascript"></script>

@stop

@section ('content')

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="fas fa-hand-holding-usd"></i> Edit {{__('admin.investor')}} #<?php echo $data->name ?></h1>


  @include ('inc.alerts')

  <div class="row">
    <div class="col-sm-12 col-md-8">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{__('admin.details')}}</h6>
        </div>
        <div class="card-body">

          <form id="frm-add-banner" enctype="multipart/form-data"  method="post" action="{{ admin_url('investor/edit/'.$data->id) }}">
            {{ csrf_field() }}

            <div class="form-group">
              <label>Name</label>
              <input type="text" data-validation="required" class="form-control" name="name" value="<?php echo $data->name ?>"/>
            </div>
            <div class="form-group">
              <label>Bank Name</label>
              <input type="text" data-validation="required" class="form-control" name="bank_name" value="<?php echo $data->bank_name ?>"/>
            </div>
            <div class="form-group">
              <label>Bank Account No</label>
              <input type="text"   data-validation="required"class="form-control" name="bank_account_no" value="<?php echo $data->bank_account_no ?>"/>
            </div>

            <div class="form-group" style="text-align: center">
              <button type="submit" name="submit" value="submit" class="btn btn-success btn-middle btn-lg btn-submit">{{__('admin.submit')}}</button>
            </div>
          </form>


        </div>
      </div>
    </div>
  </div>

  <br><br>

</div>

@stop