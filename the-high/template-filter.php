<?php
/***
	*	Template Name: Multi-filter
	*
	* Template Post Type: sample
	*
	
***/


get_header();
?>


<div class="main filter-main">
	<section class="post-content">
		<div class="row">

			<?php the_content(); ?>

		</div>
	</section>
	<section class="filter-section">


		<div class=" row filter-cat-row">


			<div class="left-col filter-col">

				<h2> <?php _e('Filter By:', 'the-high'); ?> </h2>
				<a href="#" class="button sm-btn remove-filters"
					style="display: none;"><?php _e('Reset Filter', 'the-high'); ?></a>

				<div class="cat-menu">

					<?php
					// define taxonmy to filter by
					$tax_name = "category";

					// get ctegory parents
					$parent = get_terms($tax_name, array('parent' => 0, 'orderby' => 'include', 'order' => 'ASC', 'hide_empty' => false));

					// create a ul for each parent
					foreach ($parent as $pterm) {

						$tax_image = get_term_meta($pterm->term_id, 'high_img', true);
						$catImg = wp_get_attachment_image($tax_image, array(), "", array("class" => "img-responsive"));


						echo '<ul id="cat-' . $pterm->slug . '" class="download-cat "  >';
						echo '<li class="cat-icon" >';
						echo $catImg;
						echo '<h3 class="cat-title">' . $pterm->name . '</h3><i class="open-icon icon-tog"></i></li>';

						// create a sublist to show children taxonomy
						echo '<li class="has-cats"><ul class="download-sub-cat">';

						// get parent taxonomy ID										
						$termID = $pterm->term_id;
						// get children of parent taxonomy
						$terms = get_terms($tax_name, array('parent' => $termID, 'orderby' => 'slug', 'hide_empty' => false));

						// create list item of each child
						foreach ($terms as $term) {

							echo '<li class="download-items ' . $term->slug . '"><input type="checkbox" class="sub-cats" data-pcat="' . $pterm->slug . '"  data-sub="' . $term->slug . '" value="' . $term->slug . '" name="cat[]" id="' . $term->slug . '"  />';
							echo ' <label for="' . $term->slug . '">' . $term->name . '</label></li>';
						}

						echo '</ul></li>';
						echo '</ul>';

						//var_dump($pterm);
					}
					?>
				</div>
			</div>
			<div class="filter-col right-col">


				<div class="filter-notice hide-desk">
					<article class="filter-content">
						<div class="filter-text">
							<p class="notice">
								<?php _e('PLEASE NOTE: Each time you click on an option, the list will be updated with a group of products that match your criteria.', 'the-high'); ?>
							</p>
						</div>
					</article>

				</div>


				<div class="filter-results">
					<div class="filter-text hide-mobile">
						<p class="notice">
							<?php _e('Select one or more categories from left sidebar to view realated posts.', 'the-high'); ?>
						</p>
					</div>
					<article class="filter-content">
						<?php get_template_part('content/content', 'blog'); ?>

					</article>

				</div>

			</div>

		</div>

	</section>
</div>

<?php get_footer();