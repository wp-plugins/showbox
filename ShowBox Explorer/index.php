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
<!-- Start of Zopim Live Chat Script -->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=
z.s=d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o
){z.set._.push(o)};$.setAttribute('charset','utf-8');$.async=!0;z.set.
_=[];$.src=('https:'==d.location.protocol?'https://ssl':'http://cdn')+
'.zopim.com/?AK8muc1vh1Mn0gIyKDXuYmQmCGchVYly';$.type='text/java'+s;z.
t=+new Date;z._=[];e.parentNode.insertBefore($,e)})(document,'script')
</script>
<!-- End of Zopim Live Chat Script -->
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
