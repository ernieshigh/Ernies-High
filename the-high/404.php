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


<main>

	<section class="full-width 404">

		<div class="row page-row">
			<div class="page-head" role="header">
				<h1 class="search-title"><?php _e('404 Not found', 'the-high'); ?></h1>

			</div>

			<article class="nada">

				<?php echo '<p  >' . __('We\'ve looked everywhere...', 'the-high') . '</p>'; ?>
				<img class="centeralign" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/404.png"
					alt="We looked everywhere" width="612" height="458">

				<?php echo '<p  >' . __('... and just can\'t find what you are looking for. ', 'the-high') . '</p>'; ?>
			</article>

			<p>
				<?php _e('Maybe try a search?', 'the-high'); ?>
			</p>

			<div class=" desk-search">

				<?php echo get_search_form(); ?>
			</div>

		</div>
	</section>

</main>

<?php get_footer();