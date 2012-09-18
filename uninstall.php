<?php

  if (!defined('WP_UNINSTALL_PLUGIN'))
  {
    exit();
  }
  
  delete_option('piklist_wp_helpers');

?>