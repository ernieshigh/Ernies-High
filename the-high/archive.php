<?php
/****
	*
	* Category Template
	*
****/

$tag = get_queried_object();

get_header(); 
?>
	
	<main id="<?php echo $tag->name; ?>" >
	
		<?php get_template_part( 'content/content', 'archive-loop'); ?>
		
	</main>
	
<?php get_footer(); 