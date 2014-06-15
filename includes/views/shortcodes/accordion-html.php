<?php

/*
 * Variables used are declared in the function including this file
 * $accordion_id = the id of the accordion being created
 * $sections = an array of sections to be displayed with the following keys
 *        ['id']      - ID of the section
 *        ['title']   - title of the section (what the user will see)
 *        ['content'] - the content that will be inside of the section
 * 
 * returns the return_string for use later in plugin
 */

$return_string = 
  '<div id="'. $accordion_id .'">';
foreach ($sections as $section) {
  $return_string .= '<h3 style="margin-bottom:0';
  if ($section['title_font_size']!='') {
    $return_string .= '; font-size:'. $section['title_font_size'];
  }
  $return_string .= 
      '">'. $section['title'] .'</h3>'.
      '<div id="#'. $section['id'] .'"';
  if ($section['section_font_size']!='') {
    $return_string .= ' style="font-size:'. $section['section_font_size'] .'"';
  }
  $return_string .= '>'. $section['content'] .'</div>';
}
$return_string .= '</div>'; //Close the parent div
return $return_string;