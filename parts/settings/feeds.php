<?php
/*
Title: Feeds
Setting: piklist_wp_helpers
Tab: Feeds
Order: 90
*/

  piklist('field', array(
    'type' => 'checkbox'
    ,'field' => 'disable_feeds'
    ,'label' => 'Disable All Feeds'
    ,'choices' => array(
      'true' => 'Disable'
    )
  ));

  if (current_theme_supports('post-thumbnails'))
  {
    piklist('field', array(
      'type' => 'checkbox'
      ,'field' => 'featured_image_in_feed'
      ,'label' => 'Featured Image'
      ,'choices' => array(
        'true' => 'Add Featured Images to feed.'
      )
    ));
  }
  
?>