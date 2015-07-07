<?php
/*
Title: General
Setting: piklist_wp_helpers
Order: 100
*/

global $wp_version;

$options = get_option('piklist_wp_helpers');
  
  piklist('field', array(
    'type' => 'checkbox'
    ,'field' => 'all_options'
    ,'label' => 'Show ALL Options'
    ,'description' => !empty($options['all_options']) ? '<a href="' . admin_url() . 'options.php"> View all options &#8594;</a>' : null
    ,'choices' => array(
      'true' => 'Expose ALL site options, under WordPress Settings tab.'
    )
  ));


  $emoji = get_option('use_smilies') ? convert_smilies(':-(') : ':-(';

  piklist('field', array(
    'type' => 'checkbox'
    ,'field' => 'disable_emojis'
    ,'label' => 'Disable Emojis'
    ,'choices' => array(
      'true' => 'Disable all Emoji support.' . '&nbsp;' . $emoji
    )
  ));

    // Uncheck the option to use smilies on Settings > Writing
    if($options['disable_emojis'] == true)
    {
      update_option('use_smilies', null);
    }


  if ( is_multisite() && is_super_admin() )
  {
    piklist('field', array(
      'type' => 'checkbox'
      ,'field' => 'theme_switcher'
      ,'label' => 'Theme Switcher'
      ,'description' => '* Setting shown to Super Administrators only.'
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

  piklist('field', array(
    'type' => 'checkbox'
    ,'field' => 'disable_uprade_notifications'
    ,'label' => 'Disable Upgrade Notifications (show to Administrators only)'
    ,'description' => 'Do you really want to disable upgrade notifications?<br />Upgrading to the latest versions of WordPress, plugins and themes, is the best way to keep your site secure and performing well.'
    ,'choices' => array(
      'wordpress' => 'WordPress'
      ,'plugins' => 'Plugins'
      ,'themes' => 'Themes'
    )
  ));

  if ($wp_version >= 3.5)
  {

    piklist('field', array(
      'type' => 'checkbox'
      ,'field' => 'link_manager'
      ,'label' => 'Link Manager'
      ,'choices' => array(
        'true' => 'Enable'
      )
    ));

  }