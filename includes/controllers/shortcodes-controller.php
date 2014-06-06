<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

/** Include model and view classes for dialog shortcodes */
require_once $pjjuh_plugin_dir . 'models/shortcodes-dialog-model.php';
require_once $pjjuh_plugin_dir . 'views/shortcodes/shortcodes-dialog-main-view.php';

/** Include model and view classes for tabs shortcodes */
require_once $pjjuh_plugin_dir . 'models/shortcodes-tabs-model.php';
require_once $pjjuh_plugin_dir . 'views/shortcodes/shortcodes-tabs-main-view.php';

class PJJUH_Shortcodes_Controller extends PJ_Controller {
  private $models, $views;
  private $current_tab_group;
  
  public function __construct() {
    add_action('wp_print_footer_scripts', array($this, 'create_pjjuh_script'));
  }
  
  /* DIALOG FUNCTIONS */
  public function create_dialog($atts, $content = NULL) {
    if (!isset($this->models['dialog'])) {
      $this->models['dialog'] = new PJJUH_Shortcodes_Dialog_Model();
    }
    if (!isset($this->views['dialog'])) {
      $this->views['dialog'] = new PJJUH_Shortcodes_Dialog_View();
    }
    $current_model = $this->models['dialog'];
    $current_view = $this->views['dialog'];
    $dialog_id = $current_model->initialize_dialog_data($atts, $content);
    return $current_view->render_dialog($current_model->get_dialog($dialog_id));
  }
  
  /* TAB FUNCTIONS */
  public function create_tabs($atts, $content) {
    if (!isset($this->models['tabs'])) {
      $this->models['tabs'] = new PJJUH_Shortcodes_Tabs_Model();
    }
    if (!isset($this->views['tabs'])) {
      $this->views['tabs'] = new PJJUH_Shortcodes_Tabs_View();
    }
    $current_model = $this->models['tabs'];
    $current_view = $this->views['tabs'];
    $this->current_tab_group[] = $current_model->initialize_tabs_data($atts);
    do_shortcode($content);
    if (count($this->current_tab_group)>1) {
      $current_group_id = array_pop($this->current_tab_group);
      $this->current_tab_group[] = $current_group_id;      
    } else {
      $current_group_id = $this->current_tab_group[0];
    }
    $rendered_tabs = $current_view->render_tabs($current_model->get_tab_group_data($current_group_id));
    array_pop($this->current_tab_group);
    return $rendered_tabs;
  }
  
  public function add_tab($atts, $content) {
    if (!isset($this->current_tab_group)) {
      return 'Unable to add tabs without a tab group, use [pjjuh-tab-group][/pjjuh-tab-group]';
    }
    if (count($this->current_tab_group)>1) {
      //return 'Unable to handle nested Tab groups just yet';
      //proposed solution to nesting.
      $current_group_id = array_pop($this->current_tab_group);
      $this->current_tab_group[] = $current_group_id;
    } else {
      $current_group_id = $this->current_tab_group[0];
    }
    $this->models['tabs']->initialize_individual_tab_data($current_group_id, $atts, $content);
  }
  
  /* SCRIPT FUNCTION */
  public function create_pjjuh_script() {
    $scripts = '';
    if (isset($this->views['tabs']) && isset($this->models['tabs'])) {
     $scripts = $this->views['tabs']->render_script($this->models['tabs']->get_all_tabs());
    }
    if (isset($this->views['dialog']) && isset($this->models['dialog'])) {
      $scripts .= $this->views['dialog']->render_script($this->models['dialog']->get_all_dialogs());
    }
    if ($scripts != '') {
      echo '<script>'.$scripts.'</script>';
    }
  }
  /* END DIALOG FUNCTIONS */
}