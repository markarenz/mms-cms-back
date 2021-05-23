$(function() {
  init__lightbox_links();
});

function init__lightbox_links(){
  $('.lightbox').click(function(event){
    event.preventDefault();
    var src=$(this).attr('href');
    console.log(src);
    $('#app-modal .stage .inner').html('<img src="' + src + '" alt="IMAGE"/>');
    $('#app-modal').show();
  });
}

function ucFirst(str){
 return str.toString().replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() +
 txt.substr(1).toLowerCase();});
}

function setup_search_clear(){
  $("#searchclear").click(function(){
    $("#searchinput").val('');
  });
}
/* For adding tab behavior to textareas for pretty HTML */
function enable_tabs_for_textareas(){
  var textareas = document.getElementsByTagName('textarea');
  var count = textareas.length;
  for(var i=0;i<count;i++){
      textareas[i].onkeydown = function(e){
          if(e.keyCode==9 || e.which==9){
              e.preventDefault();
              var s = this.selectionStart;
              this.value = this.value.substring(0,this.selectionStart) + "\t" + this.value.substring(this.selectionEnd);
              this.selectionEnd = s+1;
          }
      }
  }
}
