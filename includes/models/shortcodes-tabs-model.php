<?php

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

class PJJUH_Shortcodes_Tabs_Model extends PJ_Model {
  private $tabs_data, $tabs_group_defaults, $tab_defaults, $group_id_iterator,
          $tab_id_iterator;
  
  public function __construct() {
    $this->tabs_group_defaults = array(
        'id'=>'pjjuh_tabs_'
    );
    $this->tab_defaults = array(
        'id'=>'pjjuh_tabs_child_',
        'title'=>''
    );
    $this->group_id_iterator = 1;
    $this->tab_id_iterator = 1;
  }
  
  /*
   * Start the tabs group
   * @return the id of the current group
   */
  public function initialize_tabs_data($atts) {
    $temp_group = array();
    //get the attributes passed and compare to defaults
    $atts = shortcode_atts($this->tabs_group_defaults, $atts);
    
    //Set attributes to temp_group
    if ($atts['id'] == 'pjjuh_tabs_') {
      $temp_group['id'] = $atts['id'] . $this->group_id_iterator;
      $this->group_id_iterator++;
    } else {
      $temp_group['id'] = $atts['id'];
    }
    $this->tabs_data[$temp_group['id']] = $temp_group;

    return $temp_group['id'];
  }
  
  //Add a tab to the current group
  public function initialize_individual_tab_data($group_id, $atts, $content) {
    $temp_tab = array();
    //get the attributes passed and compare to defaults
    $atts = shortcode_atts($this->tab_defaults, $atts);
    
    //Set attributes to temp_tab
    if ($atts['id'] == 'pjjuh_tabs_child_') {
      $temp_tab['id'] = $atts['id'] . $this->tab_id_iterator;
      $this->tab_id_iterator++;
    } else {
      $temp_tab['id'] = $atts['id'];
    }
    $temp_tab['title'] = $atts['title'];
    $temp_tab['content'] = do_shortcode($content);
    
    $this->tabs_data[$group_id]['tabs'][$temp_tab['id']] = $temp_tab;
  }
  
  public function get_tab_group_data($group_id) {
    return $this->tabs_data[$group_id];
  }
  
  public function get_all_tabs() {
    return $this->tabs_data;
  }
}