<?php
/*
Notice Type: updated
Notice ID: wp_helpers_1_7_2
Capability: manage_options
*/

$options = get_option('piklist_active_plugin_versions');

printf(__('<h3>What\'s new in WordPress Helpers %1$s</h3>'), $options['wp-helpers/wp-helpers.php'][0]);

printf(__('%1$sDisable Emoji support%2$s &#8594;'), '<a href="' . admin_url() . 'tools.php?page=piklist_wp_helpers&tab=writing">', '</a>');