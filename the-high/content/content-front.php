<?php
/*
 *
 *
 * Front Page Content
 *
 *
*/
?>
	<div class="container front-page-container">
		 
			
		<article class="page-entry">
			
			<?php while(have_posts()):the_post(); ?>
			
					<?php the_content(); ?>
			
			<?php endwhile; ?>
					
		</article>
			 
		
	</div> 