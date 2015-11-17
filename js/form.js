$(document).ready(function() {
  var $captchas = $(this).find('img[id$=_refresh_captcha]');
  $captchas.each(function(index) {
    var arr = $(this).attr('id').split('_'); 
    var captcha_id = arr[0];
    $('#' + captcha_id + '_refresh_captcha').click(function() {
      $('#' + captcha_id + '_img_captcha').attr("src", "scripts/captcha.php?rnd=" + Math.random());
    });
  });
  $("form").submit(function(){
    var arr = $(this).attr('id').split('_'); 
    var form_id = arr[0];
    var str = $(this).serialize();
    var $form = $(this);
    var $inputs = $form.find('input[type=text], textarea');
    var ids = {};
    $form.find("input[type=submit]").attr("disabled", true);
    $inputs.each(function(index) {
      ids[$(this).attr('name')] = $(this).val();
    });
    $.ajax({
      type: "POST",
      dataType: "JSON",
      url: "scripts/form.php",
      data: str + '&form=' + $(this).attr('id'),
      success: function(msg) {
        // result = msg['result'];
        //console.log(msg['errors']);
        if (msg['result'] == 'OK') {
          $form.find('div[id$=_d]').removeClass();
          $form.find('div[id$=_d]').addClass('form-group');
          $form.find("input[type=text], textarea").removeAttr('style');
          $form.hide();
          $form.find("input[type=text], textarea").val('');
          $('#' + form_id +'_note').html(msg['note']);
          $('#' + form_id +'_note').show();
          $('#' + form_id +'_note').css({ opacity: 1 });
          $('#' + form_id +'_note').delay(15000) .animate({opacity: 0, top: '45%'}, 200,
            function(){
              $(this).css('display', 'none');
              $form.show();
            }
          );
        } else {
          $('#' + form_id +'_note').html(msg['result']);
        }
        $form.find("input[type=submit]").removeAttr("disabled");
      }
    });
    return false;
  });
  $('a#go').click( function(event) {
    event.preventDefault();
    $('#overlay').fadeIn(400,
      function() {
        $('#modal_form') 
          .css('display', 'block')
          .animate({opacity: 1, top: '50%'}, 200);
    });
  });
  $('#modal_close, #overlay').click( function() {
    $('#modal_form')
      .animate({opacity: 0, top: '45%'}, 200,
        function() {
          $(this).css('display', 'none');
          $('#overlay').fadeOut(400);
        }
      );
  });
});