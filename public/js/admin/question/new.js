$(document).ready(function() {
  $.validate({
      form: "#frm-add-question",
      onSuccess: function($form) {
          var form_id = $form.attr("id");
          $("#" + form_id)
              .find("button[name=submit]")
              .addClass("is-loading");
      }
  });

  $("#frm-add-question").submit(function(e) {
      e.preventDefault();

      var content = "";

      $("#frm-add-question .form-control").each(function(i, v) {
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
          title: "Confirmation!",
          content: content,
          buttons: {
              cancel: function() {
                  $("#frm-add-question")
                      .find("button[name=submit]")
                      .removeClass("is-loading");
              },
              confirm: {
                  text: "Confirm",
                  btnClass: "btn-success",
                  keys: ["enter"],
                  action: function() {
                      $("#frm-add-question").unbind();
                      $(".btn-submit").trigger("click");
                      return true;
                  }
              }
          }
      });

      return false;
  });

});
