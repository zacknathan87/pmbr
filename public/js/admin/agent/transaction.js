$(document).ready(function () {

  $.validate({
    form: '#frm-add-transaction',
    onSuccess : function($form) {
      var form_id = $form.attr('id')
      $('#'+form_id).find('button[name=submit]').addClass('is-loading')
    },
  });

  $("#frm-add-transaction").submit( function(e) {
    e.preventDefault();

    var content = '';

    $("#frm-add-transaction .form-control").each(function(i, v) {
      if($(v).prev().is("label")) {
        var text = '';
        
        if($(v).is("select")) {
          text = $(v).children("option:selected").text();
        } else {
          text = $(v).val();
        }

        content += $(v).prev()[0].innerHTML+"<br> <div class='confirm-value'>"+text+"</div><br>";

      }
    });

    $.confirm({
      useBootstrap: true,
      title: "Confirmation!",
      content: content,
      buttons: {
        cancel: function() {
          $('#frm-add-transaction').find('button[name=submit]').removeClass('is-loading')
        },
        confirm: {
          text: "Confirm",
          btnClass: "btn-success",
          keys: ["enter"],
          action: function() {
            $('#frm-add-transaction').unbind();
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