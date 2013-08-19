<?php
/**
 * places functions and definitions
 *
 * @package places
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

/*
 * Load Jetpack compatibility file.
 */
require( get_template_directory() . '/inc/jetpack.php' );

if ( ! function_exists( 'places_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function places_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/extras.php' );

	/**
	 * Customizer additions
	 */
	require( get_template_directory() . '/inc/customizer.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on places, use a find and replace
	 * to change 'places' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'places', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'places' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );
}
endif; // places_setup
add_action( 'after_setup_theme', 'places_setup' );

/**
 * Setup the WordPress core custom background feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for WordPress 3.3
 * using feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @todo Remove the 3.3 support when WordPress 3.6 is released.
 *
 * Hooks into the after_setup_theme action.
 */
function places_register_custom_background() {
	$args = array(
		'default-color' => 'ffffff',
		'default-image' => '',
	);

	$args = apply_filters( 'places_custom_background_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-background', $args );
	} else {
		define( 'BACKGROUND_COLOR', $args['default-color'] );
		if ( ! empty( $args['default-image'] ) )
			define( 'BACKGROUND_IMAGE', $args['default-image'] );
		add_custom_background();
	}
}
add_action( 'after_setup_theme', 'places_register_custom_background' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function places_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'places' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'places_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function places_scripts() {
	/* load scripts for jquery tabs */
	if ( !is_admin() ) {
		wp_register_style( 'tabs_css', get_template_directory_uri().'/jquery-ui-1.8.23.custom.css' );
		wp_enqueue_style( 'tabs_css' );
		wp_enqueue_script('jquery-ui-tabs');
	}

	wp_enqueue_style( 'places-style', get_stylesheet_uri() );

	wp_enqueue_script( 'places-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'places-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'places-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'places_scripts' );

/**
 * Implement the Custom Header feature
 */
//require( get_template_directory() . '/inc/custom-header.php' );

/* ajaxifying theme */
if ( ! is_admin() ) {
    $url = get_stylesheet_directory_uri() . '/lib/';
    wp_enqueue_script( 'hash-change', "{$url}jquery.ba-hashchange.min.js", array('jquery'), '', true);
    $url = get_stylesheet_directory_uri() . '/js/';
    wp_enqueue_script( 'ajax-theme', "{$url}ajax.js", array( 'hash-change' ), '', true);
}

if (is_admin()) {
	wp_enqueue_style( 'places-style', get_template_directory_uri() . '/admin.css');
}


/* redirect after login */
function admin_default_page() {
  return ( '/' );
}
add_filter('login_redirect', 'admin_default_page');

/* Add custom logo */
function custom_login_logo() {
	echo '<style type="text/css">
	h1 a { background-image: url(http://linz.pflueckt.at/static/leaflet051/images/leaf-green.png) !important; background-size: 38px 95px !important; }
	</style>';
}
add_action('login_head', 'custom_login_logo');

/* remove admin bar */
add_filter( 'show_admin_bar', '__return_false' );

/* hide admin menu */
function hide_menus() {
    if ( !current_user_can('manage_options') ) {
        ?>
        <style>
           #adminmenuback, #adminmenuwrap, #wp-admin-bar-wp-logo{
                display:none;
            }
        </style>
        <?php
    }
}
add_action('admin_head', 'hide_menus');


/* create custom post type PLACE */
add_action( 'init', 'create_post_type' );
function create_post_type() {
	register_post_type( 'place',
		array(
			'labels' => array(
				'name' => __( 'Places' ),
				'singular_name' => __( 'Place' )
			),
		'public' => true,
		'has_archive' => false,
		)
	);
	add_post_type_support( 'place', 
		array(
			'excerpt',
			'comments',
			'custom-fields',
			'thumbnail'
		));
}


/* Define the custom PLACES box */
add_action( 'add_meta_boxes', 'places_add_custom_box' );

/* Do something with the data entered */
add_action( 'save_post', 'places_save_postdata' );

/* Adds a box to the main column on the places screen */
function places_add_custom_box() {
	add_meta_box(
        'places_sectionid',
        __( 'PLACE DETAILS', 'places_textdomain' ),
        'places_inner_custom_box',
        'place'
    );
}

/* Prints the box content */
function places_inner_custom_box( $post ) {

	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'places_noncename' );

	// The actual fields for data entry
	// Use get_post_meta to retrieve an existing value from the database and use the value for the form
	$places_lat = get_post_meta( $post->ID, '_places_lat', true );
	$places_long = get_post_meta( $post->ID, '_places_long', true );

	// begin a table row with
	echo '<table>';
	echo '<tr>
	<th><label for="places_lat">Latitude</label></th>
	<td><input type="text" name="places_lat" id="places_lat" size="20" value="'.$places_lat.'">
	<span class="description">Use to define latitude of your place.</span></td>
	</tr>';
	echo '<tr>
	<th><label for="places_long">Longitude</label></th>
	<td><input type="text" name="places_long" id="places_long" size="20" value="'.$places_long.'">
	<span class="description">Use to define longitude of your place.</span></td>
	</tr>';
	echo '</table>';
}

/* When the event is saved, saves our custom data */
function places_save_postdata( $post_id ) {
  // First we need to check if the current user is authorised to do this action. 
	//if ( ! current_user_can( 'edit_page', $post_id ) ) return;

  // Secondly we need to check if the user intended to change this value.
  if ( ! isset( $_POST['places_noncename'] ) || ! wp_verify_nonce( $_POST['places_noncename'], plugin_basename( __FILE__ ) ) )
      return;

  // Thirdly we can save the value to the database

  //if saving in a custom table, get post_ID
  $post_ID = $_POST['post_ID'];
  //sanitize user input
  $places_lat = $_POST['places_lat'];
  $places_long = $_POST['places_long'];

  // save $places data 
  add_post_meta($post_ID, '_places_lat', $places_lat, true) or
    update_post_meta($post_ID, '_places_lat', $places_lat);
  add_post_meta($post_ID, '_places_long', $places_long, true) or
    update_post_meta($post_ID, '_places_long', $places_long);
}


