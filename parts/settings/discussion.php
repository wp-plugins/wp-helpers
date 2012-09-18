<?php
/*
Title: Comments
Setting: piklist_wp_helpers
Tab: Discussion
Order: 50
*/

  piklist('field', array(
    'type' => 'number'
    ,'field' => 'comments_open'
    ,'label' => 'Close comments for old Posts'
    ,'description' => 'days or older.'
    ,'value' => ''
    ,'attributes' => array(
      'class' => 'small-text'
    )
  ));

  piklist('field', array(
    'type' => 'checkbox'
    ,'field' => 'make_clickable'
    ,'label' => 'Automatic linking'
    ,'choices' => array(
      'true' => 'Turn off automatic linking of urls in comments'
    )
  ));

?>