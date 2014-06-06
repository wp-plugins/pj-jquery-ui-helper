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

/*
 * PJ_Class used as base for all classes
 */
class PJ_Main {

}

/*
 * PJ_Plugin, extension of PJ_Main.
 * This is the initial class of the plugin, to create the controller 
 * and specify the actions the plugin will use
 */
class PJ_Plugin extends PJ_Main {
  /* The url of this plugin */
  public $plugin_url;
  
  /* The system path of this plugin */
  public $plugin_path;
  
  /* The identifier of the plugin being used */
  public $plugin_slug = NULL;
  
  public function __construct() {
    if (!$this->plugin_slug) {
      $this->plugin_slug = plugin_basename(__FILE__); //Want to set plugin_slug to folder name of plugin... but also allow for it to be overridden in class that is extending this class
    }
  }

  /*
   * Function to load plugin text domain 
   */
  public function load_plugin_textdomain( $domain )
  {
    // The "plugin_locale" filter is also used in load_plugin_textdomain()
    $locale = apply_filters('plugin_locale', get_locale(), $domain);
    
    load_textdomain($domain, WP_LANG_DIR.'/pj-jquery-ui-helper'.$domain.'-'.$locale.'.mo');
    load_plugin_textdomain($domain, FALSE, $this->plugin_path.'languages');
  }
  
  /*
   * Function to return strings based on current plugin_url/plugin_path
   * depending on whether $is_path is true/false (True for a path, false for a url)
   * 
   * @parameter string $url_string a string to state what type of url is required. (includes/controllers/models/views and others)
   * 
   * @return string URL
   */
  public function get_plugin_location($url_string, $is_path=false) {
    $current_string = $this->plugin_url;
    if ($is_path)
      $current_string = $this->plugin_path;
    if (!$url_string) 
      return $current_string;
    switch ($url_string) {
      case 'includes' :
        return $current_string . 'includes/';
      case 'controllers' : 
        return $current_string . 'includes/controllers/';
      case 'models' :
        return $current_string . 'includes/models/';
      case 'views' :
        return $current_string . 'includes/views/';
      default :
        return $current_string;
    }
  }
}

/*
 * PJ_Model, extension of PJ_Main with generic Model functions/variables
 */
class PJ_Model extends PJ_Main {
  public $data;
}

/*
 * PJ_View, extension of PJ_Main with generic View functions/variables
 */
class PJ_View extends PJ_Main {
  
}

/*
 * PJ_Controller, extension of PJ_Main with generic Controller functions/variables
 */
class PJ_Controller extends PJ_Main {
  public $classes = array('model'=>NULL, 'view'=>NULL);
}