// Call the dataTables jQuery plugin
$(document).ready(function () {
    $("#dataTable").DataTable({
        order: [[2, "desc"]],
        processing: true,
        serverSide: true,
        ajax: {
            url: ADMIN_URL + "/report/getList",
            method: "GET",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        },
        language: {
            infoFiltered: "",
        },
        lengthMenu: [10, 20, 50, 100],
        iDisplayLength: 50,
    });
});
