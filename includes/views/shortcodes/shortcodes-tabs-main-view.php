<?php

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

class PJJUH_Shortcodes_Tabs_View extends PJ_View {
  private $current_dir;
  
  public function __construct() {
    $this->current_dir = plugin_dir_path(__FILE__);
  }
  
  public function render_tabs($tab_group) {
    $group_id = $tab_group['id'];
    $tabs = $tab_group['tabs'];
    $current_content = include $this->current_dir . 'tabs-html.php';
    return $current_content;
  }
  public function render_script($tab_groups) {
    return include $this->current_dir . 'tabs-script.php';
  }
}

