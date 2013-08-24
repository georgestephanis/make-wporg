<?php get_header(); ?>

<div id="headline">
	<div class="wrapper">
		<h2><a href="<?php echo esc_url( home_url() ); ?>"><?php bloginfo('name'); ?></a></h2>
	</div>
</div>

<?php get_template_part( 'masthead' ); ?>

<nav class="subhead">
	<div class="wrapper">
		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'nav-menu' ) ); ?>

		<?php if( true || class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'subscriptions' ) ) : ?>
		<?php /* @todo: switch this form over to the Jetpack Subscriptions shortcode */ ?>
		<?php /* jetpack_do_subscription_form( $args = array() ); */ ?>
		<form action="#" method="post">
			<fieldset>
				<label for="signup-email">Get news updates in your email:</label>
				<input type="email" name="email" class="text" id="signup-email" />
				<button type="submit" class="button button-primary">Sign Up</button>
			</fieldset>
		</form>
		<?php endif; ?>
	</div>
</nav>

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

		<article class="core">
			<h2>Core</h2>
			<p>This is the official blog for the core development team of the WordPress open source project. Follow our progress with weekly meeting agendas, project schedules, and the occasional code debate. <a href="#">Learn More &raquo;</a></p>
			<small>
				<p>Weekly IRC chats: Wednesdays @ 20:00 UTC</p>
				<p>#wordpress-dev on irc.freenode.net</p>
			</small>
		</article>
		<article class="ui">
			<h2>UI</h2>
			<p>This is the official blog for the WordPress open source project's UI design and development group. Follow along and/or participate as we post about what we're currently working on, meeting, and big picture items. <a href="#">Learn More &raquo;</a></p>
			<small>
				<p>Weekly IRC chats: Tuesdays @ 19:00 UTC</p>
				<p>#wordpress-ui on irc.freenode.net</p>
			</small>
		</article>
		<article class="mobile">
			<h2>Mobile</h2>
			<p>This is the development blog for all the official WordPress apps, including iOS, Android, Windows Phone, and BlackBerry. <a href="#">Learn More &raquo;</a></p>
			<small>
				<p>Weekly IRC chats: Wednesdays @ 16:00 UTC</p>
				<p>#wordpress-mobile on irc.freenode.net</p>
			</small>
		</article>
		<article class="accessibility">
			<h2>Accessibility</h2>
			<p>Welcome to the official blog for the WordPress accessibility group -- dedicated to improving accessibility in core WordPress and related projects. <a href="#">Learn More &raquo;</a></p>
			<small>
				<p>Weekly IRC chats: Wednesdays @ 19:00 UTC</p>
				<p>#wordpress-ui on irc.freenode.net</p>
			</small>
		</article>
		<article class="polyglots featured-group">
			<h2>Polyglots</h2>
			<p>This site was created with inspiration from the main development blog - only this site is meant for the translation teams working on the latest releases of WordPress. <a href="#">Learn More &raquo;</a></p>
			<small>
				<p>Weekly IRC chats: Tuesdays @ 20:00 UTC</p>
				<p>#wordpress-polyglots on irc.freenode.net</p>
			</small>
		</article>
		<article class="support">
			<h2>Support</h2>
			<p>Support everything WordPress. tl;dr: Making Support Better from both ends. <a href="#">Learn More &raquo;</a></p>
			<small>
				<p>Weekly IRC chats: Thursdays @ 20:00 UTC</p>
				<p>#wordpress-sfd on irc.freenode.net</p>
			</small>
		</article>
		<article class="themes">
			<h2>Themes</h2>
			<p>The Theme Review Team is a group of volunteers who review and approve Themes submitted to be included in the official WordPress Theme directory. <a href="#">Learn More &raquo;</a></p>
		</article>
		<article class="plugins">
			<h2>Plugins</h2>
			<p>Howdy! This P2 blog is for announcements and resources for WordPress plugin developers and the Plugin Directory. If you write plugins, you should subscribe. <a href="#">Learn More &raquo;</a></p>
		</article>
	</div>
</section>

<?php get_footer(); ?>