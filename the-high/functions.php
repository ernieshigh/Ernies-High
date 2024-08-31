<?php
// Setup the-high Theme

include get_theme_file_path('/inc/high-walker.php');
include get_theme_file_path('/inc/high-functions.php');
include get_theme_file_path('/inc/high-cpt.php');
include get_theme_file_path('/inc/high-filter.php');
include get_theme_file_path('/inc/high-cat-filter.php');
include get_theme_file_path('/inc/high-blocks.php');
//include get_theme_file_path('/blocks/features.php');


if (!function_exists('wp_body_open')) {
	function wp_body_open()
	{
		do_action('wp_body_open');
	}
}


add_action('after_setup_theme', 'high_name_setup');
function high_name_setup()
{

	// theme text domain
	load_theme_textdomain('the-high', get_template_directory() . '/languages');

	//add post format
	add_theme_support('post-formats', array('aside', 'gallery', ));

	//adds title in head
	add_theme_support("title-tag");

	// add feed
	add_theme_support('automatic-feed-links');

	// add thumbnail
	add_theme_support('post-thumbnails');
	add_image_size('feature-thumb', 320, 9999);

	add_theme_support('html5', array('search-form'));
	//register  menu option
	add_action('init', 'basic_high_register_menus');

	// add editor styles 
	add_theme_support("responsive-embeds");
	add_theme_support("align-wide");
	add_editor_style();

	// block support 
	add_theme_support("wp-block-styles");
	add_theme_support("responsive-embeds");
	add_theme_support("align-wide");
	add_editor_style();



	// set content width
	if (!isset($content_width))
		$content_width = 1280;
	add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));// add custom header
	$header = array(
		'random-default' => false,
		'height' => 100,
		'flex-height' => true,
		'flex-width' => true,
		'default-text-color' => '#5f9ea0',
		'header-text' => true,
		'uploads' => true,
		'wp-head-callback' => 'high_header_style',
	);
	add_theme_support("custom-header", $header);

	// add custom background
	$background = array(
		'default-color' => '#fff',
		'default-image' => '',
		'wp-head-callback' => '_custom_background_cb',
		'admin-head-callback' => '',
		'admin-preview-callback' => ''
	);
	add_theme_support("custom-background", $background);

	// set header defaults
	if (!function_exists('high_header_style')) {
		function high_header_style()
		{
			$header_text_color = get_header_textcolor();
			$header_image = get_header_image();

			if ($header_image): ?>
				<style type="text/css">
					header {
						background-image: url(<?php echo esc_url($header_image); ?>);
					}
				</style>
				<?php
			endif;
		}
	}

	add_theme_support("title-tag");

}

add_filter('wp_get_attachment_image_attributes', function ($attr) {
	$attr['alt'] = get_the_title();
	$attr['title'] = get_the_title();
	return $attr;
});


// display logo 
// 
add_action('after_setup_theme', 'high_display_logo');
function high_display_logo()
{
	$defaults = array(
		'height' => 220,
		'width' => 220,
		'flex-height' => false,
		'flex-width' => false,
		'header-text' => array('site-title', 'site-description'),

	);
	add_theme_support('custom-logo', $defaults);

}

add_action('after_setup_theme', 'basic_high_register_menus', 0);
function basic_high_register_menus()
{
	register_nav_menus(array(
		'primary_menu' => __('Primary Menu', 'the-high'),
		'footer_menu' => __('Footer Menu', 'the-high'),
	));
}

// Allow SVG
add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes) {

	global $wp_version;
	if ($wp_version !== '4.7.1') {
		return $data;
	}

	$filetype = wp_check_filetype($filename, $mimes);

	return [
		'ext' => $filetype['ext'],
		'type' => $filetype['type'],
		'proper_filename' => $data['proper_filename']
	];

}, 10, 4);

// allow SVG media in theme							   
add_action('admin_head', 'fix_svg');
function cc_mime_types($mimes)
{
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}

function fix_svg()
{
	echo '<style type="text/css">
        .attachment-266x266, .thumbnail img {
             width: 100% !important;
             height: auto !important;
        }
        </style>';
}


// add preloac to enqueue stylesheets
add_filter('style_loader_tag', 'high_preload_styles', 10, 2);
function high_preload_styles($html, $handle)
{
	if (strcmp($handle, 'preload-style') == 0) {
		$html = str_replace("rel='stylesheet'", "rel='preload' as='style' ", $html);
	}
	return $html;
}



// enqueue add custom scripts and styles if needed
add_action('wp_enqueue_scripts', 'high_scripts');
function high_scripts()
{
	// styles  
	//wp_dequeue_style( 'wp-block-library' );
	//wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style('wc-blocks-style'); // Remove WooCommerce block CSS

	wp_enqueue_style('default', get_stylesheet_directory_uri() . '/assets/css/fallback.css');
	wp_enqueue_style('wpb-google-fonts', 'https://fonts.googleapis.com/css2?family=Open+Sans&family=Source+Sans+3&display=swap', false);
	wp_enqueue_style('high-style', get_stylesheet_uri());


	//scripts

	if (!is_admin()) {
		wp_dequeue_script('jquery');
		wp_deregister_script('jquery');
	}

	if (is_page(198)) {
		wp_enqueue_script('scroll', 'https://unpkg.com/scroll-out/dist/scroll-out.min.js', array(), false);
	}


	if (is_page_template('template-filter.php')) {
		wp_register_script('jquery', '/wp-includes/js/jquery/jquery.js');
		wp_enqueue_script('jquery');
		wp_enqueue_script('filter', get_stylesheet_directory_uri() . '/assets/js/high-filter.js', array('jquery'));

		wp_localize_script(
			'filter',
			'high_filter',
			array(
				'ajax_url' => admin_url('admin-ajax.php'),
				'high_nonce' => wp_create_nonce('high_nonce'),
			)
		);

	}

	if (is_page_template(array('template-yoga.php', 'template-contact-form.php'))) {
		wp_enqueue_style('parallax', get_stylesheet_directory_uri() . '/assets/css/parallax-style.css');
		wp_register_script('jquery', '/wp-includes/js/jquery/jquery.js');
		wp_enqueue_script('jquery');
		wp_enqueue_script('parallax', get_stylesheet_directory_uri() . '/assets/js/parallax-script.js', array('jquery'));
	}

}

// add sidebar and widget areas
add_action('widgets_init', 'high_sidebar');
function high_sidebar()
{

	register_sidebar(array(
		'name' => __('The Sidebar', 'the-high'),
		'id' => 'right_sidebar',
		'description' => __('This sidebar uses the right sidebar template.', 'the-high'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => __('The Other Sidebar', 'the-high'),
		'id' => 'left_sidebar',
		'description' => __('This sidebar uses the left sidebar template.', 'the-high'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => __('Left Foot', 'the-high'),
		'id' => 'left_foot',
		'description' => __('Add a widget to left footer', 'the-high'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => __('Center Foot', 'the-high'),
		'id' => 'center_foot',
		'description' => __('Add widget to center foot.', 'the-high'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => __('Right Foot', 'the-high'),
		'id' => 'right_foot',
		'description' => __('Add widget to right foot', 'the-high'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
}