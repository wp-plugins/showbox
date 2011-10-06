<?php

// Get path to php scripts
$ShowBox_Path=base64_decode($_GET['ShowBox_Explorer_URL']);

?>

$(document).ready(function() {

// Define path to ShowBox Explorer
<?php 
print 'ShowBox_Explorer_URL="'.$ShowBox_Path.'/";';
?>

    $('.show-box-lightbox').lightbox();

// Output images tree
    $(document).find('#tree').dynatree({ 
        title: "Root folder", 

/*
        rootVisible: true, 
        autoFocus: false, 
        persist: true, 
        checkbox: true,
*/
//    persist: true,
    checkbox: true,
    selectMode: 3,
    activeVisible: true,
        
        fx: { height: "toggle", duration: 200 }, 



        initAjax: { 
            url: ShowBox_Explorer_URL+"folder_content.php", 
            data: { key: "root" }
        }, 



// trigger on then checked ...
        onSelect: function(flag, node) {
// Create image buffer
        buffer=Image_Box_Buffer('60','60', node);
// Show images
      $("#images_list").html(buffer);
// Save images to file
   Save_Images_To_File( ShowBox_Explorer_URL+"save_image_list.php", "#message_box");
        },




// Will send request when clicked on folder
        onLazyRead: function(dtnode) { 
         dtnode.appendAjax( 
         { url: ShowBox_Explorer_URL+"folder_content.php", 
           data: { key: dtnode.data.key } 
          }); 
        } 
    }); 
});
