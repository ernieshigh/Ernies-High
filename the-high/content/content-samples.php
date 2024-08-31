<?php 
/**
	 *
	 *  Get Sample post type in loop
	 *
**/

global $post;

 ?>
	<div class="container blog-container">
	
		<div class="row">
		<?php 
			$titled = get_the_title(); 
			echo '<h1 class="page-title">' . $titled . '</h1>';  
		?>
			<div class="page-entry">
				<?php the_content(); ?>
			</div>
		
		
		</div>
	
		<div class="row blog-row">
		<?php  
				$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
				$sticky = get_option( 'sticky_posts' );
				
				$args = array(
					'post_type' => 'sample',
					'paged' => $paged,
					'posts_per_page' => 12,
					'ignore_sticky_posts' => true,
				);
				
				$query = new WP_Query( $args );
			
				if( $query->have_posts() ) :   while ($query->have_posts()) : $query->the_post(); ?>
       			
				<article  <?php post_class('post-content'); ?>>
					<h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
					
								  
					<div class="post-entry">
					<?php the_post_thumbnail('feature-thumb');?>
						<?php  the_excerpt(); ?>
					</div>
					
																		
				
					<footer class="entry-meta">
						<span class="meta-prep meta-prep-author small"><?php _e(' By  ', 'the-high'); ?></span>
						<span class="author vcard"><?php echo  get_avatar( get_the_author_meta( 'ID'), 32 ); ?> <a class="url fn n" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" title="<?php printf( __( ' View all articles by %s ', 'the-high' ), the_author_meta( 'display_name', 25 ) ); ?>"> <?php the_author(); ?></a></span>
	   
						<br><span class="tag-links"> This post is tagged as <?php echo get_the_tag_list('',', ',''); ?> . </span>
							
						<?php
							$categories_list = get_the_category_list( __( ', ', 'the-high' ) );
							if ( $categories_list ):
						?>
							<span class="cat-links">
								<?php printf( __( '<span class="%1$s">Posted in</span> %2$s ', 'the-high' ), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list );$show_sep = true; ?>
							</span>
							
						<?php endif; // End if categories ?>
						
					</footer>
				</article>		   					

			<?php endwhile; ?>
		<?php endif; ?>
		
		
		</div>
		<?php high_pagination(); ?>
	</div> <!-- this is the blog -->