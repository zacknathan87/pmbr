@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')

<script src="{{ asset('js/admin/question/list.js?v=').env('ASSET_V', 1) }}" type="text/javascript"></script>

@stop

@section ('content')

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="far fa-question-circle"></i> {{__('admin.question')}}</h1>


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
              <th>ID</th>
              <th>{{__('admin.question')}}</th>
              <th width="120">{{__('admin.action')}}</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($list as $l) {

              $buttons = '';
              $buttons .= '
                  <a href="' . admin_url('question/view/' . $l->id) . '" class="btn btn-sm btn-primary"><i class="far fa-eye"></i></a>
                  <a href="' . admin_url('question/edit/' . $l->id) . '" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>
                  <button type="button" id="' . $l->id . '"  data-toggle="modal" data-target="#mdl-delete" class="btn btn-sm btn-danger btn-trigger-modal btn-delete" ><i class="fa fa-trash"></i></button>

                  ';


              echo '
                <tr>
                  <td>' . $l->id . '</td>
                  <td>' . $l->question_en . '</td>
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


<!-- Modal -->
<div class="modal fade" id="mdl-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-vcentered" role="document">
    <div class="modal-content">
      <div class="modal-header  bg-danger text-white">
        <h5 class="modal-title" id="exampleModalLabel">{{__('admin.delete_data')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <form method="post" action="{{ url('admin-management/question/delete') }}">
        {{ csrf_field() }}

        <div class="modal-body">
          <input type="hidden" name="question_id" value="" />
          <p>{{__('admin.confirm_delete')}}</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('admin.close')}}</button>
          <button type="submit" class="btn btn-danger" name="submit" value="submit">{{__('admin.delete')}}</button>
        </div>

      </form>
    </div>
  </div>
</div>





@stop