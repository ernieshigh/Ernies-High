<?php
/**
	*
	* Template for standard single post 
	*
	*
**/

?>

<?php get_header(); ?>
	
	<main  id="post-<?php echo $post->ID; ?>">
	
		<?php 
		
			while ( have_posts() ) : the_post(); 
			
			$post_type = get_post_type( get_the_ID() );
			 
			
			if($post_type == "sample")  {
				get_template_part( 'content/content', 'single-sample' );
			}else{
				get_template_part( 'content/content', 'single' );
			}
	 
								  
				
			endwhile;
			
		?>
							 
	</main>
		
		
<?php get_footer(); ?>