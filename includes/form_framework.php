<?php



// Output debug info
function ShowBox_Output_Debug($var){
 print '<pre>';
 print_r($var); 
 print '</pre>';
}






































// Output text input element
function ShowBox_Print_Text_Form_Element($obj_var, $instance, $element_name, $Text_Prompt){


// Get element name,id,value
 $field_name=$obj_var->get_field_name($element_name);
 $field_id=$obj_var->get_field_id($element_name);
 $field_value=$instance[$element_name];

print <<<EOF

 <p style="text-align:left;">
 <label for="$field_name">$Text_Prompt
 <input style="width: 250px;" id="$field_id" name="$field_name" type="text" value="$field_value" />
 </label>
 </p>


EOF;
}





























// Output checkbox type element with setted parameters
function ShowBox_Print_CheckBox_Form_Element($Text_Prompt,$element_name, $select_items_list, $obj_var, $instance,$class_style=""){


// Get element name,id,value
 $field_name=$obj_var->get_field_name($element_name);
 $field_id=$obj_var->get_field_id($element_name);
 $field_value=$instance[$element_name];


echo <<<EOF
<p>
<label for="{$field_name}">$Text_Prompt
<input class="checkbox" type="checkbox" id="{$field_id}" name="{$field_name}"
EOF;

checked( $field_value, 'on' );

echo <<<EOF
 /> 
</label>
</p>
EOF;


}














































// Output select type element with setted parameters
function ShowBox_Print_Select_Form_Element($Text_Prompt,$field_name, $select_items_list, $obj_var, $instance,$class_style=""){


// generate select clock type list
 $var1=print_select_list($instance[$field_name], $select_items_list);



echo <<<EOF
<p >
<label for="{$obj_var->get_field_name($field_name)}">$Text_Prompt
 <select $class_style id="{$obj_var->get_field_id($field_name)}" name="{$obj_var->get_field_name($field_name)}"  value="{$instance[$field_name]}" >

 $var1

 </select>
</label>
</p>
EOF;


}




































// This function output (analog,digital) selector for clock
function ShowBox_print_select_list($selected_value,$buffer_select){


// Init buffer var
 $buffer='';

// Create select element
 foreach($buffer_select as $element ){

  if ($selected_value==$element['value']){
    $buffer.='<option value="'.$element['value'].'"  selected="selected">'.$element['text'].'</option>';
   }
  else
   {
    $buffer.='<option value="'.$element['value'].'">'.$element['text'].'</option>';
   }
 }



 return($buffer);


}



?>