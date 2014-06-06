<?php

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

class PJJUH_Shortcodes_Dialog_View extends PJ_View {
  private $current_dir;
  
  public function __construct() {
    $this->current_dir = plugin_dir_path(__FILE__);
  }
  
  /*
   * Create the dialog to be created
   */
  public function render_dialog($dialog) {
    $current_data = $dialog;
    $current_content = include $this->current_dir . 'dialog-html.php';
    return $current_content;
  }
  public function render_script($dialogs) {
    return include $this->current_dir . 'dialog-script.php';
  }
}