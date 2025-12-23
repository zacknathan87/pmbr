<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="/icon/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title><?php echo ucfirst(explode("/", Request::path())[0]); ?> - {{ config('app.name', '') }}</title>


  <!-- <script>
    window.Laravel = {
      !!json_encode([
        'csrfToken' => csrf_token(),
        'user' => Auth::user()
      ]) !!
    };
  </script> -->

  <!-- Styles -->
  <link href="{{ asset('admin_templates/sb-admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset("plugins/jquery-confirm/dist/jquery-confirm.min.css") }}" />

  <link href="{{ asset('plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css?v=').env('ASSET_V', 1) }}" rel="stylesheet">

  <link href="{{ asset('plugins/fontawesome/css/all.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset("plugins/magnify-popup/magnific-popup.css") }}" />

        <link href="{{ asset('plugins/daterangepicker/daterangepicker.css?v=').env('ASSET_V', 1) }}" rel="stylesheet">


  <link href="{{ asset('css/app.css?v=').env('ASSET_V', 1) }}" rel="stylesheet">
  <link href="{{ asset('admin_templates/sb-admin/css/sb-admin-2.min.css?v=').env('ASSET_V', 1) }}" rel="stylesheet">
  <link href="{{ asset('css/admin.css?v=').env('ASSET_V', 1) }}" rel="stylesheet">



  @yield('pagespecificstyles')


</head>


@if (Auth::guard('admin')->check())

<body>
  <div id="wrapper">
    @include('admin.inc.menu')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
        @include('admin.inc.nav')


        <!-- Begin Page Content -->
        <div class="container-fluid">

          @yield('content')

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      @include('admin.inc.footer')

    </div>
    <!-- End of Content Wrapper -->


  </div>
</body>
@else

<body style="overflow: auto" class="bg-gradient-primary">
  @yield('content')

  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('admin_templates/sb-admin/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('admin_templates/sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Scripts -->
  <!-- <script src="{{ asset('js/app.js?v=').env('ASSET_V', 1) }}" defer></script> -->

  <script src="{{ asset("plugins/form-validator/jquery.form-validator.min.js") }}" type="text/javascript"></script>


  <script src="{{ asset("plugins/jquery-confirm/dist/jquery-confirm.min.js") }}" type="text/javascript"></script>
  <script src="{{ asset("plugins/timer/timer.jquery.min.js") }}" type="text/javascript"></script>

  <?php
  $language_array = include public_path('../resources/lang/' . App::getLocale() . '/app.php');
  ?>

  <script>
    var languageData = <?php echo json_encode($language_array); ?>;

    var formLang = {
      requiredField: '<?php echo __('app.required'); ?>',
    };
  </script>

  <script src="{{ asset('js/login.js?v=').env('ASSET_V', 1) }}"></script>
</body>
@endif

</html>