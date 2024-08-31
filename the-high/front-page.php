<?php
/***
	*
	* Custom front page template
	*
***/

	global $wpdb, $wp_query, $post;
	
	get_header();
?> 
		<main class="main main-home">  
			<?php get_template_part( 'content/content', 'front'); ?>
		</main>
	 
	 
<?php  get_footer();