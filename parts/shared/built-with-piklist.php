<?php

  add_action('piklist_settings_form', array('piklist_helpers_settings_message', 'init'));
  add_action('piklist_helpers_admin_css', array('piklist_helpers_settings_message', 'settings_message_styles'));


  if (!class_exists('Piklist_Helpers_Settings_Message'))
  {

    class Piklist_Helpers_Settings_Message
    {
      public static function init()
      {
  ?>
        <div id="setting-footer">
          <?php _e('This settings page was built with Piklist. Learn more at <a href="http://piklist.com/user-guide/tutorials/building-settings-pages/#utm_source=wpadmin&utm_medium=helperssettingspage&utm_campaign=wphelpersplugin">Piklist.com</a>.'); ?>
        </div>
  <?php
      }

      public static function settings_message_styles()
      {
        echo '#setting-footer { border-top: 1px solid #DFDFDF; margin: 10px 0 0; padding: 10px 0 0; color: #777777; }' . PHP_EOL;
      }

    }
  }
?>