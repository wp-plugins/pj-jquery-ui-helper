<?php

/* 
 * Admin controller
 */

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

/** Include Model and View */
require_once $pjjuh_plugin_dir . 'models/admin-model.php';
require_once $pjjuh_plugin_dir . 'views/admin/admin-main-view.php';

class PJJUH_Admin_Controller extends PJ_Admin_Controller {
  public $model, $view;
  private $plugin_name, $plugin_slug, 
          $current_setting_group, $current_setting_page;
  
  /*
   * Construct controller class
   * set model and view class
   * declare actions to be used
   */
  public function __construct($plugin_name, $plugin_version) {
    //Set model and view
    $this->model = new PJJUH_Admin_Model($plugin_version);
    $this->view = new PJJUH_Admin_View();
    
    $this->plugin_name = $plugin_name;
    $this->plugin_slug = str_replace(' ', '-', $plugin_name);

    //Declare actions
    add_action('admin_init', array($this, 'admin_init_groups'));
    add_action('admin_menu', array($this, 'admin_menu'));
  }
  
  //Called by activation hook, registers plugin data
  public function register_plugin() {
    $this->model->initialise_meta_setting_groups();
    $this->model->register_plugin();
  }
  
  //create the admin_menu and sub_menus (based on groups in model's model array) for this plugin
  public function admin_menu() {
    add_menu_page($this->plugin_name, $this->plugin_name, 'manage_options', $this->plugin_slug);
    $sub_menus = $this->model->get_model();
    $first_sub = true;
    foreach ($sub_menus as $sub_menu) {
      $sub_slug = $this->plugin_slug;
      if (!$first_sub) {
        $sub_slug .= '_' . $sub_menu['id'];
      } else {
        $first_sub = false;
      }
      add_submenu_page($this->plugin_slug,
              $sub_menu['page_title'],
              $sub_menu['menu_title'],
              'manage_options',
              $sub_slug,
              array($this, 'create_sub_menu'));
    }
  }
  
  //register settings to be used
  public function admin_init_groups() {
    $plugin_settings_groups = $this->model->get_model();
    $first_sub = true;
    foreach ($plugin_settings_groups as $current_group) {
      register_setting($current_group['id'], $current_group['id']);
      $page = $this->plugin_slug;
      if (!$first_sub) {
        $page .= '_' . $current_group['id'];
      } else {
        $first_sub = false;
      }
      $this->admin_init_sections($current_group['sections'], $page);
    }
  }
  
  //Initiate sections for group being processed in admin_init_groups
  private function admin_init_sections($sections, $page) {
    foreach ($sections as $section) {
        add_settings_section(
                $section['id'],
                $section['title'],
                array($this, 'setting_section_callback'),
                $page);
        $this->admin_init_settings($section['settings'], $section['id'], $page);
    }    
  }
  
  //Initiate settings for section being processed in admin_init_sections
  private function admin_init_settings($settings, $section_id, $page) {
    foreach($settings as $setting) {
      add_settings_field(
              $setting['id'],
              $setting['title'],
              array($this, 'settings_field'),
              $page,
              $section_id,
              array('setting_id'=>$setting['id'], 'setting_type'=>$setting['type']));
    }
  }
  
  /*
   * Create a text field for setting
   * $setting_id setting ID passed from do_settings_fields, set in add_settings_field
   */
  public function settings_field($setting) {
    $callback = array($this->view, 'render_setting_'.$setting['setting_type']);
    $args = array(
        $setting['setting_id'],
        $this->current_setting_group['id'],
        $this->model->get_options($this->current_setting_group['id'],$setting['setting_id'])
        );
    switch ($setting['setting_type']) {
      case 'text' :
        break;
      case 'dropdown' :
        $args[] = $this->model->get_setting_items($this->current_setting_group['id'], $setting['setting_id']);
    }
    call_user_func_array($callback, $args);
  }
  
  //to display a sub menu from the admin menu
  public function create_sub_menu() {
    if ($this->find_current_group()) {
      $this->view->render_sub_menu_header(get_admin_page_title(), $this->current_setting_group['description']);
      settings_fields($this->current_setting_group['id']);
      do_settings_sections($this->current_setting_page);
      $this->view->render_sub_menu_footer();
    }
  }
  
  /*
   * Find the setting group being used in the current admin sub_menu
   * Return true or false
   */
  public function find_current_group() {
    $title = get_admin_page_title();
    if (!$this->current_setting_group) {
      $groups = $this->model->get_model();
      $first = true;
      foreach ($groups as $group) {
        if ($group['page_title'] == $title) {
          $this->current_setting_group = $group;
          if ($first) { 
            $this->current_setting_page = $this->plugin_slug;
          } else {
            $this->current_setting_page = $this->plugin_slug . '_' . $group['id'];
          }
          return true;
        }
        $first = false;
      }
    } else {
      return true;
    }
    return false;
  }
  
  //display setting section description
  public function setting_section_callback($arg) {
    if ($this->find_current_group()) {
      $description = $this->current_setting_group['sections'][$arg['id']]['description'];
      $this->view->render_setting_section($description);
    }
  }
} //End Controller
