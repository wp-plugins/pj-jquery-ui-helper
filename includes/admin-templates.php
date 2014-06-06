<?php

/* 
 * Template Classes to be used for extension in Admin view of Wordpress
 */

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

/*
 * PJ_Admin_Model, extension of PJ_Model to include generic functions for use in admin
 */
class PJ_Admin_Model extends PJ_Model {
  /*
   * Get the difference between 2 string's lengths
   * 
   * @return int
   */
  public function get_string_delta($first_string, $second_string) {
    return strlen($first_string) - strlen($second_string);
  }  
}

/*
 * PJ_Admin_View, extension of PJ_View to include generic functions for use in admin
 */
class PJ_Admin_View extends PJ_View {
  public $data; //Constructor to set this to the model
}

/*
 * PJ_Admin_Controller, extension of PJ_Controller to include generic functions for use in admin
 */
class PJ_Admin_Controller extends PJ_Controller {
  
}