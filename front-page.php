<?php get_header(); ?>

<?php get_template_part( 'masthead' ); ?>

<?php get_template_part( 'subhead' ); ?>

<section class="get-involved">
	<div class="wrapper">
		<h2 class="section-title"><?php _e( 'There are many different ways for you to get involved with WordPress:', 'make-wporg' ); ?></h2>

		<?php $sites_query = new WP_Query(); ?>
		<?php while( $sites_query->have_posts() ) : $sites_query->the_post(); ?>
			<article id="site-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h2><?php the_title(); ?></h2>
				<?php the_excerpt(); ?>
				<?php if ( get_post_meta( get_the_ID(), 'weekly_chat', true ) ) : ?>
					<small>
						<p><?php printf( __( 'Weekly IRC chats: %s', 'make-wporg' ), get_post_meta( get_the_ID(), 'weekly_chat_when', true ) ); ?></p>
						<p><?php echo get_post_meta( get_the_ID(), 'weekly_chat_where', true ); ?></p>
					</small>
				<?php endif; ?>
			</article>
		<?php endwhile; ?>

	</div>
</section>

<?php get_footer(); ?>