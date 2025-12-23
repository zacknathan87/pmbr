<script>
  var ASSET_URL = '<?php echo asset(''); ?>';
  var BASE_URL = '<?php echo url('/'); ?>';
  var USER_CURRENCY = '<?php echo strtoupper(Auth::user()->userCurrency()) ?>';
  var currency_ratio = '<?php echo getSetting('currency_ratio_' . Auth::user()->userCurrency()) ?>';
</script>

<!-- Bootstrap core JavaScript-->
<script src="{{ asset('admin_templates/sb-admin/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin_templates/sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Scripts -->
<script src="{{ asset('js/app.js?v=').env('ASSET_V', 1) }}" defer></script>





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


<!-- page specific scripts -->
@yield('pagespecificscripts')