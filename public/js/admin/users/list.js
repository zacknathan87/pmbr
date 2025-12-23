// Call the dataTables jQuery plugin
$(document).ready(function () {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: ADMIN_URL + "/users/getList",
            method: "GET",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        },
        ordering: false,
        language: {
            infoFiltered: "",
        },
        lengthMenu: [50, 100, 200, 500],
        iDisplayLength: 50,
    });
});

$("body").on("click", ".btn-suspend", function () {
    var id = $(this).attr("id");
    $("input[name=user_id]").val(id);
});

$("body").on("click", ".btn-activate", function () {
  var id = $(this).attr("id");
  $("input[name=user_id]").val(id);
});

