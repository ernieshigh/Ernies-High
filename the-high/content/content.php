<?php
/*
 *
 *
 * Default Page Content
 *
 *
*/
?>
	<div class="container page-container">
		 
		<div class="page-meta" role="header"><h1 class="page-title"> <?php  get_the_title(); ?> </h1></div> 
			
		<article class="page-entry">
			
			<?php while(have_posts()):the_post(); ?>
			
					<?php the_content(); ?>
			
			<?php endwhile; ?>
					
		</article>
			
		<?php  if(is_front_page() === false): comments_template( '', true ); endif; ?>
		
	</div> 