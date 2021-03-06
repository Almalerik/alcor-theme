<?php
/**
 * alcor functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package alcor
 */
if (! function_exists ( 'alcor_setup' )) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function alcor_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on alcor, use a find and replace
		 * to change 'alcor' to the name of your theme in all the template files.
		 */
		load_theme_textdomain ( 'alcor', get_template_directory () . '/languages' );
		
		// Add default posts and comments RSS feed links to head.
		add_theme_support ( 'automatic-feed-links' );
		
		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support ( 'title-tag' );
		
		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support ( 'post-thumbnails' );
		
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus ( array (
				'primary' => esc_html__ ( 'Primary Menu', 'alcor' ) 
		) );
		
		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support ( 'html5', array (
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption' 
		) );
		
		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support ( 'post-formats', array (
				'aside',
				'image',
				'video',
				'quote',
				'link' 
		) );
		
		// Set up the WordPress core custom background feature.
		add_theme_support ( 'custom-background', apply_filters ( 'alcor_custom_background_args', array (
				'default-color' => 'ffffff',
				'default-image' => '' 
		) ) );
	}

endif; // alcor_setup
add_action ( 'after_setup_theme', 'alcor_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function alcor_content_width() {
	$GLOBALS ['content_width'] = apply_filters ( 'alcor_content_width', 640 );
}
add_action ( 'after_setup_theme', 'alcor_content_width', 0 );

/**
 * Add jquery support
 */
function jquery_scripts() {
	wp_enqueue_script ( 'jquery' );
}
add_action ( 'wp_enqueue_scripts', 'jquery_scripts' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function alcor_widgets_init() {
	register_sidebar ( array (
			'name' => esc_html__ ( 'Header widgets', 'alcor' ),
			'id' => 'sidebar-header-widget',
			'description' => '',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>' 
	) );
	register_sidebar ( array (
			'name' => esc_html__ ( 'Sidebar', 'alcor' ),
			'id' => 'sidebar-1',
			'description' => '',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>' 
	) );
}
add_action ( 'widgets_init', 'alcor_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function alcor_scripts() {
	wp_enqueue_style ( 'alcor-fontawesome', get_template_directory_uri () . '/assets/font-awesome/4.4.0/css/font-awesome.min.css' );
	wp_enqueue_style ( 'alcor-bootstrap-style', get_template_directory_uri () . '/assets/bootstrap/3.3.5/css/bootstrap.min.css', array (
			'alcor-style' 
	) );
	wp_enqueue_script ( 'alcor-bootstrap-script', get_template_directory_uri () . '/assets/bootstrap/3.3.5/js/bootstrap.min.js', array (
			'jquery'
	), '20130115', true );	
	wp_enqueue_style ( 'alcor-style', get_stylesheet_uri () );
	wp_enqueue_style ( 'alcor-style-css', get_template_directory_uri () . '/assets/css/alcor.css', array (
			'alcor-bootstrap-style' 
	) );
	
	wp_enqueue_script ( 'alcor-navigation', get_template_directory_uri () . '/js/navigation.js', array (), '20120206', true );
	
	wp_enqueue_script ( 'alcor-skip-link-focus-fix', get_template_directory_uri () . '/js/skip-link-focus-fix.js', array (), '20130115', true );
	wp_enqueue_script ( 'alcor-script', get_template_directory_uri () . '/assets/js/alcor.js', array (
			'jquery' 
	), '20130115', true );
	wp_enqueue_script ( 'alcor-jquery-color', get_template_directory_uri () . '/assets/js/jquery.color.js', array (
			'jquery' 
	), '20130115', true );
	
	wp_enqueue_style ( 'alcor-swiper-css', get_template_directory_uri () . '/assets/swiper/3.2.0/dist/css/swiper.min.css');
	wp_enqueue_script ( 'alcor-swiper-js', get_template_directory_uri () . '/assets/swiper/3.2.0/dist/js/swiper.jquery.min.js', array (
			'jquery'
	), '20130115', true );
	
	if (is_singular () && comments_open () && get_option ( 'thread_comments' )) {
		wp_enqueue_script ( 'comment-reply' );
	}
}
add_action ( 'wp_enqueue_scripts', 'alcor_scripts' );

if (! function_exists ( 'alcor_admin_script' )) {
	function alcor_admin_script($hook) {
		wp_register_style ( 'alcor-admin-style', get_template_directory_uri () . '/assets/admin/css/admin.css' );
		wp_enqueue_style ( 'alcor-admin-style' );
		wp_enqueue_media ();
		wp_enqueue_style ( 'alcor-fontawesome', get_template_directory_uri () . '/assets/font-awesome/4.4.0/css/font-awesome.min.css' );
		wp_enqueue_style ( 'alcor-select2', get_template_directory_uri () . '/assets/admin/select2/css/select2.min.css' );
		wp_enqueue_script ( 'alcor-select2-script', get_template_directory_uri () . '/assets/admin/select2/js/select2.min.js', array (
				'jquery' 
		) );
		wp_enqueue_script ( 'alcor-admin-script', get_template_directory_uri () . '/assets/admin/js/admin.js', array (
				'jquery',
				'alcor-select2-script' 
		) );
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script( 'jquery-ui-accordion' );
	}
}
add_action ( 'admin_enqueue_scripts', 'alcor_admin_script' );

/**
 * Implement the theme class.
 */
require get_template_directory () . '/inc/alcor.php';
$alcor = new Alcor_Theme ();

/**
 * Implement the Custom Header feature.
 */
require get_template_directory () . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory () . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory () . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory () . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory () . '/inc/jetpack.php';

/**
 * Load Alcor Nav
 */
require get_template_directory () . '/inc/nav/nav.php';

/**
 * Load Alcor Slider
 */
require get_template_directory () . '/inc/slider/slider.php';
