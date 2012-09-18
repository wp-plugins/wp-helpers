<?php
/*
Title: General
Setting: piklist_wp_helpers
Order: 10
*/

  
  piklist('field', array(
    'type' => 'checkbox'
    ,'field' => 'show_ids'
    ,'label' => 'Show ID\'s'
    ,'choices' => array(
      'true' => 'Show ID\'s on edit screens for Posts, Pages, Users, etc.'
    )
  ));

  if ( is_multisite() && is_super_admin() )
  {
    piklist('field', array(
      'type' => 'checkbox'
      ,'field' => 'theme_switcher'
      ,'label' => 'Theme Switcher'
      ,'description' => '*setting shown to Super Administrators only.'
      ,'choices' => array(
        'true' => 'Disable for non-Super Administrators'
      )
    ));
  }

  piklist('field', array(
    'type' => 'checkbox'
    ,'field' => 'remove_screen_options'
    ,'label' => 'Screen Options Tab'
    ,'choices' => array(
      'true' => 'Remove'
    )
  ));

?>