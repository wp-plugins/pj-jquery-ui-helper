<?php

/*
 * Variables used are declared in the function including this file
 * $group_id = the id of the group being created
 * $tabs = an array of tabs to be displayed with the following keys
 *        ['id']      - ID of the tab
 *        ['title']   - title of the tab (what the user will see)
 *        ['content'] - the content that will be inside of the tab
 * 
 * returns the return_string for use later in plugin
 */

$return_string = 
  '<div id="'. $group_id .'">
    <ul>';
foreach ($tabs as $tab) {
  $return_string .= '<li><a href="#'. $tab['id'] .'">'. $tab['title'] .'</a></li>';
}
$return_string .= '</ul>'; //Close unordered list
foreach ($tabs as $tab) {
  $return_string .= '<div id="'. $tab['id'] .'">'. $tab['content'] .'</div>';
}
$return_string .= '</div>'; //Close the parent div
return $return_string;