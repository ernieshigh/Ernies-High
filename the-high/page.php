<?php
/**
*
*
* Basic page for non-posts
*
*
*/

global $post;

?>

<?php get_header(); ?>
	
	
	<?php
		if(is_page('248')){
			
			echo '<canvas id="high-scroll"></canvas>';
			echo '<div style="position: relative; top: 120px; max-width: 650px; margin: 2em auto; color: #fff; z-index: 999;">';
			echo '<h1 style="text-align: center; color: #fff; margin: 1em auto;"> Scroll</h1>';
			echo '<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et </p>';
			echo '</div>';
			
		echo '<script> </script>';
		}
	
	?>
	<main> 
		
		<?php get_template_part( 'content/content', 'content'); ?>
		
	</main>
	
<?php get_footer();