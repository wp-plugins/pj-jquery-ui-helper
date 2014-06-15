<?php

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

class PJJUH_Shortcodes_Accordion_View extends PJ_View {
  private $current_dir;
  
  public function __construct() {
    $this->current_dir = plugin_dir_path(__FILE__);
  }
  
  public function render_accordion($accordion) {
    $accordion_id = $accordion['id'];
    $sections = $accordion['sections'];
    $current_content = include $this->current_dir . 'accordion-html.php';
    return $current_content;
  }
  public function render_script($accordions) {
    return include $this->current_dir . 'accordion-script.php';
  }
}

