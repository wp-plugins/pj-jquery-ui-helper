<?php

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

class PJJUH_Admin_Model extends PJ_Admin_Model {
  private $meta_settings_groups, $options;
  
  public function __construct($plugin_version) {
    $current_version = get_option('pjjuh_version');
    if (!$current_version || version_compare($plugin_version, $current_version)) {
      $this->initialise_meta_setting_groups();
      $this->register_plugin();
      update_option('pjjuh_version', $plugin_version);
    }
  }
  
  //initialise the meta settings groups for plugin
  public function initialise_meta_setting_groups() {
    $settings_groups = array(
        'pjjuh_settings'=>array(
            'menu_title'=>'General Settings',
            'page_title'=>'PJ jQuery UI Helper - General Settings',
            'id'=>'pjjuh_settings',
            'description'=>false, //don't want description
            'sections'=>array(
                'display_section'=>array(
                    'title'=>'Display',
                    'id'=>'display_section',
                    'description'=>'Settings for the look and feel of PJ jQuery UI Helper.',
                    'settings'=>array(
                        'theme'=>array( 
                            'title'=>'Theme',
                            'id'=>'theme',
                            'description'=>'The CSS theme to be used',
                            'type'=>'dropdown',
                            'default'=>'blue',
                            'items'=>array('blue','base','flick','trontastic')
                        )//End of item
                    ) //End of items
                )//End of section
            ) //End of sections
        ),//End of group
        'pjjuh_shortcode_settings'=>array(
            'menu_title'=>'Shortcode Settings',
            'page_title'=>'PJ jQuery UI Helper - Shortcode Settings',
            'id'=>'pjjuh_shortcode_settings',
            'description'=>false,
            'sections'=>array(
                'dialog_section'=>array(
                    'title'=>'Default Dialog Settings',
                    'id'=>'dialog_section',
                    'description'=>'Default settings to be used for pjjuh-dialog shortcode.',
                    'settings'=>array(
                        'dialog-width'=>array( 
                            'title'=>'Default Width',
                            'id'=>'dialog-width',
                            'description'=>'Default width used for dialog boxes',
                            'type'=>'text',
                            'default'=>'300'
                        ), //End of setting
                        'dialog-height'=>array(
                            'title'=>'Default Height',
                            'id'=>'dialog-height',
                            'description'=>'Default height used for dialog boxes',
                            'type'=>'text',
                            'default'=>'400'
                        ), //End of setting
                        'dialog-modal'=>array(
                            'title'=>'Modal',
                            'id'=>'dialog-modal',
                            'description'=>'Should the dialog be modal (Prevent any other action in the page).',
                            'type'=>'dropdown',
                            'default'=>'true',
                            'items'=>array('true','false')
                        ), //End of setting
                    ) //End of settings
                ) // End of section
            )//End of sections
        ),//End of group
    );//End of model
    $this->meta_settings_groups = $settings_groups;
  }
  
  //register all options, called by controller when plugin is activated
  public function register_plugin() {
    $setting_groups = $this->meta_settings_groups;
    foreach ($setting_groups as $setting_group) {
      $setting_name = $setting_group['id'];
      $settings = $this->get_default_settings($setting_group['id']);
      update_option($setting_name, $settings);
    }
  }
  
  //return default settings for the group of setting_group_id passed as argument
  public function get_default_settings($setting_group_id) {
    $return_settings = array();
    foreach($this->get_all_settings_from_group($setting_group_id) as $setting) {
      $return_settings[$setting['id']] = $setting['default'];
    }
    if ($this->check_option($setting_group_id)) {
      return $this->update_default_settings($setting_group_id, $return_settings);
    }
    return $return_settings;
  }
  
  //update options that are already set
  private function update_default_settings($setting_group_id, $settings) {
    $options = $this->options[$setting_group_id];
    foreach ($settings as $key => $value) {
      if (isset($options[$key])) {
        if ($options[$key]!=$value) {
          $settings[$key] = $options[$key];
        }
      }
    }
    return $settings;
  }
  
  /*
   * Get options, this function is to return the options set in the DB, on first use
   * it will query using get_option function, thereafter the options for the setting_group
   * have been stored into the class variable options for getting without querying the DB.
   * @param $setting_group_id required string of specific setting group
   * @param $setting_id optional string for required setting
   * return all options for given group or just specified option
   */
  public function get_options($setting_group_id, $setting_id=NULL) {
    if(!$this->check_option($setting_group_id)) { //if initialise returns false (no options in db)
      return false;
    }
    $current_options_group = $this->options[$setting_group_id];
    if ($setting_id && isset($current_options_group[$setting_id])) {
      return $current_options_group[$setting_id];
    } else if ($setting_id) { //if there is a setting_id passed and no actual setting
      return false;
    } else { //setting_id is null, return entire group
      return $current_options_group;
    }
  }
  
  //get list of accepted items from setting
  public function get_setting_items($setting_group_id, $setting_id) {
    foreach ($this->get_all_settings_from_group($setting_group_id) as $setting) {
      if ($setting['id']==$setting_id) {
        return $setting['items'];
      }
    }
  }
  
  //return all settings from group given (disregard sections
  private function get_all_settings_from_group($setting_group_id) {
    if (!$this->meta_settings_groups) {
      $this->initialise_meta_setting_groups();
    }
    $return_array = array();
    foreach ($this->meta_settings_groups[$setting_group_id]['sections'] as $section) {
      foreach ($section['settings'] as $setting) {
        $return_array[] = $setting;
      }
    }
    return $return_array;
  }
  
  /*
   * Current: return full model
   * TODO - allow for returning smaller versions of model
   */
  public function get_model() {
    if (!$this->meta_settings_groups) {
      $this->initialise_meta_setting_groups();
    }
    return $this->meta_settings_groups;    
  }
  
  //Initialise options for given $setting_group, return true if options set
  private function initialise_options() {
    if (!$this->meta_settings_groups) { 
      $this->initialise_meta_setting_groups();
    }
    foreach ($this->meta_settings_groups as $setting_group) {
      $this->options[$setting_group['id']] = get_option($setting_group['id']);
    }
  }
  
  //check that option is more than blank
  private function check_option($setting_group_id) {
    if (!isset($this->options[$setting_group_id])) {
      $this->initialise_options();
    }
    if ($this->options[$setting_group_id]==FALSE) {
      return false;
    } else {
      return true;
    }
  }
  
} //End Model
/*
 * OLD MODEL
  private $plugin_version;


  private $plugin_settings_groups;
  
  public function __construct($plugin_version) {
    $this->plugin_settings_groups = array(
      'pjjuh_settings_group'=> array(
          'title'=> 'PJ jQuery UI Helper Settings',
          'description'=> 'General settings for PJ jQuery UI Helper',
          'name'=>'pjjuh_settings',
          'items'=> array(
              'theme'=> array(
                  'title'=> 'CSS Theme',
                  'description'=> 'The CSS Theme to use for jQuery UI.',
                  'type'=> 'drop_down',
                  'accepted_items'=> array('blue', 'base'),
                  'default'=> 'base'
              )
          )  
      ),
      'pjjuh_dialog_settings_group'=> array(
          'title'=> 'jQuery UI Dialog Settings',
          'description'=> 'Settings for the Dialog in jQuery UI',
          'name'=>'pjjuh_dialog_settings',
          'items'=> array(
              'width'=> array(
                  'title'=> 'Dialog Width',
                  'description'=> 'The width to use globally for dialogs created with jQuery UI',
                  'type'=> 'int',
                  'default'=> 300
              ),
              'height'=> array(
                  'title'=> 'Dialog Height',
                  'description'=> 'The height to use globally for dialogs created with jQuery UI',
                  'type'=> 'int',
                  'default'=> 400
              ),
              'modal'=> array(
                  'title'=> 'Modal',
                  'description'=> 'Default all dialogs to be Modal.',
                  'type'=> 'checkbox',
                  'default'=> true
              )
          ),
      )
    );
    add_action('admin_init', array($this, 'register_settings'));
    $this->plugin_version = $plugin_version;
  }
  
  /*
   * Register settings for use in Admin Menu
   *
  public function register_settings() {
    register_setting('pjjuh_settings', 'pjjuh_settings');
  }
  
  public function register_model() {
    $current_version = get_option('pjjuh_version');
    if (!$current_version)
    {
      $default_pjjuh_settings = array(
        'theme'=>'blue'
      );
      $default_pjjuh_dialog_settings = array(
        'width'=>300,
        'height'=>400,
        'modal'=>'true'
      );
      add_option('pjjuh_settings', $default_pjjuh_settings);
      add_option('pjjuh_dialog_settings', $default_pjjuh_dialog_settings);
      add_option('pjjuh_verison', $this->plugin_version);
    }
  }
}*/