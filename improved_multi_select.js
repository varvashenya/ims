Drupal.behaviors.improved_multi_select = function(context) {
  if ($('select[multiple]:not(.improvedselect-processed)').length > 0) {
    $('select[multiple]', context).each(function(){
      $(this).addClass('improvedselect-processed');
      $(this).parent().append('<div class="improvedselect" sid="'+ $(this).attr('id') +'" id="improvedselect-'+ $(this).attr('id') +'"><div class="improvedselect-text-wrapper"><input type="text" class="improvedselect_filter" sid="'+ $(this).attr('id') +'" prev="" /></div><ul class="improvedselect_sel"></ul><ul class="improvedselect_all"></ul><div class="improvedselect_control"><span class="add" sid="'+ $(this).attr('id') +'">&gt;</span><span class="del" sid="'+ $(this).attr('id') +'">&lt;</span><span class="add_all" sid="'+ $(this).attr('id') +'">&raquo;</span><span class="del_all" sid="'+ $(this).attr('id') +'">&laquo;</span></div><div class="clear" /></div>');
      var improvedselect_id = $(this).attr('id');
      $(this).find('option').each(function(){
        if ($(this).attr("selected")) {
          $('#improvedselect-'+ improvedselect_id +' .improvedselect_sel').append('<li so="'+ $(this).attr('value') +'">'+ $(this).text() +'</li>');
        }
        else {
          $('#improvedselect-'+ improvedselect_id +' .improvedselect_all').append('<li so="'+ $(this).attr('value') +'">'+ $(this).text() +'</li>');
        }
      });
      $('#improvedselect-'+ improvedselect_id +' li').click(function(){
        $(this).toggleClass('selected');
      });
      $(this).hide();
    });
    $('.improvedselect_filter').keyup(function(){
      $text = $(this).val();
      if ($text.length) {
        if ($text != $(this).attr('prev')) {
          $(this).attr('prev', $text);
          patt = new RegExp($text,'i');
          $('#improvedselect-'+ $(this).attr('sid') +' .improvedselect_all li').each(function(){
            str = $(this).text();
            if (str.match(patt)){
              $(this).show();
            }
            else{
              $(this).hide('fast');
            }
          });
        }
      }
      else {
        $(this).attr('prev', '')
        $('#improvedselect-'+ $(this).attr('sid') +' .improvedselect_all li').each(function(){
          $(this).show();
        });
      }
    });

    function improvedselectUpdate(sid){
      $('#'+ sid +' option:selected').attr("selected", "");
      $('#improvedselect-'+ sid +' .improvedselect_sel li').each(function(){
        $('#'+ sid +' [value="'+ $(this).attr('so') +'"]').attr("selected", "selected");
      });
    }

    $('.improvedselect .add').click(function(){
      sid = $(this).attr('sid');
      $('#improvedselect-'+ sid +' .improvedselect_all .selected').each(function(){
        $(this).removeClass('selected');
        $(this).show();
        $('#improvedselect-'+ sid +' .improvedselect_sel').append($(this));
      });
      improvedselectUpdate(sid);
    });
    $('.improvedselect .del').click(function(){
      sid = $(this).attr('sid');
      $('#improvedselect-'+ sid +' .improvedselect_sel .selected').each(function(){
        $(this).removeClass('selected');
        $('#improvedselect-'+ sid +' .improvedselect_all').append($(this));
      });
      improvedselectUpdate(sid);
    });
    $('.improvedselect .add_all').click(function(){
      sid = $(this).attr('sid');
      $('#improvedselect-'+ sid +' .improvedselect_all li').each(function(){
        if ($(this).css('display') != 'none') {
          $(this).removeClass('selected');
          $('#improvedselect-'+ sid +' .improvedselect_sel').append($(this));
        }
      });
      improvedselectUpdate(sid);
    });
    $('.improvedselect .del_all').click(function(){
      sid = $(this).attr('sid');
      $('#improvedselect-'+ sid +' input').val('');
      $('#improvedselect-'+ sid +' input').attr('sid', '');
      $('#improvedselect-'+ sid +' .improvedselect_sel li').each(function(){
        $(this).removeClass('selected');
        $('#improvedselect-'+ sid +' .improvedselect_all').append($(this));
      });
      $('#improvedselect-'+ sid +' .improvedselect_all li').each(function(){
        $(this).show();
      });
      improvedselectUpdate(sid);
    });
  }
};