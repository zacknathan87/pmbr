// Call the dataTables jQuery plugin
$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: ADMIN_URL + "/game/getBetList",
            data: function(d) {
                d.game_channel_id = $("select[name='game_channel_id']").val();
                d.status_id = $("select[name='status_id']").val();
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
});
