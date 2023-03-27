$(document).ready(function() {
    var opacity = 0.2;
    var chkbox = $('.chkBox');
    $('#formGeneral').on('submit', function() {
        $('select').prop('disabled', false);
    });
    if (chkbox.is(':checked')) {
        chkbox.closest('#formFields').find('input[type=text]').prop('readonly', true);
        chkbox.closest('#formFields').find('input[type=date]').prop('readonly', true);
        chkbox.closest('#formFields').find('select').prop('disabled', true);
        chkbox.closest('#formFields').find('textarea').prop('readonly', true);

        chkbox.closest('#formFields').find('input[type=text]').css('opacity', opacity);
        chkbox.closest('#formFields').find('input[type=date]').css('opacity', opacity);
        chkbox.closest('#formFields').find('select').css('opacity', opacity);
        chkbox.closest('#formFields').find('textarea').css('opacity', opacity);
        chkbox.closest('#formFields').find('input[type=text]').css('font-style', 'italic');
        chkbox.closest('#formFields').find('input[type=date]').css('font-style', 'italic');
        chkbox.closest('#formFields').find('select').css('font-style', 'italic');
        chkbox.closest('#formFields').find('textarea').css('font-style', 'italic');
        
        $('#headerPreviousMaintenance').css('opacity', opacity);
        $('#headerPreviousMaintenance').css('font-style', 'italic');
        $('#bodyPreviousMaintenance td').css('opacity', opacity);
        $('#bodyPreviousMaintenance td').css('font-style', 'italic');
        //chkbox.closest('#formFields').css('font-style', 'italic');        

        chkbox.parents().siblings('#formFields').find('input[type=text]').prop('readonly', true);
        chkbox.parents().siblings('#formFields').find('input[type=date]').prop('readonly', true);
        chkbox.parents().siblings('#formFields').find('select').prop('disabled', true);
        chkbox.parents().siblings('#formFields').find('textarea').prop('readonly', true);

        chkbox.parents().siblings('#formFields').find('input[type=text]').css('opacity', opacity);
        chkbox.parents().siblings('#formFields').find('input[type=date]').css('opacity', opacity);
        chkbox.parents().siblings('#formFields').find('select').css('opacity', opacity);
        chkbox.parents().siblings('#formFields').find('textarea').css('opacity', opacity);
        chkbox.parents().siblings('#formFields').find('input[type=text]').css('font-style', 'italic');
        chkbox.parents().siblings('#formFields').find('input[type=date]').css('font-style', 'italic');
        chkbox.parents().siblings('#formFields').find('select').css('font-style', 'italic');
        chkbox.parents().siblings('#formFields').find('textarea').css('font-style', 'italic');
        
        //chkbox.parents().siblings('#formFields').css('font-style', 'italic');
      } else {
        chkbox.closest('#formFields').find('input[type=text]').prop('readonly', false);
        chkbox.closest('#formFields').find('input[type=date]').prop('readonly', false);
        chkbox.closest('#formFields').find('select').prop('disabled', false);
        chkbox.closest('#formFields').find('textarea').prop('readonly', false);

        chkbox.closest('#formFields').find('input[type=text]').css('opacity','');
        chkbox.closest('#formFields').find('input[type=date]').css('opacity','');
        chkbox.closest('#formFields').find('select').css('opacity','');
        chkbox.closest('#formFields').find('textarea').css('opacity','');
        chkbox.closest('#formFields').find('input[type=text]').css('font-style', '');
        chkbox.closest('#formFields').find('input[type=date]').css('font-style', '');
        chkbox.closest('#formFields').find('select').css('font-style', '');
        chkbox.closest('#formFields').find('textarea').css('font-style', '');
        //chkbox.closest('#formFields').css('font-style', '');

        $('#headerPreviousMaintenance').css('opacity', '');
        $('#headerPreviousMaintenance').css('font-style', '');
        $('#bodyPreviousMaintenance td').css('opacity', '');
        $('#bodyPreviousMaintenance td').css('font-style', '');

        chkbox.parents().siblings('#formFields').find('input[type=text]').prop('readonly', false);
        chkbox.parents().siblings('#formFields').find('input[type=date]').prop('readonly', false);
        chkbox.parents().siblings('#formFields').find('select').prop('disabled', false);
        chkbox.parents().siblings('#formFields').find('textarea').prop('readonly', false);

        chkbox.parents().siblings('#formFields').find('input[type=text]').css('opacity','');
        chkbox.parents().siblings('#formFields').find('input[type=date]').css('opacity','');
        chkbox.parents().siblings('#formFields').find('select').css('opacity','');
        chkbox.parents().siblings('#formFields').find('textarea').css('opacity','');
        chkbox.parents().siblings('#formFields').find('input[type=text]').css('font-style', '');
        chkbox.parents().siblings('#formFields').find('input[type=date]').css('font-style', '');
        chkbox.parents().siblings('#formFields').find('select').css('font-style', '');
        chkbox.parents().siblings('#formFields').find('textarea').css('font-style', '');
        //chkbox.parents().siblings('#formFields').css('font-style', '');
      }
      chkbox.click(function() {
      if (chkbox.is(':checked')) {
        chkbox.closest('#formFields').find('input[type=text]').prop('readonly', true);
        chkbox.closest('#formFields').find('input[type=date]').prop('readonly', true);
        chkbox.closest('#formFields').find('select').prop('disabled', true);
        chkbox.closest('#formFields').find('textarea').prop('readonly', true);

        chkbox.closest('#formFields').find('input[type=text]').css('opacity', opacity);
        chkbox.closest('#formFields').find('input[type=date]').css('opacity', opacity);
        chkbox.closest('#formFields').find('select').css('opacity', opacity);
        chkbox.closest('#formFields').find('textarea').css('opacity', opacity);
        chkbox.closest('#formFields').find('input[type=text]').css('font-style', 'italic');
        chkbox.closest('#formFields').find('input[type=date]').css('font-style', 'italic');
        chkbox.closest('#formFields').find('select').css('font-style', 'italic');
        chkbox.closest('#formFields').find('textarea').css('font-style', 'italic');
        //chkbox.closest('#formFields').css('font-style', 'italic');

        $('#headerPreviousMaintenance').css('opacity', opacity);
        $('#headerPreviousMaintenance').css('font-style', 'italic');
        $('#bodyPreviousMaintenance td').css('opacity', opacity);
        $('#bodyPreviousMaintenance td').css('font-style', 'italic');

        chkbox.parents().siblings('#formFields').find('input[type=text]').prop('readonly', true);
        chkbox.parents().siblings('#formFields').find('input[type=date]').prop('readonly', true);
        chkbox.parents().siblings('#formFields').find('select').prop('disabled', true);
        chkbox.parents().siblings('#formFields').find('textarea').prop('readonly', true);

        chkbox.parents().siblings('#formFields').find('input[type=text]').css('opacity', opacity);
        chkbox.parents().siblings('#formFields').find('input[type=date]').css('opacity', opacity);
        chkbox.parents().siblings('#formFields').find('select').css('opacity', opacity);
        chkbox.parents().siblings('#formFields').find('textarea').css('opacity', opacity);
        chkbox.parents().siblings('#formFields').find('input[type=text]').css('font-style', 'italic');
        chkbox.parents().siblings('#formFields').find('input[type=date]').css('font-style', 'italic');
        chkbox.parents().siblings('#formFields').find('select').css('font-style', 'italic');
        chkbox.parents().siblings('#formFields').find('textarea').css('font-style', 'italic');
        //chkbox.parents().siblings('#formFields').css('font-style', 'italic');
      } else {
        chkbox.closest('#formFields').find('input[type=text]').prop('readonly', false);
        chkbox.closest('#formFields').find('input[type=date]').prop('readonly', false);
        chkbox.closest('#formFields').find('select').prop('disabled', false);
        chkbox.closest('#formFields').find('textarea').prop('readonly', false);

        chkbox.closest('#formFields').find('input[type=text]').css('opacity','');
        chkbox.closest('#formFields').find('input[type=date]').css('opacity','');
        chkbox.closest('#formFields').find('select').css('opacity','');
        chkbox.closest('#formFields').find('textarea').css('opacity','');
        chkbox.closest('#formFields').find('input[type=text]').css('font-style', '');
        chkbox.closest('#formFields').find('input[type=date]').css('font-style', '');
        chkbox.closest('#formFields').find('select').css('font-style', '');
        chkbox.closest('#formFields').find('textarea').css('font-style', '');
        //chkbox.closest('#formFields').css('font-style', '');

        $('#headerPreviousMaintenance').css('opacity', '');
        $('#headerPreviousMaintenance').css('font-style', '');
        $('#bodyPreviousMaintenance td').css('opacity', '');
        $('#bodyPreviousMaintenance td').css('font-style', '');

        chkbox.parents().siblings('#formFields').find('input[type=text]').prop('readonly', false);
        chkbox.parents().siblings('#formFields').find('input[type=date]').prop('readonly', false);
        chkbox.parents().siblings('#formFields').find('select').prop('disabled', false);
        chkbox.parents().siblings('#formFields').find('textarea').prop('readonly', false);

        chkbox.parents().siblings('#formFields').find('input[type=text]').css('opacity','');
        chkbox.parents().siblings('#formFields').find('input[type=date]').css('opacity','');
        chkbox.parents().siblings('#formFields').find('select').css('opacity','');
        chkbox.parents().siblings('#formFields').find('textarea').css('opacity','');
        chkbox.parents().siblings('#formFields').find('input[type=text]').css('font-style', '');
        chkbox.parents().siblings('#formFields').find('input[type=date]').css('font-style', '');
        chkbox.parents().siblings('#formFields').find('select').css('font-style', '');
        chkbox.parents().siblings('#formFields').find('textarea').css('font-style', '');
        //chkbox.parents().siblings('#formFields').css('font-style', '');
      }
    });
  })