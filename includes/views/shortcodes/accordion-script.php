<?php

$return_string = '
        function getParentOffset(offsetParent) {'.
          'returnInt = offsetParent.offsetTop;'.
          'if (offsetParent.offsetParent) {'.
            'if (offsetParent.offsetParent.offsetTop > 0) {'.
              'returnInt = returnInt + getParentOffset(offsetParent.offsetParent);'.
            '}'.
          '}'.
          'return returnInt;'.
        '}';
foreach ($accordions as $accordion) {
  $return_string .= '
          $("#'. $accordion['id'] .'").accordion({'.'heightStyle:"'.$accordion['height_style'].'",'.
            'beforeActivate: function( event, ui ) {'.
             'newHeadOffset = ui.newHeader[0].offsetTop;'.
              'oldHeadOffset = ui.oldHeader[0].offsetTop;'.
              'if (newHeadOffset > oldHeadOffset) {'.
                'totalOffset = oldHeadOffset + getParentOffset(ui.oldHeader[0].offsetParent);'.
                'if (totalOffset < $(document).scrollTop()) {'.
                  '$("html,body").animate({ scrollTop: totalOffset });'.
                '}'.
              '}'.
            '}'.
          '});';
}
return $return_string;