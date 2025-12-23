$(document).ready(function() {
  $.validate({
      form: "#frm-approve-withdrawal",
      onSuccess: function($form) {
          var form_id = $form.attr("id");
          $("#" + form_id)
              .find("button[name=submit]")
              .addClass("is-loading");
      }
  });

  $.validate({
    form: "#frm-reject-withdrawal",
    onSuccess: function($form) {
        var form_id = $form.attr("id");
        $("#" + form_id)
            .find("button[name=submit]")
            .addClass("is-loading");
    }
});

  $("#frm-approve-withdrawal").submit(function(e) {
      e.preventDefault();

      var content = "";

      $("#frm-approve-withdrawal .form-control").each(function(i, v) {
          if ($(v).prev().is("label")) {
              if ($(v).is("select")) {
                content +=
                      $(v).prev()[0].innerHTML +
                      "<br> <div class='confirm-value'>" +
                      $(v).find(":selected").text() +
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
          title: "Approve Confirmation!",
          content: content,
          buttons: {
              cancel: function() {
                  $("#frm-approve-withdrawal")
                      .find("button[name=submit]")
                      .removeClass("is-loading");
              },
              confirm: {
                  text: "Confirm",
                  btnClass: "btn-success",
                  keys: ["enter"],
                  action: function() {
                      $("#frm-approve-withdrawal").unbind();
                      $(".btn-submit").trigger("click");
                      return true;
                  }
              }
          }
      });

      return false;
  });

  $("#frm-reject-withdrawal").submit(function(e) {
    e.preventDefault();

    var content = "";

    $("#frm-reject-withdrawal .form-control").each(function(i, v) {
        if ($(v).prev().is("label")) {
            if ($(v).is("select")) {
              content +=
                    $(v).prev()[0].innerHTML +
                    "<br> <div class='confirm-value'>" +
                    $(v).find(":selected").text() +
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
        title: "Reject Confirmation!",
        content: content,
        buttons: {
            cancel: function() {
                $("#frm-reject-withdrawal")
                    .find("button[name=submit]")
                    .removeClass("is-loading");
            },
            confirm: {
                text: "Confirm",
                btnClass: "btn-success",
                keys: ["enter"],
                action: function() {
                    $("#frm-reject-withdrawal").unbind();
                    $(".btn-reject").trigger("click");
                    return true;
                }
            }
        }
    });

    return false;
});

});
