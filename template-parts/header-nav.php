<nav
	class="navbar navbar-default <?php echo $alcor -> get_setting("header_fixed_top");?> navbar-fade">
	<div class="container-fluid">
		<div class="navbar-header">
					
							<?php if ( has_nav_menu( "primary" ) ) :?>
							<button type="button" class="navbar-toggle collapsed"
				data-toggle="collapse" data-target="#navbar" aria-expanded="false"
				aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span> <span
					class="icon-bar"></span> <span class="icon-bar"></span> <span
					class="icon-bar"></span>
			</button>
							<?php endif;?>
	            			
	            			<div class="brand-container">
				<a href="<?php echo esc_url( home_url( '/' ) )?>"
					class="navbar-brand" rel="home">
					<img src="<?php echo $alcor->get_logo()?>"
						alt="<?php echo get_bloginfo('title')?>"
						class="site-logo image-responsive">
				</a>
				<div class="navbar-brand-name">
								<?php if ( is_front_page() && is_home() ) : ?>
									<h1 class="site-title">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</h1>
								<?php else : ?>
									<p class="site-title">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</p>
								<?php endif;?>

								<?php
								
								$description = get_bloginfo ( 'description', 'display' );
								if ($description || is_customize_preview ()) :
									?>
									<p class="site-description"><?php echo $description; ?></p>
								<?php endif;?>
									
								</div>
				<div class="clearfix"></div>
			</div>
		</div>
						<?php if ( has_nav_menu( "primary" ) ) :?>
						<div id="navbar" class="navbar-collapse collapse">
				            <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'walker' => new Alcor_Walker(), 'menu_class' => 'nav navbar-nav navbar-right alcor-menu'  ) ); ?>
						</div>
						<?php endif; ?>
        			</div>
</nav>