<?php
/****
	*
	* Sample Archive for Custom Post Taxonomy (Sample Type)
	*
****/        

                  
	$tag = get_queried_object();
	
	get_header(); 

?>
	
	<main id="<?php echo $tag->name; ?>" class="type-archive">
	
		<?php get_template_part( 'content/content', 'tag-sample-type'); ?>
		
	</main>
	
	
<?php get_footer();