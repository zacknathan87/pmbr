<!-- Footer -->
<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span>Copyright &copy; <?php echo env('APP_NAME').' '.date('Y'); ?></span>
    </div>
  </div>
</footer>
<!-- End of Footer -->

<script>
  var APP_URL = '<?php echo url(""); ?>';
</script>


<script>
  var MEMBER_URL = '<?php echo url("member"); ?>';
  var ADMIN_URL = '<?php echo url("admin"); ?>';
  var ASSET_URL = '<?php echo asset(''); ?>';
</script>

<!-- Scripts -->
<!-- <script src="{{ asset('js/app.js?v=').env('ASSET_V', 1) }}" defer></script> -->

<!-- Bootstrap core JavaScript-->
<script src="{{ asset('admin_templates/sb-admin/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin_templates/sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- common scripts -->
<script src="{{ asset("plugins/form-validator/jquery.form-validator.min.js") }}" type="text/javascript"></script>
<script src="{{ asset('plugins/momentjs/moment.js?v=').env('ASSET_V', 1) }}"></script>
<script src="{{ asset('plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js?v=').env('ASSET_V', 1) }}"></script>


<!-- Core plugin JavaScript-->
<script src="{{ asset('admin_templates/sb-admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('admin_templates/sb-admin/js/sb-admin-2.min.js') }}"></script>

<script src="{{ asset("plugins/form-validator/jquery.form-validator.min.js?v=").env('ASSET_V', 1) }}" type="text/javascript"></script>
<script src="{{ asset("plugins/magnify-popup/jquery.magnific-popup.min.js") }}" type="text/javascript"></script>

<script src="{{ asset('admin_templates/sb-admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin_templates/sb-admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset("plugins/jquery-confirm/dist/jquery-confirm.min.js") }}" type="text/javascript"></script>
<script src="{{ asset("plugins/timer/timer.jquery.min.js") }}" type="text/javascript"></script>



<script src="{{ asset('js/admin/index.js?v=').env('ASSET_V', 1) }}" type="text/javascript"></script>

<script src="{{ asset('plugins/daterangepicker/daterangepicker.js?v=').env('ASSET_V', 1) }}"></script>


<script>
  var ADMIN_URL = '<?php echo url("admin-management"); ?>';
  var ASSET_URL = '<?php echo asset(''); ?>';
  var BASE_URL = '<?php echo url('/'); ?>';
</script>

<?php
$language_array = include public_path('../resources/lang/' . App::getLocale() . '/app.php');
?>

<script>
  var languageData = <?php echo json_encode($language_array); ?>;
</script>

<script>
$(document).ready(function() {
  $('.image-link').magnificPopup({type:'image'});
})
</script>

<!-- page specific scripts -->
@yield('pagespecificscripts')