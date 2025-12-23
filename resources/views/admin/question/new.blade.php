@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')

<script src="{{ asset('js/admin/question/new.js?v=').env('ASSET_V', 1) }}" type="text/javascript"></script>

@stop

@section ('content')

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="far fa-question-circle"></i> {{__('admin.add_question')}}</h1>


  @include ('inc.alerts')

  <div class="row">
    <div class="col-sm-12 col-md-8">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{__('admin.question')}}</h6>
        </div>
        <div class="card-body">

          <form id="frm-add-question" method="post" action="{{ admin_url('question/new') }}">
            {{ csrf_field() }}

          
            <div class="form-group">
              <label>English</label>
              <textarea data-validation="required" class="form-control" name="question_en"></textarea>
            </div>
            <div class="form-group">
              <label>Bahasa Malaysia</label>
              <textarea data-validation="required" class="form-control" name="question_my"></textarea>
            </div>
            <div class="form-group">
              <label>Chinese</label>
              <textarea data-validation="required" class="form-control" name="question_cn"></textarea>
            </div>
      

            <div class="form-group" style="text-align: center">
              <button type="submit" name="submit" class="btn btn-success btn-middle btn-lg btn-submit">{{__('admin.submit')}}</button>
            </div>
          </form>


        </div>
      </div>
    </div>
  </div>

  <br><br>

</div>

@stop