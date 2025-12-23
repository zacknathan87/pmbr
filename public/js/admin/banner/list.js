// Call the dataTables jQuery plugin
$(document).ready(function() {
  $("#dataTable").DataTable({
      order: [[0, "desc"]]
  });

  $(".btn-delete").on("click", function() {
      var id = $(this).attr("id");

      $("input[name=banner_id]").val(id);
  });
});
