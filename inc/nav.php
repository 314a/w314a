<!--<div class="site-branding">
	<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
	<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
</div><!-- .site-branding -->

<!--<nav id="site-navigation" class="main-navigation" role="navigation">
	<button class="menu-toggle" aria-controls="menu" aria-expanded="false"><?php _e( 'Primary Menu', 'w314a' ); ?></button>
	<div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e('Skip to content','w314a_theme');?>">
	<?php esc_attr_e('Skip to content','w314a_theme');?></a></div>
</nav> <!--#site-navigation -->
		
<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="navbar-inner">
	  <div class="container">
		<div class="navbar-header">
		  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		  <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
		</div>

		<?php wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container_class' => 'collapse navbar-collapse navbar-responsive-collapse',
					'menu_class' => 'nav navbar-nav navbar-right',
					'fallback_cb' => '',
					'menu_id' => 'main-menu',
					'walker' => new wp_bootstrap_navwalker()
				)
			); ?>
	  </div>
	</div>
</nav>