<?php
/*
 *
 *
 * Archive Page Loop
 *
 *
 */

$query_object = get_queried_object();
$cpt = $query_object->name;

$tax = '';
$taxonomies = get_object_taxonomies(array('post_type' => $cpt));

?>

<div class="container page-container">
	<?php echo '<h1 class="cat-title">' . $cpt . '</h1>'; ?>
	<div class="row loop-row">

		<?php

		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args = array(
			'posts_per_page' => 9,
			'post_type' => $cpt,
			'paged' => $paged,
		);

		$cat_query = new WP_Query($args);

		if ($cat_query->have_posts()):
			while ($cat_query->have_posts()):
				$cat_query->the_post(); ?>

				<article <?php post_class('post-content'); ?>>
					<h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark"
							title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

					<?php the_post_thumbnail(); ?>
					<div class="post-entry">
						<?php the_excerpt('high_excerpt_length', 'high_excerpt_more'); ?>
					</div>

					<?php if (is_singular())
						wp_enqueue_script("comment-reply"); ?>

					<footer class="entry-meta">
						<span class="meta-prep meta-prep-author"><?php _e('By ', 'the-high'); ?></span>
						<span class="author vcard"><?php echo get_avatar(get_the_author_meta('ID'), 32); ?> <a
								class="url fn n" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"
								title="<?php printf(__(' View all articles by %s ', 'the-high'), the_author_meta('display_name', 25)); ?>">
								<?php the_author(); ?></a></span>

						<span class="tag-links"> This post is tagged as
							<?php
							foreach ($taxonomies as $tax) {
								$terms = get_the_terms(get_the_ID(), $tax);
							}
							if (!empty($terms)):
								foreach ($terms as $term) {
									echo '<a href="' . get_term_link($term->slug, $tax) . '">' . $term->name . ', </a>';
								}
							endif;
							?>
						</span>
					</footer>
				</article>

			<?php endwhile; ?>
		<?php endif; ?>


	</div>
	<?php high_pagination(); ?>
</div> <!-- this is the blog -->