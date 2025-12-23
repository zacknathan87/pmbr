$(document).ready(function() {
  $.validate({
      form: "#frm-add-announcement",
      onSuccess: function($form) {
          var form_id = $form.attr("id");
          $("#" + form_id)
              .find("button[name=submit]")
              .addClass("is-loading");
      }
  });

  $("#frm-add-announcement").submit(function(e) {
      e.preventDefault();

      var content = "";


      $("#frm-add-announcement .form-control").each(function(i, v) {
        if(!$(v).hasClass("note-form-control")) {
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
        }
         
      });

      $.confirm({
          useBootstrap: true,
          title: "Confirmation!",
          content: content,
          buttons: {
              cancel: function() {
                  $("#frm-add-announcement")
                      .find("button[name=submit]")
                      .removeClass("is-loading");
              },
              confirm: {
                  text: "Confirm",
                  btnClass: "btn-success",
                  keys: ["enter"],
                  action: function() {
                      $("#frm-add-announcement").unbind();
                      $(".btn-submit").trigger("click");
                      return true;
                  }
              }
          }
      });

      return false;
  });

  $('#summernote').summernote({

    toolbar: [
      // [groupName, [list of button]]
      ['style', ['bold', 'italic', 'underline', 'clear']],
      ['font', ['strikethrough', 'superscript', 'subscript']],
      ['fontsize', ['fontsize']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['height', ['height']]
    ],  
    height: 200
  });
});
