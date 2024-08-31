<?php
/*
 *
 *
 * Main Index for Basic theme
 *
 *
*/
?>

<?php get_header(); ?>

	<main>

		<?php 
		
			if(is_home()):
				get_template_part( 'content/content', 'blog' );  // if is the blog page
			else :
				get_template_part( 'content/content' ); // any other page 
			endif; 
			
		?>
		
	</main>
	
<?php get_footer();