// Fired then checkbox selected
function ShowBoxAllowLinkChecked(){

// Get state of checkbox
state=$('#ShowBoxAllowLink').is(':checked');

// show/hide DropBox login link
if (state){
 $('#DropBoxLoginLink').show();
}
else {
 $('#DropBoxLoginLink').hide();
}

}

































// Create image box buffer 
function Image_Box_Buffer(w,h, node){

// Init image buffer
 buffer='';

// Get selected nodes list
 selectedNodes = node.tree.getSelectedNodes();
// create list of urls
 $.map(selectedNodes, function(node){


//  buffer+='<img width=\"'+w+'\" height="'+h+'" src=\"'+node.data.url+'\" />';

// if file not folder ...
  if (node.data.url!=undefined){
  // Create output link
   buffer+='<a rel="show-box-group" href=\"'+node.data.url+'\" class="show-box-lightbox">\n'+
   '<img width=\"'+w+'px\"  height="'+h+'px"  src=\"'+node.data.url+'\" />'+'\n'+'</a>'+'\n';
}
});


 return(buffer);
 }




























































//  Save Images to file
function Save_Images_To_File(url_var, message_box){

// Do query for save images list
 $.ajax({
 url: url_var,
//  context: document.body,

// Get url of selected item
//        data:  { url: node.data.url, flag: flag },
 data:  { image_block: $.base64.encode(buffer) },

// Load images to "images_list" container
        success: function(data){
// Update images block
//  $("#images_list").html('Succesfully loaded...');
 $( message_box ).html(data);
  }
});



}