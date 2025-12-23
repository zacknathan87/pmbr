@extends ('admin.plane')

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')

<script src="{{ asset('js/admin/question/new.js?v=').env('ASSET_V', 1) }}" type="text/javascript"></script>

@stop

@section ('content')

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-black"><i class="far fa-question-circle"></i> {{__('admin.edit_question')}} - #<?php echo $data->id ?></h1>


  @include ('inc.alerts')

  <div class="row">
    <div class="col-sm-12 col-md-8">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{__('admin.details')}}</h6>
        </div>
        <div class="card-body">

          <form id="frm-add-question" method="post" action="{{ admin_url('question/edit/'.$data->id) }}">
            {{ csrf_field() }}

            <h4>{{__('admin.question')}}</h4>
         
            <div class="form-group"> 
              <label>English</label>
              <textarea data-validation="required" class="form-control" name="question_en"><?php echo $data->question_en ?></textarea>
            </div>
            <div class="form-group">
              <label>Bahasa Malaysia</label>
              <textarea data-validation="required" class="form-control" name="question_my"><?php echo $data->question_my ?></textarea>
            </div>
            <div class="form-group">
              <label>Chinese</label>
              <textarea data-validation="required" class="form-control" name="question_cn"><?php echo $data->question_cn ?></textarea>
            </div>
<!-- 

            <br>
            <hr>
            <br>
            <h4>Correct Answer</h4>

            <div class="row">
              <div class="col-3">
                English
              </div>
              <div class="col-3">
                Bahasa Malaysia
              </div>
              <div class="col-3">
                Chinese
              </div>
            </div>

            <div class="row">
                <div class="col-1">
                  <div style="text-align:center;margin: 6px 0;">1</div>
                </div>
              <div class="col-3">
                <div class="form-group">
                  <input type="text" data-validation="required" class="form-control" name="correct_answer_en" value="<?php //echo $data->correctAnswer->answer_en ?>">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  <input type="text" data-validation="required" class="form-control" name="correct_answer_my" value="<?php //echo $data->correctAnswer->answer_my ?>">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  <input type="text" data-validation="required" class="form-control" name="correct_answer_cn" value="<?php //echo $data->correctAnswer->answer_cn ?>">
                </div>
              </div>
            </div>

            <br>
            <hr>

            <h4>Other Answers</h4>

            <div class="row">
              <div class="col-1"> </div>
              <div class="col-3">
                English
              </div>
              <div class="col-3">
                Bahasa Malaysia
              </div>
              <div class="col-3">
                Chinese
              </div>
            </div>


            <?php for ($i = 1; $i <= 36; $i++) {

              $required = 'required';

              ?>

              <div class="row">
                <div class="col-1">
                  <div style="text-align:center;margin: 6px 0;"><?php echo ($i + 1) ?></div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <input type="text" data-validation="<?php echo $required ?>" class="form-control" name="answers_en[]" value="<?php //echo isset($answers[$i]) ? $answers[$i]->answer_en : ''; ?>">
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <input type="text" data-validation="<?php echo $required ?>" class="form-control" name="answers_my[]" value="<?php //echo isset($answers[$i]) ? $answers[$i]->answer_my : ''; ?>">
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <input type="text" data-validation="<?php echo $required ?>" class="form-control" name="answers_cn[]" value="<?php //echo isset($answers[$i]) ? $answers[$i]->answer_cn : ''; ?>">
                  </div>
                </div>
              </div>
            <?php } ?> -->


            <div class="form-group" style="text-align: center">
              <button type="submit" name="submit" class="btn btn-success btn-middle btn-lg btn-submit">{{__('admin.update')}}</button>
            </div>
          </form>


        </div>
      </div>
    </div>
  </div>

  <br><br>

</div>

@stop