jQuery(document).ready(function($) {
  
  var frame;
  
  jQuery('body').on('click', '#insert-file-btn', function(event) {
      event.preventDefault();
      if (frame) {
        frame.open();
      }else {
        frame = wp.media({
                    title: 'Select or Upload files for material',
                    button: {
                      text: 'Use this media'
                    },
                    multiple: true
        });
        frame.on('select', function() {
          var files = frame.state().get('selection').toJSON(); 

          for (var i = 0; i < files.length; i++) {
            console.log(files[i]);
            var fileID = files[i].id;
            if (files[i].sizes) {
              var thumbUrl = files[i].sizes.thumbnail.url;
            }else {
              var thumbUrl = files[i].icon;
            }          
            var fileTitle = files[i].title;
            var isSelected = false;
            jQuery('.select-file').each(function(index, el) {
              var id = jQuery(this).attr('id');
              
              if(id == fileID) {
                alert('This file is already selected, select another.');
                frame.open();
                isSelected = true;
              }
            });
            if(!isSelected){
              jQuery('#selected-files').append('<div class="select-file" id="'+fileID+'"><p class="file-title">'+fileTitle+'</p><div class="select-file-thumb"><img src="'+thumbUrl+'"><div class="delete-file-btn" data-id="'+fileID+'"></div></div><input type="hidden" name="files-id[]" value="'+fileID+'"></div>');       
            }
          }
        });
        frame.open();
      }
  });

  jQuery('body').on('click', '.select-file .delete-file-btn', function(event) {
    var id = jQuery(this).data('id');
    jQuery('#'+id).remove();
  });

  jQuery('body').on('change', 'input[name="placement"]', function(event) {
    var val = jQuery(this).val();

    if(val == 'internal') {
      jQuery('#selected-files').show();
      jQuery('#insert-file-btn').show();
      jQuery('#external-link').hide();
      jQuery('input[name="file-link"').prop('required', false);
    }else if(val == 'external') {
      jQuery('#selected-files').hide();
      jQuery('#insert-file-btn').hide();
      jQuery('#external-link').show();
      jQuery('input[name="file-link"').prop('required', true);
    }
  });

  jQuery('body').on('click', '.related-file', function(event) {
    event.preventDefault();
    jQuery(this).remove();
    var link = jQuery(this).data('link');
    var name = jQuery(this).text();
    var id = jQuery(this).data('id');
    jQuery('#selected-files-list').append('<label for="selected-file"><a href="'+link+'" target="_blank" class="related-title">'+name+'</a><input type="hidden" value="'+id+'" name="selected-files[]"><div class="delete-related-btn" data-id="'+id+'" data-title="'+name+'"></div></label>');
  });

  jQuery('body').on('click', '.delete-related-btn', function(event) {
    var id = jQuery(this).data('id');
    var title = jQuery(this).data('title');
    jQuery('#searched-files-select p').remove();
    jQuery('#searched-files-select').append('<li class="related-file" data-id="'+id+'">'+title+'</li>')
    jQuery(this).parent().remove();
  });

  jQuery('body').on('change', 'input[name="rlt-file-title"]', function(event) {
      var metarialTitle = jQuery('input[name="rlt-file-title"]').val();
      var ajaxUrl = jQuery('input[name="ajax-url"]').val();
      var materialID = jQuery('input[name="materialID"]').val();
      var relatedFiles = [materialID];      
      jQuery('#searched-files-select').html('<div class="loader" id="loader-1">');
      jQuery('input[name="selected-files[]"]').each(function(index, el) {
        var val = jQuery(this).val();
        relatedFiles.push(val);
      });
      console.log(relatedFiles);
      $.ajax({
        url: ajaxUrl,
        type: 'POST',
        dataType: 'html',
        data: {
          'file-name' : metarialTitle,
          'exclude' : relatedFiles
        },
        error: function(xhr, textStatus, errorThrown) {
            console.log("error", xhr, textStatus, errorThrown);
        },
      }).done(function(d) {
        jQuery('#searched-files-select').html(d);
      });/*end ajax*/
  });

  jQuery('body').on('click', '#search-files-btn', function(event) {
    var metarialTitle = jQuery('input[name="rlt-file-title"]').val();
    var ajaxUrl = jQuery('input[name="ajax-url"]').val();
    var materialID = jQuery('input[name="materialID"]').val();
    var relatedFiles = [materialID];      
    jQuery('#searched-files-select').html('<div class="loader" id="loader-1">');
    jQuery('input[name="selected-files[]"]').each(function(index, el) {
      var val = jQuery(this).val();
      relatedFiles.push(val);
    });
    $.ajax({
      url: ajaxUrl,
      type: 'POST',
      dataType: 'html',
      data: {
        'file-name' : metarialTitle,
        'exclude' : relatedFiles
      },
      error: function(xhr, textStatus, errorThrown) {
          console.log("error", xhr, textStatus, errorThrown);
      },
    }).done(function(d) {
      jQuery('#searched-files-select').html(d);
    });/*end ajax*/
  });

  jQuery('input[name="ll_is_newest_materials_allow"]').change(function(event) {
    var value = jQuery(this).val();
    console.log(value);
    if (value == '1') {
      jQuery('input[name="ll_new_materials_count"]').prop('disabled',false);
    }else {
       jQuery('input[name="ll_new_materials_count"]').prop('disabled',true);
    }
  });

  jQuery('input[name="ll_is_top_materials_allow"]').change(function(event) {
    var value = jQuery(this).val();
    if (value == '1') {
      jQuery('input[name="ll_top_materials_count"]').prop('disabled',false);
    }else {
       jQuery('input[name="ll_top_materials_count"]').prop('disabled',true);
    }
  });
  $('.ll-color-picker-class').wpColorPicker();
  
});
  

