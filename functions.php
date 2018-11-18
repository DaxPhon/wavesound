<?php
  // add custom header
  $defaults = array(
  	'default-image' => get_template_directory_uri() . '/assets/images/wavesound-header-image.jpg',
  );
  add_theme_support( 'custom-header', $defaults );

  // register menu
  function register_main_menu() {
    register_nav_menu('primary',__( 'Hauptmenü' ));
  }
  add_action( 'init', 'register_main_menu' );

  function wavesound_main_menu() {
      $menu_name = 'Hauptmenü'; // specify custom menu slug
      $menu_list = '<div class="main-menu"><ul>' ."\n";
      $ws_menu = wp_get_nav_menu_object( $menu_name );

      if ($menu_items = wp_get_nav_menu_items($menu_name)) {
          $count = 0;
          $submenu = false;
          $parent_id = 0;
          $previous_item_has_submenu = false;
          $current_item = current( wp_filter_object_list( $menu_items, array( 'object_id' => get_queried_object_id() ) ) );
          $current_item_title = $current_item->title;

          foreach ((array) $menu_items as $key => $menu_item) {
              $title = $menu_item->title;
              $url = $menu_item->url;

              // check if it's a top-level item
              if ($menu_item->menu_item_parent == 0) {
                  $parent_id = $menu_item->ID;

                  // check if it has children
                  if (empty($menu_items[$count + 1]) || $menu_items[ $count + 1 ]->menu_item_parent != $parent_id )
                  {
                    $menu_list .= "\t". '<li class="';
                    ($current_item_title === $title) ? $menu_list .= ' active"' : $menu_list .= '"';
                    $menu_list .= '><a href="'. $url .'" class="nr-'.$count.'">'. $title;
                  } else {
                    $menu_list .= "\t". '<li class="has-children';
                    ($current_item_title === $title) ? $menu_list .= ' active"' : $menu_list .= '"';
                    $menu_list .= '><div class="collapse-wrapper"><a href="'. $url .'" class="nr-'.$count.'">'. $title;
                  }
              }

              // if this item has a (nonzero) parent ID, it's a second-level (child) item
              else {
                  if ( !$submenu ) { // first item
                      // add the dropdown arrow to the parent
                      $menu_list .= '</a><button class="collapse-submenu" type="button" data-toggle="collapse" data-target="#collapse'.$parent_id.'" aria-expanded="true" aria-controls="collapse'.$parent_id.'"><i class="fas fa-chevron-up"></i></button></div>' . "\n";
                      // start the child list
                      $submenu = true;
                      $previous_item_has_submenu = true;
                      $menu_list .= "\t\t" . '<ul id="collapse'.$parent_id.'" class="collapse show">' ."\n";
                 }

                  $menu_list .= "\t\t\t". '<li';
                  ($current_item_title === $title) ? $menu_list .= ' class="active"' : false;
                  $menu_list .= '><a href="'. $url .'" class="nr-'.$count.'">'. $title.'</a>';
                  $menu_list .= '</li>' ."\n";

                  // if it's the last child, close the submenu code
                  if ( $menu_items[ $count + 1 ]->menu_item_parent != $parent_id && $submenu ){
                      $menu_list .= "\t\t" . '</ul></li>' ."\n";
                      $submenu = false;
                  }
              }

              // close the parent (top-level) item
              if (empty($menu_items[$count + 1]) || $menu_items[ $count + 1 ]->menu_item_parent != $parent_id )
              {
                 if ($previous_item_has_submenu)
                  {
                      // the a link and list item were already closed
                      $previous_item_has_submenu = false; //reset
                  }
                  else {
                      // close a link and list item
                      $menu_list .= "\t" . '</a></li>' . "\n";
                  }
              }

              $count++;
          }
          $menu_list .= "\t". '<li class="search nr-'.$ws_menu->count.'">' .get_search_form( false ). '</li>'."\n";

      } else {
           $menu_list .= '<div class="alert alert-danger" role="alert">Bitte '.$menu_name.' pflegen!</div>';
      }
      $menu_list .= "\t". '</ul></div>' ."\n";
      echo $menu_list;
  }

  // add js
  function add_theme_scripts() {
    wp_enqueue_script( 'jquery', get_template_directory_uri() . '/assets/js/jquery.min.js');
    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js');
    wp_enqueue_script( 'general', get_template_directory_uri() . '/assets/js/general.js');
  }
  add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );

  // check parameters if there are more than 5 sites
  add_action( 'pre_get_posts', function( $query ) {

      if( $query->is_main_query() && ! is_admin() && $query->is_search() ) {

          // change the query parameters
          $query->set( 'posts_per_page', 5 );

      }

  } );

  // highlighting the search results: content
  function search_excerpt_highlight() {
      $excerpt = get_the_excerpt();
      $keys = implode('|', explode(' ', get_search_query()));
      $excerpt = preg_replace('/(' . $keys .')/iu', '<em class="search-highlight">\0</em>', $excerpt);

      echo '<p>' . $excerpt . '</p>';
  }

  // highlighting the search results: title
  function search_title_highlight() {
      $title = get_the_title();
      $keys = implode('|', explode(' ', get_search_query()));
      $title = preg_replace('/(' . $keys .')/iu', '<em class="search-highlight">\0</em>', $title);

      echo $title;
  }
?>
