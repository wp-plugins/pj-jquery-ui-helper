<?php

$return_string = '';
foreach ($tab_groups as $tab_group) {
  $return_string .= '
          $("#'. $tab_group['id'] .'").tabs();';
}
return $return_string;