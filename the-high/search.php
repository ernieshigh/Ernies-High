<?php
/*
 *
 *
 *  Get search results
 *
 *
*/
	
get_header(); 


?>
 
	<section id="page-header" class="full-width" role="header">

		<div >
			<div class="row page-row" >
				<div class="page-head" role="header">
					<h1 class="search-title"><?php printf( __( 'Search Results for: %s', 'the-high' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
					<?php echo '<p class="page-blrp">' . html_entity_decode(get_bloginfo('description')) . '</p>';?>
				</div>
			</div>
		</div>

	</section>

<section>
	
		<div class="container">
			 
			
			<div class="row  post-row row-eq-height">
				<?php get_template_part('content/content', 'search'); ?>
			</div>
		</div>
		
		<?php high_pagination(); ?>
		
	</section> 
	
<?php get_footer();