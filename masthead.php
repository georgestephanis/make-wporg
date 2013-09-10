
<header class="masthead">
	<?php while ( have_posts() ) : the_post(); ?>
		<hgroup <?php post_class( 'wrap' ); ?>>
			<?php
				if ( have_post_thumbnail() ) {
					the_post_thumbnail( array( 400, 200 ) );
				}
				the_content();
			?>
		</hgroup>
	<?php endwhile; ?>
</header>
