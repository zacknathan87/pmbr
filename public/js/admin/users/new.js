$(document).ready(function () {

  $.validate({
    form: '#frm-add-user',
    onSuccess : function($form) {
      var form_id = $form.attr('id')
      $('#'+form_id).find('button[name=submit]').addClass('is-loading')
    },
  });

});