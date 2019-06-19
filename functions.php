<?php //no close php
/**
 * All Menu Locations for this theme
 */
function bp_menu_areas(){
	register_nav_menus( array(
		//code-friendly => human-friendly
		'main_menu' 	=> 'Main Menu',
		'social_menu' 	=> 'Social Media Menu',
	) );
}
add_action( 'init', 'bp_menu_areas' );

//HTML output for Social Media Menu. Call this in header.php
function bp_social_menu(){
	//Social Media Links
		 wp_nav_menu( array(
		 	'theme_location' 	=> 'social_menu',
		 	'container' 		=> false, //no container
		 	'menu_class'		=> 'social-navigation',
		 	'fallback_cb'		=> false, //do nothing if no menu in this location
		 	'link_before'		=> '<span class="screen-reader-text">',
		 	'link_after'		=> '</span>',
		 ) );
}

//featured images
add_theme_support( 'post-thumbnails' );

//custom logo
$logo_args = array(
	'width' 		=> 300,
	'height'		=> 300,
	'flex-width'	=> true,
	'flex-height' 	=> true,
);
add_theme_support( 'custom-logo', $logo_args );

//improve RSS and JSON feeds
add_theme_support( 'automatic-feed-links' );

//use modern markup on wordpress HTML output
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 
									'gallery', 'caption' ) );

//make sure to remove the <title> HTML from header.php. WordPress will automatically add it
add_theme_support( 'title-tag' );

/**
 * Load all CSS and JS this theme needs
 */
add_action( 'wp_enqueue_scripts', 'bp_stylesheets' );
function bp_stylesheets(){
	wp_enqueue_style( 'genericons', get_stylesheet_directory_uri() . '/genericons/genericons.css' );
	wp_enqueue_script( 'script', get_template_directory_uri() . '/js/script.js', array ( 'jquery' ), 1.1, true);
	if ( is_singular() ) wp_enqueue_script( "comment-reply" );
	wp_enqueue_script("jquery");
}

//add the ability to upload SVGs to WP Media
add_action('upload_mimes', 'add_file_types_to_uploads');
function add_file_types_to_uploads($file_types){
	$new_filetypes = array();
	$new_filetypes['svg'] = 'image/svg+xml';
	$file_types = array_merge($file_types, $new_filetypes );
	return $file_types;
}

/**
 * register widget areas (dynamic sidebars)
 */
add_action( 'widgets_init', 'bp_widget_areas' );
function bp_widget_areas(){
	register_sidebar( array(
		'name' 	=> 'BP Sidebar',
		'id' 	=> 'bp_sidebar',
		'description' => 'N/A',
	) );
}

//Required for Theme Check: max width of YouTube and other embeds
if ( ! isset( $content_width ) ) $content_width = 700;

/**
 * Helper function to display archive or single pagination (next/prev buttons)
 */
function bp_pagination(){
	if( is_singular() ):
		//single post pagination
		previous_post_link( '%link', '&larr; Previous: %title' );
		next_post_link( '%link', 'Next: %title &rarr;' );
	else:
		//archive pagination
		if( wp_is_mobile() ):
			previous_posts_link( '&larr; Previous Page' );
			next_posts_link( 'Next Page &rarr;' );
		else:
			//numbered pagination
			the_posts_pagination(array(
				'mid_size' => 2,
				'next_text' => 'Next Page &rarr;',
			));
		endif;
	endif;
}
