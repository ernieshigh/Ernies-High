<?php
/****
	*
	* Category Template
	*
****/
							   
$category = get_queried_object();
$cat_id = $category->term_id;

get_header(); ?>

	<main id="cat-<?php echo $cat_id; ?>" >
	
		<?php get_template_part( 'content/content', 'category-loop'); ?>
		
	</main>
	
<?php get_footer();
