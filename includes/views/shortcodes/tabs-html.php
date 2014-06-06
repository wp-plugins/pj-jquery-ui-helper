<?php

/* 
 * Array $current_data set in function that includes this php file, with following items in array
 * 'dialog_id' - id of the dialog to be used
 * 'page' - Page object to be used
 * 'button_id' - id for button used
 * 'button_title' - text to be displayed on button
 * 'width' - width of dialog
 * 'height' - height of dialog
 * 'modal' - true/false
 */
    /*
     * to be added:
     * page_post_title - dialog_title
       page_post_content - dialog_content
       page_guid - dialog_other_href
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