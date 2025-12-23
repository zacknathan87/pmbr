$(document).ready(function() {
    $(".timer").each(function() {
        var time = $(this).data("time");

        $(this).timer({
            action: "start",
            duration: time,
            countdown: true,
            callback: function() {
                window.location.reload();
            }
        });
    });

    $(".btn-set-limit").on("click", function() {
        var id = $(this).attr("id");

        $("input[name=answer_no]").val(id);
    });

    $.validate({
        form: "#frm-set-win",
        onSuccess: function($form) {
            var form_id = $form.attr("id");
            $("#" + form_id)
                .find("button[name=submit]")
                .addClass("is-loading");
        }
    });
});
