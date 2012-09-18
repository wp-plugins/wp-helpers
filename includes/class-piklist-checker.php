<?php
/*
 * Piklist Checker
 * Version: 0.1.0
 *
 * Verifies that Piklist is installed and activated.
 * If not, plugin will be deactivated and user will be notifed.
 *
 * Developers:
 ** Copy this file to your plugin
 ** include_once before running any plugin code.
 ** Run the "check" function
 ** Example: include these two lines at the beginning of your plugin:
 *** include_once('path-to-checker-file/class-piklist-checker.php');
 *** if (!piklist_checker::check(__FILE__)) { return; }
 *
 * Most recent version of this file can be found here:
 * http://s-plugins.wordpress.org/piklist/assets/class-piklist-checker.php
 */

if (!class_exists('Piklist_Checker'))
{
  class Piklist_Checker
  {
    private static $plugins = array();

    public static function init()
    {
      add_action('admin_init', array('piklist_checker', 'show_message'));
    }

    public static function check($check_plugin)
    {
      if (!function_exists('piklist'))
      {
        require_once(ABSPATH . 'wp-admin/includes/plugin.php');
      
        $plugins = get_option('active_plugins', array());
        
        foreach ($plugins as $plugin)
        {
          if (strstr($check_plugin, $plugin))
          {
            array_push(self::$plugins, $check_plugin);
            
            deactivate_plugins($plugin);
            
            return false;
          }
        }
      }
      
      return true;
    }

    public static function message()
    {
      ob_start();
    
        $url = 'plugin-install.php?tab=search&s=piklist&plugin-search-input=Search+Plugins';
        $get_pikist_url = (is_multisite() ? network_admin_url($url) : admin_url($url));
  ?>
    
        <h3><?php _e('The following plugin(s) have been deactivated.'); ?></h3>
      
        <p>
          <?php _e('The plugin(s) below require the Piklist plugin to be installed and activated.'); ?>
          <?php _e(sprintf('Please download and %1$s to run the plugin(s) or return to your %2$s without installation.', '<a href="' . $get_pikist_url . '">Install Piklist</a>', '<a href="' . admin_url() . '">Dashboard</a>')); ?>
        </p>

        <h4><?php _e('Plugin(s)'); ?></h4>

        <ul>
          <?php foreach(self::$plugins as $plugin): $data = get_plugin_data($plugin); ?>
            <li>
              <?php echo $data['Title']; ?>
              <br />
              <?php echo $data['Description']; ?>
            </li>
          <?php endforeach; ?>
        </ul>

  <?php
        $message = ob_get_contents();

      ob_end_clean();
    
      return $message;
    }
    
    public static function show_message()
    {
      if (!empty(self::$plugins))
      {
        wp_die(self::message());
      }
    }
  }
  
  piklist_checker::init();
}
?>