<?php
/**
	*
	*
	*  Template Name: Samples
	*  Show Sample posts in blog format
	*
	*
**/

global $post;

?>

<?php get_header(); ?>
	
	<main>
	
		<?php get_template_part( 'content/content', 'samples'); ?>
		
	</main>
	
<?php get_footer();