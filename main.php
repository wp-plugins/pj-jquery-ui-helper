<?php

/*
Plugin Name: PJ jQuery UI Helper
Plugin URI: http://pjokumsen.co.za/wordpress/plugins/pj-jquery-ui-helper/
Description: Plugin to use jQuery UI in WordPress.
Version: 1.0.3
Author: Peter Jokumsen
Author URI: http://pjokumsen.co.za/
*/

/*
PJ jQuery UI Helper - WordPress plugin to use jQuery UI
Copyright (C) 2014 Peter Jokumsen

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}
//Declared to be used for getting major data
global $pjjuh_main;

//get plugin dir for includes
$pjjuh_plugin_dir = plugin_dir_path(__FILE__) . '/includes/';
/** Begin Template includes */
require_once  $pjjuh_plugin_dir . 'templates.php';
if (is_admin()) {  
  require_once $pjjuh_plugin_dir . 'admin-templates.php'; 
}
/** Begin controller includes */
require_once $pjjuh_plugin_dir . 'controllers/shortcodes-controller.php';
if (is_admin()) { 
  require_once $pjjuh_plugin_dir . 'controllers/admin-controller.php'; 
}
/** End includes */

class PJJUH_Main extends PJ_Plugin {
  /*
   * DIR to jQuery CSS files, differs if in debug mode
   * 
   * @type string
   */
  public $jQuery_CSS_Dir;
  
  /*
   * DIR to jQuery JS files, differs if in debug mode
   * 
   * @type string
   */
  public $jQuery_JS_Dir;
  public $PJJUH_JS_Dir;
  
  //Set this to "min." if not in debug mode
  public $scriptSuffix;
  
  //Array of Controllers to be used
  public $controllers;
  
  public $plugin_path;
  public $plugin_url;
  public $plugin_version = '1.0.3';
  public $plugin_slug = 'pj-jquery-ui-helper';
  
  
  public function __construct() {
    parent::__construct();
    $this->controllers = array('admin'=>NULL, 'shortcodes'=>NULL);
    $this->plugin_url = plugins_url('/', __FILE__);
    $this->plugin_path = plugin_dir_path(__FILE__);
    $pjjuh_settings = get_option('pjjuh_settings');
    
    $this->jQuery_CSS_Dir = $this->plugin_url . 'css/themes/' . $pjjuh_settings['theme'] . '/';
    $this->jQuery_JS_Dir = $this->plugin_url . 'js/jquery-ui/';
    $this->PJJUH_JS_Dir = $this->plugin_url . 'js/pjjuh-scripts/';
    $this->scriptSuffix = '';
      
    $this->checkDebug();
    $this->load_plugin_textdomain($this->plugin_slug);
    
    //Test stuff
    add_action('plugins_loaded', array($this, 'init'));
    
    add_action('wp_enqueue_scripts', array($this,'load_scripts'));
    if (is_admin()) {
      add_action('init', array($this, 'admin_init'));
    }
  }
  
  //Include template classes
  public function init() {
    $this->add_shortcodes();
  }
  
  /*
   * Checks if debug is enabled and makes necessary changes
   * currently loads regular CSS and JS (not minified)
   */
  private function checkDebug() {
    if (!WP_DEBUG) {
      $this->jQuery_CSS_Dir .= 'minified/';
      $this->scriptSuffix = '.min';
    }
  }
  
//Enqueue scripts for PJ Modal Dialog
  public function load_scripts() {
    //Loading scripts that will always be used, specific scripts loaded in the controllers
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-widget');
    wp_enqueue_script('jquery-ui-tabs');
    wp_enqueue_script('jquery-ui-dialog');
    wp_enqueue_script('jquery-ui-button');
    wp_enqueue_style('jquery-ui-style', $this->jQuery_CSS_Dir . 'jquery-ui' . $this->scriptSuffix . '.css', false, $this->plugin_version);
  }
  //
  public function admin_init() {
    if (!$this->controllers['admin']) {
      $this->controllers['admin'] = new PJJUH_Admin_Controller('PJ jQuery UI Helper', $this->plugin_version);
    }
  }
  
  //Adding shortcodes
  function add_shortcodes() {
    if (!$this->controllers['shortcodes']) {
      $this->controllers['shortcodes'] = new PJJUH_Shortcodes_Controller();
    }
    add_shortcode('pjjuh-dialog', array($this->controllers['shortcodes'], 'create_dialog'));
    add_shortcode('pjjuh-tab-group', array($this->controllers['shortcodes'], 'create_tabs'));
    add_shortcode('pjjuh-tab', array($this->controllers['shortcodes'], 'add_tab'));
    /* original shortcode stuff
    include_once $this->plugin_path . 'functions/CreateDialogScript.php';
    add_shortcode('jquery-diag', 'pjjuh_dialog_shortcode'); */
  }
  
  public function register_plugin() {
    if (!$this->controllers['admin']) {
      $this->controllers['admin'] = new PJJUH_Admin_Controller('PJ jQuery UI Helper', $this->plugin_version);
    }
    $this->controllers['admin']->register_plugin();
  }
}
if (!$pjjuh_main) {
  $pjjuh_main = new PJJUH_Main();
}
//Action hooks for PJJUH_Main
add_action('init', array($pjjuh_main, 'init'));
if (is_admin()) {
  register_activation_hook(__FILE__, array($pjjuh_main, 'register_plugin'));
}