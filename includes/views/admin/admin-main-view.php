<?php

class PJJUH_Admin_View extends PJ_Admin_View {
  //create wrapper div and form for sub_menu with description of sub_menu if set
  public function render_sub_menu_header($title, $description) {
    echo '<div class="wrap"><h1>'. $title .'</h1>';
    if ($description) {
      echo '<p>'. $description .'</p>';
    }
    echo '<form action="options.php" method="post">';
  }
  
  //close off opened div and form from header
  public function render_sub_menu_footer() {
    ?>
    <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
    </form></div>
    <?php
  }
  
  //create the description for setting section
  public function render_setting_section($description) {
    echo '<p>' . $description . '</p>';
  }
  
  /*
   * Create input for a setting of type 'text'
   * @param setting_id the id of the given setting
   * @param setting_group_id the id of the group the setting is for
   * @param current_value the current value of the setting
   */
  public function render_setting_text($setting_id, $setting_group_id, $current_value) {
    echo "<input id='{$setting_id}' name='{$setting_group_id}[{$setting_id}]' size='40' type='text' value='{$current_value}' />";
  }
  
  /*
   * Create select for a dropdown input (setting type 'dropdown')
   * @param setting_id the id of the given setting
   * @param setting_group_id the id of the group the setting is for
   * @param current_value the current value of the setting
   * @param items array of items to be put into dropdown list
   */
  public function render_setting_dropdown($setting_id, $setting_group_id, $current_value, $items) {
    echo "<select id='{$setting_id}' name='{$setting_group_id}[{$setting_id}]'>";
    foreach ($items as $item) {
      echo "<option value='{$item}' ";
      if ($item==$current_value) {
        echo "selected='selected'";
      }
      echo ">{$item}</option>";
    }
    echo "</select>";
  }
} //End View