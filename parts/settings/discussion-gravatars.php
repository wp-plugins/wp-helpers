<?php
/*
Title: Gravatars
Setting: piklist_wp_helpers
Tab: Discussion
Order: 50
*/


  //KM: Not working. Can't upload file in settings page
  piklist('field', array(
    'type' => 'file'
    ,'field' => 'upload_simple'
    ,'scope' => 'post'
    ,'label' => 'Upload New Gravatar'
    ,'value' => 'Upload'
  ));
  
  piklist('field', array(
    'type' => 'hidden'
    ,'field' => 'post_status'
    ,'scope' => 'upload_simple'
    ,'label' => 'Attachment Status'
    ,'value' => 'wp-helpers'
  ));

  // KM: This returns an image from the  media library even though the post_status => wphelpers
  //// -make sure you have an image in media library
  //// -view the Discussions tab and image will show up... but it shouldn't
  $args = array(
    'post_type' => 'attachment'
    ,'numberposts' => 1
    ,'post_status' => 'wp-helpers'
  );

$attachments = get_posts( $args );

global $wpdb;
piklist::pre($wpdb);
if ($attachments) {
  foreach ( $attachments as $post ) {
    setup_postdata($post);
    the_attachment_link($post->ID, false);
  }
}




?>