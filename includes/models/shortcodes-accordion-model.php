<?php

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

class PJJUH_Shortcodes_Accordion_Model extends PJ_Model {
  private $accordion_data, $accordion_defaults, $section_defaults, $accordion_id_iterator,
          $section_id_iterator;
  
  public function __construct() {
    $this->accordion_defaults = array(
        'id'=>'pjjuh_accordion_',
        'title_font_size'=>'',
        'section_font_size'=>'',
        'height_style'=>'auto',
    );
    $this->section_defaults = array(
        'id'=>'pjjuh_section_',
        'title_font_size'=>'',
        'section_font_size'=>'',
        'title'=>'You forgot to set the title attribute'
    );
    $this->accordion_id_iterator = 1;
    $this->section_id_iterator = 1;
  }
  
  /*
   * Start the accordion
   * @return the id of the current accordion
   */
  public function initialize_accordion_data($atts) {
    $temp_accordion = array();
    //get the attributes passed and compare to defaults
    $atts = shortcode_atts($this->accordion_defaults, $atts);
    
    //Set attributes to temp_group
    if ($atts['id'] == 'pjjuh_accordion_') {
      $temp_accordion['id'] = $atts['id'] . $this->accordion_id_iterator;
      $this->accordion_id_iterator++;
    } else {
      $temp_accordion['id'] = $atts['id'];
    }
    $temp_accordion['title_font_size'] = $atts['title_font_size'];
    $temp_accordion['section_font_size'] = $atts['title_font_size'];
    if ($atts['height_style'] != 'auto' && $atts['height_style'] != 'content' && $atts['height_style'] != 'fill') {
      $atts['height_style'] = 'auto';
    }
    $temp_accordion['height_style'] = $atts['height_style'];
    $this->accordion_data[$temp_accordion['id']] = $temp_accordion;

    return $temp_accordion['id'];
  }
  
  //Add a section to the current accordion
  public function initialize_individual_section_data($accordion_id, $atts, $content) {
    $temp_section = array();
    //get the attributes passed and compare to defaults
    $atts = shortcode_atts($this->section_defaults, $atts);
    
    //Set attributes to temp_tab
    if ($atts['id'] == 'pjjuh_section_') {
      $temp_section['id'] = $atts['id'] . $this->section_id_iterator;
      $this->section_id_iterator++;
    } else {
      $temp_section['id'] = $atts['id'];
    }
    $current_accordion = $this->accordion_data[$accordion_id];
    $temp_section['title'] = $atts['title'];
    $temp_section['title_font_size'] = ($atts['title_font_size']=='' ? $current_accordion['title_font_size'] : $atts['title_font_size']);
    $temp_section['section_font_size'] = ($atts['section_font_size']=='' ? $current_accordion['section_font_size'] : $atts['section_font_size']);
    $temp_section['content'] = do_shortcode($content);
    
    $this->accordion_data[$accordion_id]['sections'][$temp_section['id']] = $temp_section;
  }
  
  public function get_accordion_data($accordion_id) {
    return $this->accordion_data[$accordion_id];
  }
  
  public function get_all_accordions() {
    return $this->accordion_data;
  }
}
