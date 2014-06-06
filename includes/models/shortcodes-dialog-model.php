<?php

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

class PJJUH_Shortcodes_Dialog_Model extends PJ_Model {
  private $dialog_default_atts; //default values for attributes of dialog shortcode
  private $dialog_id_iterator;
  private $dialogs; //array of dialogs in use
  
  public function __construct() {
    //get the settings from DB
    $dialog_settings = get_option('pjjuh_shortcode_settings');

    //specify defaults of dialog attributes
    $this->dialog_default_atts = array(
      'button_title'=>'Button',
      'title'=>'',
      'page'=>'',
      'width'=>$dialog_settings['dialog-width'],
      'height'=>$dialog_settings['dialog-height'],
      'modal'=>$dialog_settings['dialog-modal']
    );
    
    //set starting ID to 1
    $this->dialog_id_iterator = 1;
  }
  
  /*
   * Function to initialize dialog data, takes attributes from shortcode
   * and then sets them to 
   */
  public function initialize_dialog_data($atts, $content) {
    $temp_dialog = array(); //temporary dialog to be inserted into dialogs array
    //get the attributes passed and compare to defaults
    $atts = shortcode_atts($this->dialog_default_atts, $atts);
    
    //Set attributes to temp_dialog
    $temp_dialog['button_title'] = $atts['button_title'];
    $temp_dialog['width'] = $atts['width'];
    $temp_dialog['height'] = $atts['height'];
    $temp_dialog['modal'] = $atts['modal'];
    $page = $this->check_dialog_page($atts['page']);
    
    //insert data from page
    if ($page instanceof WP_Post) {
      $temp_dialog['dialog_title'] = $page->post_title;
      $temp_dialog['dialog_content'] = $page->post_content;
      $temp_dialog['dialog_other_href'] = $page->guid;
    } else {
      $temp_dialog['dialog_title'] = $atts['title'];
      $temp_dialog['dialog_content'] = $content;
      $temp_dialog['dialog_other_href'] = '#';
    }

    //set the dialog_id
    $temp_dialog_id = '';
    $temp_dialog_id = 'pjjuh_dialog_' . $this->dialog_id_iterator;
    $this->dialog_id_iterator++;

    $temp_dialog['dialog_id'] = $temp_dialog_id;
    $temp_dialog['button_id'] = $temp_dialog_id . '_button';
    $this->dialogs[$temp_dialog_id] = $temp_dialog;
    return $temp_dialog_id;
  }
  
  //returns WP_Post if correct page id passed, otherwise specifies issue
  private function check_dialog_page($att_page) {
    //check that page is a correct value, if not say so.
    if ($att_page!='') {
      $page= get_page_by_path($att_page);
      if (!($page instanceof WP_Post)) {
        $page = 'Page is not a valid page';
      }
      return $page;
    } else {
      return 'No Page value set.';
    }
    
  }
  
  //return an individual dialog
  public function get_dialog($dialog_id) {
    return $this->dialogs[$dialog_id];
  }
  
  //return all dialogs
  public function get_all_dialogs() {
    return $this->dialogs;
  }
}