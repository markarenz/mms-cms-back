
function find_block_in_library(type){
  for(var i=0;i<block_library.length;i++){
    if (block_library[i].slug==type){
      return block_library[i];
    }
  }
  return false;
}
function pagebuilder_update_json(){
  var blocks=[];
  $('#content-ui-stage .ui-block').each(function(){
    var type=$(this).attr('data-block-type');
    var id=$(this).find('.input__block_id').val();
    var this_class=$(this).find('.input__block_class').val();
    var title=$(this).find('.input__block_title').val();
    var template=find_block_in_library(type);
    var block={};
    block.type=type;
    block.id=id;
    block.title=title;
    block.class=this_class;
    var fields=template.fields;
    for(var i=0;i<fields.length;i++){
      var val=$(this).find('.input__' + fields[i].slug).val();
      block[ fields[i].slug ]=val;
    }
    blocks.push(block);
  });
  var jstr=JSON.stringify(blocks);
  $('textarea[name="content"]').val(jstr);
}

function pagebuilder_new_at(index, type){
  $('#app-modal').hide();
  var json_str=$('textarea[name="content"]').val();
  var blocks=JSON.parse(json_str);
  var newblock={};
  newblock.type=type;
  newblock.title='';
  newblock.id='';
  var template=find_block_in_library(type);
  var fields=template.fields;
  for (var i=0;i<fields.length;i++){
    newblock[fields[i].slug]=''; // default to empty values for now
  }

  blocks.splice(index,0,newblock);
  var jstr=JSON.stringify(blocks);
  $('textarea[name="content"]').val(jstr);
  $('#content-ui').delay(10).fadeIn(10,function(){
    pagebuilder_draw_ui();
    $('#content-ui').delay(10).fadeIn(10,function(){
      pagebuilder_update_json();
    });
  });
}
function pagebuilder_blocks_search(){
  var srch=$('#searchinput').val();
  $('.choices .btn').each(function(){
    if ($(this).html().toLowerCase().indexOf(srch)>=0){
      $(this).show();
    } else {
      $(this).hide();
    }
  });
}

function sort_block_library(a,b) {
  if (a.title < b.title)
    return -1;
  if (a.title > b.title)
    return 1;
  return 0;
}


function pagebuilder_pick_type(index){
  // pick block type
  var html='';
  html+='<h2 class="text-orange">Select a Content Block Type</h2><div class="row"><div class="col-md-12 text-right"> \
    <div class="btn-group"> \
      <input id="searchinput" type="search" class="form-control" placeholder="Search..." onkeyup="pagebuilder_blocks_search();"> \
      <span id="searchclear" class="glyphicon glyphicon-remove-circle" onclick="$(\'#searchinput\').val(\'\');pagebuilder_blocks_search();"></span> \
    </div> \
    </div></div>';
  html+='<div class="choices pt-2">';
  for(var i=0;i<block_library.length;i++){
    html+=' <a href="#" class="btn btn-secondary" onclick="pagebuilder_new_at(' + index + ', \'' + block_library[i].slug + '\')">' + block_library[i].title + '</a> ';
  }
  html+='</div>';
  $('#app-modal .stage .inner').html(html);
  $('#app-modal').show();
}
function pagebuilder_delete(i){
  $('#ui-block-' + i).remove();
  // save content json
  pagebuilder_update_json();
}
function arraymove(arr, fromIndex, toIndex) {
    var element = arr[fromIndex];
    arr.splice(fromIndex, 1);
    arr.splice(toIndex, 0, element);
}
function pagebuilder_insert_order(i,o){
  o*=1;
  var json_str=$('textarea[name="content"]').val();
  var blocks=JSON.parse(json_str);
  arraymove(blocks, i, o);
  var jstr=JSON.stringify(blocks);
  $('textarea[name="content"]').val(jstr);
  $('#content-ui').delay(10).fadeIn(10,function(){
    pagebuilder_draw_ui();
  });
}
function pagebuilder_draw_plus(i){
  return '<div class="row text-center"><div class="col-md-12 plus-row"><a href="#" onclick="pagebuilder_pick_type(' + i + ')" aria-label="ADD"><i class="fa fa-plus" aria-hidden=TRUE></i></a></div></div>';
}
function nullempty(v){
  if( typeof v === 'undefined' ) {
    console.log('?');
      return '';
  }
  console.log('ok');
  return v;
}
function pagebuilder_draw_ui(){
  var json_str=$('textarea[name="content"]').val();
  var blocks=JSON.parse(json_str);
  var ui_html='';
  ui_html+=pagebuilder_draw_plus(0);
  for(var i=0;i<blocks.length;i++){
    var block=blocks[i];
    var template=find_block_in_library(block.type);
    var order_selector='<select class="form-control width-auto display-inline" id="ui-order-' + (i+1) + '" onchange="pagebuilder_insert_order(' + i + ', ( $(this).val()-1 ));">';
    for (var o=1;o<=blocks.length; o++){
      order_selector+='<option value=' + o;
      if (o==(i+1)){order_selector+=' SELECTED '}
      order_selector+='>#' + o;
    }
    order_selector +='</select>';

    ui_html+='<div class="panel panel-default ui-block ' + block.type + '" data-block-type="' + block.type + '" id="ui-block-' + (i+1) + '">';
    ui_html+='  <div class="panel-heading"><div class="inner">';
    ui_html+= '    <div class="row"><div class="col-md-2">' + order_selector + ' <span style="cursor:pointer;font-size:20px;margin-left:5px;" onclick="$(this).parent().parent().parent().parent().parent().toggleClass(\'active\');$(this).find(\'.fa-expand\').toggle();$(this).find(\'.fa-compress\').toggle();"><i class="fa fa-expand"></i><i class="fa fa-compress" style="display:none;"></i></span></div>';
      ui_html+='<div class="col-md-2" style="padding-top:5px;">Type: ' + template.title + '</div>';
      ui_html+='<div class="col-md-2"><label style="padding-top:5px;">Title</label><br /><input type="text" class="form-control input__block_title display-inline" value="' + block.title + '" onchange="pagebuilder_update_json();" /></div>';
      ui_html+='<div class="col-md-2"><label style="padding-top:5px;">Classes</label><br /><input type="text" class="form-control input__block_class display-inline" value="' + nullempty(block.class) + '" onchange="pagebuilder_update_json();" /></div>';
      ui_html+='<div class="col-md-2"><label style="padding-top:5px;">ID</label><br /><input type="text" class="form-control input__block_id display-inline" value="' + block.id + '" onchange="pagebuilder_update_json();" /></div>';
      ui_html+='<div class="col-md-1"><a href="#" class="pull-right color-red" onclick="pagebuilder_delete(' + (i+1) + ');" aria-label="Delete"><i class="fa fa-minus-circle text-red" aria-hidden=TRUE></i></a></div>';
    ui_html+='  </div></div></div>';
    ui_html+='  <div class="panel-body"><div class="inner">';

    var cols=0;
    for (var l=0;l<template.fields.length;l++){
        var field=template.fields[l];
        if (cols%12==0){
          ui_html+='<div class="row pt-2">';
        }
        ui_html+='<div class="col-md-' + field.colsize + '">';
  	    ui_html+='<label>' + field.label + '</label><br />';
        var val='';
        if (typeof block[field.slug]!=="undefined"){
          val=block[field.slug];
        }
        switch(field.type){
          case "text":
            ui_html+='<input type="text" class="form-control input__' + field.slug + '" value="' + val + '" onchange="pagebuilder_update_json();">';
          break;
          case "textarea":
            ui_html+='<textarea onchange="pagebuilder_update_json();" class="form-control input__' + field.slug + '">' + val + '</textarea>';
          break;
          case "image":
            ui_html+='<div class="row"><div class="col-md-7"><input type="text" id="input__ui-block-' + (i+1) + '__' + field.slug + '" class="form-control img_upload input__' + field.slug + '" data-preview="img_preview__' + (i+1) + '__' + field.slug + '" value="' + val + '" onchange="pagebuilder_update_preview(this);pagebuilder_update_json();"></div>';
            ui_html+='<div class="col-md-2 text-center"><button class="btn btn-primary" onclick="pagebuilder_select_image(\'ui-block-' + (i+1) + '\', \'' + field.slug + '\'); return false;"><i class="fa fa-upload"></i></button></div>';
            ui_html+='<div class="col-md-3 text-center"><img src="/img/no-img.jpg" id="img_preview__' + (i+1) + '__' + field.slug + '" class="pagebuilder_image_preview" onclick="pagebuilder_remove_image(\'' + field.slug + '\');"/></div></div>';
          break;
          case "select":
            ui_html+='<select class="input__' + field.slug + ' input_fix_post_draw form-control" data-value="' + val + '" onchange="pagebuilder_update_json();">';
            for (var q=0;q<field.options.length;q++){
              var option=field.options[q];
              ui_html+='<option value="' + option.value + '" ';
              if (option.value==val){
                ui_html+=' SELECTED ';
              }
              ui_html+=' >' + option.label;
            }
            ui_html+='</select>';
          break;
        }
        ui_html+='</div>';
        cols+=field.colsize;
        if (cols%12==0){
          ui_html+='</div> <!-- ENDROW -->';
        }

    }
    ui_html+='    </div>';
    ui_html+='  </div>';
    ui_html+='</div>';
    ui_html+=pagebuilder_draw_plus((i+1));


  }
  $('#content-ui-stage').html(ui_html);
  $('#content-ui').delay(10).fadeIn(10,function(){
    pagebuilder_post_draw_ui();
  });
}

function pagebuilder_post_draw_ui(){
  /* Fix selects */
  $('#content-ui-stage select.input_fix_post_draw').each(function(){
    var val=$(this).attr('data-value');
    if (val!=''){
      $(this).val(val);
    }
  });
  $('#content-ui-stage input.input_fix_post_draw').each(function(){
    if ($(this).val()==''){
      var val=$(this).attr('data-default');
      if (val!=''){
        $(this).val(val);
      }
    }
  });
  $('#content-ui-stage .img_upload').each(function(){
    pagebuilder_update_preview($(this));
  });
}
function set_ui_mode(mode){
  editor.mode=mode;
  if (mode=='ui'){
    $('#content-ui').show();
    $('#content-raw').hide();
    pagebuilder_draw_ui();
  } else {
    $('#content-ui').hide();
    $('#content-raw').show();
  }
}
function init_ui(){
  set_ui_mode('ui');
}
function update_slug_init(){
  $('#slug').change(function(){
    update_slug();
  });
}
function update_slug(){
  $('#btn-view-page').attr('href','/' + $('#slug').val().split("'").join("\'"));
}
