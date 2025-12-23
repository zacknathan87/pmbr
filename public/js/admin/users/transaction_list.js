var init_start = true;
var init_end = true;

$(document).ready(function () {

  var start_date = (start_get.length != 0) ? moment(start_get, 'YYYY-MM-DD') : moment().startOf('day');
  var end_date = (end_get.length != 0) ? moment(end_get, 'YYYY-MM-DD') : moment().endOf('day');

  // function cb(start_date, end_date) {
  //   $("#start_date").val(start_date.format('YYYY-MM-DD'));
  //   $("#end_date").val(end_date.format('YYYY-MM-DD'));

  //   $('#reportrange span').html(start_date.format('DD/MM/YYYY') + ' - ' + end_date.format('DD/MM/YYYY'));
  // }

  function cb_start(start_date) {
    $("#start_date").val(start_date.format('YYYY-MM-DD'));
    $('#reportrange_start span').html(start_date.format('DD/MM/YYYY'));


    if(init_start) {
      init_start = false
    } else {
      var range = $("input[name=range]").val()
      if(range) {
        $("input[name=range]").val('')
        $(".btn-prefix-range").removeClass("btn-primary");
        $(".btn-prefix-range").addClass("btn-outline-primary");
      }
    }
  }

  function cb_end(end_date) {
    $("#end_date").val(end_date.format('YYYY-MM-DD'));
    $('#reportrange_end span').html(end_date.format('DD/MM/YYYY'));

    if(init_end) {
      init_end = false
    } else {
      var range = $("input[name=range]").val()
      if(range) {
        $("input[name=range]").val('')
        $(".btn-prefix-range").removeClass("btn-primary");
        $(".btn-prefix-range").addClass("btn-outline-primary");
      }
    }
  }

  $('#reportrange_start').daterangepicker({
    singleDatePicker: true,
    // startDate: start_date,
    // endDate: end_date,
    // ranges: {
    //    'Today': [moment().startOf('day'), moment().endOf('day')],
    //    'Yesterday': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days').endOf('day')],
    //    'This Week': [moment().startOf('isoWeek'), moment().endOf('isoWeek')],
    //    'Last Week': [moment().subtract(1, 'weeks').startOf('isoWeek'), moment().subtract(1, 'weeks').endOf('isoWeek')],
    //    'This Month': [moment().startOf('month'), moment().endOf('month')],
    //    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    // }
  }, cb_start);

  $('#reportrange_end').daterangepicker({
    singleDatePicker: true,
  }, cb_end);

  cb_start(start_date);
  cb_end(end_date);

  


  $(".btn-prefix-range").on("click", function (e) {
    // change style
    $(".btn-prefix-range").removeClass("btn-primary");
    $(".btn-prefix-range").addClass("btn-outline-primary");
    $(this).removeClass("btn-outline-primary");
    $(this).addClass("btn-primary");

    // change date
    var range = $(this).data('range');
    var start_date, end_date;
    if (range == 'today') {
      start_date = moment().startOf('day');
      end_date = moment().endOf('day');
    }
    if (range == 'yesterday') {
      start_date = moment().subtract(1, 'days').startOf('day');
      end_date = moment().subtract(1, 'days').endOf('day');
    }
    if (range == 'this_week') {
      start_date = moment().startOf('isoWeek');
      end_date = moment().endOf('isoWeek');
    }
    if (range == 'this_month') {
      start_date = moment().startOf('month')
      end_date = moment().endOf('month')
    }
    if (range == 'last_month') {
      start_date = moment().subtract(1, 'month').startOf('month')
      end_date = moment().subtract(1, 'month').endOf('month')
    }

    if (start_date && end_date) {

      $("#start_date").val(start_date.format('YYYY-MM-DD')).trigger("change");
      $('#reportrange_start span').html(start_date.format('DD/MM/YYYY'));

      $("#end_date").val(end_date.format('YYYY-MM-DD')).trigger("change");
      $('#reportrange_end span').html(end_date.format('DD/MM/YYYY'));

      $("input[name=range]").val(range)
    }
  })

  $('.export').on('click', function () {

    var url = $(this).data('url');
    var filename = $(this).data('filename');
    console.log(url)
    $(this).addClass('is-loading')
    $.ajax({
      url: url,
      method: 'GET',
      xhrFields: {
        responseType: 'blob'
      },
      success: function (data) {
        $('.export').removeClass('is-loading')

        var a = document.createElement('a');
        var data_url = window.URL.createObjectURL(data);
        a.href = data_url;
        a.download = filename;
        document.body.append(a);
        a.click();
        a.remove();
        window.URL.revokeObjectURL(data_url);
      }
    });
  });
});
