<?php

/*
 * Variables used are declared in the function including this file
 * $group_id = the id of the group being created
 * $tabs = an array of tabs to be displayed with the following keys
 *        ['id']      - ID of the tab
 *        ['title']   - title of the tab (what the user will see)
 *        ['content'] - the content that will be inside of the tab
 *        ['title_font_size'] - Font size of the title
 *        ['section_font_size'] - Font size of the section
 * 
 * returns the return_string for use later in plugin
 */

$return_string = 
  '<div id="'. $group_id .'">
    <ul>';
foreach ($tabs as $tab) {
  $return_string .= '<li'; 
  if ($tab['title_font_size']!='') { 
    $return_string .= ' style="font-size:' . $tab['title_font_size'] . '">';
  }
  else { 
    $return_string .= '>';
  }
  $return_string .= '<a href="#'. $tab['id'] .'">'. $tab['title'] .'</a></li>';
}
$return_string .= '</ul>'; //Close unordered list
foreach ($tabs as $tab) {
  $return_string .= '<div id="'. $tab['id'] .'"';
  if ($tab['section_font_size']!='') { 
    $return_string .= ' style="font-size:' . $tab['section_font_size'] . '">'; 
  }
  else {
    $return_string .= '>';
  }
  $return_string .= $tab['content'] .'</div>';
}
$return_string .= '</div>'; //Close the parent div
return $return_string;