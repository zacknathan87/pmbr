$(document).ready(function () {

  $.validate({
    form: '#frm-add-credit',
    onSuccess : function($form) {
      var form_id = $form.attr('id')
      $('#'+form_id).find('button[name=submit]').addClass('is-loading')
    },
  });

  $("#frm-add-credit").submit( function(e) {
    e.preventDefault();

    var content = '';

    $("#frm-add-credit .form-control").each(function(i, v) {
      if($(v).prev().is("label")) {
        content += $(v).prev()[0].innerHTML+"<br> <div class='confirm-value'>"+$(v).val()+"</div><br>";
      }
    });

    $.confirm({
      useBootstrap: true,
      title: "Confirmation!",
      content: content,
      buttons: {
        cancel: function() {
          $('#frm-add-credit').find('button[name=submit]').removeClass('is-loading')
        },
        confirm: {
          text: "Confirm",
          btnClass: "btn-success",
          keys: ["enter"],
          action: function() {
            $('#frm-add-credit').unbind();
            $('.btn-submit').trigger("click");
            return true
          }
        },
      }
    });

    return false
  });


  // ------------------------------------------------------------------------------------- //

  $.validate({
    form: '#frm-withdrawal',
    onSuccess : function($form) {
      var form_id = $form.attr('id')
      $('#'+form_id).find('button[name=submit]').addClass('is-loading')
    },
  });

  $("#frm-withdrawal").submit( function(e) {
    e.preventDefault();

    var content = '';

    $("#frm-withdrawal .form-control").each(function(i, v) {
      if($(v).prev().is("label")) {
        content += $(v).prev()[0].innerHTML+"<br> <div class='confirm-value'>"+$(v).val()+"</div><br>";
      }
    });

    $.confirm({
      useBootstrap: true,
      title: "Confirmation!",
      content: content,
      buttons: {
        cancel: function() {
          $('#frm-withdrawal').find('button[name=submit]').removeClass('is-loading')
        },
        confirm: {
          text: "Confirm",
          btnClass: "btn-success",
          keys: ["enter"],
          action: function() {
            $('#frm-withdrawal').unbind();
            $('.btn-submit').trigger("click");
            return true
          }
        },
      }
    });

    return false
  });


});