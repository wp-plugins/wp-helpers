<?php
/*
Plugin Name: WordPress Helpers
Plugin URI: http://piklist.com
Description: Enhanced settings for WordPress. Located under <a href="tools.php?page=piklist_wp_helpers">TOOLS > HELPERS</a>
Version: 1.1.0
Author: Piklist
Author URI: http://piklist.com/
Plugin Type: Piklist
*/

add_action('init', array('piklist_wordpress_helpers', 'init'), -1);

class Piklist_WordPress_Helpers
{
  private static $options = null;
  
  private static $filter_priority = 9999;

  public static function init()
  {
    include_once('includes/class-piklist-checker.php');
   
    if (!piklist_checker::check(__FILE__))
    {
      return;
    }
    
    add_filter('piklist_admin_pages', array('piklist_wordpress_helpers', 'admin_pages'));
    
    self::helpers();
  }

  public static function admin_pages($pages) 
  {    
    $pages[] = array(
      'page_title' => 'WordPress Helpers'
      ,'menu_title' =>  'Helpers'
      ,'sub_menu' => 'tools.php'
      ,'capability' => 'manage_options'
      ,'menu_slug' => 'piklist_wp_helpers'
      ,'setting' => 'piklist_wp_helpers'
      ,'icon_url' => plugins_url('piklist/parts/img/piklist-icon.png') 
      ,'icon' => 'piklist-page'
      ,'single_line' => false
      ,'default_tab' => 'General'
    );
  
    return $pages;
  }

  public static function helpers() 
  {
    if (self::$options = get_option('piklist_wp_helpers'))
    {
      foreach (self::$options as $option => $value)
      {
        $value = is_array($value) && count($value) == 1 ? $value[0] : $value;

        if ($value == 'true')
        {
          switch ($option)
          {
            case 'shortcodes_in_widgets':
              add_filter('widget_text', 'do_shortcode', self::$filter_priority);
            break;
          
            case 'private_title_format':
              add_filter('private_title_format', array('piklist_wordpress_helpers', 'title_format'), self::$filter_priority);         
            break;

            case 'protected_title_format':
              add_filter('protected_title_format', array('piklist_wordpress_helpers', 'title_format'), self::$filter_priority);                
            break;

            case 'disable_autosave':
              add_action('admin_enqueue_scripts', array('piklist_wordpress_helpers', 'disable_autosave'), self::$filter_priority);
            break;

            case 'admin_color_scheme':
              self::remove_filter('admin_color_scheme_picker', 'admin_color_scheme_picker');
            break;

            case 'menu_apperance_editor':
              add_action('_admin_menu', array('piklist_wordpress_helpers', '_add_themes_utility_last'), self::$filter_priority);
            break;

            case 'disable_feeds':
              add_action('do_feed', array('piklist_wordpress_helpers', 'wp_die'), self::$filter_priority);
              add_action('do_feed_rdf', array('piklist_wordpress_helpers', 'wp_die'), self::$filter_priority);
              add_action('do_feed_rss', array('piklist_wordpress_helpers', 'wp_die'), self::$filter_priority);
              add_action('do_feed_rss2', array('piklist_wordpress_helpers', 'wp_die'), self::$filter_priority);
              add_action('do_feed_atom', array('piklist_wordpress_helpers', 'wp_die'), self::$filter_priority);
            break;

            case 'featured_image_in_feed':
              add_filter('the_excerpt_rss', array('piklist_wordpress_helpers', 'featured_image'), self::$filter_priority);
              add_filter('the_content_feed', array('piklist_wordpress_helpers', 'featured_image'), self::$filter_priority);
            break;

            case 'disable_visual_editor':
              add_filter('user_can_richedit', '__return_false', self::$filter_priority);
            break;

            case 'show_admin_bar':
              add_filter('show_admin_bar', '__return_false');
              add_action('piklist_helpers_admin_css', array('piklist_wordpress_helpers', 'hide_admin_bar_profile_option'), self::$filter_priority);
            break;

            case 'show_ids':
              add_action('init', array('piklist_wordpress_helpers', 'show_ids'), self::$filter_priority);
            break;

            case 'make_clickable':
              self::remove_filter('comment_text', 'make_clickable');
            break;

            case 'theme_switcher':
              
              if (is_multisite() && !is_super_admin())
              {
                add_action('admin_init', array('piklist_wordpress_helpers', 'theme_switcher'), self::$filter_priority); 
              }
              
            break;

            case 'remove_screen_options':
              add_filter('screen_options_show_screen', '__return_false', self::$filter_priority);
            break;

            case 'comments_open_pages':
              add_filter('comments_open', array('piklist_wordpress_helpers', 'comments_open_pages'), self::$filter_priority, 2);
            break;

            case 'enhanced_classes':
              add_filter('body_class',array('piklist_wordpress_helpers', 'body_class'));
              add_filter('post_class',array('piklist_wordpress_helpers', 'post_class'));
            break;

            case 'disable_self_ping':
              add_action('pre_ping', array('piklist_wordpress_helpers', 'disable_self_ping'));
            break;   
          }
        }
        else if (!empty($value))
        {
          switch ($option)
          {
            case 'default_editor':
              add_filter('wp_default_editor', array('piklist_wordpress_helpers', 'wp_default_editor'), self::$filter_priority);
            break;

            case 'edit_posts_per_page':
              add_filter('edit_posts_per_page', array('piklist_wordpress_helpers', 'edit_posts_per_page'), self::$filter_priority);
            break;

            case 'excerpt_box_height':
              add_action('piklist_helpers_admin_css', array('piklist_wordpress_helpers', 'excerpt_box_height'), self::$filter_priority);
            break;

            case 'remove_widgets':
              add_action('widgets_init', array('piklist_wordpress_helpers', 'remove_widgets'), 99);
            break;

            case 'remove_dashboard_widgets':
              add_action('admin_init', array('piklist_wordpress_helpers', 'remove_dashboard_widgets'), self::$filter_priority);
            break;

            case 'clean_header':

              $value = is_array($value) ? $value : array($value);
              
              foreach ($value as $tag)
              {
                self::remove_filter('wp_head', $tag);
              }

            break;
            
            case 'excerpt_length_type':
          
              switch ($value)
              {
                case 'words':
                  add_filter('excerpt_length', array('piklist_wordpress_helpers', 'excerpt_length'), self::$filter_priority);
                break;
          
                case 'characters':
                  add_filter('get_the_excerpt', array('piklist_wordpress_helpers', 'excerpt_length'), self::$filter_priority);
                break;
              }
            
            break;
          
            case 'profile_fields':
              add_filter('user_contactmethods', array('piklist_wordpress_helpers', 'unset_profile_fields'), self::$filter_priority, 1);
            break;
          
            case 'change_howdy':
              add_filter('admin_bar_menu', array('piklist_wordpress_helpers', 'change_howdy'), self::$filter_priority);
            break;
          
            case 'show_admin_bar_components':
              add_action('wp_before_admin_bar_render', array('piklist_wordpress_helpers', 'remove_admin_bar_components'), self::$filter_priority);
            break;

            case 'screen_layout_columns_dashboard':

              if ($value != 'default')
              {
                add_filter('get_user_option_screen_layout_dashboard', array('piklist_wordpress_helpers', 'get_user_option_screen_layout_dashboard'), self::$filter_priority);
                add_action('piklist_helpers_admin_css', array('piklist_wordpress_helpers', 'screen_layout_prefs'), self::$filter_priority);
              }

            break;

            case 'screen_layout_columns_post':

              if ($value != 'default')
              {
                add_filter('get_user_option_screen_layout_post', array('piklist_wordpress_helpers', 'get_user_option_screen_layout_post'), self::$filter_priority);
                add_filter('get_user_option_screen_layout_page', array('piklist_wordpress_helpers', 'get_user_option_screen_layout_post'), self::$filter_priority);
                add_action('piklist_helpers_admin_css', array('piklist_wordpress_helpers', 'screen_layout_prefs'), self::$filter_priority);
              }
              
            break;
          }
        }
      }
    }
    
    add_action('admin_footer', array('piklist_wordpress_helpers', 'admin_css'), self::$filter_priority);
  }

  public static function remove_filter($filter, $tag)
  {
    global $wp_filter;

    extract(piklist::key_path($wp_filter, $tag, array('tag', 'priority', 'filter')));
    
    if (isset($wp_filter[$filter]) && $filter == $tag)
    {
      foreach ($wp_filter[$filter] as $priority => $data)
      {
        remove_action($filter, $tag, $priority, $wp_filter[$filter][$priority][$tag]['accepted_args']);
      }
    }
    else
    {
      remove_action($filter, $tag, $priority, $wp_filter[$filter][$priority][$tag]['accepted_args']);
    }
  }
  
  public static function title_format($format)
  {
    return '%s';
  }
  
  public static function excerpt_length($length)
  {
    if (is_numeric($length) && self::$options['excerpt_length_type'] == 'words')
    {
      return !empty(self::$options['excerpt_length']) ? self::$options['excerpt_length'] : $length;
    }
    else if (!is_numeric($length) && self::$options['excerpt_length_type'] == 'characters')
    {
      return !empty(self::$options['excerpt_length']) ? substr($length, 0, self::$options['excerpt_length']) : $length;
    }

    return $length;
  }

  public static function disable_autosave()
  {
    wp_dequeue_script('autosave');
  }

  public static function wp_default_editor($default)
  {
    return self::$options['default_editor']; 
  }

  public static function edit_posts_per_page($posts_per_page)
  {
    return self::$options['edit_posts_per_page'];
  }

  public static function excerpt_box_height()
  {
    echo '#excerpt { height:' . self::$options['excerpt_box_height'] . 'px; }' . PHP_EOL;
  }

  public static function remove_widgets()
  {
    $value = self::$options['remove_widgets'][0]['widgets'];
    $value = is_array($value) ? $value : array($value);

    foreach ($value as $tag)
    {
      unregister_widget($tag);
    }
  }

  public static function remove_dashboard_widgets()
  {
    $value = self::$options['remove_dashboard_widgets'][0]['dashboard_widgets'];
    $value = is_array($value) ? $value : array($value);

    foreach ($value as $tag)
    {
      remove_meta_box($tag, 'dashboard', 'normal');
    }
  }

  public static function _add_themes_utility_last()
  {
    self::remove_filter('admin_menu', '_add_themes_utility_last');
  }

  public static function unset_profile_fields($contactmethods)
  {
    $value = self::$options['profile_fields'];
    $value = is_array($value) ? $value : array($value);

    foreach ($value as $tag) 
    {
      if (isset($contactmethods[$tag]))
      {
        unset($contactmethods[$tag]);
      }
    }

    return $contactmethods;
  }

  public static function featured_image($content)
  {
    global $post;
      
    if (has_post_thumbnail($post->ID))
    {
      $content = '<p class="entry-featured-image entry-featured-image-' . $post->ID . '">' . get_the_post_thumbnail($post->ID) . '</p>' . $content;
    }
      
    return $content;
  }

  public static function change_howdy($wp_admin_bar)
  {
    // @Credit http://botcrawl.com/how-to-change-or-remove-the-howdy-greeting-message-on-the-wordpress-user-menu-bar/
    $my_account = $wp_admin_bar->get_node('my-account');
    
    $wp_admin_bar->add_node(array(
      'id' => 'my-account'
      ,'title' => str_replace('Howdy, ', self::$options['change_howdy'] . ' ', $my_account->title)
    ));
  }

  public static function remove_admin_bar_components()
  {
    global $wp_admin_bar;
    
    $value = self::$options['show_admin_bar_components'];
    $value = is_array($value) ? $value : array($value);

    foreach ($value as $tag)
    {
      $wp_admin_bar->remove_node($tag);
    }
  }

  public static function hide_admin_bar_profile_option()
  {
    echo '.show-admin-bar { display: none; }' . PHP_EOL;
  }

  public static function screen_layout_prefs()
  { 

    //echo 'body.' . $screen_bodyclass . ' ' . '.screen-layout, body.' . $screen_bodyclass . ' ' . '.columns-prefs { display: none; }' . PHP_EOL;
    echo '.screen-layout, .columns-prefs { display: none; }' . PHP_EOL;
  }

  public static function comments_open_pages( $open, $post_id )
  {
    if ('page' == get_post_type())
    {
      return false;
    }
    return $open;
  }

  /* = Show ID's
  -----------------------------------------------
   */

  public static function show_ids() 
  {

    add_action('manage_users_custom_column', array('piklist_wordpress_helpers', 'edit_column_return'), self::$filter_priority, 3);
    add_filter('manage_users_columns', array('piklist_wordpress_helpers', 'edit_column_header'), self::$filter_priority, 2);

    add_action('manage_link_custom_column', array('piklist_wordpress_helpers', 'edit_column_echo'), self::$filter_priority, 2);
    add_filter('manage_link-manager_columns', array('piklist_wordpress_helpers', 'edit_column_header'), self::$filter_priority, 2);
    
    $post_types = array(
      'posts' => 'post'
      , 'pages' => 'page'
      , 'media' => 'media'
    );

    foreach ($post_types as $post_type => $value)
    {
      add_action('manage_' . $post_type . '_custom_column', array('piklist_wordpress_helpers', 'edit_column_echo'), self::$filter_priority, 2);
      add_filter('manage_' . $post_type . '_columns', array('piklist_wordpress_helpers', 'edit_column_header'), self::$filter_priority, 2);
      add_filter('manage_edit-' .  $value . '_sortable_columns', array('piklist_wordpress_helpers', 'edit_column_header'), self::$filter_priority);
    }
    
    if ($custom_post_types = get_post_types(array('_builtin' => false)))
    {
      foreach ($custom_post_types  as $custom_post_type)
      {
        add_action('manage_' . $custom_post_type . '_custom_column', array('piklist_wordpress_helpers', 'edit_column_echo'), self::$filter_priority, 2);
        add_filter('manage_' . $custom_post_type . '_columns', array('piklist_wordpress_helpers', 'edit_column_header'), self::$filter_priority, 2);
        add_filter('manage_edit-' .  $custom_post_type . '_sortable_columns', array('piklist_wordpress_helpers', 'edit_column_header'), self::$filter_priority);
      }
    }

    $taxonomies_builtin = array(
      'category'
      , 'post_tag'
    );

    foreach ($taxonomies_builtin as $taxonomy_builtin)
    {
      add_action('manage_' . $taxonomy_builtin . '_custom_column', array('piklist_wordpress_helpers', 'edit_column_return'), self::$filter_priority, 3);
      add_filter('manage_edit-' . $taxonomy_builtin . '_columns', array('piklist_wordpress_helpers', 'edit_column_header'), self::$filter_priority, 2);
      add_filter('manage_edit-' . $taxonomy_builtin . '_sortable_columns', array('piklist_wordpress_helpers', 'edit_column_header'), self::$filter_priority);
    }
    
    if ($custom_taxonomies = get_taxonomies(array('_builtin' => false)))
    {
      foreach ($custom_taxonomies  as $custom_taxonomy)
      {
        add_action('manage_' . $custom_taxonomy . '_custom_column', array('piklist_wordpress_helpers', 'edit_column_return'), self::$filter_priority, 3);
        add_filter('manage_edit-' . $custom_taxonomy . '_columns', array('piklist_wordpress_helpers', 'edit_column_header'), self::$filter_priority, 2);
        add_filter('manage_edit-' . $custom_taxonomy . '_sortable_columns', array('piklist_wordpress_helpers', 'edit_column_header'), self::$filter_priority);
      }
    }
  }

  public static function edit_column_header($defaults)
  {
    return array_slice($defaults, 0, 1, true) +
      array('piklist_id' => __('ID')) +
      array_slice($defaults, 1, count($defaults) - 1, true);
  }

  public static function edit_column_echo($column, $value)
  {
    switch ($column)
    {
      case 'piklist_id':
        
        $value = (int) $value;
      
      break;
    }
    
    echo $value;
  }

  public static function edit_column_return($value, $column, $value)
  {
    switch ($column)
    {
      case 'piklist_id':
        
        $value = (int) $value;
      
      break;
    }
    
    return $value;
  }

  public static function get_user_option_screen_layout_dashboard()
  {
    return self::$options['screen_layout_columns_dashboard'];
  }

  public static function get_user_option_screen_layout_post()
  {
    return self::$options['screen_layout_columns_post'];
  }

  public static function theme_switcher()
  {
    global $submenu;
    
    unset($submenu['themes.php'][5]);
    unset($submenu['themes.php'][15]);
  }

  public static function disable_self_ping(&$links)
  {
    // @ Credit http://blogwaffe.com/2006/10/04/wordpress-plugin-no-self-pings/
    foreach ($links as $l => $link)
      if (0 === strpos($link, get_option('home')))
        unset($links[$l]);
  }

  /* = Body / Post Classses
  -----------------------------------------------
   * @credit http://themehybrid.com/
   */
  public static function body_class($classes)
  {
      global $post;

      $extended_classes = array();
      $tax_classes = array();
      $date_classes = array();
      $author_classes = array();
      $browser_classes = array();

      if (is_singular())
      {
        $extended_classes = array_merge($extended_classes, self::taxonomy_class($tax_classes));

        $extended_classes = array_merge($extended_classes, self::date_class($date_classes));

        if (has_post_thumbnail())
        {
          $extended_classes[] = 'has-post-thumbnail';
        }

        if (is_multi_author())
        {
          $extended_classes = array_merge($extended_classes, self::author_class($author_classes));
        }
      }
      
      if (is_archive())
      {
        if ( is_year() )
        {
          $extended_classes[] = 'year';
        }

        if ( is_month() )
        {
          $extended_classes[] = 'month';
        }

        if ( is_day() )
        {
          $extended_classes[] = 'day';
        }
          
      }

      if (is_user_logged_in())
      {
        global $wp_roles;
        $current_user = wp_get_current_user();
        $roles = $current_user->roles;
        $role = array_shift($roles);
        $extended_classes[] = ($wp_roles->role_names[$role]) ? translate_user_role($wp_roles->role_names[$role] ) : false;
      }

      if (is_multisite())
      {
         global $blog_id;
         $sitename = str_replace(' ', '-' , strtolower( get_bloginfo('name') ) );
         $extended_classes[] = 'multisite';
         $extended_classes[] = 'site-' . $blog_id;
         $extended_classes[] = 'site-' . $sitename;
      }

      $extended_classes = array_merge($extended_classes, self::browser_class($browser_classes));
  
      $classes = array_merge((array)$classes, (array)$extended_classes);
      $classes = array_map('strtolower', $classes);
      $classes = sanitize_html_class($classes);
      $classes = array_unique($classes);

      return $classes;
  }

  public static function post_class($classes = '', $post_id = null)
  {

      global $post, $wp_query;

      $extended_classes = array();
      $tax_classes = array();
      $date_classes = array();
      $author_classes = array();

      if(!is_singular())
      {
        $extended_classes[] = (($wp_query->current_post+1) % 2) ? 'odd' : 'even';

        $extended_classes = array_merge($extended_classes, self::date_class($date_classes));

        $extended_classes = array_merge($extended_classes, self::taxonomy_class($tax_classes));

        if (has_post_thumbnail())
        {
          $extended_classes[] = 'has-post-thumbnail';
        }

        if (is_multi_author())
        {
          $extended_classes = array_merge($extended_classes, self::author_class($author_classes));
        }

        if (post_type_supports($post->post_type, 'excerpt') && has_excerpt())
        {
          $extended_classes[] = 'has-excerpt';
        }
      
      }


      $classes = array_merge((array)$classes, (array)$extended_classes);
      $classes = array_map('strtolower', $classes);
      $classes = sanitize_html_class($classes);
      $classes = array_unique($classes);


      return $classes;

  }

  public static function browser_class()
  {
    // @Credit http://www.mattvarone.com/wordpress/browser-body-classes-function/
    global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
      if($is_lynx) $browser_classes[] = 'lynx';
      elseif($is_gecko) $browser_classes[] = 'gecko';
      elseif($is_opera) $browser_classes[] = 'opera';
      elseif($is_NS4) $browser_classes[] = 'ns4';
      elseif($is_safari) $browser_classes[] = 'safari';
      elseif($is_chrome) $browser_classes[] = 'chrome';
      elseif($is_IE)
      {
        $browser_classes[] = 'ie';
        if(preg_match('/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version))
        {
          $browser_classes[] = 'ie-' . $browser_version[1];
        }
      }
      else
      {
        $browser_classes[] = 'browser-unknown';
      }

      if($is_iphone) $browser_classes[] = 'iphone';
      
      return $browser_classes;
  }

  public static function date_class()
  {
    $date_classes[] = get_the_date('F');
    $date_classes[] = 'day-' . get_the_date('j');
    $date_classes[] = get_the_date('Y');
    $date_classes[] = 'time-' . get_the_date('a');

    return $date_classes;
  }

  public static function author_class()
  {
    global $post;

    $author_id = $post->post_author;
    $author_classes[] = 'author-' . get_the_author_meta( 'user_nicename', $author_id );

    return $author_classes;
  }

  public static function taxonomy_class()
  {

    global $post, $post_id;
        
      $post = get_post($post->ID);
      $post_type = $post->post_type;

      $taxonomies = get_object_taxonomies($post_type);
        foreach ($taxonomies as $taxonomy)
        {
          $terms = get_the_terms( $post->ID, $taxonomy );
          if (!empty($terms))
          {
            $output = array();

            foreach ($terms as $term)
            {
              $tax_classes[] .= $term->taxonomy . '-' . $term->name ;

              if (is_taxonomy_hierarchical( $term->taxonomy ))
              {
                 // Get Parents, Grandparents, etc.
                $counter = 1;
                while (!is_wp_error(get_term( $term->parent, $term->taxonomy))) :

                  $term_parent = get_term( $term->parent, $term->taxonomy);
                  $tax_classes[] .= $term->taxonomy . '-' . 'level-' . $counter . '-' . $term_parent->name;
                  $tax_classes[] .= $term->taxonomy . '-hierarchical-' . $term_parent->name;
                  $term = $term_parent;
                  $counter++;

                endwhile;
              }
            }              
          }
        }
    return $tax_classes;
  }

  public static function wp_die()
  {
    wp_die(__('Disabled'));
  }

  public static function admin_css()
  { 
?>
    <style type="text/css">     
      <?php do_action('piklist_helpers_admin_css'); ?>
    </style>
<?php
  }
}



?>