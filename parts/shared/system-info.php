<?php printf(__('%1$s %3$sThis information can be used to help debug your website or just provide quick access to important information.%4$s %3$sTo email, just copy and paste.%4$s %3$s %5$sNEVER place this information on a public forum.%6$s%4$s %2$s','piklist-toolbox'),'<ul>','</ul>','<li>','</li>','<strong>','</strong>');?>

<textarea style="width:90%; height:500px;">

### Begin System Info ###


-- Site Information --

<?php printf(__('Site URL: %1$s %2$s','piklist'), str_repeat('&nbsp;', 34) . get_bloginfo('url') , PHP_EOL);?>
<?php printf(__('WordPress URL: %1$s %2$s','piklist'), str_repeat('&nbsp;', 21) . get_bloginfo('wpurl'), PHP_EOL);?>
<?php printf(__('Site Type: %1$s %2$s','piklist'), str_repeat('&nbsp;', 32) . $multisite, PHP_EOL);?>


-- WordPress Environment --

<?php printf(__('WordPress version: %1$s %2$s','piklist'), str_repeat('&nbsp;', 15) . $wp_version , PHP_EOL);?>
<?php printf(__('Language: %1$s %2$s','piklist'), str_repeat('&nbsp;', 31) . get_bloginfo('language') , PHP_EOL);?>
<?php printf(__('Permalink Structure: %1$s %2$s','piklist'), str_repeat('&nbsp;', 16) . get_option('permalink_structure') , PHP_EOL);?>
<?php printf(__('Active Theme: %1$s %2$s','piklist'), str_repeat('&nbsp;', 24) . $theme, PHP_EOL);?>
<?php printf(__('Show On Front: %1$s %2$s','piklist'), str_repeat('&nbsp;', 22) . get_option('show_on_front'), PHP_EOL);?>
<?php if('page' == get_option('show_on_front')) : ?>
<?php printf(__('Page On Front: %1$s %2$s','piklist'), str_repeat('&nbsp;', 23) . $page_on_front, PHP_EOL);?>
<?php printf(__('Page for Posts: %1$s %2$s','piklist'), str_repeat('&nbsp;', 23) . $page_for_posts, PHP_EOL);?>
<?php endif; ?>
<?php printf(__('Table prefix: %1$s %2$s','piklist'), str_repeat('&nbsp;', 27) . $table_prefix_length . $table_prefix_status, PHP_EOL);?>
<?php printf(__('Registered Post Statuses: %1$s %2$s','piklist'), str_repeat('&nbsp;', 5) . implode( ', ', get_post_stati()), PHP_EOL);?>
<?php printf(__('File Path: %1$s %2$s','piklist'), str_repeat('&nbsp;', 34) . ABSPATH, PHP_EOL);?>
<?php printf(__('Registration Enabled: %1$s %2$s','piklist'), str_repeat('&nbsp;', 12) . $users_can_register, PHP_EOL);?>
<?php printf(__('XML-RPC Enabled: %1$s %2$s','piklist'), str_repeat('&nbsp;', 18) . $enable_xmlrpc, PHP_EOL);?>
<?php printf(__('Atom Pub Enabled: %1$s %2$s','piklist'), str_repeat('&nbsp;', 16) . $enable_app, PHP_EOL);?>
<?php printf(__('Privacy Settings: %1$s %2$s','piklist'), str_repeat('&nbsp;', 21) . $blog_public, PHP_EOL);?>
<?php printf(__('Feed Content: %1$s %2$s','piklist'), str_repeat('&nbsp;', 25) . $rss_use_excerpt, PHP_EOL);?>
<?php printf(__('wp_debug: %1$s %2$s','piklist'), str_repeat('&nbsp;', 30) . $wp_debug, PHP_EOL);?>

-- Server Environment --

<?php printf(__('Web Server: %1$s %2$s','piklist'), str_repeat('&nbsp;', 30) . $_SERVER['SERVER_SOFTWARE'], PHP_EOL);?>
<?php printf(__('PHP Version: %1$s %2$s','piklist'), str_repeat('&nbsp;', 29) . phpversion(), PHP_EOL);?>
<?php printf(__('PHP Safe Mode: %1$s %2$s','piklist'), str_repeat('&nbsp;', 23) . $php_safe_mode, PHP_EOL);?>
<?php printf(__('PHP Memory Limit: %1$s %2$s','piklist'), str_repeat('&nbsp;', 17) . ini_get('memory_limit'), PHP_EOL);?>
<?php printf(__('PHP Upload Max Size: %1$s %2$s','piklist'), str_repeat('&nbsp;', 13) . ini_get('upload_max_filesize'), PHP_EOL);?>
<?php printf(__('PHP Post Max Size: %1$s %2$s','piklist'), str_repeat('&nbsp;', 18) . ini_get('post_max_size'), PHP_EOL);?>
<?php printf(__('PHP Upload Max Filesize: %1$s %2$s','piklist'), str_repeat('&nbsp;', 7) . ini_get('upload_max_filesize'), PHP_EOL);?>
<?php printf(__('PHP Time Limit: %1$s %2$s','piklist'), str_repeat('&nbsp;', 24) . ini_get('max_execution_time'), PHP_EOL);?>
<?php printf(__('PHP Max Input Vars: %1$s %2$s','piklist'), str_repeat('&nbsp;', 15) . ini_get('max_input_vars'), PHP_EOL);?>
<?php printf(__('PHP Arg Separator: %1$s %2$s','piklist'), str_repeat('&nbsp;', 18) . ini_get('arg_separator.output'), PHP_EOL);?>
<?php printf(__('PHP Allow URL File Open: %1$s %2$s','piklist'), str_repeat('&nbsp;', 7) . $allow_url_fopen, PHP_EOL);?>


-- Active Plugins --

<?php foreach ($plugins_active as $plugin) : ?>
<?php echo $plugin . PHP_EOL; ?>
<?php endforeach; ?>


-- Sidebars --

<?php foreach ($sidebar_widgets as $widgets) : ?>
<?php echo $widgets . PHP_EOL; ?>
<?php endforeach; ?>

### End System Info ###

</textarea>