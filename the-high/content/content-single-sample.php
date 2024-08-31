<?php
/**
 *  Display Single Post or search results
 */ 
 
     
?>


	<div class="container">
		<div class="row"> 
						  
				
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>         
					<?php if ( has_post_thumbnail() ) : ?> 
						<figure class="single-figure">
							<?php the_post_thumbnail('feature-thumb', ['class' => 'single-featured', 'title' => '' , 'alt' => '']); ?>
						</figure>
					<?php endif; ?>
					<div class="entry-meta">
						<span class="meta-prep meta-prep-author"><?php _e(' By  ', 'the-high'); ?></span>
						<span class="author vcard"><?php echo  get_avatar( get_the_author_meta( 'ID'), 32 ); ?> <a class="url fn n" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" title="<?php printf( __( ' View all articles by %s ', 'the-high' ), the_author_meta( 'display_name', 25 ) ); ?>"> <?php the_author(); ?></a></span>
						|  <span class="meta-prep meta-prep-entry-date"><?php _e(' Published ', 'the-high'); ?></span><span class="entry-date"><abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO') ?>"><?php the_time( get_option( 'date_format' ) ); ?></abbr></span>
						|    <span class="sample-terms"> <span class="meta-prep">Type: </span>
						<?php 
							$terms = get_the_terms( $post->ID, 'sample-type' );  
  
							foreach($terms as $term){
							
							$term_link = get_term_link( $term );  
							echo '<a href="' . $term_link . ' "> ' . $term->name . ' </a>';
						}
						?>
						</span>
					</div>
				</header><!-- .entry-header -->
	
			
				<div class="entry-content">          
					<?php the_content(); ?>
				</div><!-- .entry-content -->
		 
			
		
			</article><!-- #post -->
		<?php						   
			// add comments stuff
			//comments_template( '', true );
			
			// add ppst navigation
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
	</div>