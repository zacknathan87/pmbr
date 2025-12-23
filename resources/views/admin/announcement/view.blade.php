@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')

@stop

@section ('content')

<?php


?>

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="fas fa-bullhorn"></i> {{__('admin.announcement')}} - #<?php echo $data->id ?>

    <a class="btn btn-success float-right" href="{{ admin_url('announcement/edit/'. $data->id) }}"><i class="fas fa-edit"></i> {{__('admin.edit')}}</a>
  </h1>


  @include ('inc.alerts')

  <div class="row">
    <div class="col-sm-12 col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{__('admin.details')}}</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered " width="100%" cellspacing="0">
              <tr>
                <th width="200">ID</th>
                <td><?php echo $data->id ?></td>
              </tr>
              <tr>
                <th>{{__('admin.language')}}</th>
                <td><?php echo $data->lang ?></td>
              </tr>
              <tr>
                <th>{{__('admin.title')}}</th>
                <td><?php echo $data->title ?></td>
              </tr>
              <tr>
                <th>{{__('admin.content')}}</th>
                <td><?php echo html_entity_decode($data->content) ?></td>
              </tr>
              <!-- <tr>
                <th>Correct Answer</th>
                <td>
                  <div class="row">
                    <div class="col-4">
                      English
                      <div class="answer-pill"><?php //echo $data->correctAnswer->answer_en; ?></div>
                    </div>
                    <div class="col-4">
                      Bahasa Malaysia
                      <div class="answer-pill"><?php //echo $data->correctAnswer->answer_my; ?></div>
                    </div>
                    <div class="col-4">
                      Chinese
                      <div class="answer-pill"><?php //echo $data->correctAnswer->answer_cn; ?></div>
                    </div>
                </td>
              </tr> -->
              <!-- <tr>
                <th>Answers (<?php //echo count($data->answers); ?>)</th>
                <td>
                  <div class="row">
                    <div class="col-4">
                      English
                      <?php//foreach ($data->answers as $a) {
                        //echo '<div class="answer-pill">' . $a->answer_en . '</div>';
                      //} ?>
                    </div>
                    <div class="col-4">
                      Bahasa Malaysia
                      <?php// foreach ($data->answers as $a) {
                        //echo '<div class="answer-pill">' . $a->answer_my . '</div>';
                      //} ?>
                    </div>
                    <div class="col-4">
                      Chinese
                      <?php// foreach ($data->answers as $a) {
                        //echo '<div class="answer-pill">' . $a->answer_cn . '</div>';
                      //} ?>
                    </div>
                  </div>

                </td>
              </tr> -->
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>

</div>

@stop