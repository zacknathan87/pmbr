@if (session('status'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?php echo session('status'); ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif
@if (session('warning'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <?php echo session('warning'); ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif
@if (session('errors'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong><br>
    <?php echo session('errors'); ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif
@if (session('validation_errors'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong><br>
    <?php $errors = session('validation_errors');
      foreach ($errors->all() as $message) {
        echo $message.'<br>';
      }
    ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif