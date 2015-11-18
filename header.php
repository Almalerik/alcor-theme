<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package alcor
 */

$alcor = new Alcor_Theme();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>

<!-- Alcor custom style -->
<style type="text/css">
	<?php echo $alcor -> get_custom_style();?>
</style>

</head>

<body <?php body_class(); ?>>
	<div class="container-fluid">

		<div id="header-top" class="row">
			<div class="alcor-wrapper">
				<div class="col-xs-12"></div>
			</div>
		</div>

		<div id="header" class="row">
				<div class="alcor-wrapper">
				<nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>

				<?php

					$alcor_logo = $alcor->get_setting('alcor_logo');

					if(isset($alcor_logo) && $alcor_logo != ""):

						echo '<a href="'.esc_url( home_url( '/' ) ).'" class="navbar-brand">';

							echo '<img src="'.$alcor_logo.'" alt="'.get_bloginfo('title').'" class="alcor-logo image-responsive">';

						echo '</a>';

					else:

						echo '<a href="'.esc_url( home_url( '/' ) ).'" class="navbar-brand">';
						
							if( file_exists(get_stylesheet_directory()."/assets/images/logo.png")):
							
								echo '<img src="'.get_stylesheet_directory_uri().'/assets/images/logo.png" alt="'.get_bloginfo('title').'"  class="alcor-logo image-responsive">';
							
							else:
								
								echo '<img src="'.get_template_directory_uri().'/assets/images/logo.png" alt="'.get_bloginfo('title').'"  class="alcor-logo image-responsive">';
								
							endif;

						echo '</a>';

					endif;

				?>



          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'walker' => new Alcor_Walker(), 'menu_class' => 'nav navbar-nav navbar-right alcor-menu'  ) ); ?>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
				</div>
			</div>

	</div>
<?php dynamic_sidebar ('sidebar-header');?>
	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'alcor' ); ?></a>

		<header id="masthead" class="site-header" role="banner">
			<div class="site-branding">
			<?php if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
				</h1>
			<?php else : ?>
				<p class="site-title">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
				</p>
			
			
			<?phpendif;
			
			$description = get_bloginfo ( 'description', 'display' );
			if ($description || is_customize_preview ()) :
				?>
				<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
			<?php endif; ?>
		</div>
			<!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation" role="navigation">
				<button class="menu-toggle" aria-controls="primary-menu"
					aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'alcor' ); ?></button>
			
		</nav>
			<!-- #site-navigation -->
		</header>
		<!-- #masthead -->

		<div id="content" class="site-content">