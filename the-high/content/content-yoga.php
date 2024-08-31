<?php
/**
 *  Display main content
 */
?>


		<div class="yoga-row row"> 
						 
	<article>
			
					<div class="entry-content">
						
						
						<?php the_content(); ?>
				
					</div><!-- .entry-content -->

					
		 
			
				</article><!-- #post -->
								  
<?php
				echo '<div class="post-nav">';
				// add previus post link
				echo '<span class="prev-link" >';
				previous_post_link( '&laquo; %link', '%title' );
				echo '</span>';
				
				//add next post link
				echo '<span class="next-link" >'; 
				next_post_link( ' %link', '%title  &raquo;' );
				echo '</span>';
			
			
					echo '</div>';
			
			
			
			
								
				?>
							
		</div>