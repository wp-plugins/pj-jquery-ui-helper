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

return 
'<div id="' . $current_data['dialog_id'] .'" class="ui-helper-hidden" title="'. $current_data['dialog_title'] .'">
  <div id="content">
    '. do_shortcode($current_data['dialog_content']) .' 
  </div>
</div>
<button id="'. $current_data['button_id'] .'" href="'. $current_data['dialog_other_href'] .'">
  '. $current_data['button_title'] .'
</button>';