<?php

get_header();

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );

?>

	<div id="main-content">

					<?php while ( have_posts() ) : the_post(); ?>

						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

							<div class="entry-content">
								<?php the_content(); ?>
							</div> <!-- .entry-content -->

						</article> <!-- .et_pb_post -->

					<?php endwhile; ?>

	</div> <!-- #main-content -->

<?php

get_footer();
