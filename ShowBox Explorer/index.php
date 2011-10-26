<!-- ClickDesk - <a href='http://www.clickdesk.com'> Live Chat Service </a> for websites --><script type='text/javascript'>var _glc =_glc || [];_glc.push('ag9jb250YWN0dXN3aWRnZXRyDwsSB3dpZGdldHMY8LNNDA');var glcpath = (('https:' == document.location.protocol) ? 'https://contactuswidget.appspot.com/livily/browser/' : 'http://gae.clickdesk.com/livily/browser/');var glcp = (('https:' == document.location.protocol) ? 'https://' : 'http://');var glcspt = document.createElement('script'); glcspt.type = 'text/javascript'; glcspt.async = true;glcspt.src = glcpath + 'livechat.js';var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(glcspt, s);</script>


<?php

// Show login part...
// Test user state - logged or not
$user_state=is_Logged(dirname(__FILE__).CREDENTIALS_FILE);


// if logged - show logged banner
if ($user_state)
{
// and show public directory content
?>
<div class='wrap'>
<div class="icon32" id="icon-upload"><br></div>
<h2>ShowBox</h2>
  <h3>This is content of your DropBox "Public" folder:</h3>
  <p class="description">
  <ol>
<li>Select images  you want to show - just click on needed ones</li>
<li>In the right side you'll see all images you've selected</li>
<li>Refresh your blog main page. That's all.</li>
  </ol>
  </p>
<!-- This is DropBox explorer page content-->
  <table>
  <tr>
  <td>
<!-- Show here alerts and messages -->
  <div id="message_box" ></div>
  </td>
  </tr>
  <tr>
  <td width="50%" valign="top" class="side_part_container">
  <!-- Add a <div> element where the tree should appear: -->
  <div id="tree"></div>
  </td>
  <td width="50%" valign="top" class="side_part_container">
<!--Show here images -->
  <div id="images_list"/>
  </td>
  </tr>
  </table>
</div>
<?php

// Show success message
 Show_Success_Logged_Banner();

}
else {
// If can not find credentials file
?>
<div class="wrap">
<div class="icon32" id="icon-upload"><br></div>
<h2>ShowBox</h2>
</div>
<?
}






?>
