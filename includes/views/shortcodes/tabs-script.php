<?php

$return_string = '(function($) {';
foreach ($tab_groups as $tab_group) {
  $return_string .= '$("#'. $tab_group['id'] .'").tabs();'
          . '';
}
$return_string .= '})(jQuery);';
return $return_string;