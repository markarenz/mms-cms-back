function pagebuilder_select_image(block_id, field_slug){
  var html='<div class="text-center"><i class="fas fa-cog fa-spin" style="font-size:50px;"></i>;</div>'
  $('#app-modal .stage .inner').html(html);
  html='<div id="admin-imagepicker">';
  $('#app-modal').show();
  $.get( "/list-images", function( data ) {
    var images = JSON.parse(data);
    // eventually, let's pull thumbnails
    for (var i=0;i<images.length;i++){
      html+='<div class="admin-imagepicker-cell-wrap"><div class="admin-imagepicker-cell" style="background-image:url(' + img_remote_path + images[i].filename + ');" onclick="pagebuilder_image_select(\'' + block_id + '\', \'' + field_slug + '\', \'' + images[i].filename + '\');"> </div></div>';
    }
    html+='</div>';
    console.log(html);
    $('#app-modal .stage .inner').html(html);
  });
}

// img_remote_path

function pagebuilder_remove_image(slug){
  var id='input__' + slug;
  $('#' + id).val('');
  pagebuilder_update_preview('#' + id);
}
function pagebuilder_update_preview(obj){
  var src=$(obj).val();
  console.log('PREVIEW: ' + src);
  var preview_id=$(obj).attr('data-preview');
  if (preview_id!=''){
    if (src==''){
      src='/img/no-image.svg';
    } else {
      src='http://www.markmakesstuff.com/remote/images/' + src;
    }
    $('#' + preview_id).attr('src', src);
  }
}

function pagebuilder_image_select(block_id, slug, img){
  img=img.split('storage/uploads/').join('');
  //input__ui-block-4__photo
  var input_id='#input__' + block_id + '__' + slug;
  console.log('INPUT_ID: ' + input_id);
  $(input_id).val(img);
  pagebuilder_update_preview($(input_id));
  $('#app-modal').hide();
  pagebuilder_update_json();
}
