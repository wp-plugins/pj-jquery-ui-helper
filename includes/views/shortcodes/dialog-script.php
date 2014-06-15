<?php

//included with $dialogs variable initialised.
$return_string = '';
foreach ($dialogs as $dialog) {
  $return_string .= '
    $("#'. $dialog['dialog_id'] .'").dialog({
        autoOpen: false,
        height:'. $dialog['height'] .',
        width:'. $dialog['width'] .',
        modal:'. $dialog['modal'] .',
        open: function () {
          $("#'. $dialog['dialog_id'] .'").scrollTop(0);
        }
      }).removeClass("ui-helper-hidden");

      $("#'. $dialog['button_id'] .'")
        .button()
        .click(function() {
          $("#'. $dialog['dialog_id'] .'").dialog( "open" );
          return false;
        });';  
}
return $return_string;