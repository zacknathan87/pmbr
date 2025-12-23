$(document).ready(function() {
    var startDate = null;
    var endDate = null;

    if ($("input[name=faux_start_at]")) {
        startDate = moment($("input[name=faux_start_at]").val(), [moment.ISO_8601, 'HH:mm']).format(
            "HH:mm"
        );
    }

    if ($("input[name=faux_end_at]")) {
      endDate = moment($("input[name=faux_end_at]").val(), [moment.ISO_8601, 'HH:mm']).format(
            "HH:mm"
        );
    }


    $("#datetimepicker1").datetimepicker({
        format: "HH:mm",
        date: startDate,
    });

    $("#datetimepicker2").datetimepicker({
        format: "HH:mm",
        date: endDate,
    });

    $("#datetimepicker2")
        .val(endDate)
        .change();

    $("#datetimepicker1")
        .val(startDate)
        .change();
});
