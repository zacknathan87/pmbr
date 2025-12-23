$(document).ready(function() {
    $("select[name=game_room_id]").on("change", function() {
        var gameid = $(this)
            .children("option:selected")
            .val();

        if (gameid.length > 0) {
            $("select[name=question_id]").removeAttr("disabled");

            // get question
            $.get(
                ADMIN_URL + "/question/getQuestionByGame/" + gameid, // url
                function(data, textStatus, jqXHR) {
                    // success callback
                    $("select[name=question_id]").html(data);
                }
            );
        } else {
            $("select[name=question_id]").attr("disabled", true);
        }
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

    $.validate({
        form: "#frm-add-game",
        onSuccess: function($form) {
            var form_id = $form.attr("id");
            $("#" + form_id)
                .find("button[name=submit]")
                .addClass("is-loading");
        }
    });

    $("#frm-add-game").submit(function(e) {
        e.preventDefault();

        var content = "";

        $("#frm-add-game .form-control").each(function(i, v) {
            if (
                $(v)
                    .prev()
                    .is("label")
            ) {
                if ($(v).is("select")) {
                    content +=
                        $(v).prev()[0].innerHTML +
                        "<br> <div class='confirm-value'>" +
                        $(v)
                            .find(":selected")
                            .text() +
                        "</div><br>";
                } else {
                    content +=
                        $(v).prev()[0].innerHTML +
                        "<br> <div class='confirm-value'>" +
                        $(v).val() +
                        "</div><br>";
                }
            }
        });

        $.confirm({
            useBootstrap: true,
            title: "Confirmation!",
            content: content,
            buttons: {
                cancel: function() {
                    $("#frm-add-game")
                        .find("button[name=submit]")
                        .removeClass("is-loading");
                },
                confirm: {
                    text: "Confirm",
                    btnClass: "btn-success",
                    keys: ["enter"],
                    action: function() {
                        $("#frm-add-game").unbind();
                        $(".btn-submit").trigger("click");
                        return true;
                    }
                }
            }
        });

        return false;
    });

    var startDate =  null
    var endDate = null;


    if ($("input[name=faux_start_at]")) {
        startDate = moment($("input[name=faux_start_at]").val()).format("DD/MM/YYYY");
    }

    // if ($("input[name=faux_end_at]")) {
    //     endDate = moment($("input[name=faux_end_at]").val()).format("DD/MM/YYYY hh:mm A");
    // } 

    console.log(startDate);
    console.log(endDate);

    $("#datetimepicker1").datetimepicker({
        format: "DD/MM/YYYY",
        minDate: moment(startDate, "DD/MM/YYYY"),
        date: startDate,
        useCurrent: true,
        sideBySide: false,
        pickSeconds: false,
        pick12HourFormat: false
    });

    // $("#datetimepicker2").datetimepicker({
    //     format: "DD/MM/YYYY hh:mm A",
    //     minDate: moment(startDate, "DD/MM/YYYY hh:mm A"),
    //     date: endDate,
    //     sideBySide: true,
    //     pickSeconds: false,
    //     pick12HourFormat: false
    // });

    $("#datetimepicker2")
        .val(endDate)
        .change();

        $("#datetimepicker1")
        .val(startDate)
        .change();


    $("select[name=start_time]").on("change", function() {
        var start_time =  moment($( "select[name=start_time] option:selected" ).val(), [moment.ISO_8601, 'HH:mm']);
        $("input[name=faux_end_time]").val(start_time.add(2, 'hours').format('h A'))
        
    })


    $.validate({
        form: "#frm-add-channel",
        onSuccess: function($form) {
            var form_id = $form.attr("id");
            $("#" + form_id)
                .find("button[name=submit]")
                .addClass("is-loading");
        }
    });

    $.validate({
        form: "#frm-add-room",
        onSuccess: function($form) {
            var form_id = $form.attr("id");
            $("#" + form_id)
                .find("button[name=submit]")
                .addClass("is-loading");
        }
    });
});
