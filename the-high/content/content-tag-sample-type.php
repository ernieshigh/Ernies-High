<?php
/*
 *
 *
 * Custom Tyoe Taxonomy for custom post type sample
 *
 * var_dump($query_object) ;
 */

$query_object = get_queried_object();
$taxonomy = $query_object->taxonomy;
$name = $query_object->name;
$type = $query_object->slug;
?>

<div class="container page-container">
	<?php echo '<h1 class="cat-title">' . $name . '</h1>'; ?>

	<div class="row loop-row">

		<?php


		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args = array(
			'post_type' => 'sample',
			'posts_per_page' => 5,
			'tax_query' => array(
				array(
					'taxonomy' => $taxonomy,
					'field' => 'slug',
					'terms' => $type
				)
			),
		);

		$cat_query = new WP_Query($args);

		if ($cat_query->have_posts()):
			while ($cat_query->have_posts()):
				$cat_query->the_post(); ?>

				<article <?php post_class('post-content'); ?>>
					<h2 class="tag-title"><a href="<?php the_permalink() ?>" rel="bookmark"
							title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

					<?php if (has_post_thumbnail()): ?>
						<figure class="featured-figure">
							<?php the_post_thumbnail('feature-thumb', ['class' => 'single-featured', 'title' => '', 'alt' => '']); ?>
						</figure>
					<?php endif; ?>
					<div class="post-entry tag">
						<?php the_excerpt('high_excerpt_length', 'high_excerpt_more'); ?>
					</div>

					<?php if (is_singular())
						wp_enqueue_script("comment-reply"); ?>

					<footer class="entry-meta">
						<span class="meta-prep meta-prep-author"><?php _e('By ', 'the-high'); ?></span>
						<span class="author vcard"><?php echo get_avatar(get_the_author_meta('ID'), 32); ?> <a class="url fn n"
								href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" title="<?php //printf(__(' View all articles by %s ', 'the-high'));
								   		echo the_author_meta('display_name'); ?>">
								<?php the_author(); ?></a></span>

						<span class="sample-terms"> <span class="meta-prep">Type: </span>
							<?php
							$terms = get_the_terms($post->ID, 'sample-type');

							foreach ($terms as $term) {

								$term_link = get_term_link($term);
								echo '<a href="' . $term_link . ' "> ' . $term->name . ' </a>';
							}
							?>
						</span>
					</footer>
				</article>

			<?php endwhile; ?>
		<?php endif; ?>


	</div>
	<?php high_pagination(); ?>
</div> <!-- this is the blog -->