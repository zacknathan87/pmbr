// Call the dataTables jQuery plugin
$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: ADMIN_URL + "/game/getList",
            data: function(d) {
                d.game_channel_id = $("select[name='game_channel_id']").val();
                d.status_id = $("select[name='status_id']").val();
                d.date = $("input[name='faux_date']").val();
            },
            method: "GET",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        },
        ordering: false,
        language: {
            infoFiltered: ""
        },
        lengthMenu: [50, 100, 200, 500],
        iDisplayLength: 50
    });

    $("#datetimepicker1").datetimepicker({
        format: "DD/MM/YYYY",
        sideBySide: false,
        pickSeconds: false,
        pick12HourFormat: false
    });

    var date = $("input[name='faux_date']").val()
        ? $("input[name='faux_date']").val()
        : "";
        
    $("#datetimepicker1")
        .val(date)
        .change();

    $.validate({
        form: ".frm-set-win",
        onSuccess: function($form) {
            var form_id = $form.attr("id");
            $("#" + form_id)
                .find("button[name=submit]")
                .addClass("is-loading");
        }
    });
});

$("body").on("click", ".btn-set-win", function() {
    var id = $(this).attr("game-id");
    var typeId = $(this).attr("game-type-id");

    $("input[name=game_id]").val(id);

    $("#mdl-set-win-"+typeId).modal('show');
});
