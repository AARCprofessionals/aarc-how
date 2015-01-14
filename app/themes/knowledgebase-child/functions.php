<?php

function loop_through_categories($parent_category_slug) {
  $categoryObj = get_category_by_slug($parent_category_slug);

  $categories = get_categories(
    array(
      'child_of' => $categoryObj->term_id,
      'type' => 'post',
    )
  );

  foreach ($categories as $category) {
    echo '<h4>' . $category->name . '</h4>';
    $args = array(
      'category_name' => $category->slug
    );
    $the_query = new WP_Query( $args );
    // loop through the posts
    if ( $the_query->have_posts() ) {
      echo '<ul class="list-group">';
      while ( $the_query->have_posts() ) {
        $the_query->the_post();
        echo '<a href="' . get_the_permalink() . '" class="list-group-item">' . get_the_title() . '</a>';
      }
      echo '</ul>';
    }
  }
}


add_action( 'wp_enqueue_scripts', 'knowledgebase_load_parent_styles');
function knowledgebase_load_parent_styles() {
  wp_enqueue_style( 'parent-styles', get_template_directory_uri().'/style.css' );
}

// Unhook default Thematic functions
function unhook_thematic_functions() {
    // we put the position number of the original function (5)
    // for priority reasons
    remove_action( 'wp_enqueue_scripts', 'ipt_kb_scripts', 5 );
}
add_action( 'init', 'unhook_thematic_functions' );

/**
 * Enqueue scripts and styles
 */
function knowledgebase_scripts() {
  global $ipt_kb_version;

  // Fonts from Google Webfonts
  wp_enqueue_style( 'ipt_kb-fonts', '//fonts.googleapis.com/css?family=Oswald|Roboto:400,400italic,700,700italic', array(), $ipt_kb_version );

  // Main stylesheet
  wp_enqueue_style( 'ipt_kb-style', get_template_directory_uri(), array(), $ipt_kb_version );

  // Bootstrap
  wp_enqueue_style( 'ipt_kb-bootstrap', get_template_directory_uri() . '/lib/bootstrap/css/bootstrap.min.css', array(), $ipt_kb_version );
  wp_enqueue_style( 'ipt_kb-bootstrap-theme', get_template_directory_uri() . '/lib/bootstrap/css/bootstrap-theme.min.css', array(), $ipt_kb_version );

  // Icomoon
  wp_enqueue_style( 'ipt_kb-icomoon', get_template_directory_uri() . '/lib/icomoon/style.css', array(), $ipt_kb_version );

  // Now the JS
  wp_enqueue_script( 'ipt_kb-bootstrap', get_template_directory_uri() . '/lib/bootstrap/js/bootstrap.min.js', array( 'jquery' ), $ipt_kb_version );
  wp_enqueue_script( 'ipt_kb-bootstrap-jq', get_template_directory_uri() . '/lib/bootstrap/js/jquery.ipt-kb-bootstrap.js', array( 'jquery' ), $ipt_kb_version );

  wp_enqueue_script( 'ipt_kb-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), $ipt_kb_version, true );

  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }

  if ( is_singular() && wp_attachment_is_image() ) {
    wp_enqueue_script( 'ipt_kb-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), $ipt_kb_version );
  }

  // Load the sticky kit
  wp_enqueue_script( 'ipt-kb-sticky-kit', get_template_directory_uri() . '/lib/sticky-kit/jquery.sticky-kit.min.js', array( 'jquery' ), $ipt_kb_version );

  // Load the theme js
  wp_enqueue_script( 'ipt-kb-js', get_template_directory_uri() . '/js/ipt-kb.js', array( 'jquery' ), $ipt_kb_version );
  wp_localize_script( 'ipt-kb-js', 'iptKBJS', array(
    'ajaxurl' => admin_url( 'admin-ajax.php' ),
    'ajax_error' => __( 'Oops, some problem to connect. Try again?', 'ipt_kb' ),
  ) );
}
add_action( 'wp_enqueue_scripts', 'knowledgebase_scripts' );

