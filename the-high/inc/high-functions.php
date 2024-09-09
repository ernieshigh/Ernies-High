<?php
/***
 *
 * Custom functions 
 *
 ****/



function high_breadcrumbs()
{
	// Set variables for later use
	$here_text = '';
	$home_link = home_url('/');
	$home_text = __('Homepage', 'the-high');
	$link_before = '<span typeof="v:Breadcrumb">';
	$link_after = '</span>';
	$link_attr = ' rel="v:url" property="v:title"';
	$link = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
	$delimiter = '<img src="' . get_template_directory_uri() . '/assets/images/breadcrumb.svg" class="separator">';             // Delimiter between crumbs
	$before = '<span class="current">'; // Tag before the current crumb
	$after = '</span>';                // Tag after the current crumb
	$page_addon = '';                       // Adds the page number if the query is paged
	$breadcrumb_trail = '';
	$category_links = '';

	/** 
	 * Set our own $wp_the_query variable. Do not use the global variable version due to 
	 * reliability
	 */
	$wp_the_query = $GLOBALS['wp_the_query'];
	$queried_object = $wp_the_query->get_queried_object();

	// Handle single post requests which includes single pages, posts and attatchments
	if (is_singular()) {
		/** 
		 * Set our own $post variable. Do not use the global variable version due to 
		 * reliability. We will set $post_object variable to $GLOBALS['wp_the_query']
		 */
		$post_object = sanitize_post($queried_object);

		// Set variables 
		$title = apply_filters('the_title', $post_object->post_title);
		$parent = $post_object->post_parent;
		$post_type = $post_object->post_type;
		$post_id = $post_object->ID;
		$post_link = $before . $title . $after;
		$parent_string = '';
		$post_type_link = '';



		if ('post' === $post_type) {
			// Get the post categories
			$categories = get_the_category($post_id);
			if ($categories) {
				// Lets grab the first category
				$category = $categories[0];

				$category_links = get_category_parents($category, true, $delimiter);
				$category_links = str_replace('<a', $link_before . '<a' . $link_attr, $category_links);
				$category_links = str_replace('</a>', '</a>' . $link_after, $category_links);
			}
		}

		if (!in_array($post_type, ['post', 'page', 'attachment'])) {

			$post_type_object = get_post_type_object($post_type);


			$archive_link = esc_url(get_post_type_archive_link($post_type));

			$label = sprintf($post_type_object->labels->singular_name, 'the-high');



			$post_type_link = sprintf($link, $archive_link, $label);
		}

		// Get post parents if $parent !== 0
		if (0 !== $parent) {
			$parent_links = [];
			while ($parent) {
				$post_parent = get_post($parent);

				$parent_links[] = sprintf($link, esc_url(get_permalink($post_parent->ID)), get_the_title($post_parent->ID));

				$parent = $post_parent->post_parent;
			}

			$parent_links = array_reverse($parent_links);

			$parent_string = implode($delimiter, $parent_links);
		}

		// Lets build the breadcrumb trail

		if ($parent_string) {
			$breadcrumb_trail = $parent_string . $delimiter . $post_link;
		} else {


			$breadcrumb_trail = $post_link;
		}

		if ($post_type_link)
			$breadcrumb_trail = $post_type_link . $delimiter . $breadcrumb_trail;

		if ($category_links)
			$breadcrumb_trail = $category_links . $breadcrumb_trail;
	}

	// Handle archives which includes category-, tag-, taxonomy-, date-, custom post type archives and author archives
	if (is_archive()) {
		if (
			is_category()
			|| is_tag()
			|| is_tax()
		) {
			// Set the variables for this section
			$term_object = get_term($queried_object);
			$taxonomy = $term_object->taxonomy;
			$term_id = $term_object->term_id;
			$term_name = $term_object->name;
			$term_parent = $term_object->parent;
			$taxonomy_object = get_taxonomy($taxonomy);
			$current_term_link = $before . $term_name . $after;
			$parent_term_string = '';
			$seal = '';

			if (0 !== $term_parent) {
				// Get all the current term ancestors
				$parent_term_links = [];
				while ($term_parent) {
					$term = get_term($term_parent, $taxonomy);

					$parent_term_links[] = sprintf($link, esc_url(get_term_link($term)), $term->name);

					$term_parent = $term->parent;
				}

				$parent_term_links = array_reverse($parent_term_links);
				$parent_term_string = implode($delimiter, $parent_term_links);
			}

			if ($taxonomy == 'seal_type') {

				$seal = '<a href="/product-datasheet/">' . __('Product Datasheets', 'the-high') . '</a>';
			}

			if ($parent_term_string) {
				if ($seal != '') {
					$breadcrumb_trail = $seal . $delimiter . $parent_term_string . $delimiter . $current_term_link;
				} else {
					$breadcrumb_trail = $parent_term_string . $delimiter . $current_term_link;
				}

			} else {

				if ($seal != '') {
					$breadcrumb_trail = $seal . $delimiter . $current_term_link;
				} else {

					$breadcrumb_trail = $current_term_link;
				}
			}

		} elseif (is_author()) {

			$breadcrumb_trail = __('Author archive for ', 'the-high') . $before . $queried_object->data->display_name . $after;

		} elseif (is_date()) {
			// Set default variables
			$year = $wp_the_query->query_vars['year'];
			$monthnum = $wp_the_query->query_vars['monthnum'];
			$day = $wp_the_query->query_vars['day'];

			// Get the month name if $monthnum has a value
			if ($monthnum) {
				$date_time = DateTime::createFromFormat('!m', $monthnum);
				$month_name = $date_time->format('F');
			}

			if (is_year()) {

				$breadcrumb_trail = $before . $year . $after;

			} elseif (is_month()) {

				$year_link = sprintf($link, esc_url(get_year_link($year)), $year);

				$breadcrumb_trail = $year_link . $delimiter . $before . $month_name . $after;

			} elseif (is_day()) {

				$year_link = sprintf($link, esc_url(get_year_link($year)), $year);
				$month_link = sprintf($link, esc_url(get_month_link($year, $monthnum)), $month_name);

				$breadcrumb_trail = $year_link . $delimiter . $month_link . $delimiter . $before . $day . $after;
			}

		} elseif (is_post_type_archive()) {

			$post_type = $wp_the_query->query_vars['post_type'];
			$post_type_object = get_post_type_object($post_type);

			$breadcrumb_trail = $before . $post_type_object->labels->singular_name . $after;

		}
	}

	// Handle the search page
	if (is_search()) {
		$breadcrumb_trail = __('Search query for: ', 'the-high') . $before . get_search_query() . $after;
	}

	// Handle 404's
	if (is_404()) {
		$breadcrumb_trail = $before . __('Error 404', 'the-high') . $after;
	}

	// Handle paged pages
	if (is_paged()) {
		$current_page = get_query_var('paged') ? get_query_var('paged') : get_query_var('page');
		$page_addon = $before . sprintf(__('Page %s ', 'the-high'), number_format_i18n($current_page), 'the-high') . $after;
	}

	$breadcrumb_output_link = '';
	$breadcrumb_output_link .= '<div class="breadcrumb-box">';
	if (
		is_home()
		|| is_front_page()
	) {
		// Do not show breadcrumbs on page one of home and frontpage
		if (is_paged()) {
			// $breadcrumb_output_link .= $here_text . $delimiter;
			$breadcrumb_output_link .= '<a href="' . $home_link . '">' . $home_text . '</a>';
			$breadcrumb_output_link .= $page_addon;
		}
	} else {
		//$breadcrumb_output_link .= $here_text . $delimiter;
		$breadcrumb_output_link .= '<a href="' . $home_link . '" rel="v:url" property="v:title">' . $home_text . '</a>';
		$breadcrumb_output_link .= $delimiter;
		$breadcrumb_output_link .= $breadcrumb_trail;
		$breadcrumb_output_link .= $page_addon;
	}
	$breadcrumb_output_link .= '</div><!-- .breadcrumbs -->';

	return $breadcrumb_output_link;
}



// copyright
function high_copyright()
{
	$all_posts = get_posts(
		'post_status=publish&order=ASC'
	);
	$first_post = $all_posts[0];
	$first_date = $first_post->post_date_gmt;
	_e('Copyright &copy; ', 'the-high');
	if (substr($first_date, 0, 4) == date('Y')) {
		echo date('Y');
	} else {
		echo substr($first_date, 0, 4) . "-" . date('Y');
	}
	echo '<a href="' . esc_url(__('https://ernieshigh.dev/', 'the-high')) . '">';
	echo ' <strong>' . get_bloginfo('name') . '</strong> </a>';
	_e('All rights reserved.', 'the-high');
}

/** Add Taxonomy Thumbnails **/

add_action('admin_enqueue_scripts', 'load_media_files');
function load_media_files()
{
	wp_enqueue_media();
}

add_action('category_add_form_fields', 'high_category_thumb', 10, 2);
function high_category_thumb($term)
{

	// get meta data value 
	$image_id = get_term_meta($term->term_id, 'high_img', true);

	?>
	<tr class="form-field">
		<th>
			<label for="high_img">Category Thumb</label>
		</th>
		<td>
			<?php if ($image = wp_get_attachment_image_url($image_id, 'medium')): ?>
				<a href="#" class="high-upload">
					<img src="<?php echo esc_url($image) ?>" />
				</a>
				<a href="#" class="high-remove">Remove image</a>
				<input type="hidden" name="high_img" value="<?php echo absint($image_id) ?>">
			<?php else: ?>
				<a href="#" class="button high-upload">Upload image</a>
				<a href="#" class="high-remove" style="display:none">Remove image</a>
				<input type="hidden" name="high_img" value="">
			<?php endif; ?>
		</td>
	</tr>


	<script>
		jQuery(function ($) {
			// on upload button click
			$('body').on('click', '.high-upload', function (event) {
				event.preventDefault(); // prevent default link click and page refresh

				const button = $(this)
				const imageId = button.next().next().val();

				const customUploader = wp.media({
					title: 'Insert image', // modal window title
					library: {
						// uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
						type: 'image'
					},
					button: {
						text: 'Use this image' // button label text
					},
					multiple: false
				}).on('select', function () { // it also has "open" and "close" events
					const attachment = customUploader.state().get('selection').first().toJSON();
					button.removeClass('button').html('<img src="' + attachment.url + '">'); // add image instead of "Upload Image"
					button.next().show(); // show "Remove image" link
					button.next().next().val(attachment.id); // Populate the hidden field with image ID
				})

				// already selected images
				customUploader.on('open', function () {

					if (imageId) {
						const selection = customUploader.state().get('selection')
						attachment = wp.media.attachment(imageId);
						attachment.fetch();
						selection.add(attachment ? [attachment] : []);
					}

				})

				customUploader.open()

			});
			// on remove button click
			$('body').on('click', '.high-remove', function (event) {
				event.preventDefault();
				const button = $(this);
				button.next().val(''); // emptying the hidden field
				button.hide().prev().addClass('button').html('Upload image'); // replace the image with text
			});
		});
	</script>
	<?php

}


add_action('category_edit_form_fields', 'high_edit_category_fields', 10, 2);
function high_edit_category_fields($term, $taxonomy)
{

	// get meta data value 
	$image_id = get_term_meta($term->term_id, 'high_img', true);

	?>
	<tr class="form-field">
		<th>
			<label for="high_img">Category Thumb</label>
		</th>
		<td>
			<?php if ($image = wp_get_attachment_image_url($image_id, 'medium')): ?>
				<a href="#" class="high-upload">
					<img src="<?php echo esc_url($image) ?>" />
				</a>
				<a href="#" class="high-remove">Remove image</a>
				<input type="hidden" name="high_img" value="<?php echo absint($image_id) ?>">
			<?php else: ?>
				<a href="#" class="button high-upload">Upload image</a>
				<a href="#" class="high-remove" style="display:none">Remove image</a>
				<input type="hidden" name="high_img" value="">
			<?php endif; ?>
		</td>
	</tr>


	<script>
		jQuery(function ($) {
			// on upload button click
			$('body').on('click', '.high-upload', function (event) {
				event.preventDefault(); // prevent default link click and page refresh

				const button = $(this)
				const imageId = button.next().next().val();

				const customUploader = wp.media({
					title: 'Insert image', // modal window title
					library: {
						// uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
						type: 'image'
					},
					button: {
						text: 'Use this image' // button label text
					},
					multiple: false
				}).on('select', function () { // it also has "open" and "close" events
					const attachment = customUploader.state().get('selection').first().toJSON();
					button.removeClass('button').html('<img src="' + attachment.url + '">'); // add image instead of "Upload Image"
					button.next().show(); // show "Remove image" link
					button.next().next().val(attachment.id); // Populate the hidden field with image ID
				})

				// already selected images
				customUploader.on('open', function () {

					if (imageId) {
						const selection = customUploader.state().get('selection')
						attachment = wp.media.attachment(imageId);
						attachment.fetch();
						selection.add(attachment ? [attachment] : []);
					}

				})

				customUploader.open()

			});
			// on remove button click
			$('body').on('click', '.high-remove', function (event) {
				event.preventDefault();
				const button = $(this);
				button.next().val(''); // emptying the hidden field
				button.hide().prev().addClass('button').html('Upload image'); // replace the image with text
			});
		});
	</script>
	<?php
}
add_action('created_category', 'high_save_cat');
add_action('edited_category', 'high_save_cat');
function high_save_cat($term_id)
{

	update_term_meta(
		$term_id,
		'high_img',
		absint($_POST['high_img'])
	);

}



function high_thumb()
{
	global $post, $posts;
	$high_img = '';
	ob_start();
	ob_end_clean();
	$output = preg_match_all('/<img.+?src=[\'"]([^\'"]+)[\'"].*?>/i', $post->post_content, $matches);
	//$high_img = $matches[1][0];
	$high_img = '<img class="featured wp-post-image" src="' . $matches[1][0] . '" alt="' . get_the_title() . '" title="' . get_the_title() . '" width="200" height="200">';

	if (empty($high_img)) {
		$high_img = "/path/to/default.png";
	}
	return $high_img;


}
// add pagination to blog pages
function high_pagination()
{


	global $wp_query;

	/** Stop execution if there's only 1 page */
	if ($wp_query->max_num_pages <= 1)
		return;

	$paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
	$max = intval($wp_query->max_num_pages);

	/** Add current page to the array */
	if ($paged >= 1)
		$links[] = $paged;

	/** Add the pages around the current page to the array */
	if ($paged >= 3) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}

	if (($paged + 2) <= $max) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}

	echo '<div class="page-navigation"><ul class="">' . "\n";

	/** Previous Post Link */
	if (get_previous_posts_link())
		printf('<li>%s</li>' . "\n", get_previous_posts_link());

	/** Link to first page, plus ellipses if necessary */
	if (!in_array(1, $links)) {
		$class = 1 == $paged ? ' class="active"' : '';

		printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');

		if (!in_array(2, $links))
			echo '<li>&hellip;</li>';
	}

	/** Link to current page, plus 2 pages in either direction if necessary */
	sort($links);
	foreach ((array) $links as $link) {
		$class = $paged == $link ? ' class="active"' : '';
		printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
	}

	/** Link to last page, plus ellipses if necessary */
	if (!in_array($max, $links)) {
		if (!in_array($max - 1, $links))
			echo '<li>&hellip;</li>' . "\n";

		$class = $paged == $max ? ' class="active"' : '';
		printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
	}

	/** Next Post Link */
	if (get_next_posts_link())
		printf('<li>%s</li>' . "\n", get_next_posts_link());

	echo '</ul></div>' . "\n";
}

function mail_failure($wp_error)
{
	error_log('Mailing Error Found: ');
	error_log(print_r($wp_error, true));
}
add_action('wp_mail_failed', 'mail_failure', 10, 1);



/*** optimize scripts ***/
// defer stylesheets                                                        
//add_filter('style_loader_tag', 'high_defer_styles', 10, 2);
function high_defer_styles($html, $handle)
{
	$handles = array('block-library', 'wpb-google-fonts', 'default', 'icons', 'high-team', 'contact-form-7');
	if (in_array($handle, $handles)) {
		$html = str_replace('media=\'all\'', 'media=\'print\' onload="this.onload=null;this.media=\'all\'"', $html);
	}
	return $html;
}

//defer js                                                      
add_filter('script_loader_tag', 'defer_parsing_of_js', 10);
function defer_parsing_of_js($url)
{
	if (is_user_logged_in())
		return $url; //don't break WP Admin
	if (FALSE === strpos($url, '.js'))
		return $url;

	if (strpos($url, 'scroll-js'))
		return $url;
	if (strpos($url, 'jquery.js'))
		return $url;
	return str_replace(' src', ' defer src', $url);

}

function disable_emoji_feature()
{

	// Prevent Emoji from loading on the front-end
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_print_styles', 'print_emoji_styles');

	// Remove from admin area also
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('admin_print_styles', 'print_emoji_styles');

	// Remove from RSS feeds also
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');

	// Remove from Embeds
	remove_filter('embed_head', 'print_emoji_detection_script');

	// Remove from emails
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

	// Disable from TinyMCE editor. Currently disabled in block editor by default
	add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');

	/** Finally, prevent character conversion too
	 ** without this, emojis still work 
	 ** if it is available on the user's device
	 */

	add_filter('option_use_smilies', '__return_false');

}

function disable_emojis_tinymce($plugins)
{
	if (is_array($plugins)) {
		$plugins = array_diff($plugins, array('wpemoji'));
	}
	return $plugins;
}

add_action('init', 'disable_emoji_feature');
